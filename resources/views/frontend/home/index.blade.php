@extends('frontend.layouts.master')

@section('title', 'Trang chủ')

@section('content')
<div class="container">
    <!-- Banner Section -->
<div class="banner-section mb-5">
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('uploads/banner/banner1.jpg') }}" class="d-block w-100" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('uploads/banner/banner2.jpg') }}" class="d-block w-100" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('uploads/banner/banner3.jpg') }}" class="d-block w-100" alt="Banner 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

    <!-- Featured Products -->
    <section class="featured-products my-5">
        <h2 class="section-title">Sản phẩm nổi bật</h2>
        <div class="row">
            @foreach($featured_products as $product)
            <div class="col-md-3">
                <div class="product-card border p-2">
                    <div class="position-relative">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid w-100">
                        @php
                            $hasDiscount = $product->discount_percent > 0 && (!$product->discount_end_at || now()->lt($product->discount_end_at));
                        @endphp

                        @if($hasDiscount)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                -{{ $product->discount_percent }}%
                            </span>
                        @endif
                    </div>

                    <h5 class="mt-2">{{ $product->name }}</h5>

                    @if($hasDiscount)
                        <p class="price text-danger mb-1">{{ number_format($product->final_price) }}đ</p>
                        <p class="old-price text-muted"><del>{{ number_format($product->price) }}đ</del></p>
                    @else
                        <p class="price">{{ number_format($product->price) }}đ</p>
                    @endif

                    <button class="btn btn-primary btn-sm add-to-cart" data-id="{{ $product->id }}">
                        Thêm vào giỏ
                    </button>
                </div>
            </div>

            @endforeach
        </div>
    </section>

    <!-- New Products -->
<section class="new-products my-5">
    <h2 class="section-title">Sản phẩm mới</h2>
    <div class="row">
        @foreach($new_products as $product)
        <div class="col-md-3">
            <div class="product-card border p-2">
                <div class="position-relative">
                    <a href="{{ route('client.product.show', $product->id) }}">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid w-100">
                    </a>

                    @php
                        $hasDiscount = $product->discount_percent > 0 && (!$product->discount_end_at || now()->lt($product->discount_end_at));
                    @endphp

                    @if($hasDiscount)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                            -{{ $product->discount_percent }}%
                        </span>
                    @endif
                </div>

                <div class="product-info mt-2 text-center">
                    <h5><a href="{{ route('client.product.show', $product->id) }}" class="text-dark text-decoration-none">{{ $product->name }}</a></h5>

                    @if($hasDiscount)
                        <p class="price text-danger mb-1">{{ number_format($product->final_price) }}đ</p>
                        <p class="old-price text-muted"><del>{{ number_format($product->price) }}đ</del></p>
                    @else
                        <p class="price">{{ number_format($product->price) }}đ</p>
                    @endif

                    <button class="btn btn-primary btn-sm add-to-cart" data-id="{{ $product->id }}">
                        <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- Categories Section -->
<section class="categories-section my-5">
    <h2 class="section-title">Danh mục sản phẩm</h2>
    <div class="row">
        @foreach($categories as $category)
        <div class="col-md-4 mb-4">
            <div class="category-card">
                <a href="{{ route('client.category.show', $category->slug) }}">
                    <img src="{{asset('uploads/category/' . $category->name. '.jpg') }}" alt="{{ $category->name }}">
                    <div class="category-overlay">
                        <h3>{{ $category->name }}</h3>
                        <p>{{ $category->products_count }} sản phẩm</p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
<!-- About Section -->
<section class="about-section my-5">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="feature-box text-center">
                <i class="fas fa-truck fa-3x mb-3"></i>
                <h4>Miễn phí vận chuyển</h4>
                <p>Cho đơn hàng từ 500.000đ</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="feature-box text-center">
                <i class="fas fa-undo fa-3x mb-3"></i>
                <h4>Đổi trả miễn phí</h4>
                <p>Trong vòng 30 ngày</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="feature-box text-center">
                <i class="fas fa-headset fa-3x mb-3"></i>
                <h4>Hỗ trợ 24/7</h4>
                <p>Hotline: 1900.xxxx</p>
            </div>
        </div>
    </div>
</section>
</div>
@endsection