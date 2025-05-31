@extends('frontend.layouts.master')

@section('title', 'Liên hệ')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Liên hệ</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Thông tin liên hệ -->
        <div class="col-md-6 mb-4">
            <h2 class="section-title">Thông tin liên hệ</h2>
            <div class="contact-info mt-4">
                <div class="mb-4">
                    <h5><i class="fas fa-map-marker-alt me-2"></i> Địa chỉ</h5>
                    <p>123 Đường ABC, Quận XYZ, TP. HCM</p>
                </div>
                <div class="mb-4">
                    <h5><i class="fas fa-phone me-2"></i> Điện thoại</h5>
                    <p>Hotline: 1900 xxxx</p>
                    <p>Di động: 0123.456.789</p>
                </div>
                <div class="mb-4">
                    <h5><i class="fas fa-envelope me-2"></i> Email</h5>
                    <p>support@example.com</p>
                </div>
                <div class="mb-4">
                    <h5><i class="fas fa-clock me-2"></i> Giờ làm việc</h5>
                    <p>Thứ 2 - Thứ 6: 8:00 - 17:00</p>
                    <p>Thứ 7: 8:00 - 12:00</p>
                </div>
            </div>
        </div>

        <!-- Form liên hệ -->
        <div class="col-md-6">
            <h2 class="section-title">Gửi tin nhắn cho chúng tôi</h2>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('client.contact.store') }}" method="POST" class="contact-form mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                           value="{{ old('subject') }}">
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                    <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                </button>
            </form>
        </div>
    </div>
</div>
@endsection