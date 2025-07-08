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
                'order_status'     => 'pending',
                'is_paid'          => false,
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

            DB::commit();

            if ($request->payment_method == 'cod') {
                // Xóa giỏ hàng
                Cart::where('user_id', Auth::id())->delete();
                $order->update(['payment_status' => 'paid', 'order_status' => 'success', 'is_paid' => true]);
                return redirect()->route('client.checkout.success', $order->id)
                                ->with('success', 'Đặt hàng thành công!');
            }

            if ($request->payment_method == 'vnpay') {
                return redirect()->route('client.checkout.vnpay', ['order' => $order->id]);
            }
            if ($request->payment_method == 'momo') {
                return redirect()->route('client.checkout.momo', ['order' => $order->id]);
            }

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

    public function vnpay($orderId)
    {
        $order = Order::findOrFail($orderId);

        $vnp_TmnCode = env('VNPAY_TMNCODE');
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $vnp_Url = env('VNPAY_URL');
        $vnp_Returnurl = env('VNPAY_RETURN_URL');

        $vnp_TxnRef = $order->id;
        $vnp_OrderInfo = "Thanh toán đơn hàng $orderId";
        $vnp_Amount = $order->total_amount * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = request()->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $hashdataArr = [];
        foreach ($inputData as $key => $value) {
            $hashdataArr[] = urlencode($key) . "=" . urlencode($value);
        }
        $hashdata = implode('&', $hashdataArr);
        $query = implode('&', $hashdataArr);

        $vnp_Url = $vnp_Url . "?" . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;

        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
         $inputData = $request->all();
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $hashData = rtrim($hashData, '&');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $orderId = $request->vnp_TxnRef;
        $order = Order::find($orderId);

        if ($secureHash === $vnp_SecureHash && $request->vnp_ResponseCode == '00' && $order) {
            $order->update(['payment_status' => 'paid', 'order_status' => 'success', 'is_paid' => true]);
            Cart::where('user_id', $order->user_id)->delete();
            return redirect()->route('client.checkout.success', $orderId)
                ->with('success', 'Thanh toán VNPAY thành công!');
        }

        return redirect()->route('client.checkout.failed')->with('error', 'Thanh toán thất bại!');
    }

    public function momo($orderId)
    {
        $order = Order::findOrFail($orderId);

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');
        $orderInfo = "Thanh toán đơn hàng $orderId";
        $amount = (string) intval($order->total_amount); 
        $redirectUrl = env('MOMO_RETURN_URL');
        $ipnUrl = env('MOMO_NOTIFY_URL');
        $extraData = "";

        $requestId = uniqid();
        $requestType = "captureWallet";

        $orderIdMomo = $orderId . '_' . time();

        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderIdMomo&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderIdMomo,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
            'lang' => 'vi'
        ];

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        dd($jsonResult);
        
        return redirect($jsonResult['payUrl']);
    }

    public function momoReturn(Request $request)
    {
        $orderId = $request->orderId;
        $realOrderId = explode('_', $orderId)[0];
        $order = Order::find($realOrderId);

        if ($request->resultCode == 0 && $order) {
            $order->update(['payment_status' => 'paid', 'order_status' => 'success', 'is_paid' => true]);
            Cart::where('user_id', $order->user_id)->delete();
            return redirect()->route('client.checkout.success', $orderId)
                ->with('success', 'Thanh toán MoMo thành công!');
        }

        return redirect()->route('client.checkout.failed')->with('error', 'Thanh toán MoMo thất bại!');
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

}
