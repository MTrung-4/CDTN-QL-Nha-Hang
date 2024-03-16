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
        .right-footer,
        .bottom {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            align-content: center;
        }

        .top {
            align-content: center;
            padding-top: 5px;
            height: 50px;
            border-bottom: solid 1px #ccc;
        }

        .qty
        {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            align-content: center;
        }

        .bottom p{
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
        .right-footer {
            border-top: solid 1px #ccc;
        }
    </style>
    <div class="container">
        <div class="row">
            @foreach ($customers as $key => $customer)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ $customer->name }} - {{ $customer->phone }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="half-width left">
                                @if (session('selectedTable'))
                                    {{ session('selectedTable')->name }}
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
                                <!-- Hiển thị tổng số tiền -->
                                <div class="bottom">
                                    <p>Tổng:
                                        {{ number_format($customer->totalPrice, 0, '', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="half-footer left-footer">
                                <!-- Thêm nút 'Chọn Bàn' vào mỗi khách hàng -->
                                <a href="/admin/tables/list" class="btn btn-primary btn-sm">Lấy Bàn</a>

                            </div>
                            <div class="row">
                                <div class="half-footer right-footer">
                                    Khách Nhận Bàn
                                </div>
                                <div class="option">
                                    <a class="btn btn-primary btn-sm" href="/admin/customers/view/{{ $customer->id }}"
                                        style="background-color: #17a2b8;
                                                border-color: #17a2b8;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm"
                                        onclick="removeRow({{ $customer->id }}, '/admin/customers/destroy')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
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
@endsection
