@extends('admin.users.main')

@section('content')
    <style>
        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-outline-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
            padding: 0 5px 0 20px;
        }

        .btn-outline-danger:hover {
            color: #fff;
            background-color: #e0051b;
            border-color: #e0051b;
        }
    </style>
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <!-- Thư viện Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <form action="" method="post">
        <div class="card-body">
            @csrf
            <div class="form-group">
                <label for="name">Tên Thực Đơn:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}">
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" id="description" name="description">{{ $item->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="product_search">Chọn sản phẩm:</label>
                <div class="input-group" style="width: 100%">
                    <select class="form-control select2" id="product_search" name="products[]" multiple>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                {{ in_array($product->id, $selectedProducts) ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger" type="button" id="btnClearSearch">
                            <span style="margin-right: 7px; font-size:1rem;">Xóa</span>
                        </button>
                    </div>
                </div>
                <div class="mt-2">
                    <label>Sản phẩm đã chọn:</label>
                    <ul id="selected_products" class="list-unstyled">
                        @foreach ($selectedProducts as $productId)
                            @php
                                $selectedProduct = $products->firstWhere('id', $productId);
                            @endphp
                            @if ($selectedProduct)
                                <li>{{ $selectedProduct->name }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Giá:</label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="{{ $item->price }}">
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
                        {{ $item->active == 1 ? 'checked' : '' }}>
                    <label for="active" class="custom-control-label">Có</label>
                </div>
                <div class="custom-control custom-radio">
                    <input class="custom-control-input" value="0" type="radio" id="no_active" name="active"
                        {{ $item->active == 0 ? 'checked' : '' }}>
                    <label for="no_active" class="custom-control-label">Không</label>
                </div>
            </div>

            <div class="button-group">
                <button type="button" class="btn btn-secondary" onclick="goBack()">Quay lại</button>
                <button type="submit" class="btn btn-primary">Thay Đổi</button>
            </div>
        </div>
    </form>

    <!-- Thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Thư viện Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function goBack() {
            window.location.href = "/admin/items/list";
        }

        $(document).ready(function() {
            // Khởi tạo Select2 cho dropdown select
            $('#product_search').select2();

            // Xử lý sự kiện khi sản phẩm được chọn
            $('#product_search').change(function() {
                var selectedProducts = [];

                // Lặp qua tất cả các option đã chọn
                $('#product_search option:selected').each(function() {
                    var productId = $(this).val();
                    var productName = $(this).text();
                    var productPrice = $(this).data('price');

                    selectedProducts.push({
                        id: productId,
                        name: productName,
                        price: productPrice
                    }); // Thêm thông tin sản phẩm vào mảng
                });

                // Hiển thị danh sách sản phẩm đã chọn
                displaySelectedProducts(selectedProducts);
            });

            // Hàm hiển thị danh sách sản phẩm đã chọn và tính tổng giá tiền
            function displaySelectedProducts(products) {
                // Xóa danh sách hiện tại
                $('#selected_products').empty();
                var totalPrice = 0;

                // Hiển thị các sản phẩm đã chọn
                products.forEach(function(product) {
                    $('#selected_products').append('<li>' + product.name + '</li>');
                    totalPrice += parseFloat(product.price); // Tổng giá tiền từ các sản phẩm được chọn
                });

                // Hiển thị tổng giá tiền
                $('#totalPrice').val(totalPrice.toFixed(
                    0)); // Làm tròn tổng giá tiền đến 2 chữ số sau dấu thập phân
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
