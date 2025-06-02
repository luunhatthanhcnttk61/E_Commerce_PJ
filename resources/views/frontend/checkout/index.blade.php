@extends('frontend.layouts.master')

@section('content')
<div class="checkout-section">
    <div class="container">
        <h2 class="section-title">Checkout</h2>
        
        <div class="row">
            <div class="col-md-8">
                <div class="checkout-form">
                    <form action="{{ route('client.checkout.process') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Payment Method</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="cod">Cash on Delivery</option>
                                <option value="vnpay">VN Pay</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="order-summary">
                    <h4>Order Summary</h4>
                    
                    @foreach($cart as $item)
                    <div class="cart-item">
                        <div class="item-name">{{ $item->name }}</div>
                        <div class="item-quantity">x {{ $item->quantity }}</div>
                        <div class="item-price">${{ number_format($item->price, 2) }}</div>
                    </div>
                    @endforeach

                    <div class="total">
                        <strong>Total:</strong>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#checkout-form').on('submit', function(e) {
            e.preventDefault();
            
            let form = $(this);
            let url = form.attr('action');
            let data = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function(response) {
                    if(response.success && response.payment_url) {
                        window.location.href = response.payment_url;
                    } else {
                        window.location.href = '{{ route("client.checkout.success", ":id") }}'.replace(':id', response.order_id);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>
@endpush