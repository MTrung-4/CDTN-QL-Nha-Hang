@extends('admin.users.main')

@section('content')
    <style>
        .table-card {
            margin-bottom: 30px;
            position: relative;
        }

        .status {
            background-color: #fff;
            padding: 10px 5px 15px 20px;

        }

        .card-body {
            display: flex;
            align-tables: center;
            justify-content: space-between;
            padding: 1.25rem 1.25rem 0 1.25rem;
        }

        .card-title,
        .card-text {
            margin-bottom: 0;
        }

        .ml-1 {
            display: flex;
            justify-content: space-between;
            align-tables: center;
        }

        .divider {
            margin: 0 10px;
        }

        .btn-container {
            margin: 0 0 10px 20px;

        }

        .dropdown.dropdown-right {
            position: absolute;
            top: 5px;
            right: 5px;

        }

        .dropdown.dropdown-right .dropdown-menu {
            right: 0;
            left: auto;
        }

        .dropdown-item:hover {
            color: black !important;
            text-decoration: none;
            opacity: 0.5;
        }

        .table-card .status {
            display: block;
            margin-top: 5px;
            font-weight: bold;
        }

        .cardname {
            border: 1px solid black;
            padding: 5px 10px 5px 5px;
        }

        .dropdown-menu {
            padding: 0;
        }
    </style>

    <div class="container">
        <div class="row">
            @foreach ($tables as $table)
                <div class="col-md-4 mb-4">
                    <div class="card table-card">
                        <div class="card-body">
                            <div class="d-flex align-tables-center">
                                <div class="cardname">
                                    <div class="ml-1">
                                        <h5 class="card-title">{{ $table->name }}</h5>
                                        <div class="divider">|</div>
                                        <p class="card-text">SL: {{ $table->capacity }}</p>
                                    </div>
                                </div>
                                <div class="dropdown dropdown-right">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <!-- Thêm các option cho dropdown mới -->
                                        <li style="background-color:#007bff">
                                            <a class="dropdown-item" href="/admin/tables/edit/{{ $table->id }}">
                                                <i class="fas fa-edit"></i> Chỉnh sửa
                                            </a>
                                        </li>
                                        <li style="background-color: red">
                                            <a class="dropdown-item"
                                                onclick="removeRow({{ $table->id }}, '/admin/tables/destroy')">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="status" id="table-{{ $table->id }}-status">
                            @if ($table->active == 1)
                                Trạng thái: Còn trống
                            @else
                                Trạng thái: Không còn trống
                            @endif
                        </span>
                        <div class="btn-container">
                            <button class="btn btn-primary btn-sm"
                                onclick="showEditDialog({{ $table->id }}, {{ $table->active }})">
                                <i class="fas fa-edit"></i> Thay đổi trạng thái
                            </button>

                            @if ($table->active == 1)
                                <button class="btn btn-info btn-sm ml-2"
                                    onclick="selectTableForCustomer('{{ $table->id }}')">
                                    <i class="fas fa-info"></i> Chọn bàn
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="{{ $tables->previousPageUrl() }}">Previous</a></li>

            @for ($i = 1; $i <= $tables->lastPage(); $i++)
                <li class="page-item{{ $i == $tables->currentPage() ? ' active' : '' }}">
                    <a class="page-link" href="{{ $tables->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item"><a class="page-link" href="{{ $tables->nextPageUrl() }}">Next</a></li>
        </ul>
    </div>

    <!--form thay doi-->
    <div id="editDialog" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-weight: bold">CHỈNH SỬA TRẠNG THÁI</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="statusSelect">Trạng thái mới:</label>
                        <div class="d-flex align-tables-center">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="statusRadio" id="statusRadio1"
                                    value="1">
                                <label class="form-check-label" for="statusRadio1">
                                    Còn trống
                                </label>
                            </div>
                            <div class="form-check ml-3">
                                <input class="form-check-input" type="radio" name="statusRadio" id="statusRadio0"
                                    value="0">
                                <label class="form-check-label" for="statusRadio0">
                                    Không còn trống
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary confirm-button">Xác nhận</button>
                    <button type="button" class="btn btn-secondary close-button" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function showSuccessMessage(message) {
            alert(message);
        }

        // Lấy giá trị customer_id từ tham số query string
        const customerId = new URLSearchParams(window.location.search).get('customer_id');

        // Hàm xử lý khi người dùng nhấn vào nút "Chọn bàn"
        function selectTableForCustomer(tableId) {
            // Lấy trạng thái của bàn từ HTML
            const tableStatusElement = document.getElementById('table-' + tableId + '-status');
            if (!tableStatusElement || tableStatusElement.innerText.trim() !== 'Trạng thái: Còn trống') {
                // Nếu không tìm thấy phần tử hoặc bàn không còn trống, không cho phép chọn bàn
                alert('Bàn không còn trống hoặc đã được chọn, vui lòng chọn bàn khác.');
                return;
            }

            if (confirm("Bạn có chắc chắn muốn chọn bàn không?")) {
                $.ajax({
                    url: '/admin/carts/select-table',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        customer_id: customerId,
                        table_id: tableId
                    },
                    success: function(response) {
                        if (response.hasOwnProperty('message')) {
                            console.log(response.message);
                            alert(response.message);
                            // Cập nhật trạng thái của bàn trong HTML
                            if (tableStatusElement) {
                                tableStatusElement.innerText = 'Trạng thái: Không còn trống';
                            }
                            window.location.href = '/admin/customers/processing';
                        } else {
                            console.error('Error: ' + response.error);
                            alert('Đã xảy ra lỗi: ' + response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Đã xảy ra lỗi: ' + error);
                    }
                });
            } else {
                return;
            }
        }

        //Thay đổi trạng thái
        function showEditDialog(tableId, isActive) {
            // Lấy đối tượng dialog từ HTML
            const dialog = document.getElementById('editDialog');

            // Lấy các phần tử con của dialog
            const confirmButton = dialog.querySelector('.confirm-button');
            const radioButtons = dialog.querySelectorAll('input[name="statusRadio"]');


            // Thiết lập giá trị mặc định cho radio buttons
            radioButtons.forEach(radioButton => {
                if (radioButton.value == isActive) {
                    radioButton.checked = true;
                } else {
                    radioButton.checked = false;
                }
            });

            // Hiển thị dialog
            $(dialog).modal('show');

            // Xác nhận thay đổi khi nhấn nút Xác nhận
            confirmButton.onclick = function() {
                // Lấy giá trị mới từ radio buttons
                const newStatus = dialog.querySelector('input[name="statusRadio"]:checked').value;

                // Gọi hàm AJAX để cập nhật trạng thái của bàn
                $.ajax({
                    url: '/admin/tables/update-status/' + tableId,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        status: newStatus
                    },
                    success: function(response) {
                        // Hiển thị thông báo thành công
                        alert(response.message);

                        // Tải lại trang để cập nhật trạng thái mới
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Hiển thị thông báo lỗi
                        alert('Đã xảy ra lỗi: ' + error);
                    }
                });
            };

            // Đóng dialog khi nhấn nút Đóng
            const closeButton = dialog.querySelector('.close-button');
            closeButton.onclick = function() {
                $(dialog).modal('hide');
            };
        }
    </script>
@endsection
