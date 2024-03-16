@extends('admin.users.main')

@section('content')
    <div class="customer mt-3">
        <ul>
            <li>Tên khách hàng: <strong>{{ $customer->name }}</strong></li>
            <li>Số điện thoại: <strong>{{ $customer->phone }}</strong></li>
            <li>Số Lượng: <strong>{{ $customer->qty }}</strong></li>
            <li>Thời Gian: <strong>{{  $customer->time }}</strong></li>
            <li>Email: <strong>{{ $customer->email }}</strong></li>
            <li>Ghi chú: <strong>{{ $customer->content }}</strong></li>
        </ul>
    </div>

    <div class="carts">
        @php $total = 0; @endphp
        <table class="table">
            <tbody>
                <tr class="table_head">
                    <th class="column-1">Ảnh</th>
                    <th class="column-2">Sản Phẩm</th>
                    <th class="column-3">Giá</th>
                    <th class="column-4">Số Lượng</th>
                    <th class="column-5">Tổng</th>
                </tr>

                @foreach ($carts as $key => $cart)
                    @php
                        $price = $cart->price * $cart->qty;
                        $total += $price;
                    @endphp
                    <tr>
                        <td class="column-1">
                            <div class="how-itemcart1">
                                <img src="{{ $cart->product->thumb }}" alt="IMG" style="width: 100px">
                            </div>
                        </td>
                        <td class="column-2">{{ $cart->product->name }}</td>
                        <td class="column-3">{{ number_format($cart->price, 0, '', '.') }}</td>
                        <td class="column-4">{{ $cart->qty }}</td>
                        <td class="column-5">{{ number_format($price, 0, '', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-right">Tổng Tiền</td>
                    <td>{{ number_format($total, 0, '', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <div class="card-footer clearfix">
            <a href="/admin/customers" class="btn btn-primary float-right">
                <i class="fas fa-solid fa-door-open"></i> Trở Về
            </a>
          </div>
    </div>
@endsection
