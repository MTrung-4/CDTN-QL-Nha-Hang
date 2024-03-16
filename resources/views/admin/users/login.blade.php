<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.users.header')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Đăng nhập</p>
                @include('admin.users.alert')
                <form action="/admin/users/login/store" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Tên tài khoản">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Trong form đăng nhập -->
                    {{-- <div class="row mt-3">
                        <div class="col-12 text-center">
                            <a href="/admin/users/sendemail">Quên mật khẩu</a>
                        </div>
                    </div> --}}

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    Ghi nhớ
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" style="padding:10px">Đăng nhập</button>
                        </div>
                        <!-- /.col -->
                    </div>
                    @csrf
                </form>
            </div>
        </div>
        <!-- /.login-box -->
        @include('admin.users.footer')
</body>

</html>
