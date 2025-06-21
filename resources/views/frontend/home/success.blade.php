@extends('frontend.layouts.master')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                    </div>
                    <h2 class="mb-3">Đặt hàng thành công!</h2>
                    <p class="mb-1">Mã đơn hàng: <strong>{{ $order->order_code }}</strong></p>
                    <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ xử lý đơn hàng trong thời gian sớm nhất!</p>

                    <div class="order-details mt-4">
                        <h4 class="text-start mb-3">Chi tiết đơn hàng</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        {{ $detail->product->name }} 
                                        <small class="text-muted">x {{ $detail->quantity }}</small>
                                    </td>
                                    <td class="text-end">{{ number_format($detail->total) }}đ</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end"><strong>Tổng cộng:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($order->total_amount) }}đ</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="shipping-info text-start mt-4">
                            <h4 class="mb-3">Thông tin giao hàng</h4>
                            <p class="mb-1"><strong>Người nhận:</strong> {{ $order->name }}</p>
                            <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $order->email }}</p>
                            <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                            @if($order->note)
                            <p class="mb-1"><strong>Ghi chú:</strong> {{ $order->note }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('client.home') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection