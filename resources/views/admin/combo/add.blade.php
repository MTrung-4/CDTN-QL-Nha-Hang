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
            background-color: #e0051b;/ border-color: #e0051b;
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
                <label for="name">Tên Combo:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Nhập tên thực đơn">
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" id="description" name="description" placeholder="Nhập mô tả">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="product_search">Chọn sản phẩm:</label>
                <div class="input-group" style="width: 1198px">
                    <select class="form-control select2" id="product_search" name="products[]" multiple
                        aria-placeholder="Nhấn để chọn sản phẩm hoặc món ăn">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price_sale }}">
                                {{ $product->name }}</option>
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
                        <!-- Các sản phẩm hoặc món ăn đã chọn sẽ được hiển thị ở đây -->
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label for="item_search">Chọn thực đơn:</label>
                <div class="input-group" style="width: 1198px">
                    <select class="form-control select2" id="item_search" name="items[]" multiple
                        aria-placeholder="Nhấn để chọn sản phẩm hoặc món ăn">
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}" data-price="{{ $item->price }}">{{ $item->name }}
                                @if ($item->products->isNotEmpty())
                                    ({{ implode(', ', $item->products->pluck('name')->toArray()) }})
                                @endif
                            </option>
                        @endforeach

                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger" type="button" id="btnClearItemSearch">
                            <span style="margin-right: 7px; font-size:1rem;">Xóa</span>
                        </button>
                    </div>
                </div>
                <div class="mt-10">
                    <label>Thực đơn đã chọn:</label>
                    <ul id="selected_items" class="list-unstyled">
                        <!-- Các sản phẩm hoặc món ăn đã chọn sẽ được hiển thị ở đây -->
                    </ul>
                </div>
            </div>


            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="max_order">Số lượng đặt hàng tối đa:</label>
                        <input type="number" class="form-control" id="max_order" name="max_order" min="1"
                            value="{{ old('max_order') }}" placeholder="Nhập số lượng đặt hàng tối đa">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="promotion">Khuyến mãi:</label>
                        <input type="number" class="form-control" id="promotion" name="promotion" min="1"
                            value="{{ old('promotion') }}" placeholder="Nhập % khuyến mãi">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="price_combo">Giá:</label>
                        <input type="number" class="form-control" id="price_combo" name="price_combo" min="0"
                            value="{{ old('price_combo') }}" placeholder="Nhập tổng tiền">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="totalPrice">Tổng Tiền:</label>
                        <input type="number" class="form-control" id="totalPrice" name="totalPrice"
                            placeholder="Tổng tiền được tính tự động" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date">Ngày bắt đầu:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ old('start_date') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date">Ngày kết thúc:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ old('end_date') }}">
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

            <button type="submit" class="btn btn-primary">Thêm Combo</button>
        </div>
    </form>



    <!-- Thư viện jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script>
        function showSuccessMessage(message) {
            alert(message);
        }

        $(document).ready(function() {
            // Khởi tạo Select2 cho dropdown select sản phẩm
            $('#product_search').select2();

            // Khởi tạo Select2 cho dropdown select món ăn
            $('#item_search').select2();

            // Biến tạm lưu tổng giá tiền gốc
            var originalTotalPrice = 0;

            // Xử lý sự kiện khi sản phẩm hoặc món ăn được chọn
            $('#product_search, #item_search').change(function() {
                var selectedProducts = [];
                var selectedItems = [];
                var totalPrice = 0;

                // Tính tổng tiền từ các sản phẩm được chọn
                $('#product_search option:selected').each(function() {
                    selectedProducts.push($(this).text());
                    totalPrice += parseFloat($(this).data('price'));
                });

                // Tính tổng tiền từ các món ăn được chọn
                $('#item_search option:selected').each(function() {
                    selectedItems.push($(this).text());
                    totalPrice += parseFloat($(this).data('price'));
                });

                // Lưu trữ tổng giá tiền gốc
                originalTotalPrice = totalPrice;

                // Hiển thị danh sách sản phẩm đã chọn
                displaySelectedProducts(selectedProducts);

                // Hiển thị danh sách món ăn đã chọn
                displaySelectedItems(selectedItems);

                // Hiển thị tổng giá tiền
                $('#totalPrice').val(totalPrice.toFixed(0));
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

            // Hàm hiển thị danh sách món ăn đã chọn
            function displaySelectedItems(items) {
                // Xóa danh sách hiện tại
                $('#selected_items').empty();
                // Hiển thị các món ăn đã chọn
                items.forEach(function(item) {
                    $('#selected_items').append('<li>' + item + '</li>');
                });
            }

            // Xử lý sự kiện khi nhấn nút "Xóa" cho sản phẩm
            $('#btnClearSearch').click(function() {
                // Xóa tất cả các lựa chọn trong dropdown sản phẩm
                $('#product_search').val([]).trigger('change');
                // Xóa danh sách hiển thị sản phẩm đã chọn
                $('#selected_products').empty();
            });

            // Xử lý sự kiện khi nhấn nút "Xóa" cho món ăn
            $('#btnClearItemSearch').click(function() {
                // Xóa tất cả các lựa chọn trong dropdown món ăn
                $('#item_search').val([]).trigger('change');
                // Xóa danh sách hiển thị món ăn đã chọn
                $('#selected_items').empty();
            });

            // Xử lý sự kiện khi thay đổi phần trăm khuyến mãi
            $('#promotion').change(function() {
                var promotion = parseFloat($(this).val());
                if (!isNaN(promotion) && promotion >= 0 && promotion <= 100) {
                    var discountedPrice = originalTotalPrice * (1 - promotion / 100);
                    $('#totalPrice').val(discountedPrice.toFixed(0));
                }
            });
        });
    </script>
@endsection
