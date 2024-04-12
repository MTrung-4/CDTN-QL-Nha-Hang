@extends('admin.users.main')

@section('content')
    <div class="container">
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
                       <h3>{{ $cartCount }}</h3>
                        <p>Tổng số đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer revenue-chart-btn">Xem biểu đồ <i
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
            <div class="position-relative mb-4">
                <canvas id="revenue-chart" height="250" width="715"
                    style="display: block; height: 200px; width: 572px;"></canvas>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    <script>
        $(function() {
            var productsCtx = $('#products-chart');
            var cartCtx = $('#cart-chart');
            var revenueChartCtx = $('#revenue-chart');
            var productsChart;
            var cartChart;
            var revenueChart;

            // Hàm hiển thị biểu đồ Sản phẩm
            function showProductsChart() {
                $('#products-chart-container').show();
                $('#cart-chart-container').hide();
                $('#revenue-chart-container').hide();
                if (!productsChart) {
                    productsChart = new Chart(productsCtx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($productLabels) !!}, // Dữ liệu thời gian
                            datasets: [{
                                label: 'Sản phẩm',
                                data: {!! json_encode($productData) !!}, // Dữ liệu số lượng sản phẩm
                                backgroundColor: 'transparent',
                                borderColor: '#007bff',
                                pointBorderColor: '#007bff',
                                pointBackgroundColor: '#007bff',
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
                if (!cartChart) {
                    cartChart = new Chart(cartCtx, {
                        type: 'line',
                        data: {
                            labels: {!! json_encode($cartLabels) !!}, // Dữ liệu thời gian
                            datasets: [{
                                label: 'Đơn hàng',
                                data: {!! json_encode($cartData) !!}, // Dữ liệu số lượng đơn hàng
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
        });
    </script>
@endsection
