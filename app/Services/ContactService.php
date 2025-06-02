<?php

namespace App\Services;

use App\Repositories\Interfaces\ContactRepositoryInterface as ContactRepository;
use App\Services\Interfaces\ContactServiceInterface;

class ContactService implements ContactServiceInterface
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getContacts($request)
    {
        $filter = [];
        if($request->keyword) {
            $filter['keyword'] = $request->keyword;
        }
        if($request->status) {
            $filter['status'] = $request->status;
        }
        return $this->contactRepository->getAllPaginate($filter);
    }

    public function updateStatus($id, $status)
    {
        return $this->contactRepository->updateContact($id, ['status' => $status]);
    }

    public function create(array $data)
    {
        $data['status'] = 'pending';
        return $this->contactRepository->create($data);
    }
    public function findById($id)
    {
        return $this->contactRepository->findById($id);
    }

    public function sendReply($contact, $replyContent)
    {
        try {
            // Send email
            Mail::to($contact->email)
                ->cc(config('mail.from.address')) // CC to admin
                ->queue(new ContactReplyMail($contact, $replyContent));

            // Log the reply
            Log::info('Reply sent to contact', [
                'contact_id' => $contact->id,
                'email' => $contact->email
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send reply email', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}