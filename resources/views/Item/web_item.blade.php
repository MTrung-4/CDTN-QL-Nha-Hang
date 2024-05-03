@extends('main')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Briem+Hand:wght@100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Dancing+Script:wght@400..700&display=swap');

        .item-container {
            margin: 100px auto;
        }

        .block2-pic {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            /* Tạo ra một hình vuông */
            overflow: hidden;
        }

        .block2-pic img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Đảm bảo ảnh sẽ không bị căn chỉnh */
        }

        .isotope-item {
            margin-bottom: 20px;
            /* Thêm khoảng cách giữa các sản phẩm */
        }

        h1 {
            font-family: "Briem Hand", cursive;
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        h2 {
            font-family: "Briem Hand", cursive;
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }

        .block2-txt {
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
        }

        .block2-txt-child1 {
            margin-bottom: 10px;
        }

        .block2-txt-child1 a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .block2-txt-child1 a:hover {
            color: #fe508d;
        }
    </style>
    <div class="container item-container">
        <h1>Thực Đơn <div class="br" style=" font-family: Dancing Script, cursive; line-height: 1.5;">Hãy
                tham khảo thực đơn đa dạng của chúng tôi và tận hưởng những món ăn ngon miệng đặc biệt chỉ có tại đây!</h1>
        @foreach ($items as $item)
            <div class="col-12 p-b-35">
                <h2>{{ $item->name }}</h2>
                <p style="font-family: Briem Hand, cursive; color: #666; margin-bottom: 20px;">Giá: {{ $item->price }} đ
                </p>
                <div class="row">
                    @foreach ($item->products as $product)
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="{{ $product->thumb }}" alt="{{ $product->name }}">
                                </div>
                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l">
                                        <a href="/san-pham/{{ $product->id }}-{{ Str::slug($product->name, '-') }}.html"
                                            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            {{ $product->name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
