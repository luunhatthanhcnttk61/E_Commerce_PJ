@extends('frontend.layouts.master')

@section('title', $category->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-3">
            @include('frontend.components.category-sidebar')
        </div>
        <div class="col-md-9">
            <div class="products-grid">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4">
                            @include('frontend.components.product-card')
                        </div>
                    @endforeach
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection