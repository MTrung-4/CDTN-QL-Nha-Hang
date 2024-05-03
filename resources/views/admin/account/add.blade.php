@extends('admin.users.main')

@section('content')
    <style>
        .thumb {
            box-sizing: border-box;
            border: solid 1px #cccccc;
            padding: 5px;
            height: 350px;
        }
    </style>
    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif
    <form action="" method="POST" id="userForm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="product">Ảnh Sản Phẩm:</label>
                        <div class="thumb">
                            <input type="file" class="form-control" id="upload">
                            <div class="m-2" id="image_show">
                            </div>
                            <input type="hidden" name="thumb" id="thumb">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="menu">Tên Tài Khoản</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    placeholder="Nhập tên tài khoản">
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="menu">Vai Trò</label>
                                    <select name="role" class="form-control">
                                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Người Dùng
                                        </option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Quản trị viên
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-13">
                                <div class="form-group">
                                    <label for="fullname">Họ và Tên</label>
                                    <input type="text" name="fullname" value="{{ old('fullname') }}" class="form-control"
                                        placeholder="Nhập họ và tên">
                                </div>
                            </div>


                            <div class="col-md-13">
                                <div class="form-group">
                                    <label for="phone">Số Điện Thoại</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                        placeholder="Nhập số điện thoại">
                                </div>
                            </div>

                            <div class="col-md-13">
                                <div class="form-group">
                                    <label for="address">Địa Chỉ</label>
                                    <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                                        placeholder="Nhập địa chỉ">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Mật Khẩu</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Nhập mật khẩu">
                            <div class="input-group-append">
                                <span style="background-color: #17a2b8;" class="input-group-text" id="togglePassword">
                                    <i class="nav-icon fas fa-solid fa-eye" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password_confirmation">Xác Nhận Mật Khẩu</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Nhập lại mật khẩu">
                            <div class="input-group-append">
                                <span style="background-color: #17a2b8;" class="input-group-text"
                                    id="toggleConfirmPassword">
                                    <i class="nav-icon fas fa-solid fa-eye" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="menu">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                            placeholder="Nhập email">
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Thêm Tài Khoản</button>
            </div>
        </div>
        @csrf
    </form>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const userForm = document.getElementById('userForm');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Change eye icon
            const eyeIconClass = type === 'password' ? 'fa-eye' : 'fa-eye-slash';
            togglePassword.innerHTML = `<i class="fa ${eyeIconClass}" aria-hidden="true"></i>`;
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);

            // Change eye icon
            const eyeIconClass = type === 'password' ? 'fa-eye' : 'fa-eye-slash';
            toggleConfirmPassword.innerHTML = `<i class="fa ${eyeIconClass}" aria-hidden="true"></i>`;
        });

        function showSuccessMessage(message) {
            alert(message);
        }
    </script>
@endsection
