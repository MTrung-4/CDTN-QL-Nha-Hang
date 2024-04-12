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
    <form action="" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="menu">Tiêu Đề</label>
                        <input type="text" name="name" value="{{ $slider->name }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="menu">Sắp Xếp</label>
                        <input type="number" name="sort_by" value="{{ $slider->sort_by }}" class="form-control"
                            min="1">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Sản Phẩm</label>
                <input type="file" class="form-control" id="upload">
                <div id="image_show">
                    <a href="{{ $slider->thumb }}">
                        <img src="{{ $slider->thumb }}" width="100px">
                    </a>
                </div>
                <input type="hidden" name="thumb" value="{{ $slider->thumb }}" id="thumb">
            </div>

            <div class="form-group">
                <label>Kích Hoạt</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                        {{ $slider->active == 1 ? 'checked' : '' }}>
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                        {{ $slider->active == 0 ? 'checked' : '' }}>
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>

            <div class="button-group">
                <button type="button" class="btn btn-secondary" onclick="goBack()">Quay lại</button>
                <button type="submit" class="btn btn-primary">Thay Đổi</button>
            </div>
        </div>
        @csrf
    </form>
    <script>
        window.location.href = "/admin/sliders/list"
    </script>
@endsection
