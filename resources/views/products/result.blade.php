@extends('main')

@section('content')
<div class="custom-content" style="margin: 62.2px 0 ; padding-left: 20px;">
    <h2>Kết quả tìm kiếm</h2>
    <br>
        @if (count($products) > 0)
            <ul>
                @foreach ($products as $product)
                    <li>@include('products.list')</li>
                @endforeach
            </ul>
        @else
            <p style="font-weight: bold; text-align: center;">Không tìm thấy sản phẩm nào.</p>
        @endif
</div>
@endsection
