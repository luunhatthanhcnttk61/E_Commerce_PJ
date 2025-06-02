@extends('frontend.layouts.master')

@section('content')
<div class="checkout-success">
    <div class="container">
        <div class="text-center">
            <i class="fas fa-check-circle text-success" style="font-size: 48px;"></i>
            <h2>Order Placed Successfully!</h2>
            <p>Thank you for your purchase. Your order number is: #{{ $order->id }}</p>
            
            <div class="order-details">
                <h4>Order Details</h4>
                <p><strong>Name:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</p>
            </div>

            <a href="{{ route('client.home') }}" class="btn btn-primary mt-4">Continue Shopping</a>
        </div>
    </div>
</div>
@endsection