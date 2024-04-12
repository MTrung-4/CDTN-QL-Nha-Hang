@extends('main')

@section('content')

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
<section class="bg0 p-t-23 p-b-140">
    <div class="container">
        <div class="p-b-10">
            <h3 class="ltext-103 cl5">
                Sản phẩm
            </h3>
        </div>

        <div class="flex-w flex-sb-m p-b-52">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">
            </div>
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
