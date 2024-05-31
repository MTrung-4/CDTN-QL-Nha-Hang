@extends('admin.users.main')

@section('content')
    <style>
        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    <form action="" method="POST">
        <div class="card-body">
            <div class="form-group">
                <label>Tiêu Đề (*):</label>
                <input type="text" name="name" value="{{ $news->name }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Mô Tả (*): </label>
                <textarea name="description" class="form-control" placeholder="Nhập mô tả">{{ $news->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Mô Tả Chi Tiết (*):</label>
                <textarea name="content" id="content" class="form-control" placeholder="Nhập mô tả chi tiết">{{ $news->content }}</textarea>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Tin (*):</label>
                <input type="file" class="form-control" id="upload">
                <div id="image_show">
                    <a href="{{ $news->thumb }}">
                        <img src="{{ $news->thumb }}" width="100px">
                    </a>
                </div>
                <input type="hidden" name="thumb" value="{{ $news->thumb }}" id="thumb">
            </div>

            <div class="form-group">
                <label>Kích Hoạt (*):</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                        {{ $news->active == 1 ? 'checked' : '' }}>
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                        {{ $news->active == 0 ? 'checked' : '' }}>
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
        function goBack() {
            window.location.href = "/admin/news/list"
        }
    </script>
@endsection

