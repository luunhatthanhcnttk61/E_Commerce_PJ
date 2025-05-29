@extends('frontend.layouts.master')

@section('title', 'Thanh toán')

@section('content')
<div class="container">
    <h1 class="my-4">Thanh toán</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h4>Thông tin giao hàng</h4>
                    <form id="checkout-form" action="{{ route('client.checkout.process') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Họ tên</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Địa chỉ</label>
                            <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Ghi chú</label>
                            <textarea name="note" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <h4 class="mt-4">Phương thức thanh toán</h4>
                        <div class="payment-methods">
                            <div class="form-check mb-2">
                                <input type="radio" name="payment_method" value="cod" class="form-check-input" checked>
                                <label class="form-check-label">Thanh toán khi nhận hàng (COD)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" name="payment_method" value="vnpay" class="form-check-input">
                                <label class="form-check-label">Thanh toán qua VNPAY</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="payment_method" value="momo" class="form-check-input">
                                <label class="form-check-label">Thanh toán qua Momo</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Đặt hàng</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4>Đơn hàng của bạn</h4>
                    @foreach($cart as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                        <span>{{ number_format($item->total) }}đ</span>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Tổng cộng:</strong>
                        <strong>{{ number_format($total) }}đ</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection