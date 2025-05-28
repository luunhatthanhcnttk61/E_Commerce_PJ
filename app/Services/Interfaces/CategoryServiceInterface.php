<?php

namespace App\Services\Interfaces;

interface CategoryServiceInterface
{
    public function getCategories($request);
    public function getAllCategories();
    public function createCategory($data);
    public function findById($id);
    public function updateCategory($id, $data);
    public function deleteCategory($id);
}