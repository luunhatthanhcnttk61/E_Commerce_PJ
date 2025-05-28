<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface 
{
    public function getAllPaginate($filter = []);
    public function getAll();
    public function createCategory($data);
    public function updateCategory($id, array $data);
    public function deleteCategory($id);
    public function findById($id);
}