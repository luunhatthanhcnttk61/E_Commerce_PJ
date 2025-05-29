(function($) {
    "use strict";
    var FE = {};
    var $document = $(document);

    // Xử lý giỏ hàng
    FE.cart = () => {
        // Thêm vào giỏ hàng
        $('.add-to-cart').click(function(e) {
            e.preventDefault();
            let productId = $(this).data('id');
            let quantity = $('#quantity').val() || 1;
            
            $.ajax({
                url: '/cart/add',
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        updateCartCount(response.cartCount);
                        toastr.success('Thêm vào giỏ hàng thành công');
                    }
                }
            });
        });

        // Cập nhật số lượng
        $('.update-cart').change(function() {
            let productId = $(this).data('id');
            let quantity = $(this).val();
            
            updateCartItem(productId, quantity);
        });

        // Xóa sản phẩm khỏi giỏ
        $('.remove-cart').click(function() {
            let productId = $(this).data('id');
            
            removeCartItem(productId);
        });
    }

    // Xử lý đánh giá sản phẩm
    FE.review = () => {
        // Xử lý submit đánh giá
        $('#review-form').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if(response.success) {
                        toastr.success('Gửi đánh giá thành công');
                        form[0].reset();
                    }
                }
            });
        });

        // Xử lý rating stars
        $('.rating-stars i').hover(
            function() {
                let index = $(this).index() + 1;
                highlightStars(index);
            },
            function() {
                let rating = $('#rating').val();
                highlightStars(rating);
            }
        );

        $('.rating-stars i').click(function() {
            let rating = $(this).index() + 1;
            $('#rating').val(rating);
            highlightStars(rating);
        });
    }

    
// Xử lý thanh toán
FE.checkout = () => {
    $('#checkout-form').submit(function(e) {
        let paymentMethod = $('input[name="payment_method"]:checked').val();
        
        if(paymentMethod === 'vnpay' || paymentMethod === 'momo') {
            e.preventDefault();
            let formData = $(this).serialize();
            
            $.ajax({
                url: '/checkout/payment-url',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if(response.success) {
                        window.location.href = response.payment_url;
                    }
                }
            });
        }
    });
}

    // Helper functions
    function updateCartCount(count) {
        $('.cart-count').text(count);
    }

    function updateCartItem(productId, quantity) {
        $.ajax({
            url: '/cart/update',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: quantity,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    location.reload();
                }
            }
        });
    }

    function removeCartItem(productId) {
        $.ajax({
            url: '/cart/remove/' + productId,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    location.reload();
                }
            }
        });
    }

    function highlightStars(count) {
        $('.rating-stars i').each(function(index) {
            $(this).toggleClass('active', index < count);
        });
    }

    // Initialize
    $document.ready(function(){
        FE.cart();
        FE.review();
        FE.checkout();
    });
})(jQuery);