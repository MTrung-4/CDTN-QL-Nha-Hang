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
                    <input style="border: 1px solid black" class="form-control form-control-navbar" type="search" id="searchInput" placeholder="Tìm kiếm"
                        aria-label="Search">
                </div>
            </form>
        </div>
    </div>


    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Tên Danh Mục</th>
                <th>Hoạt Động</th>
                <th>Cập Nhật</th>
                <th width="100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            {!! App\Helpers\Helper::menu($menus) !!}
        </tbody>
    </table>

    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="{{ $menus->previousPageUrl() }}">Previous</a></li>

            @for ($i = 1; $i <= $menus->lastPage(); $i++)
                <li class="page-item{{ $i == $menus->currentPage() ? ' active' : '' }}">
                    <a class="page-link" href="{{ $menus->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item"><a class="page-link" href="{{ $menus->nextPageUrl() }}">Next</a></li>
        </ul>
    </div>
    <script>
        function showSuccessMessage(message) {
            alert(message);
        }

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
