<?php

namespace App\Services\Interfaces;

interface CustomerServiceInterface
{
    public function getCustomers($request); 
    public function paginate();
    public function createCustomer($data);
    public function findById($id);
    public function updateCustomer($id, $data);
    public function deleteCustomer($id);
}