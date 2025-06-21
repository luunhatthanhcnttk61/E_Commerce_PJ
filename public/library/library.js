// (function($) {
//     "use strict";
//     var HT = {};
//     var $document = $(document);

//     // Xử lý switchery cho user và product status
//     HT.switchery = () => {
//         // Xử lý user status
//         $('.js-switch-user').each(function() {
//             var switchery = new Switchery(this, {color: '#1AB394'});
            
//             $(this).on('change', function() {
//                 let status = $(this).prop('checked') ? 1 : 0;
//                 let userId = $(this).data('id');
                
//                 $.ajax({
//                     url: '/admin/user/update-status',
//                     type: 'POST',
//                     data: {
//                         status: status,
//                         user_id: userId,
//                         _token: $('meta[name="csrf-token"]').attr('content')
//                     },
//                     success: function(response) {
//                         if(response.success) {
//                             toastr.success('Cập nhật trạng thái người dùng thành công');
//                         } else {
//                             toastr.error('Có lỗi xảy ra khi cập nhật người dùng');
//                         }
//                     },
//                     error: function() {
//                         toastr.error('Có lỗi xảy ra khi cập nhật người dùng');
//                     }
//                 });
//             });
//         });

//         // Xử lý product status
//         $('.js-switch-product-status').each(function() {
//             var switchery = new Switchery(this, {color: '#1AB394'});
            
//             $(this).on('change', function() {
//                 let status = $(this).prop('checked') ? 1 : 0;
//                 let productId = $(this).data('id');
                
//                 $.ajax({
//                     url: '/admin/product/update-status',
//                     type: 'POST',
//                     data: {
//                         status: status,
//                         id: productId,
//                         _token: $('meta[name="csrf-token"]').attr('content')
//                     },
//                     success: function(response) {
//                         if(response.success) {
//                             toastr.success('Cập nhật trạng thái sản phẩm thành công');
//                         } else {
//                             toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm');
//                         }
//                     },
//                     error: function() {
//                         toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm');
//                     }
//                 });
//             });
//         });

//     // Xử lý product featured
//         $('.js-switch-product-featured').each(function() {
//             var switchery = new Switchery(this, {color: '#1AB394'});
            
//             $(this).on('change', function() {
//                 let featured = $(this).prop('checked') ? 1 : 0;
//                 let productId = $(this).data('id');
                
//                 $.ajax({
//                     url: '/admin/product/update-featured',
//                     type: 'POST',
//                     data: {
//                         featured: featured,
//                         id: productId,
//                         _token: $('meta[name="csrf-token"]').attr('content')
//                     },
//                     success: function(response) {
//                         if(response.success) {
//                             toastr.success('Cập nhật sản phẩm nổi bật thành công');
//                         } else {
//                             toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm');
//                         }
//                     },
//                     error: function() {
//                         toastr.error('Có lỗi xảy ra khi cập nhật sản phẩm');
//                     }
//                 });
//             });
//         });
//         // Thêm xử lý category status
//     $('.js-switch-category-status').each(function() {
//         var switchery = new Switchery(this, {color: '#1AB394'});
        
//         $(this).on('change', function() {
//             let status = $(this).prop('checked') ? 'active' : 'inactive';
//             let categoryId = $(this).data('id');
//             $.ajax({
//                 url: '/admin/category/update-status',
//                 type: 'POST',
//                 data: {
//                     status: status,
//                     id: categoryId,
//                     _token: $('meta[name="csrf-token"]').attr('content')
//                 },
//                 success: function(response) {
//                     if(response.success) {
//                         toastr.success('Cập nhật trạng thái danh mục thành công');
//                     } else {
//                         toastr.error('Có lỗi xảy ra khi cập nhật danh mục');
//                     }
//                 },
//                 error: function() {
//                     toastr.error('Có lỗi xảy ra khi cập nhật danh mục');
//                 }
//             });
//         });
//     });

//     $('.js-switch-customer-status').each(function() {
//         var switchery = new Switchery(this, {color: '#1AB394'});
        
//         $(this).on('change', function() {
//             let status = $(this).prop('checked') ? 'active' : 'inactive';
//             let customerId = $(this).data('id');
            
//             $.ajax({
//                 url: '/admin/category/update-status',
//                 type: 'POST',
//                 data: {
//                     status: status,
//                     id: customerId,
//                     _token: $('meta[name="csrf-token"]').attr('content')
//                 },
//                 success: function(response) {
//                     if(response.success) {
//                         toastr.success('Cập nhật trạng thái khách hàng thành công');
//                     } else {
//                         toastr.error('Có lỗi xảy ra khi cập nhật khách hàng');
//                     }
//                 },
//                 error: function() {
//                     toastr.error('Có lỗi xảy ra khi cập nhật khách hàng');
//                 }
//             });
//         });
//     });
// }
        
//     // Xử lý order status
//        HT.orderStatus = () => {
//             $('.order-status').change(function () {
//                 let orderId = $(this).data('id');
//                 let status = $(this).val();

//                 $.ajax({
//                     url: '/admin/order/' + orderId + '/status', // route xử lý cập nhật
//                     type: 'PUT',
//                     data: {
//                         _token: $('meta[name="csrf-token"]').attr('content'),
//                         status: status
//                     },
//                     success: function (response) {
//                         if (response.success) {
//                             toastr.success(response.message);
//                         } else {
//                             toastr.error('Không thể cập nhật trạng thái đơn hàng');
//                         }
//                     },
//                     error: function () {
//                         toastr.error('Lỗi máy chủ. Vui lòng thử lại');
//                     }
//                 });
//             });
//         }


//     // Xử lý tracking number
//     HT.trackingNumber = () => {
//         $('.tracking-number').blur(function() {
//             var orderId = $(this).data('id');
//             var trackingNumber = $(this).val();
            
//             $.ajax({
//                 url: '/order/' + orderId + '/tracking',
//                 type: 'PUT',
//                 data: {
//                     _token: $('meta[name="csrf-token"]').attr('content'),
//                     tracking_number: trackingNumber
//                 },
//                 success: function(response) {
//                     toastr.success('Cập nhật mã vận đơn thành công');
//                 },
//                 error: function(error) {
//                     toastr.error('Có lỗi xảy ra');
//                 }
//             });
//         });
//     }

//     // Xử lý review
//     HT.review = () => {
//         // Xử lý khi click nút xem chi tiết
//         $('.view-review').click(function() {
//             var review = $(this).data('review');
            
//             // Cập nhật nội dung modal
//             $('#product-name').text(review.product.name);
//             $('#customer-name').text(review.customer.name);
//             $('#rating').html([...Array(5)].map((_, i) => 
//                 `<i class="fa fa-star ${i < review.rating ? 'text-warning' : 'text-muted'}"></i>`
//             ).join(''));
//             $('#comment').text(review.comment);
//             $('#created-at').text(moment(review.created_at).format('DD/MM/YYYY HH:mm'));
            
//             // Lưu ID đánh giá cho các nút duyệt/từ chối
//             $('.approve-review, .reject-review').data('id', review.id);
//         });

//         // Xử lý khi click nút duyệt
//         $('.approve-review').click(function() {
//             updateReviewStatus($(this).data('id'), 'approved');
//         });

//         // Xử lý khi click nút từ chối 
//         $('.reject-review').click(function() {
//             updateReviewStatus($(this).data('id'), 'rejected');
//         });

//         // Hàm cập nhật trạng thái đánh giá
//         function updateReviewStatus(id, status) {
//             $.ajax({
//                 url: '/review/update-status',
//                 type: 'POST', 
//                 data: {
//                     id: id,
//                     status: status,
//                     _token: $('meta[name="csrf-token"]').attr('content')
//                 },
//                 success: function(response) {
//                     if(response.success) {
//                         toastr.success('Cập nhật trạng thái thành công');
//                         location.reload();
//                     } else {
//                         toastr.error('Có lỗi xảy ra');
//                     }
//                 },
//                 error: function() {
//                     toastr.error('Có lỗi xảy ra');
//                 }
//             });
//         }
//     }


//     HT.contact = function() {
//     // Xử lý form trả lời
//     $('#replyForm').on('submit', function(e) {
//         e.preventDefault();
//         var form = $(this);
//         var btn = $('#btnSendReply');
        
//         $.ajax({
//             url: form.data('url'),
//             method: 'POST',
//             data: form.serialize(),
//             beforeSend: function() {
//                 btn.prop('disabled', true)
//                    .html('<i class="fa fa-spinner fa-spin"></i> Đang gửi...');
//             },
//             success: function(response) {
//                 if (response.success) {
//                     toastr.success('Đã gửi trả lời thành công');
//                     // Cập nhật UI sau khi trả lời
//                     updateStatusBadge('replied');
//                     form.hide();
//                     $('.alert-replied').show();
//                 }
//             },
//             error: function(xhr) {
//                 toastr.error(xhr.responseJSON.error || 'Có lỗi xảy ra');
//                 btn.prop('disabled', false)
//                    .html('<i class="fa fa-paper-plane"></i> Gửi trả lời');
//             }
//         });
//     });

//     // Helper function để cập nhật badge trạng thái
//     function updateStatusBadge(status) {
//         const badges = {
//             'new': 'badge-primary',
//             'read': 'badge-info',
//             'replied': 'badge-success'
//         };
        
//         const labels = {
//             'new': 'Mới',
//             'read': 'Đã đọc',
//             'replied': 'Đã trả lời'
//         };

//         const badge = $('.status-badge');
//         badge.removeClass(Object.values(badges).join(' '))
//              .addClass(badges[status])
//              .text(labels[status]);
//     }
// };

//     // Initialize khi document ready
//     $document.ready(function(){
//         HT.switchery();
//         HT.orderStatus();
//         HT.trackingNumber();
//         HT.review();
//         HT.contact();
//     });
// })(jQuery);


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
