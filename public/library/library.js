(function($) {
    "use strict";
    var HT = {};
    var $document = $(document);

    // Xử lý switchery cho user và product status
    HT.switchery = () => {
        // Xử lý user status
        $('.js-switch-user').each(function() {
            var switchery = new Switchery(this, {color: '#1AB394'});
            
            $(this).on('change', function() {
                let status = $(this).prop('checked') ? 1 : 0;
                let userId = $(this).data('id');
                
                $.ajax({
                    url: '/admin/user/update-status',
                    type: 'POST',
                    data: {
                        status: status,
                        user_id: userId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Cập nhật trạng thái người dùng thành công');
                        } else {
                            toastr.error('Có lỗi xảy ra khi cập nhật người dùng');
                        }
                    },
                    error: function() {
                        toastr.error('Có lỗi xảy ra khi cập nhật người dùng');
                    }
                });
            });
        });

        // Xử lý product status
        $('.js-switch-product-status').each(function() {
            var switchery = new Switchery(this, {color: '#1AB394'});
            
            $(this).on('change', function() {
                let status = $(this).prop('checked') ? 1 : 0;
                let productId = $(this).data('id');
                
                $.ajax({
                    url: '/admin/product/update-status',
                    type: 'POST',
                    data: {
                        status: status,
                        id: productId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Cập nhật trạng thái sản phẩm thành công');
                        } else {
                            toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm');
                        }
                    },
                    error: function() {
                        toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm');
                    }
                });
            });
        });

    // Xử lý product featured
        $('.js-switch-product-featured').each(function() {
            var switchery = new Switchery(this, {color: '#1AB394'});
            
            $(this).on('change', function() {
                let featured = $(this).prop('checked') ? 1 : 0;
                let productId = $(this).data('id');
                
                $.ajax({
                    url: '/admin/product/update-featured',
                    type: 'POST',
                    data: {
                        featured: featured,
                        id: productId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success('Cập nhật sản phẩm nổi bật thành công');
                        } else {
                            toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm');
                        }
                    },
                    error: function() {
                        toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm');
                    }
                });
            });
        });
        // Thêm xử lý category status
    $('.js-switch-category-status').each(function() {
        var switchery = new Switchery(this, {color: '#1AB394'});
        
        $(this).on('change', function() {
            let status = $(this).prop('checked') ? 'active' : 'inactive'; // Chú ý: category dùng string
            let categoryId = $(this).data('id');
            
            $.ajax({
                url: '/admin/category/update-status',
                type: 'POST',
                data: {
                    status: status,
                    id: categoryId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success('Cập nhật trạng thái danh mục thành công');
                    } else {
                        toastr.error('Có lỗi xảy ra khi cập nhật danh mục');
                    }
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra khi cập nhật danh mục');
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


    HT.contact = function() {
    // Xử lý form trả lời
    $('#replyForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = $('#btnSendReply');
        
        $.ajax({
            url: form.data('url'),
            method: 'POST',
            data: form.serialize(),
            beforeSend: function() {
                btn.prop('disabled', true)
                   .html('<i class="fa fa-spinner fa-spin"></i> Đang gửi...');
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Đã gửi trả lời thành công');
                    // Cập nhật UI sau khi trả lời
                    updateStatusBadge('replied');
                    form.hide();
                    $('.alert-replied').show();
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.error || 'Có lỗi xảy ra');
                btn.prop('disabled', false)
                   .html('<i class="fa fa-paper-plane"></i> Gửi trả lời');
            }
        });
    });

    // Helper function để cập nhật badge trạng thái
    function updateStatusBadge(status) {
        const badges = {
            'new': 'badge-primary',
            'read': 'badge-info',
            'replied': 'badge-success'
        };
        
        const labels = {
            'new': 'Mới',
            'read': 'Đã đọc',
            'replied': 'Đã trả lời'
        };

        const badge = $('.status-badge');
        badge.removeClass(Object.values(badges).join(' '))
             .addClass(badges[status])
             .text(labels[status]);
    }
};

    // Initialize khi document ready
    $document.ready(function(){
        HT.switchery();
        HT.orderStatus();
        HT.trackingNumber();
        HT.review();
        HT.contact();
    });
})(jQuery);