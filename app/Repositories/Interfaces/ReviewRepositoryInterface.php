<?php

namespace App\Repositories\Interfaces;

interface ReviewRepositoryInterface
{
    public function getAllPaginate($filter = []);
    public function createReview($data);
    public function updateReview($id, array $data);
    public function deleteReview($id);
    public function findById($id);
    public function getByProduct($productId);
}