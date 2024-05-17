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
                <th style="width: 300px; overflow-wrap: break-word">Nội dung</th>
                <th>Thời gian</th>
                <th style="width: 200px">&nbsp;</th>
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
                        <!-- Nút duyệt đơn -->
                        <button style="width:2.3rem; padding: .25rem .5rem;" class="btn btn-success approve-btn"
                            data-review-id="{{ $review->id }}">
                            <i class="fas fa-check"></i>
                        </button>

                        <!-- Nút từ chối đơn -->
                        <button style="width:2.3rem; padding: .25rem .5rem;" class="btn btn-danger reject-btn"
                            data-review-id="{{ $review->id }}">
                            <i class="fas fa-times"></i>
                        </button>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Xử lý sự kiện khi nút "Duyệt" được nhấn
            $('.approve-btn').click(function() {
                var reviewId = $(this).data('review-id');

                if (confirm("Bạn có chắc chắn muốn duyệt bình luận này?")) {
                    updateStatus(reviewId, 'approved', null);
                }
            });

            // Xử lý sự kiện khi nút "Từ chối" được nhấn
            $('.reject-btn').click(function() {
                var reviewId = $(this).data('review-id');

                if (confirm("Bạn có chắc chắn muốn hủy bình luận này?")) {
                    updateStatus(reviewId, 'rejected', null);
                }
            });


            function updateStatus(reviewId, status) {

                $.ajax({
                    type: 'POST',
                    url: '/admin/reviews/update-status',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'review_id': reviewId,
                        'status': status,
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Có lỗi xảy ra khi cập nhật trạng thái: ' + error);
                    }
                });
            }
        });

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
