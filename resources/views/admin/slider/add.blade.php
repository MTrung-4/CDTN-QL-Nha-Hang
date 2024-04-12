@extends('admin.users.main')

@section('content')
    <form action="" method="POST">
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="menu">Tiêu Đề</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nhập tiêu đề slider">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="menu">Sắp Xếp</label>
                        <input type="number" name="sort_by" value="1" class="form-control" min="1" placeholder="Nhập số thứ tự của slider">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="menu">Ảnh Sản Phẩm</label>
                <input type="file" class="form-control" id="upload">
                <div id="image_show">

                </div>
                <input type="hidden" name="thumb" id="thumb">
            </div>

            <div class="form-group">
                <label>Kích Hoạt</label>
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
            <button type="submit" class="btn btn-primary">Thêm Slider</button>
        </div>
        @csrf
    </form>

    <script>
        function showSuccessMessage(message) {
            alert(message);
        }
    </script>
    
@endsection
