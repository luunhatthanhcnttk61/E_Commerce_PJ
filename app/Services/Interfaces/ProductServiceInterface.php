<?php

namespace App\Services\Interfaces;

interface ProductServiceInterface
{
    public function paginate();
    public function createProduct($data);
    public function findById($id);
    public function updateProduct($id, $data);
    public function deleteProduct($id);
}