@extends('main')

@section('content')
    <style>
        /* CSS cho phần thông tin khách hàng */
        .customer-info {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .customer-info h2 {
            margin-top: 0;
            text-align: center;
        }

        .customer-info .form-group {
            margin-bottom: 15px;
            display: flex;
            /* Hiển thị các phần tử con trên cùng một hàng */
            align-items: center;
            /* Căn chỉnh các phần tử con theo chiều dọc */
        }

        .customer-info label {
            font-weight: bold;
            min-width: 100px;
            /* Đảm bảo rộng của label */
        }

        .customer-info p {
            margin-bottom: 0;
            margin-left: 10px;
            /* Khoảng cách giữa label và nội dung */
        }

        /* CSS cho phần thanh toán */
        .option-payment {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
        }

        .option-payment h2 {
            text-align: center;
        }

        .payment-methods {
            margin-top: 20px;
        }

        .payment-methods button {
            display: block;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            color: #fff;
            background-color: #007bff;
            /* Màu nền cho các nút */
            transition: background-color 0.3s ease;
            /* Hiệu ứng chuyển đổi màu nền */
        }

        .payment-methods button:hover {
            background-color: #0056b3;
            /* Màu nền khi rê chuột vào */
        }

        .payment-details {
            display: none;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
        }

        .customer-info {
            position: relative;
            /* Thiết lập vị trí tương đối cho khung thông tin khách hàng */
        }

        .btn.btn-primary {
            position: absolute;
            /* Thiết lập vị trí tuyệt đối cho nút xác nhận */
            bottom: 10px;
            /* Căn chỉnh vị trí theo trục Y */
            right: 10px;
            /* Căn chỉnh vị trí theo trục X */
        }


        .btn.btn-danger {
            position: absolute;
            bottom: 10px;
        }
    </style>

    <div style="margin: 100px auto;" class="container payment-container">
        @include('admin.users.alert-web')
        <div class="row">
            <div class="col-md-8">
                <div class="customer-info">
                    <h2 style="margin-bottom: 10px; text-align: center;">Thông tin khách hàng</h2>
                    <div class="form-group">
                        <label for="name">Mã đơn hàng:</label>
                        <p>#{{ $cart->id }}</p>
                    </div>
                    <div class="form-group">
                        <label for="name">Họ tên:</label>
                        <p>{{ $customer->name }}</p>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <p>{{ $customer->phone }}</p>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <p>{{ $customer->email }}</p>
                    </div>
                    <div class="form-group">
                        <label for="created_at">Ngày đặt:</label>
                        <p>{{ $customer->created_at }}</p>
                    </div>
                    <div class="form-group">
                        <label for="qty">Số lượng:</label>
                        <p>{{ $cart->qty }}</p>
                    </div>
                    <div class="form-group">
                        <label for="content">Ghi chú:</label>
                        <p>{{ $cart->content }}</p>
                    </div>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($products as $product)
                        @php
                            $price = $product->price * $product->qty;
                            $total += $price;
                        @endphp
                    @endforeach

                    <div class="form-group">
                        <label for="total">Tổng:</label>
                        <p>{{ number_format($total, 0, '', '.') }} đ</p>
                    </div>
                </div>
            </div>
            <div class="option-payment col-md-4">
                <h2>Thanh toán</h2>
                <div class="payment-methods">
                    <div tyle="background-color: blue;" class="form-group">
                        <form id="vnpayForm" action="{{ url('/vnpay_payment') }}" method="post">
                            @csrf
                            <input type="hidden" name="total" value="{{ $total }}">
                            <input type="hidden" name="cart_id" value="{!! $cart->id !!}">
                            <button type="submit" id="vnpayButton" name="redirect"
                                class="primary-btn checkout-btn">VNPAY</button>
                        </form>
                        <button type="button" id="payment_transfer" data-method="transfer"> Chuyển khoản </button>
                        <button type="button" id="payment_cash" data-method="cash"> Thanh toán bằng tiền mặt </button>
                    </div>
                    <div class="form-group">
                        <div class="payment-details" id="transfer_details" style="display: none;">
                            <img style="width: 300px" src="/template/images/BIDV.jpg">
                        </div>
                        <div class="payment-details" id="cash_details" style="display: none;">
                            <p>(*) Vui lòng thanh toán trực tiếp tại nhà hàng. (*)</p>
                        </div>
                    </div>
                </div>
                <div class="button-group">
                    <form id="confirmPaymentForm" method="post">
                        @csrf
                        <input type="hidden" id="customer_id" value="{{ $customer->id }}">
                        <input type="hidden" id="paymentOption" name="payment_option">
                        <button type="submit" class="btn btn-primary">Xác nhận thanh toán</button>
                    </form>
                    <form action="/cancel-order/{{ $cart->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="cancel_order" class="btn btn-danger">Hủy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript để hiển thị thông tin thanh toán khi lựa chọn phương thức
        const paymentButtons = document.querySelectorAll('.payment-methods button');
        const paymentDetails = document.querySelectorAll('.payment-details');
        let selectedPaymentMethod = null;

        paymentButtons.forEach(button => {
            button.addEventListener('click', () => {
                const selectedMethod = document.querySelector(`#${button.dataset.method}_details`);
                paymentDetails.forEach(detail => {
                    detail.style.display = 'none';
                });
                if (selectedMethod) {
                    selectedMethod.style.display = 'block';
                }
                selectedPaymentMethod = button.dataset.method;
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const confirmButton = document.querySelector('.btn.btn-primary');
            confirmButton.addEventListener('click', function(event) {
                event.preventDefault();
                if (selectedPaymentMethod === null) {
                    alert("Vui lòng chọn phương thức thanh toán");
                    return;
                }
                if (confirm("Bạn có chắc chắn muốn xác nhận không?")) {
                    document.querySelector('#paymentOption').value = selectedPaymentMethod;
                    savePaymentOption('{{ $cart->id }}', selectedPaymentMethod, function() {
                        document.getElementById('confirmPaymentForm').submit();
                    });
                }
            });

            const vnpayButton = document.querySelector('#vnpayButton');
            vnpayButton.addEventListener('click', function() {
                savePaymentOption('{{ $cart->id }}', 'VNPAY', function() {
                    document.getElementById('vnpayForm').submit();
                });
            });
        });

        function savePaymentOption(cartId, payOption, callback) {
            var customerId = document.getElementById('customer_id').value;
            if (customerId) {
                // In ra giá trị của customerId trên DevTools
                console.log("customerId: ", customerId);

                $.ajax({
                    type: 'POST',
                    url: '/payment-option',
                    data: {
                        _token: '{{ csrf_token() }}',
                        customer_id: customerId,
                        cart_id: cartId,
                        pay_option: payOption
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log('Phương thức thanh toán đã được lưu thành công');
                            callback();
                        } else {
                            console.error('Không thể lưu phương thức thanh toán');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi khi gửi yêu cầu AJAX');
                        alert('Đã xảy ra lỗi khi gửi yêu cầu AJAX');
                    }
                });
            } else {
                // Nếu không tồn tại, in ra thông báo lỗi
                console.error("Không tìm thấy customerId");
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const cancelButton = document.querySelector('#cancel_order');

            cancelButton.addEventListener('click', function(event) {
                event.preventDefault();
                if (confirm("Bạn có chắc chắn muốn hủy đơn hàng không?")) {
                    const orderId = "{{ $cart->id }}"; // Lấy id của đơn hàng

                    // Gửi yêu cầu AJAX
                    fetch('/cancel-order/' + orderId, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                _token: "{{ csrf_token() }}",
                                cart_id: orderId
                            })
                        })
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            } else {
                                // Không cần throw lỗi ở đây
                                console.error('Có lỗi xảy ra khi hủy đơn hàng.');
                                /*  window.location.href = "{{ route('carts') }}"; */
                            }
                        })
                        .then(data => {
                            console.log('Đơn hàng đã được hủy thành công:', data);
                            /* window.location.href =
                            "{{ route('carts') }}";  */ // Chuyển hướng sau khi hủy đơn hàng
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        });
    </script>
@endsection
