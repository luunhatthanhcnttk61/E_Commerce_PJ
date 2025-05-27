<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Services\Interfaces\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function paginate()
    {
        return $this->productRepository->getAllPaginate();
    }

    public function createProduct($data)
    {
        return $this->productRepository->createProduct($data);  
    }

    public function findById($id)
    {
        return $this->productRepository->findById($id);
    }

    public function updateProduct($id, $data)
    {
        return $this->productRepository->updateProduct($id, $data); 
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->deleteProduct($id); 
    }
}