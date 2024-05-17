<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn bạn đã đặt hàng</title>
</head>

<body>
    <h1>Bạn đã đặt hàng thành công </h1>
    <p>Chúng tôi sẽ sớm gọi cho bạn để xác nhận thông tin. Vui lòng để ý cuộc gọi đến từ nhà hàng.</p>
    <br>
    <p>Cảm ơn bạn đã đặt hàng tại Yen's Restaurant. Chúc bạn một ngày tốt lành.</p>

    <h2>Thông tin đơn hàng của bạn:</h2>

    <h3>Thông tin khách hàng:</h3>
    <p><strong>Tên:</strong> {{ $customerData['name'] }}</p>
    <p><strong>Số điện thoại:</strong> {{ $customerData['phone'] }}</p>
    <p><strong>Email:</strong> {{ $customerData['email'] }}</p>
    <p><strong>Thời gian:</strong> {{ $customerData['time'] }}</p>
    <p><strong>Số lượng khách:</strong> {{ $customerData['qty'] }}</p>
    <p><strong>Nội dung:</strong> {{ $customerData['content'] }}</p>

    <p>Trân trọng,</p>
    <p>Đội ngũ Yen's Restaurant</p>
</body>

</html>
