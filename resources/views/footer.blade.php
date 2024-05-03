<!-- Footer -->
<footer class="bg3 p-t-75 p-b-32">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Yen Restaurant
                </h4>
                {{-- <ul>
                    <img src="/template/images/">
                </ul> --}}
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Lịch sử ra đời
                </h4>

                <p class="stext-107 cl7 size-201">
                    Tự hào là nhà hàng Việt độc đáo và được ca ngợi nhất tại Nha Trang, Yến's Restaurant đã góp phần làm
                    nên danh tiếng của thị trấn từ năm 2011. Với sứ mệnh mang lại trải nghiệm ẩm thực tinh tế và đậm đà
                    văn hóa Việt, chúng tôi đã chinh phục lòng tin của hàng ngàn thực khách. Hãy đến và khám phá lý do
                    tại sao Yến's Restaurant luôn là điểm đến lý tưởng cho những tín đồ ẩm thực!
                </p>

            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    VỀ CHÚNG TÔI
                </h4>

                <ul>
                    <p class="stext-107 cl7 size-201" style="text-align: justify;">
        
                    </p>

                    <li class="p-b-10">
                        <a href="/lien-he" class="stext-107 cl7 hov-cl1 trans-04">
                            Liên Hệ
                        </a>
                    </li>

                    <p class="stext-107 cl7 size-201">
                        HOTLINE: 0902.678.910
                    </p>
                </ul>
            </div>
        </div>
    </div>
</footer>


<!-- Back to top -->
<div class="btn-back-to-top" id="myBtn">
    <span class="symbol-btn-back-to-top">
        <i class="zmdi zmdi-chevron-up"></i>
    </span>
</div>


<!--===============================================================================================-->
<script src="/template/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="/template/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="/template/vendor/bootstrap/js/popper.js"></script>
<script src="/template/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="/template/vendor/select2/select2.min.js"></script>
<script>
    $(".js-select2").each(function() {
        $(this).select2({
            minimumResultsForSearch: 20,
            dropdownParent: $(this).next('.dropDownSelect2')
        });
    })
</script>
<!--===============================================================================================-->
<script src="/template/vendor/daterangepicker/moment.min.js"></script>
<script src="/template/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="/template/vendor/slick/slick.min.js"></script>
<script src="/template/js/slick-custom.js"></script>
<!--===============================================================================================-->
<script src="/template/vendor/parallax100/parallax100.js"></script>
<script>
    $('.parallax100').parallax100();
</script>
<!--===============================================================================================-->
<script src="/template/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<script>
    $('.gallery-lb').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled: true
            },
            mainClass: 'mfp-fade'
        });
    });
</script>
<!--===============================================================================================-->
<script src="/template/vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
<script src="/template/vendor/sweetalert/sweetalert.min.js"></script>
<script>
    $('.js-addwish-b2').on('click', function(e) {
        e.preventDefault();
    });

    $('.js-addwish-b2').each(function() {
        var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
        $(this).on('click', function() {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-b2');
            $(this).off('click');
        });
    });

    $('.js-addwish-detail').each(function() {
        var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

        $(this).on('click', function() {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-detail');
            $(this).off('click');
        });
    });

    /*---------------------------------------------*/

    $('.js-addcart-detail').each(function() {
        var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
        $(this).on('click', function() {
            swal(nameProduct, "is added to cart !", "success");
        });
    });
</script>
<!--===============================================================================================-->
<script src="/template/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script>
    $('.js-pscroll').each(function() {
        $(this).css('position', 'relative');
        $(this).css('overflow', 'hidden');
        var ps = new PerfectScrollbar(this, {
            wheelSpeed: 1,
            scrollingThreshold: 1000,
            wheelPropagation: false,
        });

        $(window).on('resize', function() {
            ps.update();
        })
    });
</script>
<!--===============================================================================================-->
<script src="/template/js/main.js"></script>
<script src="/template/js/public.js"></script>
<script src="/template/admin/js/main.js"></script>
