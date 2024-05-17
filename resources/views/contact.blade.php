<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/template/images/icons/favicon.png" />
    <!--=====================================/==========================================================-->
    <link rel="stylesheet" type="text/css" href="/template/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/vendor/slick/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/vendor/MagnificPopup/magnific-popup.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/css/util.css">
    <link rel="stylesheet" type="text/css" href="/template/css/main.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/template/css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>

<body>
    @include('header')
    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('/template/images/yen.png')">
        <h2 class="ltext-105 cl0 txt-center">
            Giới Thiệu
        </h2>
    </section>

    <section style="margin: 100px auto">
        <section class="bg0 p-t-75 p-b-120">
            <div class="container">
                <div class="container">
                    <div class="flex-w flex-tr">
                        <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                            @include('admin.users.alert-web')
                            <form method="post" action="/submit-feedback">
                                @csrf
                                <h4 class="mtext-105 cl2 txt-center p-b-30">
                                    Gửi phản hồi cho chúng tôi
                                </h4>

                                <div class="bor8 m-b-20 how-pos4-parent">
                                    <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text"
                                        name="email" placeholder="example@gmail.com">
                                    <img class="how-pos4 pointer-none" src="/template/images/icons/icon-email.png"
                                        alt="ICON">
                                </div>

                                <div class="bor8 m-b-30">
                                    <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="message" placeholder="Phản hồi của bạn"></textarea>
                                </div>

                                <button
                                    class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                                    Gửi
                                </button>
                            </form>
                        </div>

                        <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                            <div class="flex-w w-full p-b-42">
                                <span class="fs-18 cl5 txt-center size-211">
                                    <span class="lnr lnr-map-marker"></span>
                                </span>

                                <div class="size-212 p-t-2">
                                    <span class="mtext-110 cl2">
                                        Địa chỉ
                                    </span>

                                    <p class="stext-115 cl6 size-213 p-t-18">
                                        3/13A, Trần Quang Khải, Lộc Thọ, Nha Trang, Khánh Hòa
                                    </p>
                                </div>
                            </div>

                            <div class="flex-w w-full p-b-42">
                                <span class="fs-18 cl5 txt-center size-211">
                                    <span class="lnr lnr-phone-handset"></span>
                                </span>

                                <div class="size-212 p-t-2">
                                    <span class="mtext-110 cl2">
                                        Số điện thoại
                                    </span>

                                    <p class="stext-115 cl1 size-213 p-t-18">
                                        0902.678.910
                                    </p>
                                </div>
                            </div>

                            <div class="flex-w w-full">
                                <span class="fs-18 cl5 txt-center size-211">
                                    <span class="lnr lnr-envelope"></span>
                                </span>

                                <div class="size-212 p-t-2">
                                    <span class="mtext-110 cl2">
                                        Email
                                    </span>

                                    <p class="stext-115 cl1 size-213 p-t-18">
                                        contact@example.com
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div style="margin-top: 100px;" class="row">
                    <div class="order-md-2 col-md-7 col-lg-8 p-b-30">
                        <div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
                            <h3 class="mtext-111 cl2 p-b-16">
                                YEN'S RESTAURANT
                            </h3>

                            <p class="stext-113 cl6 p-b-26">
                                Tự hào là nhà hàng Việt độc đáo và được ca ngợi nhất tại Nha Trang, Yến's Restaurant đã
                                góp phần làm nên danh tiếng của thị trấn từ năm 2011. Với sứ mệnh mang lại trải nghiệm
                                ẩm thực tinh tế và đậm đà văn hóa Việt, chúng tôi đã chinh phục lòng tin của hàng ngàn
                                thực khách. Hãy đến và khám phá lý do tại sao Yến's Restaurant luôn là điểm đến lý tưởng
                                cho những tín đồ ẩm thực!
                            </p>

                            <div class="bor16 p-l-29 p-b-9 m-t-22">
                                <p class="stext-114 cl6 p-r-40 p-b-11">
                                    Yến's Restaurant được chọn bởi sự kết hợp hoàn hảo giữa chất lượng món ăn, sự tin
                                    cậy và phong cách ẩm thực hiện đại. Yến's không chỉ là nơi thưởng thức món ăn ngon,
                                    mà còn là đối tác đồng hành, sáng tạo, luôn khám phá và mang đến những trải nghiệm
                                    ẩm thực độc đáo, làm hài lòng cả những thực khách khó tính nhất.
                                </p>

                                <span class="stext-111 cl8">
                                    Chúng tôi mong rằng Yến's Restaurant sẽ không chỉ là một nhà hàng, mà còn là một
                                    điểm đến lý tưởng cho những ai đam mê nghệ thuật ẩm thực. Đến với Yến's, bạn sẽ được
                                    đắm mình trong không gian ấm áp, phong cách phục vụ chuyên nghiệp và tận tâm. Chúng
                                    tôi cam kết mang lại những trải nghiệm không chỉ dừng lại ở việc thưởng thức món ăn,
                                    mà còn là hành trình khám phá văn hóa ẩm thực đặc sắc. Hãy để Yến's Restaurant là
                                    nơi bạn tìm thấy những khoảnh khắc tuyệt vời và những câu chuyện ẩm thực đáng nhớ..
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
                        <div class="how-bor2">
                            <div class="hov-img0">
                                <img src="/template/images/yen.png" alt="IMG">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <footer> @include('footer')</footer>
</body>

</html>
