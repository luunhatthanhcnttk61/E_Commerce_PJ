<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CartServiceInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $total = $this->cartService->getTotal();
        return view('frontend.cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $result = $this->cartService->addToCart($request->product_id, $request->quantity);
        return response()->json([
            'success' => $result,
            'cartCount' => $this->cartService->getCount()
        ]);
    }

    public function update(Request $request)
    {
        $result = $this->cartService->updateCart($request->product_id, $request->quantity);
        return response()->json(['success' => $result]);
    }

    public function remove($id)
    {
        $result = $this->cartService->removeFromCart($id);
        return response()->json(['success' => $result]);
    }
}