(function($) {
    "use strict";
    var HT = {};
    var $document = $(document);

    HT.switchery = () => {
        // User status
        $('.js-switch-user').each(function() {
            new Switchery(this, { color: '#1AB394' });
            $(this).on('change', function() {
                let status = $(this).prop('checked') ? 1 : 0;
                let userId = $(this).data('id');

                $.post('/admin/user/update-status', {
                    status,
                    user_id: userId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }).done(function(res) {
                    res.success ? toastr.success('Cập nhật trạng thái người dùng thành công') :
                                  toastr.error('Có lỗi xảy ra khi cập nhật người dùng');
                }).fail(() => toastr.error('Có lỗi xảy ra khi cập nhật người dùng'));
            });
        });

        // Product status
        $('.js-switch-product-status').each(function() {
            new Switchery(this, { color: '#1AB394' });
            $(this).on('change', function() {
                let status = $(this).prop('checked') ? 1 : 0;
                let productId = $(this).data('id');

                $.post('/admin/product/update-status', {
                    status,
                    id: productId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }).done(function(res) {
                    res.success ? toastr.success('Cập nhật trạng thái sản phẩm thành công') :
                                  toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm');
                }).fail(() => toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm'));
            });
        });

        // Product featured
        $('.js-switch-product-featured').each(function() {
            new Switchery(this, { color: '#1AB394' });
            $(this).on('change', function() {
                let featured = $(this).prop('checked') ? 1 : 0;
                let productId = $(this).data('id');

                $.post('/admin/product/update-featured', {
                    featured,
                    id: productId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }).done(function(res) {
                    res.success ? toastr.success('Cập nhật sản phẩm nổi bật thành công') :
                                  toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm');
                }).fail(() => toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm'));
            });
        });

        // Category status
        $('.js-switch-category-status').each(function() {
            new Switchery(this, { color: '#1AB394' });
            $(this).on('change', function() {
                let status = $(this).prop('checked') ? 'active' : 'inactive';
                let categoryId = $(this).data('id');

                $.post('/admin/category/update-status', {
                    status,
                    id: categoryId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }).done(function(res) {
                    res.success ? toastr.success('Cập nhật trạng thái danh mục thành công') :
                                  toastr.error('Có lỗi xảy ra khi cập nhật danh mục');
                }).fail(() => toastr.error('Có lỗi xảy ra khi cập nhật danh mục'));
            });
        });

        // Customer status
        $('.js-switch-customer-status').each(function() {
            new Switchery(this, { color: '#1AB394' });
            $(this).on('change', function() {
                let status = $(this).prop('checked') ? 'active' : 'inactive';
                let customerId = $(this).data('id');

                $.post('/admin/category/update-status', {
                    status,
                    id: customerId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }).done(function(res) {
                    res.success ? toastr.success('Cập nhật trạng thái khách hàng thành công') :
                                  toastr.error('Có lỗi xảy ra khi cập nhật khách hàng');
                }).fail(() => toastr.error('Có lỗi xảy ra khi cập nhật khách hàng'));
            });
        });
    };

    HT.orderStatus = () => {
        $('.order-status').change(function () {
            let orderId = $(this).data('id');
            let status = $(this).val();

            $.ajax({
                url: '/admin/order/' + orderId + '/status',
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: status
                },
                success: function (response) {
                    response.success ? toastr.success(response.message) :
                                       toastr.error('Không thể cập nhật trạng thái đơn hàng');
                },
                error: function () {
                    toastr.error('Lỗi máy chủ. Vui lòng thử lại');
                }
            });
        });
    };

    HT.trackingNumber = () => {
        $('.tracking-number').blur(function() {
            let orderId = $(this).data('id');
            let trackingNumber = $(this).val();

            $.ajax({
                url: '/order/' + orderId + '/tracking',
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    tracking_number: trackingNumber
                },
                success: function() {
                    toastr.success('Cập nhật mã vận đơn thành công');
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra');
                }
            });
        });
    };

    HT.review = () => {
        $('.view-review').click(function() {
            let review = $(this).data('review');

            $('#product-name').text(review.product.name);
            $('#customer-name').text(review.customer.name);
            $('#rating').html([...Array(5)].map((_, i) => 
                `<i class="fa fa-star ${i < review.rating ? 'text-warning' : 'text-muted'}"></i>`
            ).join(''));
            $('#comment').text(review.comment);
            let date = new Date(review.created_at);
            let formatted = `${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}/${date.getFullYear()} ${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
            $('#created-at').text(formatted);
            $('.approve-review, .reject-review').data('id', review.id);
        });

        $('.approve-review').click(function() {
            updateReviewStatus($(this).data('id'), 'approved');
        });

        $('.reject-review').click(function() {
            updateReviewStatus($(this).data('id'), 'rejected');
        });

        function updateReviewStatus(id, status) {
            $.ajax({
                url: '/admin/review/update-status',
                type: 'POST',
                data: {
                    id: id,
                    status: status,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Cập nhật trạng thái đánh giá thành công');
                        $('#reviewModal').modal('hide');
                        setTimeout(() => location.reload(), 500);
                    } else {
                        toastr.error('Có lỗi xảy ra');
                    }
                },
                error: function() {
                    toastr.error('Có lỗi xảy ra');
                }
            });
        }
    };

    HT.contact = () => {
        $('#replyForm').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let btn = $('#btnSendReply');

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

    $document.ready(function() {
        HT.switchery();
        HT.orderStatus();
        HT.trackingNumber();
        HT.review();
        HT.contact();
    });
})(jQuery);
