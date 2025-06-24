<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CartServiceInterface;
use App\Models\Product;
use Cart; 
use Illuminate\Http\Request;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = CartModel::where('user_id', Auth::id())
                        ->with('product')
                        ->get();
        
        $total = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $hasDiscount = $product->discount_percent > 0 &&
                    (!$product->discount_end_at || now()->lt($product->discount_end_at));
        
        $finalPrice = $hasDiscount
            ? $product->price * (1 - $product->discount_percent / 100)
            : $product->price;

        CartModel::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ],
            [
                'quantity' => \DB::raw('COALESCE(quantity, 0) + ' . $request->quantity),
                'price' => $finalPrice
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Thêm vào giỏ hàng thành công',
            'cartCount' => CartModel::where('user_id', Auth::id())->sum('quantity')
        ]);
    }


    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = CartModel::where('user_id', Auth::id())
                    ->where('product_id', $request->product_id)
                    ->firstOrFail();

        $cart->update(['quantity' => $request->quantity]);

        $newTotal = CartModel::where('user_id', Auth::id())
                       ->get()
                       ->sum(function($item) {
                           return $item->price * $item->quantity;
                       });

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật giỏ hàng thành công',
            'total' => number_format($cart->price * $cart->quantity) . 'đ',
            'cartTotal' => number_format($newTotal) . 'đ'
        ]);
    }

    public function remove($id)
    {
        CartModel::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa sản phẩm thành công',
            'cartCount' => CartModel::where('user_id', Auth::id())->sum('quantity')
        ]);
    }
}