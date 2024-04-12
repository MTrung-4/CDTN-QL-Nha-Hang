@extends('admin.users.main')

@section('content')
    <style>
        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif
    <form action="" method="post">
        <div class="card-body">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Tên bàn ăn:</label>
                        <input type="text" class="form-control" id="name" name="name" value=" {{ $table->name }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="capacity">Sức chứa:</label>
                        <input type="number" class="form-control" id="capacity" name="capacity"
                            value="{{ $table->capacity }}" min="0">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" id="description" name="description">{{ $table->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Sửa Bàn ăn</button>

            <div class="button-group">
                <button type="button" class="btn btn-secondary" onclick="goBack()">Quay lại</button>
                <button type="submit" class="btn btn-primary">Thay Đổi</button>
            </div>
        </div>
    </form>

    <script>
        window.location.href = "/admin/tables/list"
    </script>
@endsection
