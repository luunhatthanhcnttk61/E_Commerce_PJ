<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Interfaces\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    protected $model;
    protected $product;

    public function __construct(Cart $model, Product $product)
    {
        $this->model = $model;
        $this->product = $product;
    }

    public function getCartByUser($userId)
    {
        return $this->model->with('product')
                          ->where('user_id', $userId)
                          ->get();
    }

    public function addToCart($userId, $productId, $quantity)
    {
        $product = $this->product->find($productId);
        if (!$product) return false;

        $existingItem = $this->model->where('user_id', $userId)
                                  ->where('product_id', $productId)
                                  ->first();

        if ($existingItem) {
            return $this->updateCart($userId, $productId, $existingItem->quantity + $quantity);
        }

        return $this->model->create([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $product->price
        ]);
    }

    public function updateCart($userId, $productId, $quantity)
    {
        return $this->model->where('user_id', $userId)
                          ->where('product_id', $productId)
                          ->update(['quantity' => $quantity]);
    }

    public function removeFromCart($userId, $productId)
    {
        return $this->model->where('user_id', $userId)
                          ->where('product_id', $productId)
                          ->delete();
    }

    public function clearCart($userId)
    {
        return $this->model->where('user_id', $userId)->delete();
    }

    public function getTotal($userId)
    {
        return $this->model->where('user_id', $userId)
                          ->get()
                          ->sum(function($item) {
                              return $item->quantity * $item->price;
                          });
    }

    public function getCount($userId)
    {
        return $this->model->where('user_id', $userId)->sum('quantity');
    }
}