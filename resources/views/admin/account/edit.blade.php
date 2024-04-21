@extends('admin.users.main')

@section('content')
    <style>
        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <form action="" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên Tài Khoản</label>
                        <input type="text" name="name" value="{{ $account->name }}" class="form-control"
                            placeholder="Nhập tên tài khoản">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Vai Trò</label>
                        <select name="role" class="form-control">
                            <option value="user" {{ $account->role === 'user' ? 'selected' : '' }}>Người Dùng</option>
                            <option value="admin" {{ $account->role === 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Mật Khẩu</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Nhập mật khẩu mới">
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
                                <span style="background-color: #17a2b8"; class="input-group-text"
                                    id="toggleConfirmPassword">
                                    <i class="nav-icon fas fa-solid fa-eye" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Email</label>
                        <input type="text" name="email" value="{{ $account->email }}" class="form-control"
                            placeholder="Nhập email">
                    </div>
                </div>

            </div>
            <div class="button-group">
                <button type="button" class="btn btn-secondary" onclick="goBack()">Quay lại</button>
                <button type="submit" class="btn btn-primary">Thay Đổi</button>
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

        function goBack() {
            window.location.href = "/admin/accounts/list"
        }
    </script>
@endsection
