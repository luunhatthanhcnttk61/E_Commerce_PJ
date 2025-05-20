<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Register</title>

    <link href="backends/css/bootstrap.min.css" rel="stylesheet">
    <link href="backends/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="backends/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="{{ asset('backends/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('backends/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('backendscss/customize.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">IN+</h1>

            </div>
            <h3>Register to IN+</h3>
            <p>Create account to see it in action.</p>
            <form class="m-t" role="form" action="{{ route('auth.register.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}" name="name" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        
                    @enderror
                </div>
                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email (@gmail.com)" value= "{{ old('email') }}" name="email" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password (minimum 8 characters)" name="password" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" name = "checkbox" @if(old('checkbox')) checked @endif><i></i> Agree the terms and policy </label></div>
                        @error('checkbox')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href= {{ route('auth.index') }}>Login</a>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>

</html>
