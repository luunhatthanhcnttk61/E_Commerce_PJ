@extends('frontend.layouts.master')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container my-4">
    <h3 class="mb-4">Đơn hàng của tôi</h3>

    @if ($orders->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        @foreach ($orders as $order)
        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-light">
                <strong>Mã đơn: #{{ $order->id }}</strong> <br>
                <small>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</small> <br>
                @php
                    $statusText = [
                        'pending' => 'Chờ xử lý',
                        'processing' => 'Đang xử lý',
                        'shipped' => 'Đang giao',
                        'delivered' => 'Đã giao',
                        'cancelled' => 'Đã hủy',
                    ];
                @endphp
                <span class="badge bg-info mt-1">{{ $statusText[$order->order_status] ?? 'Không xác định' }}</span>

            </div>

            <div class="card-body">
                @foreach ($order->orderDetails as $detail)
                <div class="order-item d-flex mb-4">
                    <div class="image-wrapper">
                        <img src="{{ asset('/' . $detail->product->image) }}">
                    </div>
                    <div class="info-wrapper flex-grow-1 ms-3">
                        <div class="fw-semibold">{{ $detail->product->name }}</div>
                        <div class="text-muted">Số lượng: {{ $detail->quantity }}</div>
                    </div>
                    <div class="price-wrapper text-end">
                        <strong>{{ number_format($detail->total) }}đ</strong>
                    </div>
                </div>
                @endforeach

                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Tổng tiền:</strong>
                    <strong class="text-danger">{{ number_format($order->total_amount) }}đ</strong>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

{{-- Inline CSS --}}
<style>
    .order-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .order-item {
        align-items: center;
        border-bottom: 1px dashed #ddd;
        padding-bottom: 15px;
    }

    .price-wrapper {
        min-width: 100px;
    }

    .card {
        border: 1px solid #e0e0e0;
    }

    .card-header {
        font-size: 15px;
    }
</style>
@endsection
