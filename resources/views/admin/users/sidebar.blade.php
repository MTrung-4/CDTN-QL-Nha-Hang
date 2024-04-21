<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex border-bottom">
            <div class="image">
                <img src="/template/admin/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column border-bottom" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/" class="nav-link">
                        <i class="nav-icon fas -bottom-3fa-solid fa-store"></i>
                        <p>Cửa Hàng</p>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-bars"></i>
                        <p> Danh Mục</p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/menus/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Danh Mục</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/menus/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Danh Mục</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item border-bottom mb-2">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-images"></i>
                        <p> Slider

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/sliders/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Slider</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/sliders/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Slider</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-table"></i>
                        <p> Bàn Ăn

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/tables/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Bàn Ăn</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/tables/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Bàn Ăn</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-store-alt"></i>
                        <p> Sản Phẩm

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/products/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Sản Phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/products/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Sản Phẩm</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item border-bottom mb-2">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-utensils"></i>
                        <p> Thực Đơn </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/items/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Thực Đơn</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/items/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Thực Đơn</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="nav-item border-bottom mb-2">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-regular fa-copyright"></i>
                        <p> Combo

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/combos/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Combo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/combos/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Combo</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p> Giỏ Hàng
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/customers/waiting" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đơn Chờ Duyệt</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/customers/processing" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đơn Đang Xử Lý</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/customers/cancel" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đơn Đã Hủy</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/customers/history" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lịch Sử Đơn Hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/admin/customers/show" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-user-plus"></i>
                        <p> Khách Hàng
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="/admin/statistics" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-chart-line"></i>
                        <p> Thống Kê </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-address-card"></i>
                        <p> Tài Khoản

                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/accounts/add" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Tài Khoản</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/accounts/list" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh Sách Tài Khoản</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Đăng Xuất</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
