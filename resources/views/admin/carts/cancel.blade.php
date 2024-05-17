@extends('admin.users.main')

@section('content')
    <table class="table">
        <style>
            .view-btn {
                background-color: #00FF00;
                border-color: #00FF00;
                color: #fff;
            }

            .view-btn:hover {
                background-color: #008000;
                border-color: #008000;
            }

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
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên Khách Hàng</th>
                <th>SDT</th>
                <th>Thời Gian Dùng</th>
                <th>Trạng Thái</th>
                <th>Lý Do Hủy</th>
                <th>Thời Gian Đặt</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carts as $key => $cart)
                <tr>
                    <td>{{ $cart->customer->id }}</td>
                    <td>{{ $cart->customer->name }}</td>
                    <td>{{ $cart->customer->phone }}</td>
                    <td>{{ $cart->customer->time }}</td>
                    <td style="color: red; font-weight: bold">{{ $cart->status === 0 ? 'Đã Hủy' : '' }}</td>
                    <td>{{ $cart->cancel_reason }}</td>
                    <td>{{ $cart->customer->created_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm view-btn" href="/admin/customers/view/{{ $cart->customer->id }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="{{ $customers->previousPageUrl() }}">Previous</a></li>

            @for ($i = 1; $i <= $customers->lastPage(); $i++)
                <li class="page-item{{ $i == $customers->currentPage() ? ' active' : '' }}">
                    <a class="page-link" href="{{ $customers->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item"><a class="page-link" href="{{ $customers->nextPageUrl() }}">Next</a></li>
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
