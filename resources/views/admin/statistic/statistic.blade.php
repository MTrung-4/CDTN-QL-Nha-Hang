@extends('admin.users.main')

@section('content')
    <div class="container">
        <!-- Biểu mẫu nhập ngày bắt đầu và ngày kết thúc -->
        <div style="display: flex;">
            <form method="post" action="{{ route('statistics') }}" class="d-inline-block" style="margin-right: 100px;">
                @csrf
                <div class="row mb-5 align-items-end">
                    <div class="mx-1">
                        <label for="start_date">Ngày bắt đầu:</label>
                        <input type="date" id="start_date" class="form-control" name="start_date"
                            value="{{ old('start_date') }}">
                    </div>
                    <div class="mx-1">
                        <label for="end_date">Ngày kết thúc:</label>
                        <input type="date" id="end_date" class="form-control" name="end_date"
                            value="{{ old('end_date') }}">
                    </div>
                    <div class="mx-1">
                        <button type="submit" class="btn btn-primary">Áp dụng</button>
                    </div>
                </div>
            </form>

            <form method="post" action="{{ route('statistics') }}" id="optionForm" class="d-inline-block">
                @csrf
                <div class="row mb-5 align-items-end">
                    <div class="mx-1">
                        <label for="option">Chọn Phạm Vi Thống Kê:</label>
                        <select name="option" id="option" class="form-control">
                            <option value="">--Chọn Thời Gian--</option>
                            <option value="this_month">Tháng này</option>
                            <option value="last_month">Tháng trước</option>
                            <option value="last_7_days">Trong vòng 7 ngày gần đây</option>
                            <option value="this_quarter">Theo quý</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Áp dụng</button>
                </div>
            </form>
        </div>


        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $productsCount }}</h3>
                        <p>Tổng số sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <a href="#" class="small-box-footer products-chart-btn" id="products-chart-btn">
                        Xem Biểu Đồ <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $cartCount }}</h3>
                        <p>Tổng số đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class=" ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer cart-chart-btn" id="cart-chart-btn">Xem biểu đồ <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>+ {{ $currentMonthTotalRevenue }}</h3>
                        <p>Tổng số doanh thu</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer revenue-chart-btn" id="revenue-chart-btn">Xem biểu đồ <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $accountCount }}</h3>

                        <p>Tổng số tài khoản</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer account-chart-btn" id="account-chart-btn">Xem biểu đồ <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Biểu đồ Sản phẩm -->
        <div class="card-body" id="products-chart-container" style="display: none;">
            <canvas id="products-chart" height="250" width="715" style="display: block; height: 200px; width: 572px;"
                class="chartjs-render-monitor"></canvas>
        </div>

        <!-- Biểu đồ Đơn hàng -->
        <div class="card-body" id="cart-chart-container" style="display: none;">
            <canvas id="cart-chart" height="250" width="715" style="display: block; height: 200px; width: 572px;"
                class="chartjs-render-monitor"></canvas>
        </div>

        <!-- Biểu đồ doanh thu -->
        <div class="card-body" id="revenue-chart-container" style="display: none;">
            <canvas id="revenue-chart" height="250" width="715"
                style="display: block; height: 200px; width: 572px;"></canvas>
        </div>

        <!--Biểu đồ tài khoản-->
        <div class="card-body" id="account-chart-container" style="display: none;">

            <canvas id="account-chart" height="250" width="715"
                style="display: block; height: 200px; width: 572px;"></canvas>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    <script>
        $(function() {
            var productsCtx = $('#products-chart');
            var cartCtx = $('#cart-chart');
            var revenueChartCtx = $('#revenue-chart');
            var accountChartCtx = $('#account-chart');
            var productsChart;
            var cartChart;
            var revenueChart;
            var accountChart;

            // Hàm hiển thị biểu đồ Sản phẩm
            function showProductsChart() {
                $('#products-chart-container').show();
                $('#cart-chart-container').hide();
                $('#revenue-chart-container').hide();
                $('#account-chart-container').hide();
                if (!productsChart) {
                    productsChart = new Chart(productsCtx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($productLabels) !!}, // Dữ liệu thời gian
                            datasets: [{
                                label: 'Sản phẩm',
                                data: {!! json_encode($productData) !!}, // Dữ liệu số lượng sản phẩm
                                backgroundColor: 'transparent',
                                borderColor: '#FF0000',
                                pointBorderColor: '#FF0000',
                                pointBackgroundColor: '#FF0000',
                                pointRadius: 3
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                mode: 'index',
                                intersect: false
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Thời gian'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Số lượng'
                                    }
                                }]
                            }
                        }
                    });
                }
            }

            // Hàm hiển thị biểu đồ Đơn hàng
            function showCartChart() {
                $('#products-chart-container').hide();
                $('#cart-chart-container').show();
                $('#revenue-chart-container').hide();
                $('#account-chart-container').hide();
                if (!cartChart) {
                    cartChart = new Chart(cartCtx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($cartLabels) !!}, // Dữ liệu thời gian
                            datasets: [{
                                label: 'Đơn hàng',
                                data: {!! json_encode($cartData) !!}, // Dữ liệu số lượng đơn hàng
                                backgroundColor: 'transparent',
                                borderColor: '#21FFFF',
                                pointBorderColor: '#21FFFF',
                                pointBackgroundColor: '#21FFFF',
                                pointRadius: 3
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                mode: 'index',
                                intersect: false
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Thời gian'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Số lượng'
                                    }
                                }]
                            }
                        }
                    });
                }
            }

            // Hàm hiển thị biểu đồ doanh thu
            function showRevenueChart() {
                $('#products-chart-container').hide();
                $('#cart-chart-container').hide();
                $('#revenue-chart-container').show();
                $('#account-chart-container').hide();
                if (!revenueChart) {
                    revenueChart = new Chart(revenueChartCtx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($revenueLabels) !!},
                            datasets: [{
                                label: 'Doanh thu',
                                data: {!! json_encode($revenueData) !!},
                                backgroundColor: 'transparent',
                                borderColor: '#28a745',
                                pointBorderColor: '#28a745',
                                pointBackgroundColor: '#28a745',
                                pointRadius: 3
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                mode: 'index',
                                intersect: false
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Thời gian'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Doanh thu'
                                    }
                                }]
                            }
                        }
                    });
                }
            }

            // Hàm hiển thị biểu đồ tài khoản
            function showAccountChart() {
                $('#products-chart-container').hide();
                $('#cart-chart-container').hide();
                $('#revenue-chart-container').hide();
                $('#account-chart-container').show();
                if (!accountChart) {
                    accountChart = new Chart(accountChartCtx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($accountLabels) !!},
                            datasets: [{
                                label: 'Tài khoản',
                                data: {!! json_encode($accountData) !!},
                                backgroundColor: 'transparent',
                                borderColor: '#ffc107',
                                pointBorderColor: '#ffc107',
                                pointBackgroundColor: '#ffc107',
                                pointRadius: 3
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                mode: 'index',
                                intersect: false
                            },
                            hover: {
                                mode: 'nearest',
                                intersect: true
                            },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Thời gian'
                                    }
                                }],
                                yAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Số lượng'
                                    }
                                }]
                            }
                        }
                    });
                }
            }

            // Xử lý sự kiện click cho Xem biểu đồ Sản phẩm
            $('#products-chart-btn').click(function(event) {
                event.preventDefault(); // Ngăn chặn hành động mặc định của nút
                showProductsChart(); // Hiển thị biểu đồ Sản phẩm khi click
            });

            // Xử lý sự kiện click cho Xem biểu đồ Đơn hàng
            $('#cart-chart-btn').click(function(event) {
                event.preventDefault(); // Ngăn chặn hành động mặc định của nút
                showCartChart(); // Hiển thị biểu đồ Đơn hàng khi click
            });

            // Xử lý sự kiện click để hiển thị biểu đồ doanh thu
            $('.revenue-chart-btn').click(function(event) {
                event.preventDefault();
                showRevenueChart();
            });

            // Xử lý sự kiện click để hiển thị biểu đồ tài khoản
            $('.account-chart-btn').click(function(event) {
                event.preventDefault();
                showAccountChart();
            });
        });

        $(document).ready(function() {
            $('#applyBtn').click(function(event) {
                /* event.preventDefault(); */
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();
                updateStatistics(startDate, endDate);
            });

            function updateStatistics(startDate, endDate) {
                $.ajax({
                    url: '{{ route('statistics') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'start_date': startDate,
                        'end_date': endDate
                    },
                    success: function(response) {
                        console.log(response);
                        // Xử lý dữ liệu phản hồi ở đây nếu cần
                    },
                    error: function(err) {
                        console.log(err);
                        // Xử lý lỗi ở đây nếu cần
                    }
                });
            }
        });

        $(document).ready(function() {
            $('#applyBtn').click(function(event) {
                /*  event.preventDefault(); */

                var selectedOption = $('#option').val();
                console.log('Option selected:', selectedOption);
                customStatistics(selectedOption);
            });

            function customStatistics(selectedOption) {
                $.ajax({
                    url: '{{ route('statistics') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'option': selectedOption
                    },
                    success: function(response) {
                        console.log(response);
                        // Xử lý dữ liệu phản hồi ở đây nếu cần
                    },
                    error: function(err) {
                        console.log(err);
                        // Xử lý lỗi ở đây nếu cần
                    }
                });
            }
        });


        // Lưu trữ giá trị của các trường vào Local Storage khi chúng thay đổi
        document.addEventListener('DOMContentLoaded', function() {
            var startDateInput = document.getElementById('start_date');
            var endDateInput = document.getElementById('end_date');
            var optionSelect = document.getElementById('option');

            startDateInput.addEventListener('change', function() {
                localStorage.setItem('start_date', startDateInput.value);
                // Xóa giá trị của select option khi ngày bắt đầu được thay đổi
                optionSelect.value = '';
                localStorage.removeItem('selected_option');
            });

            endDateInput.addEventListener('change', function() {
                localStorage.setItem('end_date', endDateInput.value);
                // Xóa giá trị của select option khi ngày kết thúc được thay đổi
                optionSelect.value = '';
                localStorage.removeItem('selected_option');
            });

            optionSelect.addEventListener('change', function() {
                // Lưu giá trị của select option vào Local Storage
                localStorage.setItem('selected_option', optionSelect.value);
                // Xóa giá trị của ngày bắt đầu và ngày kết thúc khi select option được thay đổi
                startDateInput.value = '';
                endDateInput.value = '';
                localStorage.removeItem('start_date');
                localStorage.removeItem('end_date');
            });

            // Khôi phục giá trị từ Local Storage khi trang tải lại
            var savedStartDate = localStorage.getItem('start_date');
            if (savedStartDate) {
                startDateInput.value = savedStartDate;
            }

            var savedEndDate = localStorage.getItem('end_date');
            if (savedEndDate) {
                endDateInput.value = savedEndDate;
            }

            var savedOption = localStorage.getItem('selected_option');
            if (savedOption) {
                optionSelect.value = savedOption;
            }
        });
    </script>
@endsection
