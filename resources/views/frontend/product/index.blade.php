@extends('frontend.layouts.master')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Sidebar danh mục -->
        <div class="col-md-3">
            @include('frontend.components.category-sidebar')
        </div>
        
        <!-- Danh sách sản phẩm -->
        <div class="col-md-9">
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        @include('frontend.components.product-card')
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            Không có sản phẩm nào.
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