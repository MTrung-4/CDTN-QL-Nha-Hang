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
                        <label for="name">Tên Khách Hàng</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Số Điện Thoại</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="time">Thời Gian</label>
                        <input type="text" name="time" value="{{ old('time') }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quantity">Số Lượng</label>
                        <input type="text" name="quantity" value="{{ old('quantity') }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="content">Ghi Chú</label>
                <textarea name="content" class="form-control">{{ old('content') }}</textarea>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Khách Hàng</button>
        </div>
        @csrf
    </form>
@endsection
