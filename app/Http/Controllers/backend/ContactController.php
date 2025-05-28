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
}