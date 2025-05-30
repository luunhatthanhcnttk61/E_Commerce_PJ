<?php

namespace App\Services\Interfaces;

interface CustomerServiceInterface
{
    public function getCustomers($request); 
    public function paginate();
    public function create($data);
    public function findById($id);
    public function update($id, $data);
    public function delete($id);
}