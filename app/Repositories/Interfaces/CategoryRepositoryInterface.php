<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface 
{
    public function getAllPaginate($filter = []);
    public function getAll();
    public function create($data);
    public function update($id, array $data);
    public function delete($id);
    public function findById($id);
    public function findBySlug($slug);
}