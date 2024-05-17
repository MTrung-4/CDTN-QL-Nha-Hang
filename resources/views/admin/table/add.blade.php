@extends('admin.users.main')

@section('content')
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
                        <label for="name">Tên bàn ăn (*):</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập tên bàn ăn">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="capacity">Sức chứa (*):</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" min="0" value="{{ old('capacity') }}" placeholder="Nhập sức chứa">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" id="description" name="description" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Trạng thái (*):</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                        checked="">
                    <label for="active" class="custom-control-label">Còn trống</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active">
                    <label for="no_active" class="custom-control-label">Không còn trống</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Thêm Bàn ăn</button>
        </div>
    </form>
@endsection
