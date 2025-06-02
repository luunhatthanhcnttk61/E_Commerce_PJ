@extends('frontend.layouts.master')

@section('content')
<div class="container my-5">
    <h2>Shopping Cart</h2>
    
    @if($cart->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr>
                        <td>
                            <img src="{{ asset($item->attributes->image) }}" alt="{{ $item->name }}" style="width: 50px">
                            {{ $item->name }}
                        </td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>
                            <input type="number" 
                                   min="1" 
                                   value="{{ $item->quantity }}"
                                   class="form-control quantity-input"
                                   data-id="{{ $item->id }}"
                                   style="width: 80px">
                        </td>
                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm remove-from-cart"
                                    data-id="{{ $item->id }}">
                                Remove
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="text-right">
            <a href="{{ route('client.checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    @else
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('client.product.index') }}">Continue shopping</a>
        </div>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Update quantity
    $('.quantity-input').change(function() {
        let id = $(this).data('id');
        let quantity = $(this).val();
        
        $.ajax({
            url: "{{ route('client.cart.update') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                product_id: id,
                quantity: quantity
            },
            success: function(response) {
                if(response.success) {
                    window.location.reload();
                }
            }
        });
    });

    // Remove item from cart
    $('.remove-from-cart').click(function() {
        let id = $(this).data('id');
        
        $.ajax({
            url: "{{ route('client.cart.remove', '') }}/" + id,
            method: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success) {
                    window.location.reload();
                }
            }
        });
    });
});
</script>
@endpush
@endsection