@include('head')


<!-- Header -->

<head>
    @include('header')
</head>

<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('/template/images/yen.png');">
    <h2 class="ltext-105 cl0 txt-center">
        Tin tức
    </h2>
</section>


<!-- Content page -->
<section class="bg0 p-t-62 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9 p-b-80">
                <div class="p-r-45 p-r-0-lg">
                    <!-- item blog -->
                    @foreach ($news as $new)
                        <div class="p-b-63">
                            <a href="{{ route('news.detail', ['id' => $new->id]) }}" class="hov-img0 how-pos5-parent">
                                <img src="{{ $new->thumb }}" alt="{{ $new->name }}">

                                <div class="flex-col-c-m size-123 bg9 how-pos5">
                                    <span class="ltext-103 cl2 txt-center">
                                        {{ $new->updated_at->format('d') }} <!-- Lấy ra ngày -->
                                    </span>

                                    <span class="stext-109 cl3 txt-center">
                                        {{ $new->updated_at->format('M Y') }} <!-- Lấy ra tháng và năm -->
                                    </span>
                                </div>

                            </a>

                            <div class="p-t-32">
                                <h4 class="p-b-15">
                                    <a href="{{ route('news.detail', ['id' => $new->id]) }}"
                                        class="ltext-103 cl2 hov-cl1 trans-04">
                                        {{ $new->name }}
                                    </a>
                                </h4>

                                <p style=" text-align: justify;
                                " class="stext-117 cl6">
                                    {{ $new->description }}
                                </p>

                                <a href="{{ route('news.detail', ['id' => $new->id]) }}" style="margin-top: 10px;"
                                    class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                    Xem Chi Tiết
                                    <i class="fa fa-long-arrow-right m-l-9"></i>
                                </a>

                            </div>
                        </div>
                    @endforeach

                    <div class="flex-l-m flex-w w-full p-t-10 m-lr--7">
                        <!-- Pagination -->
                        {{ $news->links() }}

                    </div>
                </div>
            </div>
        </div>
</section>

<footer>
    @include('footer')
</footer>
