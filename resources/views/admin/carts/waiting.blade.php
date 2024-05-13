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
        </style>
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên Khách Hàng</th>
                <th>SDT</th>
                <th>Thời Gian Dùng</th>
                <th>Thời Gian Đặt</th>
                <th style="width: 150px">Xác Nhận</th>
                <th style="width: 100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $key => $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->time }}</td>
                    <td>{{ $customer->created_at }}</td>
                    <td>
                        <!-- Nút duyệt đơn -->
                        <button style="width:2.3rem; padding: .25rem .5rem;" class="btn btn-success approve-btn"
                            data-customer-id="{{ $customer->id }}">
                            <i class="fas fa-check"></i>
                        </button>

                        <!-- Nút từ chối đơn -->
                        <button style="width:2.3rem; padding: .25rem .5rem;" class="btn btn-danger reject-btn"
                            data-customer-id="{{ $customer->id }}">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                    <td>
                        <a class="btn btn-view btn-sm view-btn" href="/admin/customers/view/{{ $customer->id }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="modal fade" id="cancelReasonModal" tabindex="-1" role="dialog" aria-labelledby="cancelReasonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelReasonModalLabel">Nhập Lý Do Hủy Đơn</h5>
                </div>
                <div class="modal-body">
                    <form id="cancelReasonForm">
                        <div class="form-group">
                            <label for="cancelReason">Lý Do Hủy:</label>
                            <textarea class="form-control" id="cancelReason" name="cancel_reason" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" id="confirmCancelBtn">Xác Nhận Hủy Đơn</button>
                </div>
            </div>
        </div>
    </div>


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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Xử lý sự kiện khi nút "Duyệt" được nhấn
            $('.approve-btn').click(function() {
                var customerId = $(this).data('customer-id');
                // Xác nhận trước khi duyệt đơn hàng
                if (confirm("Bạn có chắc chắn muốn duyệt đơn hàng này?")) {
                    updateStatus(customerId, 'approved', null);
                }
            });

            // Xử lý sự kiện khi nút "Từ chối" được nhấn
            $('.reject-btn').click(function() {
                var customerId = $(this).data('customer-id');
                // Hiển thị modal để nhập lý do hủy
                $('#cancelReasonModal').modal('show');

                // Xử lý khi người dùng xác nhận hủy đơn
                $('#confirmCancelBtn').click(function() {
                    var cancelReason = $('#cancelReason').val();

                    // Gửi AJAX request để cập nhật trạng thái và lý do hủy đơn
                    updateStatus(customerId, 'rejected', cancelReason);
                });
            });

            // Xử lý sự kiện khi modal ẩn đi
            $('#cancelReasonModal').on('hidden.bs.modal', function(e) {
                // Reset giá trị của trường nhập lý do khi modal được ẩn
                $('#cancelReason').val('');
            });

            // Hàm cập nhật trạng thái đơn hàng thông qua AJAX
            function updateStatus(customerId, status, cancelReason) {
                // Kiểm tra lý do hủy đơn khi trạng thái là "Từ chối"
                if (status === 'rejected' && cancelReason.trim() === '') {
                    alert('Vui lòng nhập lý do hủy đơn.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: '/admin/carts/update-status',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'customer_id': customerId,
                        'status': status,
                        'cancel_reason': cancelReason
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
    </script>
@endsection
