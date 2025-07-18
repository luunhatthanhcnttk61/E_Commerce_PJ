@extends('frontend.layouts.master')

@section('title', 'Đăng nhập')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Đăng nhập</h3>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('client.auth.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <p>Hoặc đăng nhập với</p>
                        <div class="social-login">
                            <a href="{{ route('client.auth.google') }}" class="btn btn-danger mb-2 w-100">
                                <i class="fab fa-google"></i> Đăng nhập với Google
                            </a>
                            <a href="{{ route('client.auth.facebook') }}" class="btn btn-primary w-100">
                                <i class="fab fa-facebook"></i> Đăng nhập với Facebook
                            </a>
                        </div>

                    <div class="text-center mt-3">
                        <p>Chưa có tài khoản? <a href="{{ route('client.auth.register') }}">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection