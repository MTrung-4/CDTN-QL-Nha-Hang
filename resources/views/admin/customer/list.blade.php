@extends('admin.users.main')

@include('admin.users.header')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên Khách Hàng</th>
                <th>Địa Chỉ</th>
                <th>Số Điện Thoại</th>
                <th>Email</th>
                <th>Update</th>
                <th style="width: 100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $key => $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->updated_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/admin/customers/edit/{{ $customer->id }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="removeRow({{ $customer->id }}, '/admin/customers/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
