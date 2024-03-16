@extends('main')

@section('content')
    <div class="notify" style="margin-top:62.2px; text-align:center">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
    </div>
    <form class="bg0 p-t-130 p-b-85 m-l-25 m-r--38 m-lr-0-xl" method="post">
        @include('admin.users.alert')

        @if (count($products) != 0)
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                        <div class="m-l-25 m-r--38 m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                @php $total = 0; @endphp
                                <table class="table-shopping-cart">
                                    <tbody>
                                        <tr class="table_head">
                                            <th class="column-1">Sản Phẩm</th>
                                            <th class="column-2"></th>
                                            <th class="column-3">Giá</th>
                                            <th class="column-4">Số Lượng</th>
                                            <th class="column-5">Tổng</th>
                                            <th class="column-6">&nbsp;</th>
                                        </tr>

                                        @foreach ($products as $key => $product)
                                            @php
                                                $price =
                                                    $product->price_sale != 0 ? $product->price_sale : $product->price;
                                                $priceEnd = $price * $carts[$product->id];
                                                $total += $priceEnd;
                                            @endphp
                                            <tr class="table_row">
                                                <td class="column-1">
                                                    <div class="how-itemcart1">
                                                        <img src="{{ $product->thumb }}" alt="IMG">
                                                    </div>
                                                </td>
                                                <td class="column-2">{{ $product->name }}</td>
                                                <td class="column-3">{{ number_format($price, 0, '', '.') }}</td>
                                                <td class="column-4">
                                                    <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                                        </div>
                                                        <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                            name="num_product[{{ $product->id }}]"
                                                            value="{{ $carts[$product->id] }}">
                                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="column-5">{{ number_format($priceEnd, 0, '', '.') }}</td>
                                                <td class="p-r-15">
                                                    <a href="/carts/delete/{{ $product->id }}">Xóa</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Update Cart Button -->
                            <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                                <input type="submit" value="Cập Nhật" formaction="/update-cart"
                                    class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                @csrf
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-10 col-lg-10 col-xl-7 m-lr-auto m-b-50">
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                            <h4 class="mtext-109 cl2 p-b-30">
                                Thông Tin Khách Hàng
                            </h4>

                            <!-- Customer Information Inputs -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="name"
                                            placeholder="Tên khách Hàng">
                                    </div>
                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="phone"
                                            placeholder="Số Điện Thoại">
                                    </div>
                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="email"
                                            placeholder="Email Liên Hệ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="datetime-local" name="time"
                                            placeholder="Thời gian">
                                    </div>
                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="number" name="qty"
                                            placeholder="Số lượng">
                                    </div>
                                    <div class="bor8 bg0 m-b-12">
                                        <textarea class="stext-111 cl8 plh3 size-111 p-lr-15" name="content" placeholder="Ghi Chú"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Button -->
                            <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                Đặt Hàng
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                        <!-- Thay đổi lớp lưới từ col-lg-5 và col-xl-3 sang col-lg-7 và col-xl-5 -->
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                            <h4 class="mtext-109 cl2 p-b-30">
                                Phương Thức Thanh Toán
                            </h4>

                            <div class="d-flex flex-column"> <!-- Sử dụng Flexbox để chia cột dọc -->
                                <div style="width=100px" class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                        data-bs-toggle="dropdown">Chuyển Khoản</button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <p>Số Tài Khoản: 6011309481</p>
                                        </li>
                                        <li>
                                            <p>Ngân Hàng: BIDV</p>
                                        </li>
                                        <li>
                                            <p>Tên: Trần Nguyễn Minh Trung</p>
                                        </li>
                                    </ul>
                                    <button type="button" class="btn btn-primary">Mã QR</button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-bs-toggle="dropdown">VNPAY</button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Tablet</a></li>
                                            <li><a class="dropdown-item" href="#">Smartphone</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>




                </div>
            </div>
        @else
            <div class="text-center">
                <h2>Không có sản phẩm trong giỏ hàng</h2>
                <img src="/template/images/giohang.jpg" style="height: 100px; width: 100px;">
            </div>
            <br>
        @endif
    </form>



@endsection
