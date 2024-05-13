@extends('main')
@section('content')
    <style>
        .comment-container {
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 20px;
        }
    </style>
    <div class="container p-t-80">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="/" class="stext-101 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="/danh-muc/{{ $product->menu->id }}-{{ Str::slug($product->menu->name) }}.html"
                class="stext-109 cl8 hov-cl1 trans-04">
                {{ $product->menu->name }}
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                {{ $title }}
            </span>
        </div>
    </div>

    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">


                            <div class="slick3 gallery-lb slick-initialized slick-slider slick-dotted">
                                <div class="slick-list draggable">
                                    <div class="slick-track" style="opacity: 1; width: 1539px;">
                                        <div class="item-slick3 slick-slide slick-current slick-active"
                                            data-thumb="images/product-detail-01.jpg" data-slick-index="0"
                                            aria-hidden="false"
                                            style="width: 513px; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1;"
                                            tabindex="0" role="tabpanel" id="slick-slide10"
                                            aria-describedby="slick-slide-control10">
                                            <div class="wrap-pic-w pos-relative">
                                                <img src="{{ $product->thumb }}" alt="{{ $product->thumb }}">

                                                <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                    href="{{ $product->thumb }}" tabindex="0">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">

                        @include('admin.users.alert')

                        <h4 style="font-size: 28px; font-weight: bold" class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $title }}
                        </h4>

                        <span class="mtext-106 cl2">
                            {!! \App\Helpers\Helper::price($product->price, $product->price_sale) !!} đ
                        </span>

                        <p class="stext-102 cl3 p-t-23">
                            {{ $product->description }}
                        </p>

                        <!--  -->
                        <div class="p-t-33">
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <form action="/add-cart" method="post">
                                        @if ($product->price !== null)
                                            <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>

                                                <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                    name="num_product" value="1">

                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>


                                            <button type="submit"
                                                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 ">
                                                Thêm vào giỏ hàng
                                            </button>
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        @endif
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Tóm tắt </a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#information" role="tab">Mô tả chi tiết</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Đánh giá</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {!! $product->description !!}
                                </p>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="information" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <ul class="p-lr-28 p-lr-15-sm">
                                        <li class="flex-w flex-t p-b-7">
                                            {!! $product->content !!}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @php
                            $reviews = $product->reviews()->orderBy('id', 'desc')->get();
                        @endphp
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <div class="p-b-30 m-lr-15-sm">
                                        <!-- Review -->
                                        <div class="comment-container">
                                            @foreach ($reviews as $review)
                                                <div class="flex-w flex-t p-b-68">
                                                    <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                        <img src="/template/images/an-danh2.jpg" alt="AVATAR">
                                                    </div>

                                                    <div class="size-207">
                                                        <div class="flex-w flex-sb-m p-b-17">
                                                            <span class="mtext-107 cl2 p-r-20">
                                                                {{ $review->user->name }}
                                                            </span>

                                                            <span style="margin-right: 10px" class="fs-18 cl11">
                                                                @if ($review->status == 2)
                                                                    @for ($i = 1; $i <= $review->rating; $i++)
                                                                        <i class="fa fa-star"></i>
                                                                    @endfor
                                                                @endif
                                                            </span>
                                                        </div>

                                                        <p class="stext-102 cl6">
                                                            @if ($review->status == 2)
                                                                {{ $review->content }}
                                                            @elseif($review->status == 1)
                                                                Đã bị xóa vì nội dung không phù hợp.
                                                            @else
                                                                Đang chờ duyệt.
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if (auth()->check())
                                            <!-- Add review -->
                                            <form class="w-full" method="POST" action="{{ route('review') }}">
                                                @csrf
                                                <h5 class="mtext-108 cl2 p-b-7">
                                                    Bình luận
                                                </h5>
                                                <input name="product_id" value="{{ $product->id }}" type="hidden">

                                                <div class="flex-w flex-m p-t-50 p-b-23">
                                                    <span class="stext-102 cl3 m-r-16">
                                                        Đánh giá
                                                    </span>

                                                    <span class="wrap-rating fs-18 cl11 pointer">
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                        <input class="dis-none" type="number" name="rating">
                                                    </span>
                                                </div>

                                                <div class="row p-b-25">
                                                    <div class="col-12 p-b-5">
                                                        <label class="stext-102 cl3" for="review">Nội dung đánh
                                                            giá</label>
                                                        <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="content"></textarea>
                                                    </div>
                                                </div>

                                                <button
                                                    class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                    Gửi
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="stext-102 cl2 hov-cl1 trans-04">Đăng
                                                nhập để bình luận.</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">

        <span class="stext-107 cl6 p-lr-25">
            Loại: {{ $product->menu->name }}
        </span>
    </div>
    </section>

    <section class="sec-relate-product bg0 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Món Ăn Khác
                </h3>
            </div>

            @include('products.list')
        </div>
    </section>
@endsection
