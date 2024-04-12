@extends('admin.users.main')

@section('content')
    <style>
        .btn-outline-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
            padding: 0 5px 0 20px;
        }

        .btn-outline-danger:hover {
            color: #fff;
            background-color: #e0051b;/
            border-color: #e0051b;
        }
    </style>

    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <form action="" method="post">
        <div class="card-body">
            @csrf
            <div class="form-group">
                <label for="name">Tên Thực Đơn:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập tên thực đơn">
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" id="description" name="description" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="product_search">Chọn sản phẩm:</label>
                <div class="input-group" style="width: 1198px">
                    <select class="form-control select2" id="product_search" name="products[]" multiple aria-placeholder="Nhấn để chọn sản phẩm">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price_sale }}">{{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger" type="button" id="btnClearSearch">
                            <span style="margin-right: 7px; font-size:1rem;">Xóa</span>
                        </button>
                    </div>

                </div>
                <div class="mt-10">
                    <label>Sản phẩm đã chọn:</label>
                    <ul id="selected_products" class="list-unstyled">
                        <!-- Các sản phẩm đã chọn sẽ được hiển thị ở đây -->
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Giá:</label>
                        <input type="number" class="form-control" id="price" name="price" min="0" value="{{ old('price') }}" placeholder="Nhập tổng tiền">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="totalPrice">Tổng Tiền:</label>
                        <input type="number" class="form-control" id="totalPrice" name="totalPrice" readonly>
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

            <button type="submit" class="btn btn-primary">Thêm Thực Đơn</button>
        </div>
    </form>

    <!-- Thư viện jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script>
        function showSuccessMessage(message) {
            alert(message);
        }

        $(document).ready(function() {
            // Khởi tạo Select2 cho dropdown select
            $('#product_search').select2();

            // Xử lý sự kiện khi sản phẩm được chọn
            $('#product_search').change(function() {
                var selectedProducts = [];
                var totalPrice = 0;

                // Lặp qua tất cả các option đã chọn
                $('#product_search option:selected').each(function() {
                    selectedProducts.push($(this).text()); // Thêm tên sản phẩm vào mảng
                    totalPrice += parseFloat($(this).data(
                        'price')); // Tổng giá tiền từ các sản phẩm được chọn
                });

                // Hiển thị danh sách sản phẩm đã chọn
                displaySelectedProducts(selectedProducts);
                // Hiển thị tổng giá tiền
                $('#totalPrice').val(totalPrice.toFixed(
                0)); // Làm tròn tổng giá tiền đến 2 chữ số sau dấu thập phân
            });

            // Hàm hiển thị danh sách sản phẩm đã chọn
            function displaySelectedProducts(products) {
                // Xóa danh sách hiện tại
                $('#selected_products').empty();
                // Hiển thị các sản phẩm đã chọn
                products.forEach(function(product) {
                    $('#selected_products').append('<li>' + product + '</li>');
                });
            }

            // Xử lý sự kiện khi nhấn nút "Xóa"
            $('#btnClearSearch').click(function() {
                // Xóa tất cả các lựa chọn trong dropdown
                $('#product_search').val([]).trigger('change');
                // Xóa danh sách hiển thị sản phẩm đã chọn
                $('#selected_products').empty();
                // Reset tổng giá tiền về 0
                $('#totalPrice').val('0');
            });
        });
    </script>
@endsection
