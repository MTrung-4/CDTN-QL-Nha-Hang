@extends('main')

@section('content')
    <style>
        .account-container {
            margin: 50px auto;
            display: flex;
            justify-content: center;
        }

        .column {
            width: 33.33%;
            padding: 0 20px;
            border-left: 1px solid black;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        li {
            margin-bottom: 20px;
        }

        strong {
            font-weight: bold;
            color: #666;
            min-width: 120px;
            margin-right: 20px;
            display: block;
            text-align: left;
        }

        span {
            color: #333;
            font-weight: 400;
        }

        .user-thumb {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: auto;
            margin-right: auto;
            display: block;
            border: 2px solid #ddd;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #45a049;
        }

        .button-edit {
            background-color: #2196F3;
        }

        .button-password {
            background-color: #f44336;
        }

        p {
            display: flex;
            justify-content: center;
            font-weight: bold;
            border-bottom: 1px solid black;
        }
    </style>
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('/template/images/bg-01.jpg')">
        <h2 class="ltext-105 cl0 txt-center">
            Thông tin tài khoản
        </h2>
    </section>
    <div class="container account-container">
        <div class="column">
            <ul>
                <li><strong>Ảnh đại diện:</strong> <!-- Hiển thị ảnh đại diện -->
                    @if ($user->thumb)
                        <img src="{{ $user->thumb }}" alt="Avatar" class="user-thumb">
                    @else
                        <img src="/template/images/an-danh.jpg" alt="Avatar" class="user-thumb">
                    @endif
                </li>
            </ul>
        </div>
        <div class="column">
            <p>TÀI KHOẢN</p>
            <ul>
                <li><strong>Tên đăng nhập:</strong> <span>{{ $user->name }}</span></li>
                <li><strong>Email:</strong> <span>{{ $user->email }}</span></li>
            </ul>
            <div class="button-wrapper">
                <button style="margin-top: 65px" class="button button-password"
                    onclick="window.location.href = '{{ route('change-password-form') }}';">Thay đổi mật khẩu</button>

            </div>
        </div>
        <div class="column">
            <p>THÔNG TIN CÁ NHÂN</p>
            <ul>
                <li><strong>Họ và Tên:</strong> <span>{{ $user->fullname ? $user->fullname : 'Chưa có' }}</span></li>
                <li><strong>Số điện thoại:</strong> <span>{{ $user->phone ? $user->phone : 'Chưa có' }}</span></li>
                <li><strong>Địa chỉ:</strong> <span>{{ $user->address ? $user->address : 'Chưa có' }}</span></li>
                <!-- Thêm các trường thông tin tài khoản khác nếu cần -->
            </ul>
            <div class="button-wrapper">
                <button class="button button-edit" onclick="window.location.href = '/admin/accounts/profile/create';">Chỉnh
                    sửa thông tin</button>
            </div>
        </div>
    </div>
@endsection
