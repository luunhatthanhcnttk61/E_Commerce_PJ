<?php

namespace App\Services\Interfaces;

interface ProductServiceInterface
{
    public function paginate();
    public function create($data);
    public function findById($id);
    public function update($id, $data);
    public function delete($id);

    public function getFeaturedProducts();
    public function getNewProducts();
    public function getProductsByCategory($categoryId);
    public function search($keyword);
    public function getRelatedProducts($productId, $limit = 4);
    public function getAllProducts();
    public function getProductsByCategories(array $categoryIds);
}