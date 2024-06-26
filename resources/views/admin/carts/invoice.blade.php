<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

    <style>
        body {
            font-family: DejaVu Sans !important;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border: none;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .card-body h5 {
            color: #007bff;
        }

        .table {
            margin-bottom: 0;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: 500;
        }

        .text-right {
            text-align: right;
        }

        .card-header.position-relative {
            position: relative;
        }

        .created-at {
            position: absolute;
            top: 10px;
            /* Thay đổi giá trị top tùy ý */
            right: 10px;
            /* Thay đổi giá trị right tùy ý */
            font-size: 16px;
            /* Thay đổi kích thước font tùy ý */
            color: #333;
            /* Thay đổi màu sắc tùy ý */
        }

        .bottom-texts {
            position: absolute;
            bottom: 10px;
            /* Thay đổi giá trị bottom tùy ý */
            right: 10px;
            /* Thay đổi giá trị right tùy ý */
            font-size: 16px;
            /* Thay đổi kích thước font tùy ý */
            color: #333;
            /* Thay đổi màu sắc tùy ý */
        }

        .bottom-texts p {
            margin: 0;
            /* Loại bỏ margin mặc định */
        }

        .bottom-texts p:first-child {
            margin-bottom: 5px;
            /* Khoảng cách giữa hai dòng */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header position-relative">
                        <p style="font-size: 50px">Hóa Đơn</p>
                        <p class="created-at"><strong>Ngày tạo:</strong> {{ date('Y-m-d H:i:s') }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Thông tin khách hàng:</h5>
                                <p><strong>Tên:</strong> {{ $customer->name }}</p>
                                <p><strong>Số điện thoại:</strong> {{ $customer->phone }}</p>
                                <p><strong>Email:</strong> {{ $customer->email }}</p>
                                <p><strong>Số khách:</strong> {{ $customer->qty }}</p>
                                <p><strong>Thời gian:</strong> {{ $customer->time }}</p>
                                <p><strong>Nội dung:</strong> {{ $customer->content }}</p>
                            </div>
                        </div>
                        <hr>
                        <h5>Danh sách sản phẩm:</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><strong>#</strong></th>
                                        <th><strong>Tên sản phẩm<strong></th>
                                        <th><strong>Số lượng</strong></th>
                                        <th><strong>Đơn giá</strong></th>
                                        <th><strong>Thành tiền</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalPrice = 0; @endphp
                                    @foreach ($customer->carts as $index => $cart)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $cart->product->name }}</td>
                                            <td>{{ $cart->qty }}</td>
                                            <td>{{ number_format($cart->price, 0, '', '.') }}</td>
                                            <td>{{ number_format($cart->price * $cart->qty, 0, '', '.') }}</td>
                                            @php $totalPrice += $cart->price * $cart->qty; @endphp
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>Tổng tiền:</strong></td>
                                        <td>{{ number_format($totalPrice, 0, '', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bottom-texts">
                            <p>Yen's Restaurant</p>
                            <p>3/13A, Trần Quang Khải, Lộc Thọ, Nha Trang, Khánh Hòa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
