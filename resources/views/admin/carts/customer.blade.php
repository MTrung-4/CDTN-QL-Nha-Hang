@extends('admin.users.main')

@section('content')
    <style>
        .card {
            padding: 0;
            margin: 0;
        }

        .card-body {
            padding: 0;
        }

        .card-footer {
            padding: 0;
        }

        .half-width,
        .half-footer {
            /* Chia phần tử theo chiều rộng */
            float: left;
            /* Đảm bảo các phần tử hiển thị cạnh nhau */
            box-sizing: border-box;
        }

        .left {
            border-right: solid 1px #ccc;
            height: 90px;
            width: 30%;
        }

        .right,
        .right-footer {
            width: 70%;
        }

        .left-footer {
            border-right: solid 1px #ccc;
            height: 50px;
            width: 30%;
        }

        .card-header,
        .left,
        .right,
        .left-footer,
        .bottom,
        .qty,
        .dropdown.right-footer {
            display: flex !important;
            justify-content: center !important;
            flex-wrap: wrap !important;
            align-content: center !important;
        }

        .top {
            align-content: center;
            padding-top: 5px;
            height: 50px;
            border-bottom: solid 1px #ccc;
        }

        .bottom p {
            padding-top: 5px;
            font-weight: bold;
        }

        .bottom {
            height: 40px;
        }

        .half-width.right {
            display: flex;
            flex-direction: column;
        }

        .left-footer,
        .dropdown {
            border-top: solid 1px #ccc;
        }

        .dropdown-item:hover {
            color: black !important;
            text-decoration: none;
            opacity: 0.5;
        }

        .dropdown-item:focus {
            background-color: var(--cyan);
        }

        .payment-dropdown-item:hover,
        .payment-dropdown-item:focus {
            text-decoration: none;
            color: black;
            background-color: var(--cyan);
            opacity: 1;
        }

        .dropmenu-pay {
            top: 0;
            left: 100%;
            margin: 0 0 0 0.5rem;
        }

        .dropdown.right-footer {
            height: 50px;
        }

        .dropdown-toggle {
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }

        .btn-sm {
            background-color: #17a2b8;
            border: #17a2b8;
        }

        .complete-btn {
            background-color: #3498db;
            position: absolute;
            top: 0;
            right: 0;
            margin: 5px;
            width: 30px;
            height: 30px;
        }

        .btn-option:hover {
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .complete-btn i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 16px;
        }
    </style>

    <div class="container">
        <div class="row">
            @foreach ($customers as $key => $customer)
                @php $dropdownId = 'dropdown_' . $key; @endphp
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between align-items-center">
                                <h5>{{ $customer->name }} - {{ $customer->phone }}</h5>
                                @if ($customer->carts->first()->pay_option)
                                    <button class="btn btn-option complete-btn" data-customer-id="{{ $customer->id }}">
                                        <i class="fas fa-solid fa-check"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="half-width left" style="font-weight: bold;  ">
                                @if ($customer->carts->isNotEmpty() && $customer->carts->first()->table)
                                    {{ $customer->carts->first()->table->name }}
                                @else
                                    <i class="fas nav-icon fa-solid fa-question"></i>
                                @endif
                            </div>
                            <div class="half-width right">
                                <div class="top">
                                    <i class="fas fa-regular fa-clock nav-icon"> {{ $customer->time }} </i>
                                    <br>
                                    <div class="qty">
                                        <i class="fas fa-solid fa-users nav-icon"> {{ $customer->qty }}</i>
                                    </div>
                                </div>
                                <div class="bottom">
                                    <p>Tổng: {{ number_format($customer->totalPrice, 0, '', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="half-footer left-footer">
                                <a href="/admin/tables/list?redirect=customer&customer_id={{ $customer->id }}"
                                    class="btn btn-primary btn-sm">Lấy Bàn</a>
                            </div>

                            <div class="dropdown right-footer" onclick="event.stopPropagation()">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                    Lựa chọn
                                </button>
                                <ul id="dropdownMenu" class="dropdown-menu" style="padding: 0">
                                    <li style="background-color: #20c997">
                                        <button class="btn btn-option pay-btn" onclick="toggleDropMenuPay(event)">
                                            <i class="fas fa-solid fa-angle-right"> Thanh Toán</i>
                                        </button>
                                        @foreach ($carts as $cart)
                                            <ul class="dropdown-menu dropmenu-pay" style="display: none; padding: 0">
                                                <li><a class="dropdown-item payment-dropdown-item"
                                                        onclick="savePaymentOption({{ $customer->carts->first()->id }}, 'Tiền Mặt')">Tiền
                                                        Mặt</a></li>
                                                <li><a class="dropdown-item payment-dropdown-item"
                                                        onclick="savePaymentOption({{ $customer->carts->first()->id }}, 'Chuyển Khoản')">Chuyển
                                                        Khoản</a></li>
                                                <li><a class="dropdown-item payment-dropdown-item"
                                                        onclick="savePaymentOption({{ $customer->carts->first()->id }}, 'VNPAY')">VNPAY</a>
                                                </li>
                                            </ul>
                                        @endforeach
                                    </li>
                                    <li style="background-color: green">
                                        <button class="btn btn-option view-btn"
                                            onclick="window.location.href='/admin/customers/view/{{ $customer->id }}'">
                                            <i class="fas fa-eye"> Xem Thông Tin</i>
                                        </button>

                                    </li>
                                    <li style="background-color: #FFCC99">
                                        <button class="btn btn-option invoice-btn" data-customer-id="{{ $customer->id }}">
                                            <i class="fas fa-solid fa-check"> Xuất hóa đơn</i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!--form-->
    <div class="modal fade" id="cashModal" tabindex="-1" aria-labelledby="cashModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cashModalLabel">Nhập số tiền mà khách hàng thanh toán (VNĐ)</h5>
                </div>
                <div class="modal-body">
                    <form id="cashPaymentForm">
                        <div class="mb-3">
                            <label for="cashAmount" class="form-label">Số tiền:</label>
                            <input type="text" class="form-control" id="cashAmount" name="cashAmount">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="submitCashPayment()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>


    <div class="card-footer clearfix">
        {!! $customers->links() !!}
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function toggleDropMenuPay(event, cartId) {
            event.stopPropagation();

            var dropmenuPay = event.currentTarget.nextElementSibling;
            var displayStyle = window.getComputedStyle(dropmenuPay).display;
            dropmenuPay.style.display = (displayStyle === 'none') ? 'block' : 'none';

            dropmenuPay.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', function() {
                    dropmenuPay.querySelectorAll('.dropdown-item').forEach(item => {
                        item.classList.remove('selected');
                    });

                    this.classList.add('selected');
                    dropmenuPay.style.display = 'none';
                });
            });
        }

        function savePaymentOption(cartId, payOption) {
            if (payOption === 'Tiền Mặt') {
                // Mở hộp thoại modal
                $('#cashModal').modal('show');

                // Gán giá trị cartId vào thuộc tính data-cart-id của nút xác nhận trong modal
                $('#cashModal').find('.btn-primary').attr('data-cart-id', cartId);
            } else {
                // Gửi yêu cầu AJAX trực tiếp nếu không chọn "Tiền Mặt"
                $.ajax({
                    type: 'POST',
                    url: '/admin/carts/pay',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cart_id: cartId,
                        pay_option: payOption
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log('Phương thức thanh toán đã được lưu thành công');
                            alert(response.message);
                            window.location.reload();
                        } else {
                            console.error('Không thể lưu phương thức thanh toán');
                            alert(response.message);
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi khi gửi yêu cầu AJAX');
                        alert('Đã xảy ra lỗi khi gửi yêu cầu AJAX');
                    }
                });
            }
        }

        // Hàm xử lý khi nhấn nút xác nhận trong modal
        function submitCashPayment() {
            var cartId = $('#cashModal').find('.btn-primary').attr('data-cart-id');
            var cashAmount = parseFloat($('#cashAmount').val()); // Lấy số tiền từ trường nhập và chuyển thành kiểu số

            // Gửi yêu cầu AJAX để lưu phương thức thanh toán với số tiền
            $.ajax({
                type: 'POST',
                url: '/admin/carts/pay',
                data: {
                    _token: '{{ csrf_token() }}',
                    cart_id: cartId,
                    pay_option: 'Tiền Mặt',
                    pay_money: cashAmount
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Phương thức thanh toán đã được lưu thành công');
                        // Đóng modal
                        $('#cashModal').modal('hide');
                        // Tính số tiền thiếu/dư
                        var totalPrice = parseFloat(
                        '{{ $customer->totalPrice }}'); // Tổng giá trị của mỗi đơn hàng
                        var changeAmount = cashAmount - totalPrice; // Số tiền dư/thiếu
                        var message = ''; // Chuỗi thông báo

                        if (changeAmount === 0) {
                            message = 'Khách hàng đã thanh toán đúng số tiền.';
                        } else if (changeAmount > 0) {
                            message = 'Khách hàng đã thanh toán đủ số tiền. Số tiền thừa: ' + changeAmount;
                        } else {
                            message = 'Khách hàng thanh toán chưa đủ. Số tiền còn thiếu: ' + Math.abs(
                                changeAmount);
                        }

                        // Hiển thị hộp thoại thông báo
                        alert(message);
                        window.location.reload();
                    } else {
                        console.error('Không thể lưu phương thức thanh toán');
                        alert(response.message);
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi khi gửi yêu cầu AJAX');
                    alert('Đã xảy ra lỗi khi gửi yêu cầu AJAX');
                }
            });
        }


        //Duyet hoan thanh don hang
        $(document).ready(function() {
            // Xử lý sự kiện khi nút "Duyệt" được nhấn
            $('.complete-btn').click(function() {
                var customerId = $(this).data('customer-id');
                // Xác nhận trước khi hoàn thành đơn hàng
                if (confirm("Bạn có chắc chắn muốn hoàn thành đơn hàng này?")) {
                    updateStatus(customerId, 'completed');
                }
            });

            function updateStatus(customerId, status) {
                // Kiểm tra lý do hủy đơn khi trạng thái là "Từ chối"
                $.ajax({
                    type: 'POST',
                    url: '/admin/carts/update-status',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'customer_id': customerId,
                        'status': status,
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Có lỗi xảy ra khi cập nhật trạng thái: ' + error);
                    }
                });
            }
        });


        $('.invoice-btn').click(function() {
            var customerId = $(this).data('customer-id');

            // Gửi yêu cầu AJAX để tạo và tải xuống tệp PDF
            $.ajax({
                type: 'GET',
                url: '/invoices/' + customerId + '/generate-pdf',
                success: function(response) {},
                error: function(xhr, status, error) {}
            });
        });
    </script>
@endsection
