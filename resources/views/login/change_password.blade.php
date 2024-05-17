@extends('main')

@section('content')
    <style>
        button[type="submit"] {
            display: block;
            margin: 10px auto;
            /* Đảm bảo nút được căn giữa theo chiều ngang */
        }

        .card-header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
        }
    </style>
    <div style="margin: 100px auto 50px auto" class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('admin.users.alert-web')
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="mb-0">Thay Đổi Mật Khẩu</h5>
                    </div>
                    <form method="POST" action="{{ route('change-password') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right">Mật Khẩu Hiện
                                Tại</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="current_password" type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        name="current_password" required autocomplete="current_password">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-password" type="button"
                                            toggle="#current_password">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new_password" class="col-md-4 col-form-label text-md-right">Mật Khẩu Mới</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="new_password" type="password"
                                        class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                                        required autocomplete="new_password">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-password" type="button"
                                            toggle="#new_password">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">Xác
                                Nhận Mật Khẩu Mới</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="new_password_confirmation" type="password" class="form-control"
                                        name="new_password_confirmation" required autocomplete="new_password_confirmation">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-password" type="button"
                                            toggle="#new_password_confirmation">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Thay
                            Đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".toggle-password").click(function() {
                var selector = $(this).attr("toggle");
                var input = $(selector);
                var icon = $(this).find("i");

                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    icon.removeClass("fa-eye-slash");
                    icon.addClass("fa-eye");
                } else {
                    input.attr("type", "password");
                    icon.removeClass("fa-eye");
                    icon.addClass("fa-eye-slash");
                }
            });
        });
    </script>
@endsection
