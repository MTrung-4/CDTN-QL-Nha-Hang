@extends('admin.users.main')

@section('header')
    <script src="/ckeditor/ckeditor.js"></script>
    <style>
        .add-option {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            line-height: 30px;
            margin-left: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-option:hover {
            background-color: #0056b3;
        }

        .thumb {
            box-sizing: border-box;
            border: solid 1px #cccccc;
            padding: 5px;
            height: 350px;
        }
    </style>
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <form action="" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="menu">Ảnh Sản Phẩm</label>
                        <div class="thumb">
                            <input type="file" class="form-control" id="upload">
                            <div class="m-2" id="image_show">
                            </div>
                            <input type="hidden" name="thumb" id="thumb">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="menu">Tên Sản Phẩm</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                    placeholder="Nhập tên sản phẩm">
                            </div>
                            <div class="col-md-4">
                                <label for="menu">Danh Mục</label>
                                <select name="menu_id" class="form-control">
                                    <option value="">--Chọn Danh Mục--</option>
                                    @foreach ($menus as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="menu">Loại</label>
                                <div class="input-group">
                                    <select name="type" id="type" class="form-control">
                                        <option value="">--Chọn Loại--</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <a href="javascript:void(0);" class="add-option" data-target="type">+</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="menu">Đơn Vị</label>
                                <div class="input-group">
                                    <select name="unit" id="unit" class="form-control">
                                        <option value="">--Chọn Đơn Vị--</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit }}">{{ $unit }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <a href="javascript:void(0);" class="add-option" data-target="unit">+</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="menu">Giá Nhập</label>
                                <input type="number" name="price" value="{{ old('price') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="menu">Giá Bán</label>
                                <input type="number" name="price_sale" value="{{ old('price_sale') }}"
                                    class="form-control">
                            </div>
                        </div>
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
            </div>

            <div class="form-group">
                <label>Mô Tả Chi Tiết</label>
                <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
            </div>

        </div>

        <div class="row justify-content-between">
            <div class="col-auto">
                <i style="margin:0 5px 0 20px;" class="nav-icon fas fa-regular fa-hand-point-left"></i>
                <a style="font-weigh: bold" onclick="goBack()">Quay lại</a>
            </div>
            <div class="col-auto">
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
                </div>
            </div>
        </div>
        @csrf
    </form>
@endsection


@section('footer')
    <script>
        CKEDITOR.replace('content');

        document.querySelectorAll('.add-option').forEach(function(element) {
            element.addEventListener('click', function() {
                var target = this.getAttribute('data-target');
                var select = document.getElementById(target);

                try {
                    var newOption = prompt("Nhập option mới:");
                    if (newOption) {
                        var option = new Option(newOption, newOption);
                        select.add(option);
                        alert('Thêm option thành công!');
                        return; // Thoát khỏi hàm xử lý sau khi thêm thành công
                    } else {
                        alert('Không thêm option!');
                    }
                } catch (error) {
                    console.error('Lỗi khi thêm option:', error);
                    alert('Đã xảy ra lỗi khi thêm option!');
                }
            });
        });

        function goBack() {
            window.history.back();
        }
    </script>
@endsection
