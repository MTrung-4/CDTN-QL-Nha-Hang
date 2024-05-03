@extends('main')

@section('content')
    <div class="container history-container">
        <h2 style="margin-bottom: 10px; font-weight: bold; display: flex; justify-content: center;">LỊCH SỬ ĐẶT BÀN</h2>
        @if (isset($orderHistory) && is_array($orderHistory) && count($orderHistory) > 0)
            <div class="table-responsive">
                @foreach ($orderHistory as $key => $order)
                    <div class="order-wrapper">
                        <div class="order-header">
                            <h5 style="font-weight: bold" class="order-title">Mã Đơn Hàng: {{ $order['carts']->first()->id }}
                            </h5>
                            @php
                                $orderCount = $key + 1;
                            @endphp
                            <span class="order-count">Số lần đặt hàng: {{ $orderCount }}</span>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tên Khách Nhận Bàn</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Email</th>
                                    <th>Giờ Dùng Bữa</th>
                                    <th>Số Lượng Khách</th>
                                    <th>Ngày Đặt Bàn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($order['customer']) && is_object($order['customer']))
                                    @foreach ($order['customer']->carts as $cart)
                                        <tr>
                                            <td>{{ $order['customer']->name }}</td>
                                            <td>{{ $order['customer']->phone }}</td>
                                            <td>{{ $order['customer']->email }}</td>
                                            <td>{{ $order['customer']->time }}</td>
                                            <td>{{ $order['customer']->qty }}</td>
                                            <td>{{ $order['customer']->updated_at }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-info" onclick="toggleReservationInfo(this)">Xem
                                                    Thêm</button>
                                            </td>
                                        </tr>
                                        <tr class="reservation-info" style="display: none;">
                                            <td colspan="6">
                                                <table class="table table-striped table-hover" id="reservationTable">
                                                    <!-- Your table to display detailed reservation information -->
                                                    <thead>
                                                        <tr>
                                                            <th>Tên Bàn</th>
                                                            <th>Phương Thức Thanh Toán</th>
                                                            <th>Số Tiền TT Tại Quầy</th>
                                                            <th>Trạng Thái</th>
                                                            <th>Lý Do Hủy</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($order['carts'] as $cart)
                                                            <tr>
                                                                <td>{{ optional($cart->table)->name }}</td>
                                                                <td>{{ $cart->pay_option }}</td>
                                                                <td>{{ number_format($cart->pay_money, 0, '', '.') }} đ
                                                                </td>
                                                                <td>
                                                                    @if ($cart->status == 0)
                                                                        Hủy
                                                                    @elseif($cart->status == 1)
                                                                        Đang xử lý
                                                                    @elseif($cart->status == 2)
                                                                        Đã hoàn thành
                                                                    @else
                                                                        Trạng thái không xác định
                                                                    @endif
                                                                </td>

                                                                <td>{{ $cart->cancel_reason }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <table class="table">
                                                    <!-- Your table to display product information -->
                                                    <tbody>
                                                        <tr class="table_head">
                                                            <th class="column-1">Ảnh</th>
                                                            <th class="column-2">Sản Phẩm</th>
                                                            <th class="column-3">Giá</th>
                                                            <th class="column-4">Số Lượng</th>
                                                            <th class="column-5">Tổng</th>
                                                        </tr>
                                                        @php
                                                            $total = 0;
                                                        @endphp
                                                        @foreach ($order['carts'] as $cart)
                                                            @php
                                                                $price = $cart->price * $cart->qty;
                                                                $total += $price;
                                                            @endphp
                                                            <tr>
                                                                <td class="column-1">
                                                                    <div class="how-itemcart1">
                                                                        <img src="{{ $cart->product->thumb }}"
                                                                            alt="IMG" style="width: 100px">
                                                                    </div>
                                                                </td>
                                                                <td class="column-2">{{ $cart->product->name }}</td>
                                                                <td class="column-3">
                                                                    {{ number_format($cart->price, 0, '', '.') }}</td>
                                                                <td class="column-4">{{ $cart->qty }}</td>
                                                                <td class="column-5">
                                                                    {{ number_format($price, 0, '', '.') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @else
            <h2 style="margin-bottom: 10px; font-weight: bold; display: flex; justify-content: center;">Chưa có giao dịch
            </h2>
        @endif
    </div>

    <style>
        .history-container {
            margin: 100px auto;
        }

        .order-wrapper {
            border: 1px solid #666;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .order-title {
            margin: 0;
        }

        .order-count {
            color: #666;
        }

        .reservation-info {
            background-color: #ccc;
        }
    </style>

    <script>
        function toggleReservationInfo(button) {
            var reservationInfo = button.parentNode.parentNode.nextElementSibling;
            if (reservationInfo.style.display === 'none') {
                reservationInfo.style.display = 'table-row';
            } else {
                reservationInfo.style.display = 'none';
            }
        }
    </script>
@endsection
