<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\ContactServiceInterface as ContactService;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    private function config()
    {
        return [
            'js' => [
                '/backends/js/plugins/switchery/switchery.js',
            ],
            'css' => [
                '/backends/css/plugins/switchery/switchery.css'
            ]
        ];
    }

    public function index(Request $request)
    {
        $contacts = $this->contactService->getContacts($request);
        $config = $this->config();
        $template = 'backend.contact.index';
        
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'contacts'
        ));
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        
        $result = $this->contactService->updateStatus($id, $status);
        
        return response()->json(['success' => $result]);
    }

    public function show($id)
    {
        try {
            $contact = $this->contactService->findById($id);
            if (!$contact) {
                return redirect()->back()->with('error', 'Không tìm thấy liên hệ');
            }
            
            // Auto update status to 'read' if it's new
            if ($contact->isNew()) {
                $this->contactService->updateStatus($id, Contact::STATUS_READ);
                $contact->refresh();
            }
            
            $config = $this->config();
            $template = 'backend.contact.show';
            
            return view('backend.dashboard.layout', compact(
                'template',
                'config',
                'contact'
            ));
            
        } catch (\Exception $e) {
            \Log::error('Error in ContactController@show: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra');
        }
    }

    public function reply(Request $request, $id)
    {
        try {
            $request->validate([
                'reply_content' => 'required|string'
            ]);

            $contact = $this->contactService->findById($id);
            if (!$contact) {
                return response()->json(['error' => 'Không tìm thấy liên hệ'], 404);
            }

            if ($contact->isReplied()) {
                return response()->json(['error' => 'Liên hệ này đã được trả lời'], 400);
            }

            // Send reply email and update status
            $this->contactService->sendReply($contact, $request->reply_content);
            $this->contactService->updateStatus($id, Contact::STATUS_REPLIED);

            return response()->json([
                'success' => true,
                'message' => 'Đã gửi trả lời thành công'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in ContactController@reply: ' . $e->getMessage());
            return response()->json(['error' => 'Có lỗi xảy ra'], 500);
        }
    }
}