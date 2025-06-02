@php
use App\Models\Contact;
@endphp
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5><i class="fa fa-envelope"></i> Chi tiết liên hệ</h5>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-bold">Họ tên:</label>
                                <p>{{ $contact->name }}</p>
                            </div>
                            <div class="form-group">
                                <label class="font-bold">Email:</label>
                                <p>{{ $contact->email }}</p>
                            </div>
                            <div class="form-group">
                                <label class="font-bold">Số điện thoại:</label>
                                <p>{{ $contact->phone ?? 'Không có' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-bold">Ngày gửi:</label>
                                <p>{{ $contact->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="form-group">
                                <label class="font-bold">Trạng thái:</label>
                                <div class="d-flex align-items-center">
                                    {!! $contact->status_badge !!}
                                    <select class="form-control ml-2 contact-status" data-id="{{ $contact->id }}">
                                        @foreach(Contact::$statuses as $value => $label)
                                            <option value="{{ $value }}" {{ $contact->status === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-bold">Tiêu đề:</label>
                        <p>{{ $contact->subject }}</p>
                    </div>
                    <div class="form-group">
                        <label class="font-bold">Nội dung:</label>
                        <div class="well">{{ $contact->message }}</div>
                    </div>
                </div>
                <a href="{{ route('admin.contact.index') }}" class="btn btn-white btn-sm">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
            </div>
        </div>
    </div>
</div>

<!-- Form trả lời -->
@if(!$contact->isReplied())
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><i class="fa fa-reply"></i> Trả lời liên hệ</h5>
            </div>
            <div class="ibox-content">
                <form id="replyForm" data-url="{{ route('admin.contact.reply', $contact->id) }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="font-bold">Email người nhận:</label>
                        <p>{{ $contact->email }}</p>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-bold">Tiêu đề ban đầu:</label>
                        <p>{{ $contact->subject }}</p>
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-bold">Nội dung trả lời:</label>
                        <textarea name="reply_content" 
                                class="form-control" 
                                rows="5" 
                                required 
                                placeholder="Nhập nội dung trả lời..."></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btnSendReply">
                            <i class="fa fa-paper-plane"></i> Gửi trả lời
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <i class="fa fa-info-circle"></i> Liên hệ này đã được trả lời
</div>
@endif

@push('scripts')
<script>
$(document).ready(function() {
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
                toastr.success('Đã gửi trả lời thành công');
                setTimeout(function() {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.error || 'Có lỗi xảy ra khi gửi mail');
                btn.prop('disabled', false)
                   .html('<i class="fa fa-paper-plane"></i> Gửi trả lời');
            }
        });
    });
});
</script>
@endpush