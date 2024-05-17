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
                <th>Tiêu Đề</th>
                <th>Ảnh</th>
                <th>Hoạt Động</th>
                <th>Cập Nhật</th>
                <th style="width: 100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $key => $slider)
                <tr>
                    <td>{{ $slider->id }}</td>
                    <td>{{ $slider->name }}</td>
                    <td><a href="{{ $slider->thumb }}" target="_blank">
                            <img src="{{ $slider->thumb }}" height="40px">
                        </a>
                    </td>
                    <td>{!! \App\Helpers\Helper::active($slider->active) !!}</td>
                    <td>{{ $slider->updated_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/admin/sliders/edit/{{ $slider->id }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="removeRow({{ $slider->id }}, '/admin/sliders/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="{{ $sliders->previousPageUrl() }}">Previous</a></li>

            @for ($i = 1; $i <= $sliders->lastPage(); $i++)
                <li class="page-item{{ $i == $sliders->currentPage() ? ' active' : '' }}">
                    <a class="page-link" href="{{ $sliders->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item"><a class="page-link" href="{{ $sliders->nextPageUrl() }}">Next</a></li>
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
