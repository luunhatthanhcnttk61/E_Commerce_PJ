<?php

namespace App\Services\Interfaces;

interface ContactServiceInterface
{
    public function getContacts($request);
    public function updateStatus($id, $status);
    public function create(array $data);
    public function findById($id);
}