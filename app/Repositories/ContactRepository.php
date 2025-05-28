<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Interfaces\ContactRepositoryInterface;

class ContactRepository implements ContactRepositoryInterface
{
    protected $model;

    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

    public function getAllPaginate($filter = [])
    {
        $query = $this->model->query();

        if (!empty($filter['keyword'])) {
            $query->where(function($q) use ($filter) {
                $q->where('name', 'like', '%' . $filter['keyword'] . '%')
                  ->orWhere('email', 'like', '%' . $filter['keyword'] . '%')
                  ->orWhere('phone', 'like', '%' . $filter['keyword'] . '%');
            });
        }

        if (isset($filter['status'])) {
            $query->where('status', $filter['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function updateContact($id, array $data)
    {
        $contact = $this->findById($id);
        if($contact) {
            return $contact->update($data);
        }
        return false;
    }

    public function deleteContact($id)
    {
        $contact = $this->findById($id);
        if($contact) {
            return $contact->delete();
        }
        return false;
    }
}