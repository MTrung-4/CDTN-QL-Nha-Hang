@extends('admin.users.main')

@section('content')
    <form action="" method="POST">
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="card-body">

            <div class="form-group">
                <label>Tiêu Đề (*):</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                    placeholder="Nhập tiêu đề tin">
            </div>

            <div class="form-group">
                <label>Mô Tả (*): </label>
                <textarea name="description" class="form-control" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Mô Tả Chi Tiết (*):</label>
                <textarea name="content" id="content" class="form-control" placeholder="Nhập mô tả chi tiết">{{ old('content') }}</textarea>
            </div>


            <div class="form-group">
                <label for="menu">Ảnh Tin (*):</label>
                <input type="file" class="form-control" id="upload">
                <div id="image_show">

                </div>
                <input type="hidden" name="thumb" id="thumb">
            </div>

            <div class="form-group">
                <label>Kích Hoạt (*):</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                        checked="">
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active">
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm Tin</button>
        </div>
        @csrf
    </form>
@endsection

