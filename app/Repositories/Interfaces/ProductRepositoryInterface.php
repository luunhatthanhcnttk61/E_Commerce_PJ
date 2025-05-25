<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllPaginate();
    public function createProduct($data);
    public function updateProduct($id, array $data);
    public function deleteProduct($id);
    public function findById($id);
}