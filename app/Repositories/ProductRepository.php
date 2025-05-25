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

    public function createProduct($data)
    {
        return $this->model->create($data);
    }

    public function updateProduct($id, array $data)
    {
        $product = $this->findById($id);
        if ($product) {
            return $product->update($data);
        }
        return false;
    }

    public function deleteProduct($id)
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
}