(function($) {
    "use strict";
    var HT = {};
    var $document = $(document);

    HT.switchery = () => {
        $('.js-switch').each(function() {
            var switchery = new Switchery(this, {color: '#1AB394'});
            
            // Thêm sự kiện change
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

    $document.ready(function(){
        HT.switchery();
    });
})(jQuery);