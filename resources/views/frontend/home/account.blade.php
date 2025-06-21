@extends('frontend.layouts.master')

@section('title', 'Tài khoản của tôi')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="account-menu">
                        <h5>{{ auth()->user()->name }}</h5>
                        <hr>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('client.account.index') }}">
                                    <i class="fas fa-user"></i> Thông tin tài khoản
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('client.account.orders') }}">
                                    <i class="fas fa-shopping-bag"></i> Đơn hàng của tôi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('client.account.addresses') }}">
                                    <i class="fas fa-map-marker-alt"></i> Sổ địa chỉ
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('client.account.password') }}">
                                    <i class="fas fa-key"></i> Đổi mật khẩu
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('client.auth.logout') }}">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h4>Thông tin tài khoản</h4>
                    <form action="{{ route('client.account.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Họ tên</label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" 
                                   value="{{ auth()->user()->email }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" 
                                   value="{{ auth()->user()->phone }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection