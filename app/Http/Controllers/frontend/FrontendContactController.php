<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ContactServiceInterface;
use Illuminate\Http\Request;

class FrontendContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactServiceInterface $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
        return view('frontend.contact.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $contact = $this->contactService->create($request->all());

        return redirect()->back()->with('success', 'Tin nhắn của bạn đã được gửi');
    }
}