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

    public function create($data)
    {
        return $this->productRepository->create($data);  
    }

    public function findById($id)
    {
        return $this->productRepository->findById($id);
    }

    public function update($id, $data)
    {
        return $this->productRepository->update($id, $data); 
    }

    public function delete($id)
    {
        return $this->productRepository->delete($id); 
    }

    public function getFeaturedProducts()
    {
        return $this->productRepository->getFeaturedProducts();
    }

    public function getNewProducts()
    {
        return $this->productRepository->getNewProducts();
    }

    public function getProductsByCategory($categoryId)
    {
        return $this->productRepository->getProductsByCategory($categoryId);
    }

    public function search($keyword)
    {
        return $this->productRepository->search($keyword);
    }

    public function getRelatedProducts($productId, $limit = 4)
    {
        return $this->productRepository->getRelatedProducts($productId, $limit);
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllActive();
    }
    public function getProductsByCategories(array $categoryIds)
    {
        return $this->productRepository->getProductsByCategories($categoryIds);
    }
}