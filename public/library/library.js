(function($) {
    "use strict";
    var HT = {};
    var $document = $(document);

    // Xử lý switchery cho user status
    HT.switchery = () => {
        $('.js-switch').each(function() {
            var switchery = new Switchery(this, {color: '#1AB394'});
            
            $(this).on('change', function() {
                let status = $(this).prop('checked') ? 1 : 0;
                let userId = $(this).data('id');
                
                $.ajax({
                    url: '/user/update-status',
                    type: 'POST',
                    data: {
                        status: status,
                        user_id: userId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Cập nhật trạng thái thành công');
                        } else {
                            toastr.error('Có lỗi xảy ra');
                        }
                    }
                });
            });
        });
    }

    // Xử lý order status
    HT.orderStatus = () => {
        $('.order-status').change(function() {
            var orderId = $(this).data('id');
            var status = $(this).val();
            
            $.ajax({
                url: '/order/' + orderId + '/status',
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: status
                },
                success: function(response) {
                    toastr.success('Cập nhật trạng thái thành công');
                },
                error: function(error) {
                    toastr.error('Có lỗi xảy ra');
                }
            });
        });
    }

    // Xử lý tracking number
    HT.trackingNumber = () => {
        $('.tracking-number').blur(function() {
            var orderId = $(this).data('id');
            var trackingNumber = $(this).val();
            
            $.ajax({
                url: '/order/' + orderId + '/tracking',
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    tracking_number: trackingNumber
                },
                success: function(response) {
                    toastr.success('Cập nhật mã vận đơn thành công');
                },
                error: function(error) {
                    toastr.error('Có lỗi xảy ra');
                }
            });
        });
    }

    // Xử lý review
    HT.review = () => {
        // Xử lý khi click nút xem chi tiết
        $('.view-review').click(function() {
            var review = $(this).data('review');
            
            // Cập nhật nội dung modal
            $('#product-name').text(review.product.name);
            $('#customer-name').text(review.customer.name);
            $('#rating').html([...Array(5)].map((_, i) => 
                `<i class="fa fa-star ${i < review.rating ? 'text-warning' : 'text-muted'}"></i>`
            ).join(''));
            $('#comment').text(review.comment);
            $('#created-at').text(moment(review.created_at).format('DD/MM/YYYY HH:mm'));
            
            // Lưu ID đánh giá cho các nút duyệt/từ chối
            $('.approve-review, .reject-review').data('id', review.id);
        });

        // Xử lý khi click nút duyệt
        $('.approve-review').click(function() {
            updateReviewStatus($(this).data('id'), 'approved');
        });

        // Xử lý khi click nút từ chối 
        $('.reject-review').click(function() {
            updateReviewStatus($(this).data('id'), 'rejected');
        });

        // Hàm cập nhật trạng thái đánh giá
        function updateReviewStatus(id, status) {
            $.ajax({
                url: '/review/update-status',
                type: 'POST', 
                data: {
                    id: id,
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success('Cập nhật trạng thái thành công');
                        location.reload();
                    } else {
                        toastr.error('Có lỗi xảy ra');
                    }
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra');
                }
            });
        }
    }

    HT.featuredStatus = () => {
        $('.js-featured-switch').change(function() {
            let id = $(this).data('id');
            let featured = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                url: '/admin/product/update-featured',
                type: 'POST',
                data: {
                    id: id,
                    featured: featured,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success('Cập nhật trạng thái nổi bật thành công');
                    } else {
                        toastr.error('Có lỗi xảy ra');
                    }
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra');
                }
            });
        });
    }

    // Initialize khi document ready
    $document.ready(function(){
        HT.switchery();
        HT.orderStatus();
        HT.trackingNumber();
        HT.review();
        HT.featuredStatus();
    });
})(jQuery);