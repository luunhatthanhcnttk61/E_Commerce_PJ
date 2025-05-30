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
        // $cart = $this->cartService->getCart();
        // $total = $this->cartService->getTotal();
        // return view('frontend.cart.index', compact('cart', 'total'));

        $cart = Cart::getContent();
        $total = Cart::getTotal();
        return view('frontend.cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        // $result = $this->cartService->addToCart($request->product_id, $request->quantity);
        // return response()->json([
        //     'success' => $result,
        //     'cartCount' => $this->cartService->getCount()
        // ]);

         $product = Product::findOrFail($request->product_id);
        
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->quantity,
            'attributes' => [
                'image' => $product->image
            ]
        ]);

        return response()->json([
            'success' => true,
            'cartCount' => Cart::getTotalQuantity()
        ]);
    }

    public function update(Request $request)
    {
        // $result = $this->cartService->updateCart($request->product_id, $request->quantity);
        // return response()->json(['success' => $result]);

        Cart::update($request->product_id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ]
        ]);

        return response()->json(['success' => true]);
    }

    public function remove($id)
    {
        // $result = $this->cartService->removeFromCart($id);
        // return response()->json(['success' => $result]);

         Cart::remove($id);
        return response()->json(['success' => true]);
    }
}