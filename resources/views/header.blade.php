<header>
    @php    $menusHtml = \App\Helpers\Helper::menus($menus); @endphp
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    <i> Yen's Restaurant - Mở cửa từ 11h00 đến 22h00 </i>
                </div>

                @if (auth()->check())
                    <!-- Kiểm tra xem người dùng đã đăng nhập hay chưa -->
                    <div class="right-top-bar flex-w h-full">
                        <span class="flex-c-m trans-04 p-lr-25">Chào mừng, {{ auth()->user()->name }}</span>
                    </div>
                @else
                    <!-- Nút đăng nhập nếu người dùng chưa đăng nhập -->
                    <div class="right-top-bar flex-w h-full">
                        <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25">Đăng Nhập</a>
                    </div>
                @endif

            </div>
        </div>
        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="/" class="logo">
                    <img src="/template/images/yen.png" alt="Yen's Restaurant">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu"><a href="/">Trang Chủ</a> </li>

                        {!! $menusHtml !!}


                        <li>
                            <a href="/web-item">Thực Đơn</a>
                        </li>

                        <li>
                            <a href="/lien-he">Liên Hệ</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                        data-notify="{{ !is_null(\Session::get('carts')) ? count(\Session::get('carts')) : 0 }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>

                </div>
                <div class="flex-c-m h-full p-lr-19">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
                        <i class="zmdi zmdi-menu"></i>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="/">
                <img src="/template/images/yen.png" alt="Yen's Restaurant">
            </a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                data-notify="2">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    <i> Yen's Restaurant - Mở cửa từ 11h00 đến 22h00 </i>
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">


                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        @if (auth()->check())
                            <!-- Kiểm tra xem người dùng đã đăng nhập hay chưa -->
                            <div class="right-top-bar flex-w h-full">
                                <span class="flex-c-m trans-04 p-lr-25">Chào mừng, {{ auth()->user()->name }}</span>
                            </div>
                        @else
                            <!-- Nút đăng nhập nếu người dùng chưa đăng nhập -->
                            <div class="right-top-bar flex-w h-full">
                                <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25">Đăng Nhập</a>
                            </div>
                        @endif
                    </a>
                </div>
            </li>
        </ul>
        <ul class="main-menu-m">
            <li class="active-menu"><a href="/">Trang Chủ</a> </li>

            {!! $menusHtml !!}

            <li>
                <a href="/web-item">Thực Đơn</a>
            </li>

            <li>
                <a href="/lien-he">Liên Hệ</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="/template/images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15" action="/search" method="GET">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>

    <!--Side Bar-->
    <aside class="wrap-sidebar js-sidebar">
        <div class="s-full js-hide-sidebar"></div>

        <div class="sidebar flex-col-l p-t-22 p-b-25">
            <div class="flex-r w-full p-b-30 p-r-27">
                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-sidebar">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="sidebar-content flex-w w-full p-lr-65 js-pscroll ps ps--active-y"
                style="position: relative; overflow: hidden;">
                <ul class="sidebar-link w-full">
                    <li class="p-b-13">
                        <a href="/" class="stext-102 cl2 hov-cl1 trans-04">
                            Trang Chủ
                        </a>
                    </li>

                    <li class="p-b-13">
                        @if (auth()->check())
                            <a href="{{ route('account') }}" class="stext-102 cl2 hov-cl1 trans-04">Tài Khoản</a>
                        @else
                            <a href="{{ route('login') }}" class="stext-102 cl2 hov-cl1 trans-04">Tài Khoản</a>
                        @endif
                    </li>


                    <li class="p-b-13">
                        <a href="{{ route('order-history') }}" class="stext-102 cl2 hov-cl1 trans-04">
                            Lịch Sử Đặt Hàng
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="/lien-he" class="stext-102 cl2 hov-cl1 trans-04">
                            Liên Hệ
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Đăng Xuất
                        </a>
                        <form id="logout-form" action="{{ route('web.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </li>

                </ul>

                <div class="sidebar-gallery w-full p-tb-30">
                    <span class="mtext-101 cl5">
                        @ YEN RESTAURANT
                    </span>

                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; height: 582px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 419px;"></div>
                    </div>
                </div>
            </div>
    </aside>

</header>
