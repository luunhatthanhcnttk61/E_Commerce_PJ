<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Thêm Thành Viên Mới</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f2f5;
      padding: 20px;
    }
    .container {
      max-width: 400px;
      margin: 40px auto;
      background: white;
      padding: 25px 30px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #555;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"],
    textarea {
      width: 100%;
      padding: 8px 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 14px;
      resize: vertical;
    }
    textarea {
      min-height: 60px;
    }
    button {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Thêm Thành Viên Mới</h2>
  <form action="{{ route('user.storeUser') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="name">Họ và Tên</label>
      <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
      value="{{ old('name') }}" required >
      @error('name')
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
      value="{{ old('email') }}" required>
      @error('email')
       <span class="text-danger">{{ $message }}</span>
      @enderror
        </div>

    <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="address">Địa chỉ</label>
        <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
        @error('address')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone">Số điện thoại</label>
        <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone') }}">
        @error('phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Thêm Thành Viên</button>
  </form>
</div>

</body>
</html>