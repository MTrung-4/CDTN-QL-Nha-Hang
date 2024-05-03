@extends('main')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Briem+Hand:wght@100..900&display=swap');
    </style>
    <div class="bg0 m-t-23 p-b-140 p-t-80">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <h1 style="font-family: Briem Hand, cursive; margin-bottom: 30px;
                    color: #333; ">
                        {{ $title }}</h1>
                </div>

                <div class="flex-w flex-c-m m-tb-10">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Lọc
                    </div>
                </div>


                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                        <div class="filter-col1 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Sắp xếp:
                            </div>

                            <ul>
                                <li class="p-b-6">
                                    <a href="{{ request()->url() }}" class="filter-link stext-106 trans-04">
                                        Mặc định
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="{{ request()->fullUrlWithQuery(['price' => 'asc']) }}"
                                        class="filter-link stext-106 trans-04">
                                        Giá: Thấp tới Cao
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="{{ request()->fullUrlWithQuery(['price' => 'desc']) }}"
                                        class="filter-link stext-106 trans-04">
                                        Giá: Cao tới Thấp
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @include('products.list')

            {!! $products->links() !!}
        </div>
    </div>
@endsection
