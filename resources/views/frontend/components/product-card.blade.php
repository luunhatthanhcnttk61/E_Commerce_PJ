@php
    $hasDiscount = $product->discount_percent > 0 && (!$product->discount_end_at || now()->lt($product->discount_end_at));
@endphp

<div class="product-card position-relative border p-2 mb-3">
    <a href="{{ route('client.product.show', $product->id) }}" class="d-block position-relative">
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image img-fluid">
        @if($hasDiscount)
            <span class="badge bg-danger position-absolute top-0 start-0 m-2">-{{ $product->discount_percent }}%</span>
        @endif
    </a>
    <div class="product-info mt-2 text-center">
        <h5 class="product-title">
            <a href="{{ route('client.product.show', $product->id) }}" class="text-decoration-none text-dark">
                {{ $product->name }}
            </a>
        </h5>
        <div class="product-price">
            <span class="current-price">{{ number_format($product->final_price) }}đ</span>
            @if($hasDiscount)
                <span class="old-price text-muted"><del>{{ number_format($product->price) }}đ</del></span>
            @endif
        </div>
        <div class="product-actions mt-2">
            <button class="btn btn-primary btn-sm add-to-cart" data-id="{{ $product->id }}">
                <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
            </button>
        </div>
    </div>
</div>
