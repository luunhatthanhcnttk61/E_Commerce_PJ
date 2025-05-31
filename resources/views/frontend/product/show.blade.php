@extends('frontend.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset($product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p class="price">{{ number_format($product->price) }}đ</p>
            <p>{{ $product->description }}</p>
            
            <form action="{{ route('client.cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="form-group">
                    <label>Số lượng:</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->inventory }}" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
            </form>
        </div>
    </div>

    @if(count($relatedProducts) > 0)
    <div class="related-products mt-5">
        <h3>Sản phẩm liên quan</h3>
        <div class="row">
            @foreach($relatedProducts as $related)
                <div class="col-md-3">
                    @include('frontend.components.product-card', ['product' => $related])
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection