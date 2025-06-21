<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CartServiceInterface;
use App\Models\Product;
use Cart; // Assuming you are using the "darryldecode/cart" package or similar
use Illuminate\Http\Request;
use App\Models\Cart as CartModel; // Assuming you have a Cart model
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // protected $cartService;

    // public function __construct(CartServiceInterface $cartService)
    // {
    //     $this->cartService = $cartService;
    // }

    // public function index()
    // {
    //     // $cart = $this->cartService->getCart();
    //     // $total = $this->cartService->getTotal();
    //     // return view('frontend.cart.index', compact('cart', 'total'));

    //     $cart = Cart::getContent();
    //     $total = Cart::getTotal();
    //     return view('frontend.cart.index', compact('cart', 'total'));
    // }

    // public function add(Request $request)
    // {
    //     // $result = $this->cartService->addToCart($request->product_id, $request->quantity);
    //     // return response()->json([
    //     //     'success' => $result,
    //     //     'cartCount' => $this->cartService->getCount()
    //     // ]);

    //      $product = Product::findOrFail($request->product_id);
        
    //     Cart::add([
    //         'id' => $product->id,
    //         'name' => $product->name,
    //         'price' => $product->price,
    //         'quantity' => $request->quantity,
    //         'attributes' => [
    //             'image' => $product->image
    //         ]
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'cartCount' => Cart::getTotalQuantity()
    //     ]);
    // }

    // public function update(Request $request)
    // {
    //     // $result = $this->cartService->updateCart($request->product_id, $request->quantity);
    //     // return response()->json(['success' => $result]);

    //     Cart::update($request->product_id, [
    //         'quantity' => [
    //             'relative' => false,
    //             'value' => $request->quantity
    //         ]
    //     ]);

    //     return response()->json(['success' => true]);
    // }

    // public function remove($id)
    // {
    //     // $result = $this->cartService->removeFromCart($id);
    //     // return response()->json(['success' => $result]);

    //      Cart::remove($id);
    //     return response()->json(['success' => true]);
    // }

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
        
        $cart = CartModel::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ],
            [
                'quantity' => \DB::raw('COALESCE(quantity, 0) + ' . $request->quantity),
                'price' => $product->price
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