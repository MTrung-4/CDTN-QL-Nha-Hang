@extends('admin.users.main')

@section('content')
    <style>
        .search {
            float: right;
            /* hoặc */
            display: flex;
            justify-content: flex-end;
            margin: 0 20px 10px 20px;
        }
    </style>
    <div class="search">
        <div class="card-tools">
            <form class="form-inline">
                <div class="input-group input-group-sm">
                    <input style="border: 1px solid black" class="form-control form-control-navbar" type="search"
                        id="searchInput" placeholder="Tìm kiếm" aria-label="Search">
                </div>
            </form>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên Tài Khoản</th>
                <th>Sản Phẩm</th>
                <th>Điểm</th>
                <th>Nội dung</th>
                <th>Thời gian</th>
                <th style="width: 100px">&nbsp;</th>
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
                    <td>
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="removeRow({{ $review->id }}, '/admin/reviews/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-review"><a class="page-link" href="{{ $reviews->previousPageUrl() }}">Previous</a></li>

            @for ($i = 1; $i <= $reviews->lastPage(); $i++)
                <li class="page-review{{ $i == $reviews->currentPage() ? ' active' : '' }}">
                    <a class="page-link" href="{{ $reviews->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-review"><a class="page-link" href="{{ $reviews->nextPageUrl() }}">Next</a></li>
        </ul>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy danh sách các hàng
            var rows = document.querySelectorAll('.table tbody tr');

            // Lắng nghe sự kiện nhập vào ô tìm kiếm
            document.getElementById('searchInput').addEventListener('input', function(event) {
                var searchQuery = event.target.value.toLowerCase();

                // Lặp qua các hàng và ẩn/hiện tùy thuộc vào kết quả tìm kiếm
                rows.forEach(function(row) {
                    var rowData = row.innerText.toLowerCase();
                    if (rowData.indexOf(searchQuery) !== -1) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
