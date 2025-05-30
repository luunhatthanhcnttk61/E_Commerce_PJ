<?php

namespace App\Repositories\Interfaces;

interface CustomerRepositoryInterface
{
    public function getAllPaginate($filter = []);
    public function create($data);
    public function update($id, array $data);
    public function delete($id);
    public function findById($id);
}