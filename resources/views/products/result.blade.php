@extends('main')

@section('content')
<div class="custom-content" style="margin: 100px auto ; padding-left: 20px;">
    <h2>Kết quả tìm kiếm</h2>
    <br>
        @if (isset($products) && count($products) > 0)
            @include('products.list')
        @else
            <p style="font-weight: bold; text-align: center;">Không tìm thấy sản phẩm nào.</p>
        @endif
</div>
@endsection
