@extends('admin.users.main')

@section('content')
<style>
    .table-card {
        margin-bottom: 30px;
        position: relative;
    }

    .status {
        background-color: #fff;
        padding: 5px;

    }

    .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title,
    .card-text {
        margin-bottom: 0;
    }

    .ml-1 {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .divider {
        margin: 0 10px;
    }

    .btn-container {
        margin: 0 0 10px 20px;

    }
</style>

<div class="container">
    <div class="row">
        @foreach ($tables as $table)
        <div class="col-md-4 mb-4">
            <div class="card table-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="ml-1">
                            <h5 class="card-title">{{ $table->name }}</h5>
                            <div class="divider">|</div>
                            <p class="card-text">SL: {{ $table->capacity }}</p>
                        </div>
                        <span class="status">
                            {!! \App\Helpers\Helper::active($table->active) !!}
                        </span>
                    </div>
                </div>
                <div class="btn-container">
                    <a class="btn btn-primary btn-sm" href="/admin/tables/edit/{{ $table->id }}">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                    <button class="btn btn-info btn-sm ml-2"  onclick="selectTable({{ $table->id }})">
                        <i class="fas fa-info"></i> Chọn bàn
                    </button>
                    <button class="btn btn-danger btn-sm ml-2" onclick="removeRow({{ $table->id }}, '/admin/tables/destroy')">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script>
function selectTable(tableId) {
    // Gửi yêu cầu Ajax để chọn bàn
    $.ajax({
        type: 'GET', // Phương thức gửi dữ liệu
        url: '/admin/tables/select/' + tableId, // Đường dẫn đến endpoint xử lý
        success: function(response) {
            // Xử lý phản hồi từ máy chủ (nếu cần)
            if (response.success) {
                // Phản hồi thành công, bạn có thể thực hiện các thao tác cần thiết ở đây
                console.log('Bàn đã được chọn thành công!');
                // Chuyển hướng người dùng đến trang danh sách khách hàng
                window.location.href = '/admin/customers/show';
            } else {
                // Xử lý lỗi nếu có
                console.error('Đã xảy ra lỗi khi chọn bàn:', response.message);
            }
        },
        error: function(xhr, status, error) {
            // Xử lý lỗi trong quá trình gửi yêu cầu
            console.error('Lỗi khi gửi yêu cầu:', error);
        }
    });
}


</script>

@endsection
