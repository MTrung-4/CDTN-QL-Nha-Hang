@extends('admin.users.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th>Tên Khách Hàng</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Số Lần Đặt Hàng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer['name'] }}</td>
                    <td>{{ $customer['phone'] }}</td>
                    <td>{{ $customer['email'] }}</td>
                    <td>{{ $customer['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
