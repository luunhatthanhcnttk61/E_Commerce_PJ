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
        return $this->productRepository->getAllPaginate();  // Sửa thành getAllPaginate()
    }

    public function createProduct($data)
    {
        return $this->productRepository->createProduct($data);  // Sửa thành createProduct()
    }

    public function findById($id)
    {
        return $this->productRepository->findById($id);  // Sửa thành findById()
    }

    public function updateProduct($id, $data)
    {
        return $this->productRepository->updateProduct($id, $data);  // Sửa thành updateProduct()
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->deleteProduct($id);  // Sửa thành deleteProduct()
    }
}