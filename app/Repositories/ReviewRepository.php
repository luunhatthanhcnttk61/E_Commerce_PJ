<?php

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;

class ReviewRepository implements ReviewRepositoryInterface
{
    protected $model;

    public function __construct(Review $model)
    {
        $this->model = $model;
    }

    public function getAllPaginate($filter = [])
    {
        $query = $this->model->with(['product', 'customer']);

        if (!empty($filter['keyword'])) {
            $query = $query->whereHas('product', function($q) use ($filter) {
                $q->where('name', 'like', '%' . $filter['keyword'] . '%');
            });
        }

        if (isset($filter['status'])) {
            $query = $query->where('status', $filter['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function createReview($data)
    {
        return $this->model->create($data);
    }

    public function updateReview($id, array $data)
    {
        $review = $this->findById($id);
        if ($review) {
            return $review->update($data);
        }
        return false;
    }

    public function deleteReview($id)
    {
        $review = $this->findById($id);
        if ($review) {
            return $review->delete();
        }
        return false;
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function getByProduct($productId)
    {
        return $this->model->where('product_id', $productId)
                          ->where('status', 'approved')
                          ->with('customer')
                          ->orderBy('created_at', 'desc')
                          ->get();
    }
}