<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>

    <link href="backends/css/bootstrap.min.css" rel="stylesheet">
    <link href="backends/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="{{ asset('backends/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('backends/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('backends/css/customize.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">IN+</h1>

            </div>
            <h3>Welcome to IN+</h3>
            <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p>Login in. To see it in action.</p>
            <form action="{{ route('auth.login')}}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Username" value="{{ old('email') }}" required="" >
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control @error('email') is-invalid @enderror" placeholder="Password" required="" >
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{ route('auth.register') }}">Create an account</a>
            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="backends/js/jquery-2.1.1.js"></script>
    <script src="backendsjs/bootstrap.min.js"></script>

</body>

</html>
