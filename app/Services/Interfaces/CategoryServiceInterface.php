<?php

namespace App\Services\Interfaces;

interface CategoryServiceInterface
{
    public function getCategories($request);
    public function getAllCategories();
    public function create($data);
    public function findById($id);
    public function update($id, $data);
    public function delete($id);
}