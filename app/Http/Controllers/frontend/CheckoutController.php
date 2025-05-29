<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CheckoutServiceInterface;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutServiceInterface $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function index()
    {
        $cart = $this->checkoutService->getCart();
        $total = $this->checkoutService->getTotal();
        return view('frontend.checkout.index', compact('cart', 'total'));
    }

    public function process(CheckoutRequest $request)
    {
        $order = $this->checkoutService->createOrder($request->validated());

        if($request->payment_method === 'cod') {
            return redirect()->route('client.checkout.success', $order->id);
        }

        $paymentUrl = $this->checkoutService->getPaymentUrl($order, $request->payment_method);
        return response()->json([
            'success' => true,
            'payment_url' => $paymentUrl
        ]);
    }

    public function success($orderId)
    {
        $order = $this->checkoutService->getOrder($orderId);
        return view('frontend.checkout.success', compact('order'));
    }

    public function callback(Request $request)
    {
        $result = $this->checkoutService->handlePaymentCallback($request->all());
        
        if($result['success']) {
            return redirect()->route('client.checkout.success', $result['order_id']);
        }
        
        return redirect()->route('client.checkout.failed', $result['order_id']);
    }
}