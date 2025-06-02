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

    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function sendReply($contact, $replyContent)
    {
        try {
            // Gửi email
            Mail::to($contact->email)
                ->cc(config('mail.from.address'))
                ->queue(new ContactReplyMail($contact, $replyContent));

            // Ghi log
            Log::info('Đã gửi mail trả lời', [
                'contact_id' => $contact->id,
                'email' => $contact->email,
                'subject' => $contact->subject
            ]);

            // Cập nhật trạng thái
            return $this->updateStatus($contact->id, 'replied');

        } catch (\Exception $e) {
            Log::error('Lỗi gửi mail trả lời', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $contact = $this->findById($id);
            if (!$contact) {
                return false;
            }

            $result = $contact->update(['status' => $status]);

            if ($result) {
                Log::info('Đã cập nhật trạng thái liên hệ', [
                    'contact_id' => $id,
                    'old_status' => $contact->getOriginal('status'),
                    'new_status' => $status
                ]);
            }

            return $result;

        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật trạng thái liên hệ', [
                'contact_id' => $id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}