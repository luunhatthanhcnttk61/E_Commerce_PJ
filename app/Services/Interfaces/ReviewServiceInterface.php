<?php

namespace App\Services\Interfaces;

interface ReviewServiceInterface
{
    public function getReviews($request);
    public function createReview($data);
    public function findById($id);
    public function updateReview($id, $data);
    public function deleteReview($id);
    public function updateStatus($id, $status);
    public function getProductReviews($productId);
}