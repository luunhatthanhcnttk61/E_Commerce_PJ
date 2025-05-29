<?php
@extends('frontend.layouts.master')

@section('title', $category->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="my-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="category-banner mb-4">
        <img src="{{ $category->banner }}" alt="{{ $category->name }}" class="w-100">
    </div>

    <div class="product-filters mb-4">
        <div class="row">
            <div class="col-md-3">
                <select class="form-select" id="sort-by">
                    <option value="newest">Mới nhất</option>
                    <option value="price-asc">Giá tăng dần</option>
                    <option value="price-desc">Giá giảm dần</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="product-card">
                    <a href="{{ route('client.product.show', $product->slug) }}">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}">
                    </a>
                    <div class="product-info">
                        <h3><a href="{{ route('client.product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                        <p class="price">{{ number_format($product->price) }}đ</p>
                        <button class="btn btn-primary add-to-cart" data-id="{{ $product->id }}">
                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection