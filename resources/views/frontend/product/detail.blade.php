<@extends('frontend.layouts.master')

@section('title', $product->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
            @if($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('client.category.show', $product->category->slug) }}">
                        {{ $product->category->name }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-6">
            <div class="product-gallery">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid main-image">
                
                @if($product->images->count() > 0)
                    <div class="thumbnail-images mt-3">
                        @foreach($product->images as $image)
                            <img src="{{ asset($image->image) }}" 
                                alt="{{ $product->name }}" 
                                class="thumbnail"
                                onclick="changeMainImage(this.src)">
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="product-title">{{ $product->name }}</h1>
            @php
                $hasDiscount = $product->discount_percent > 0 && (!$product->discount_end_at || now()->lt($product->discount_end_at));
            @endphp

            <div class="product-price mb-3">
                @if($hasDiscount)
                    <span class="old-price d-block text-muted text-decoration-line-through">
                        {{ number_format($product->price) }}đ
                    </span>
                    <span class="current-price text-danger fw-bold fs-4">
                        {{ number_format($product->final_price) }}đ
                    </span>
                    <span class="badge bg-success ms-2">-{{ $product->discount_percent }}%</span>
                @else
                    <span class="current-price fs-4">{{ number_format($product->price) }}đ</span>
                @endif
            </div>

            <div class="product-description mb-4">
                {{ $product->short_description }}
            </div>
            <form action="{{ route('client.cart.add') }}" method="POST" class="add-to-cart-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="quantity mb-3">
                    <label>Số lượng:</label>
                    <input type="number" name="quantity" value="1" min="1" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                </button>
            </form>
        </div>
    </div>

    <div class="product-tabs mt-5">
        <ul class="nav nav-tabs" id="productTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#description">Mô tả</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#reviews">Đánh giá</a>
            </li>
        </ul>
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="description">
                {!! $product->description !!}
            </div>
            <div class="tab-pane fade" id="reviews">
                @include('frontend.product.components.reviews', ['reviews' => $approvedReviews])
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function changeMainImage(src) {
    document.querySelector('.main-image').src = src;
}
</script>
@endpush