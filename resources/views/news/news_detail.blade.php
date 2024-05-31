<!-- Header -->
@include('head')

<head>
    @include('header')
</head>


<!-- breadcrumb -->
<div style="margin: 100px auto 10px auto;" class="container bread-container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <a href="/show-news" class="stext-109 cl8 hov-cl1 trans-04">
            Tin Tức
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            {{ $news->name }}
        </span>
    </div>
</div>

<!-- Content page -->
<section class="bg0 p-t-52 p-b-20">
    <div style="margin-bottom: 100px" class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9 p-b-80">
                <div class="p-r-45 p-r-0-lg">
                    <div class="wrap-pic-w how-pos5-parent">
                        <img src="{{ $news->thumb }}" alt="{{ $news->name }}">

                        <div class="flex-col-c-m size-123 bg9 how-pos5">
                            <span class="ltext-103 cl2 txt-center">
                                {{ $news->updated_at->format('d') }} <!-- Lấy ra ngày -->
                            </span>

                            <span class="stext-109 cl3 txt-center">
                                {{ $news->updated_at->format('M Y') }} <!-- Lấy ra tháng và năm -->
                            </span>
                        </div>

                    </div>

                    <div class="p-t-32">
                        <h4 class="ltext-103 cl2 p-b-28">
                            {{ $news->name }}
                        </h4>

                        <p style=" text-align: justify;
                        " class="stext-103 cl6 p-b-26">
                            {{ $news->description }}
                        </p>

                        <p style=" text-align: justify;
                        font-style: italic;     text-indent: 2em;"
                            class="stext-103 cl6 p-b-26">
                            {{ $news->content }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


<footer>
    @include('footer')
</footer>
