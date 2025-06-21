<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->with('product')
                    ->get();
                        
        if ($cart->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng trống');
        }

        $total = $cart->sum(fn($item) => $item->price * $item->quantity);

        return view('frontend.home.checkout', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email',
            'phone'            => 'required|string',
            'address'          => 'required|string',
            'payment_method'   => 'required|in:cod,vnpay,momo',
            'shipping_method'  => 'required|in:standard,express,same_day',
        ]);

        DB::beginTransaction();

        try {
            $cart = Cart::where('user_id', Auth::id())->with('product')->get();

            if ($cart->isEmpty()) {
                return redirect()->back()->with('error', 'Giỏ hàng trống');
            }

            $total = $cart->sum(fn($item) => $item->price * $item->quantity);

            $order = Order::create([
                'user_id'          => Auth::id(),
                'name'             => $request->name,
                'email'            => $request->email,
                'phone'            => $request->phone,
                'address'          => $request->address,
                'shipping_address' => $request->address,
                'shipping_method'  => $request->shipping_method,
                'note'             => $request->note,
                'total_amount'     => $total,
                'payment_method'   => $request->payment_method,
                'payment_status'   => 'unpaid',
                'order_status'     => 'pending'
            ]);

            foreach ($cart as $item) {
                OrderDetail::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'total'      => $item->price * $item->quantity
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('client.checkout.success', $order->id)
                             ->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function success($orderId)
    {
        $order = Order::with(['orderDetails.product'])->findOrFail($orderId);
        return view('frontend.home.success', compact('order'));
    }
}
