<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllPaginate();
    public function create($data);
    public function update($id, array $data);
    public function delete($id);
    public function findById($id);

    public function getFeaturedProducts();
    public function getNewProducts();
    public function getProductsByCategory($categoryId);
    public function search($keyword);
    public function getRelatedProducts($productId, $limit);
    public function getAllActive();
}