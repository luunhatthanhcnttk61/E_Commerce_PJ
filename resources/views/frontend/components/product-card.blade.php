<div class="product-card">
    <a href="{{ route('client.product.show', $product->id) }}">
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
    </a>
    <div class="product-info">
        <h3 class="product-title">
            <a href="{{ route('client.product.show', $product->id) }}">{{ $product->name }}</a>
        </h3>
        <div class="product-price">
            <span class="current-price">{{ number_format($product->price) }}đ</span>
            @if($product->old_price)
                <span class="old-price">{{ number_format($product->old_price) }}đ</span>
            @endif
        </div>
        <div class="product-actions">
            <button class="btn btn-primary btn-sm add-to-cart" data-id="{{ $product->id }}">
                <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
            </button>
        </div>
    </div>
</div>