@extends('frontend.layouts.master')

@section('content')
<div class="checkout-failed">
    <div class="container">
        <div class="text-center">
            <i class="fas fa-times-circle text-danger" style="font-size: 48px;"></i>
            <h2>Payment Failed!</h2>
            <p>Sorry, there was a problem processing your payment.</p>
            <p>Order number: #{{ $order->id }}</p>
            
            <div class="mt-4">
                <a href="{{ route('client.checkout.index') }}" class="btn btn-primary">Try Again</a>
                <a href="{{ route('client.home') }}" class="btn btn-secondary">Return to Home</a>
            </div>
        </div>
    </div>
</div>
@endsection