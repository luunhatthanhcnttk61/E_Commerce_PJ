<?php 
namespace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAllPaginate()
    {
        return $this->model->paginate(10);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->findById($id);
        if ($product) {
            return $product->update($data);
        }
        return false;
    }

    public function delete($id)
    {
        $product = $this->findById($id);
        if ($product) {
            return $product->delete();
        }
        return false;
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function getFeaturedProducts()
    {
        return $this->model
            ->where('featured', 1)
            ->where('status', 1)
            ->latest()
            ->take(8)
            ->get();
    }

    public function getNewProducts()
    {
        return $this->model
            ->where('status', 1)
            ->latest()
            ->take(8)
            ->get();
    }

    public function getProductsByCategory($categoryId)
    {
        return $this->model
            ->where('category_id', $categoryId)
            ->where('status', 1)
            ->paginate(12);
    }

    public function search($keyword)
    {
        return $this->model
            ->where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->where('status', 1)
            ->paginate(12);
    }

    public function getRelatedProducts($productId, $limit = 4)
    {
        $product = $this->findById($productId);
        
        return $this->model
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $productId)
            ->where('status', 1)
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }

    public function getAllActive()
{
    return $this->model
        ->where('status', 1)
        ->latest()
        ->paginate(12);
}
}