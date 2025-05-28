<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Cài đặt hệ thống</h5>
            </div>
            <div class="ibox-content">
                <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Thông tin chung</h3>
                            <div class="form-group">
                                <label>Tên website</label>
                                <input type="text" name="site_name" class="form-control" 
                                       value="{{ $settings->where('key', 'site_name')->first()->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Email liên hệ</label>
                                <input type="email" name="contact_email" class="form-control"
                                       value="{{ $settings->where('key', 'contact_email')->first()->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="contact_phone" class="form-control"
                                       value="{{ $settings->where('key', 'contact_phone')->first()->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <textarea name="address" class="form-control" rows="3">{{ $settings->where('key', 'address')->first()->value ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3>Mạng xã hội</h3>
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" name="facebook_url" class="form-control"
                                       value="{{ $settings->where('key', 'facebook_url')->first()->value ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Youtube</label>
                                <input type="text" name="youtube_url" class="form-control"
                                       value="{{ $settings->where('key', 'youtube_url')->first()->value ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu cài đặt</button>
                </form>
            </div>
        </div>
    </div>
</div>