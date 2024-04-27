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

        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

    </style>
@endsection

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif
    <form action="" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="thumb">Ảnh Sản Phẩm:</label>
                        <input type="file" class="form-control" id="upload">
                        <div id="image_show">
                            <a href="{{ $product->thumb }}" target="_blank">
                                <img src="{{ $product->thumb }}" width="100px">
                            </a>
                        </div>
                        <input type="hidden" name="thumb" value="{{ $product->thumb }}" id="thumb">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="menu">Tên Sản Phẩm:</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-control"
                            placeholder="Nhập tên sản phẩm">
                    </div>
                    <div class="form-group">
                        <label for="menu">Menu:</label>
                        <select name="menu_id" class="form-control">
                            <option value="">--Chọn Danh Mục--</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}" {{ $product->menu_id == $menu->id ? 'selected' : '' }}>
                                    {{ $menu->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Loại:</label>
                                    <div class="input-group">
                                        <select name="type" id="type" class="form-control">
                                            <option value="">--Chọn Loại--</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type }}"
                                                    {{ $product->type == $type ? 'selected' : '' }}>{{ $type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <a href="javascript:void(0);" class="add-option" data-target="type">+</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit">Đơn Vị:</label>
                                    <div class="input-group">
                                        <select name="unit" id="unit" class="form-control">
                                            <option value="">--Chọn Đơn Vị--</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit }}"
                                                    {{ $product->unit == $unit ? 'selected' : '' }}>{{ $unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <a href="javascript:void(0);" class="add-option" data-target="unit">+</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="menu">Giá Gốc:</label>
                                <input type="number" name="price" value="{{ $product->price }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="menu">Giá Bán:</label>
                                <input type="number" name="price_sale" value="{{ $product->price_sale }}"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Ghi Chú:</label>
                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Mô Tả Chi Tiết:</label>
                <textarea name="content" id="content" class="form-control">{{ $product->content }}</textarea>
            </div>

            <div class="form-group">
                <label for="active">Kích Hoạt:</label>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="1" type="radio" id="active" name="active"
                        {{ $product->active == 1 ? 'checked' : '' }}>
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                        {{ $product->active == 0 ? 'checked' : '' }}>
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
@endsection


@section('footer')
    <script>
        CKEDITOR.replace('content');

        // Thêm option mới
        document.querySelectorAll('.add-option').forEach(function(element) {
            element.addEventListener('click', function() {
                var target = this.getAttribute('data-target');
                var select = document.getElementById(target);

                var newOption = prompt("Nhập option mới:");
                if (newOption) {
                    var option = new Option(newOption, newOption);
                    select.add(option);
                }
            });
        });

        function goBack() {
            window.location.href ="/admin/products/list";
        }
    </script>
@endsection
