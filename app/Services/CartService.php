<?php

namespace App\Services;

use App\Services\Interfaces\CartServiceInterface;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CartService implements CartServiceInterface
{
    protected $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getCart()
    {
        return $this->cartRepository->getCartByUser(Auth::id());
    }

    public function addToCart($productId, $quantity)
    {
        return $this->cartRepository->addToCart(Auth::id(), $productId, $quantity);
    }

    public function updateCart($productId, $quantity)
    {
        return $this->cartRepository->updateCart(Auth::id(), $productId, $quantity);
    }

    public function removeFromCart($productId)
    {
        return $this->cartRepository->removeFromCart(Auth::id(), $productId);
    }

    public function clearCart()
    {
        return $this->cartRepository->clearCart(Auth::id());
    }

    public function getTotal()
    {
        return $this->cartRepository->getTotal(Auth::id());
    }

    public function getCount()
    {
        return $this->cartRepository->getCount(Auth::id());
    }
}