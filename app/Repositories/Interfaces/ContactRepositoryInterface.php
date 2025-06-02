<?php

namespace App\Repositories\Interfaces;

interface ContactRepositoryInterface
{
    
    public function getAllPaginate($filter = []);
    public function findById($id);
    public function updateContact($id, array $data);
    public function deleteContact($id);
    public function create(array $data);
    
    /**
     * Send reply email to contact
     * @param object $contact
     * @param string $replyContent
     * @return bool
     */
    public function sendReply($contact, $replyContent);

    /**
     * Update contact status
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus($id, $status);
}