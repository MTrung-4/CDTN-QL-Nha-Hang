<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng kí thành công</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            text-align: center;
        }

        .register {
            margin-top: 10px;
        }

        .image {
            margin-bottom: 15px;
        }

        .image img {
            width: 100px;
            height: 100px;
        }

        #countdown {
            font-size: 16px;
            margin-bottom: 10px;
            color: blue;
        }
        .h2{
            margin-bottom: 5px;
        }
        p{
            font-size: 20px;
            font-weight: bold;
            color: red;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>ĐĂNG KÍ THÀNH CÔNG</h2>
        <div class="image">
            <img src="/template/images/email.png" alt="Tick icon">
        </div>
        <p>Vui lòng đăng nhập vào Email của bạn để xác nhận tài khoản. Bạn chỉ đăng nhập được tài khoản khi đã xác thực.</p>
        <div id="countdown">Trang sẽ tự động chuyển về trang đăng nhập sau <span id="timer">120</span> giây.</div>
        <div class="register">
            <a href="/admin/users/login">Về trang đăng nhập</a>
        </div>
    </div>

    <script>
        // Lấy thẻ span chứa đồng hồ đếm ngược
        const timerElement = document.getElementById('timer');

        let seconds = 20;

        // Hàm đếm ngược
        const countdown = setInterval(() => {
            seconds--;
            timerElement.textContent = seconds;

            // Kiểm tra nếu thời gian đếm ngược kết thúc
            if (seconds === 0) {
                clearInterval(countdown);
                // Chuyển hướng về trang đăng nhập sau khi đếm ngược kết thúc
                window.location.href = "/admin/users/login";
            }
        }, 1000);
    </script>
</body>

</html>
