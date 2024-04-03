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
        .dropdown-option,
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

        .payment-dropdown-item:hover {
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
    </style>

    <div class="container">
        <div class="row">
            @foreach ($customers as $key => $customer)
                @php $dropdownId = 'dropdown_' . $key; @endphp
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $customer->name }} - {{ $customer->phone }}</h5>
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
                                <!-- Thêm nút 'Lấy Bàn' vào mỗi khách hàng -->
                                <a href="/admin/tables/list?redirect=customer&customer_id={{ $customer->id }}"
                                    class="btn btn-primary btn-sm">Lấy Bàn</a>
                            </div>

                            <div class="dropdown right-footer" onclick="event.stopPropagation()">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                    Lựa chọn
                                </button>
                                <ul id="dropdownMenu" class="dropdown-menu" style="padding: 0">
                                    <li style="background-color: blueviolet">
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            onclick="togglePaymentOptions('{{ $dropdownId }}')">
                                            <i class="fas fa-solid fa-money-bill-wave"></i>
                                            Thanh Toán <i class="fas fa-solid fa-angle-right" style="margin-left: 1rem"></i>
                                        </a>
                                        <ul id="paymentOptions_{{ $dropdownId }}" class="dropdown-menu dropmenu-pay" style="display: none; padding: 0">
                                            <li><a class="dropdown-item" href="javascript:void(0);" onclick="">Tiền Mặt</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);" onclick="">Chuyển Khoản</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);" onclick="">VNPay</a></li>
                                        </ul>
                                        
                                    </li>

                                    <li style="background-color:green">
                                        <a class="dropdown-item" href="/admin/customers/view/{{ $customer->id }}">
                                            <i class="fas fa-eye"></i> Xem Thông Tin
                                        </a>
                                    </li>
                                    <li style="background-color: red">
                                        <a class="dropdown-item"
                                            onclick="removeRow({{ $customer->id }}, '/admin/customers/destroy')">
                                            <i class="fas fa-trash"></i> Xóa Khách Hàng
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>




    <div class="card-footer clearfix">
        {!! $customers->links() !!}
    </div>

    <script>
        function togglePaymentOptions(dropdownId) {
            var paymentOptions = document.getElementById('paymentOptions_' + dropdownId);
            if (paymentOptions.style.display === "none" || !paymentOptions.classList.contains("show")) {
                paymentOptions.style.display = "block";
                paymentOptions.classList.add("show");
            } else {
                paymentOptions.style.display = "none";
                paymentOptions.classList.remove("show");
            }
        }

        function selectOption(event, dropdownId) {
            var selectedOption = event.target.innerText;
            alert("Bạn đã chọn phương thức thanh toán: " + selectedOption);
            togglePaymentOptions(dropdownId);
        }
    </script>
@endsection
