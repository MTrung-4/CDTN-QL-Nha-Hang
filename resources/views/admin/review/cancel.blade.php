@extends('admin.users.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên Tài Khoản</th>
                <th>Sản Phẩm</th>
                <th>Điểm</th>
                <th>Nội dung</th>
                <th>Thời gian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $key => $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->user->name }}</td>
                    <td>{{ $review->product->name }}</td>
                    <td>{{ $review->rating }}</td>
                    <td>{{ $review->content }}</td>
                    <td>{{ $review->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
        
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-review"><a class="page-link" href="{{ $reviews->previousPageUrl() }}">Previous</a></li>
    
            @for ($i = 1; $i <= $reviews->lastPage(); $i++)
                <li class="page-review{{ ($i == $reviews->currentPage()) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $reviews->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
    
            <li class="page-review"><a class="page-link" href="{{ $reviews->nextPageUrl() }}">Next</a></li>
        </ul>
    </div>
@endsection
