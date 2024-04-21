<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
        }

        p {
            color: #666666;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
        }

        a:hover {
            background-color: #0056b3;
        }

        .footer {
            margin-top: 30px;
            border-top: 1px solid #cccccc;
            padding-top: 20px;
        }

        .footer p {
            font-size: 14px;
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Xác nhận tài khoản</h1>
        <p>Xin chào {{ $user->name }},</p>
        <p>Cảm ơn bạn đã đăng ký tài khoản tại Yen's Restaurant!</p>
        <p>Để hoàn tất quá trình đăng ký, vui lòng xác nhận tài khoản bằng cách nhấn vào nút bên dưới:</p>
        <p><a href="{{ route('verify', $user->email) }}">Nhấn vào đây để xác nhận tài khoản</a></p>
        <div class="footer">
            <p>Trân trọng,</p>
            <p>Đội ngũ Yen's Restaurant</p>
        </div>
    </div>
</body>
</html>
