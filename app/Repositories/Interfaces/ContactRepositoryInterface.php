<?php

namespace App\Repositories\Interfaces;

interface ContactRepositoryInterface
{
    public function getAllPaginate($filter = []);
    public function findById($id);
    public function updateContact($id, array $data);
    public function deleteContact($id);
}