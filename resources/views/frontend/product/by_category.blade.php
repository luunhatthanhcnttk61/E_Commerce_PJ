@extends('frontend.layouts.master')

@section('title', $category->name)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar danh mục -->
        <div class="col-md-3">
            @include('frontend.components.category-sidebar')
        </div>
        
        <!-- Danh sách sản phẩm -->
        <div class="col-md-9">
            <h2 class="mb-4">{{ $category->name }}</h2>
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        @include('frontend.components.product-card')
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            Không có sản phẩm nào trong danh mục này.
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Phân trang -->
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection