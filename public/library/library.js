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

    // Initialize khi document ready
    $document.ready(function(){
        HT.switchery();
        HT.orderStatus();
        HT.trackingNumber();
    });
})(jQuery);