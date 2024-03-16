@extends('admin.users.main')

@section('content')
    <form action="" method="POST">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Tên Khách Hàng</label>
                        <input type="text" name="name" value="{{ $customer->name  }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Địa Chỉ</label>
                        <input type="text" name="address" value="{{ $customer->address }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Email</label>
                        <input type="text" name="email" value="{{ $customer->email }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="menu">Số Điện Thoại</label>
                        <input type="text" name="phone" value="{{ $customer->phone}}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Ghi Chú</label> </label>
                <textarea name="content" class="form-control">{{ $customer->content }}</textarea>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Chỉnh Sửa Khách Hàng</button>
        </div>
        @csrf
    </form>
@endsection
