@extends('frontend.layouts.master')

@section('title', 'Liên hệ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Liên hệ với chúng tôi</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('client.contact.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Họ tên</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea name="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection