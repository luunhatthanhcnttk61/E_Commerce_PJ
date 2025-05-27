<?php

namespace App\Repositories\Interfaces;

interface CustomerRepositoryInterface
{
    public function getAllPaginate($filter = []);
    public function createCustomer($data);
    public function updateCustomer($id, array $data);
    public function deleteCustomer($id);
    public function findById($id);
}