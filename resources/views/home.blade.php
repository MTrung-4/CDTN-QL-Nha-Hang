@extends('main')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Dancing+Script:wght@400..700&display=swap');
    </style>
    <!-- Slider -->
    <section class="section-slide">
        <div class="wrap-slick1">
            <div class="slick1">
                @foreach ($sliders as $slider)
                    <div class="item-slick1" style="background-image: url({{ $slider->thumb }});">
                        <div class="container h-full">
                        </div>
                    </div>
                @endforeach
            </div>
    </section>

    <!-- Product -->
    @include('admin.users.alert-web')
    <section class="bg0 p-t-23 p-b-140">
        <div class="container">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    món ăn bạn thích
                </h3>
                <h3 style=" font-family: Dancing Script, cursive; font-weight: bold; font-size: 2rem; line-height: 1.5; margin-bottom:40px;">
                    Khám phá thế giới hương vị độc đáo tại nhà hàng chúng tôi - mời bạn chọn món ngay!
                </h3>
            </div>

            <div id="loadProduct">
                @include('products.list')
            </div>

            <!-- Load more -->
            <div class="flex-c-m flex-w w-full p-t-45" id="button-loadMore">
                <input type="hidden" value="1" id="page">
                <a onclick="loadMore()" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                    Xem thêm
                </a>
            </div>
        </div>
    </section>
@endsection
