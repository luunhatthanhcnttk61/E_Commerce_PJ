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
}