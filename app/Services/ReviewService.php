<?php

namespace App\Services;

use App\Repositories\Interfaces\ReviewRepositoryInterface as ReviewRepository;
use App\Services\Interfaces\ReviewServiceInterface;

class ReviewService implements ReviewServiceInterface
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function getReviews($request)
    {
        $filter = [];
        if($request->keyword) {
            $filter['keyword'] = $request->keyword;
        }
        if($request->status) {
            $filter['status'] = $request->status;
        }
        return $this->reviewRepository->getAllPaginate($filter);
    }

    public function createReview($data)
    {
        return $this->reviewRepository->createReview($data);
    }

    public function findById($id)
    {
        return $this->reviewRepository->findById($id);
    }

    public function updateReview($id, $data)
    {
        return $this->reviewRepository->updateReview($id, $data);
    }

    public function deleteReview($id)
    {
        return $this->reviewRepository->deleteReview($id);
    }

    public function updateStatus($id, $status)
    {
        return $this->reviewRepository->updateReview($id, ['status' => $status]);
    }

    public function getProductReviews($productId)
    {
        return $this->reviewRepository->getByProduct($productId);
    }
}