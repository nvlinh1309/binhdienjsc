<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Forgot Password</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/template/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">
</head>


<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">
                <img src="{{ asset('images/logo-full.png') }}" alt="" width="150px">
            </a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Hãy khôi phục mật khẩu của bạn ngay bây giờ.</p>
                @if (Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <form action="{{ route('reset.password.post') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    {{-- <div class="input-group mb-3">
                        <input name="email" value="{{ old('email') }}" type="text" class="form-control"
                            placeholder="Nhập địa chỉ email...">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div> --}}
                    @if ($errors->has('email'))
                        <div class="input-group-append  mb-3">
                            <div class="input-group-text">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="input-group mb-3">
                        <input name="password" type="password" value="{{ old('password') }}" class="form-control"
                            placeholder="Nhập mật khẩu mới..">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                        <div class="input-group-append mb-3">
                            <div class="input-group-text">
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                            class="form-control" placeholder="Nhập lại mật khẩu..">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <div class="input-group-append mb-3">
                            <div class="input-group-text">
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Reset Mật khẩu</button>
                        </div>

                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('login.index') }}">Login</a>
                </p>
            </div>

        </div>
    </div>


    <!-- jQuery -->
    <script src="/template/admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/template/admin/dist/js/adminlte.min.js"></script>
</body>

</html>
