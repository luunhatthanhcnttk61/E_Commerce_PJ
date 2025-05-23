<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Thêm thành viên mới</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form action="{{ route('user.storeUser') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" 
                                   class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <textarea name="address" class="form-control">{{ old('address') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        <a href="{{ route('user.index') }}" class="btn btn-default">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>