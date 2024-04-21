<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Dancing+Script:wght@400..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

    body {
        margin: 0;
        padding: 0;
        font-family: "Roboto", sans-serif;
        background-image: url('/template/images/login.png');
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-container {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
        max-width: 300px;
        width: 100%;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: #007bff;
    }

    .input-group {
        position: relative;
        margin-bottom: 20px;
    }

    .input-group input {
        width: 286px;
        padding: 12px 0 12px 12px;
        border: 1px solid #ddd;
        border-radius: 25px;
        background-color: #f8f9fa;
        transition: border-color 0.3s ease;
    }

    .input-group input:focus {
        outline: none;
        border-color: #007bff;
    }

    .input-group i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 15px;
        color: #aaa;
    }

    .remember-me {
        margin-bottom: 20px;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 25px;
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .forgot-password,
    .register {
        text-align: center;
        margin-top: 15px;
    }

    .forgot-password a,
    .register a {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
    }

    .forgot-password a:hover,
    .register a:hover {
        text-decoration: underline;
    }

    .alert-danger {
        font-size: 14px;
        color: red;
        margin: 0 0 10px 0;
        text-align: center;
        display: block;
    }

    .alert {
        margin-bottom: 5px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
        color: #333;
    }
</style>

<body>
    <div class="login-container">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <h2>ĐẶT LẠI MẬT KHẨU</h2>
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <label for="password">Mật Khẩu</label>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                <i class="nav-icon fas fa-solid fa-eye" id="togglePassword" aria-hidden="true"></i>
            </div>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="password">Xác Nhận Mật Khẩu</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    placeholder="Xác nhận mật khẩu" required>
                <i class="nav-icon fas fa-solid fa-eye" id="togglePassword2" aria-hidden="true"></i>
            </div>
            <button type="submit" class="btn">Đặt lại mật khẩu</button>
        </form>
    </div>

</body>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const togglePassword2 = document.getElementById('togglePassword2');
    const passwordInput = document.getElementById('password'); // Sửa id thành 'password'
    const confirmPasswordInput = document.getElementById('password_confirmation');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle eye icon
        togglePassword.classList.toggle('fa-eye');
        togglePassword.classList.toggle('fa-eye-slash');
    });

    togglePassword2.addEventListener('click', function() {
        const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);

        // Toggle eye icon
        togglePassword2.classList.toggle('fa-eye');
        togglePassword2.classList.toggle('fa-eye-slash');
    });
</script>

</html>
