@extends('frontend.layouts.master')

@section('title', 'Giỏ hàng của bạn')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>
    
    @if($cartItems->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($item->product->image) }}" 
                                     alt="{{ $item->product->name }}" 
                                     style="width: 50px; height: 50px; object-fit: cover">
                                <span class="ms-3">{{ $item->product->name }}</span>
                            </div>
                        </td>
                        <td>{{ number_format($item->price) }}đ</td>
                        <td>
                            <input type="number" 
                                   min="1" 
                                   value="{{ $item->quantity }}"
                                   class="form-control quantity-input"
                                   data-product-id="{{ $item->product_id }}"
                                   style="width: 80px">
                        </td>
                        <td>{{ number_format($item->price * $item->quantity) }}đ</td>
                        <td>
                            <button class="btn btn-danger btn-sm remove-from-cart"
                                    data-product-id="{{ $item->product_id }}">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                        <td colspan="2"><strong>{{ number_format($total) }}đ</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="text-end mt-4">
            <a href="{{ route('client.product.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm
            </a>
            <a href="{{ route('client.checkout.index') }}" class="btn btn-primary">
                <i class="fas fa-credit-card"></i> Tiến hành thanh toán
            </a>
        </div>
    @else
        <div class="alert alert-info">
            <p class="mb-0">Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('client.product.index') }}" class="btn btn-primary mt-3">
                <i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Cập nhật số lượng
    $('.quantity-input').change(function() {
        let productId = $(this).data('product-id');
        let quantity = $(this).val();
        
        $.ajax({
            url: "{{ route('client.cart.update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if(response.success) {
                    window.location.reload();
                }
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });

    // Xóa sản phẩm khỏi giỏ hàng
    $('.remove-from-cart').click(function() {
        if(!confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
            return;
        }
        
        let productId = $(this).data('product-id');
        
        $.ajax({
            url: "{{ route('client.cart.remove', '') }}/" + productId,
            method: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success) {
                    window.location.reload();
                }
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
});
</script>
@endpush
@endsection