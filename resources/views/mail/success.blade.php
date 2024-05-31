<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn bạn đã đặt hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        h1 {
            color: #007bff;
        }
        h2 {
            color: #333;
        }
        .order-details {
            margin-top: 30px;
        }
        .customer-info {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cảm ơn bạn đã đặt hàng!</h1>
            <p>Chúng tôi sẽ sớm gọi cho bạn để xác nhận thông tin. Vui lòng để ý cuộc gọi đến từ nhà hàng.</p>
            <p>Cảm ơn bạn đã đặt hàng tại Yen's Restaurant. Chúc bạn một ngày tốt lành.</p>
        </div>

        <div class="order-details">
            <h2>Thông tin đơn hàng của bạn:</h2>

            <div class="customer-info">
                <h3>Thông tin khách hàng:</h3>
                <p><strong>Tên:</strong> {{ $customer['name'] }}</p>
                <p><strong>Số điện thoại:</strong> {{ $customer['phone'] }}</p>
                <p><strong>Email:</strong> {{ $customer['email'] }}</p>
                <p><strong>Thời gian:</strong> {{ $customer['time'] }}</p>
                <p><strong>Số lượng khách:</strong> {{ $customer['qty'] }}</p>
                <p><strong>Nội dung:</strong> {{ $customer['content'] }}</p>
            </div>
        </div>

        <p>Trân trọng,</p>
        <p>Đội ngũ Yen's Restaurant</p>
    </div>
</body>
</html>
