<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface
{
    public function getCartByUser($userId);
    public function addToCart($userId, $productId, $quantity);
    public function updateCart($userId, $productId, $quantity);
    public function removeFromCart($userId, $productId);
    public function clearCart($userId);
    public function getTotal($userId);
    public function getCount($userId);
}