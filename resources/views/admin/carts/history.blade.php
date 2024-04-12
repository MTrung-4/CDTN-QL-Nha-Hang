@extends('admin.users.main')

@section('content')
    <table class="table">
        <style>
            .view-btn {
                background-color: #00FF00;
                border-color: #00FF00;
                color: #fff;
            }

            .view-btn:hover {
                background-color: #008000;
                border-color: #008000;
            }
        </style>
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên Khách Hàng</th>
                <th>SDT</th>
                <th>Thời Gian</th>
                <th>Trạng Thái</th>
                <th>Đã Thanh Toán</th>
                <th>Tiền KH Thanh Toán (Tiền Mặt)</th>
                <th>Cập Nhật</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carts as $key => $cart)
                <tr>
                    <td>{{ $cart->customer->id }}</td>
                    <td>{{ $cart->customer->name }}</td>
                    <td>{{ $cart->customer->phone }}</td>
                    <td>{{ $cart->customer->time }}</td>
                    <td style="color: green; font-weight: bold">{{ $cart->status === 1 ? 'Đã Xong' : ''}}</td>
                    <td>{{  $cart->pay_option }}</td>
                    <td>{{ $cart->pay_money }}</td>
                    <td>{{ $cart->customer->updated_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm view-btn" href="/admin/customers/view/{{ $cart->customer->id }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="{{ $customers->previousPageUrl() }}">Previous</a></li>

            @for ($i = 1; $i <= $customers->lastPage(); $i++)
                <li class="page-item{{ $i == $customers->currentPage() ? ' active' : '' }}">
                    <a class="page-link" href="{{ $customers->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item"><a class="page-link" href="{{ $customers->nextPageUrl() }}">Next</a></li>
        </ul>
    </div>

@endsection
