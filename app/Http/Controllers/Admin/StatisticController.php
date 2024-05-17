<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StatisticController extends Controller
{
    public function statistics(Request $request)
    {
        try {
            //----Thống kê sản phẩm----//
            // Đếm số lượng sản phẩm hiện có
            $productsCount = Product::count();

            // Lấy ngày bắt đầu và ngày kết thúc từ request
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $option = $request->input('option');

            if ($startDate && $endDate) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $endDate = Carbon::parse($endDate)->endOfDay();
            } elseif ($option === 'this_month') {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
            } elseif ($option === 'last_month') {
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
            } elseif ($option === 'last_7_days') {
                $startDate = Carbon::now()->subDays(6)->startOfDay();
                $endDate = Carbon::now()->endOfDay();
            } elseif ($option === 'this_quarter') {
                $endDate = Carbon::now()->endOfMonth();
                $startDate = Carbon::now()->subMonths(2)->startOfMonth();
            } else {
                // Nếu không có start_date, end_date và option nào được chọn, sử dụng ngày hiện tại
                $startDate = Carbon::now()->subDays(6)->startOfDay();
                $endDate = Carbon::now()->endOfDay();
            }

            // Thực hiện truy vấn cơ sở dữ liệu với ngày bắt đầu và kết thúc
            $productsData = Product::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as quantity')
            )
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            // Tạo mảng chứa dữ liệu cho biểu đồ
            $productLabels = [];
            $productData = [];
            foreach ($productsData as $product) {
                $productLabels[] = $product->date;
                $productData[] = $product->quantity;
            }

            //---Thống kê đơn hàng---//
            $cartCount = Cart::where('status', 2)->count();
            // Lấy thông tin đơn hàng từ bảng cart và customer
            $cartData = Cart::join('customers', 'carts.customer_id', '=', 'customers.id')
                ->where('carts.status', 2)
                ->whereBetween(DB::raw('DATE(customers.created_at)'), [$startDate, $endDate])
                ->select(
                    DB::raw('DATE(customers.created_at) as date'),
                    DB::raw('COUNT(*) as total_items')
                )
                ->groupBy(DB::raw('DATE(customers.created_at)'))
                ->get();

            // Tạo mảng chứa dữ liệu cho biểu đồ số lượng sản phẩm và số lượng đơn hàng
            $cartLabels = [];
            $cartDataArray = [];
            foreach ($cartData as $cart) {
                $cartLabels[] = $cart->date;
                $cartDataArray[] = $cart->total_items;
            }

            //---Thống kê doanh thu---//
            // Tính toán doanh thu từ đơn hàng
            $revenueLabels = [];
            $revenueDataArray = [];
            $revenueData = Cart::join('customers', 'carts.customer_id', '=', 'customers.id')
                ->where('carts.status', 2)
                ->whereBetween(DB::raw('DATE(customers.created_at)'), [$startDate, $endDate])
                ->select(
                    DB::raw('DATE(customers.created_at) as date'),
                    DB::raw('SUM(carts.price * carts.qty) as total_revenue')
                )
                ->groupBy(DB::raw('DATE(customers.created_at)'))
                ->get();

            foreach ($revenueData as $revenue) {
                $revenueLabels[] = $revenue->date;
                $revenueDataArray[] = $revenue->total_revenue;
            }

            // Thống kê doanh thu
            $currentMonthTotalRevenue = $this->calculateCurrentMonthRevenue();
            $currentMonthTotalRevenue = max(0, $currentMonthTotalRevenue);


            //--- Thống kê tài khoản ---//
            // Đếm số lượng tài khoản được tạo
            $accountCount =  User::count();

            // Lấy thông tin tài khoản từ bảng users
            $accountsData = User::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as quantity')
            )
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();

            // Tạo mảng chứa dữ liệu cho biểu đồ số lượng tài khoản
            $accountLabels = [];
            $accountData = [];
            foreach ($accountsData as $account) {
                $accountLabels[] = $account->date;
                $accountData[] = $account->quantity;
            }


            // Truyền dữ liệu cho blade template
            return view('admin.statistic.statistic', [
                'title' => 'Thống Kê',
                'productsCount' => $productsCount,
                'productLabels' => $productLabels,
                'productData' => $productData,
                'cartCount' => $cartCount,
                'cartLabels' => $cartLabels,
                'cartData' => $cartDataArray,
                'revenueLabels' => $revenueLabels,
                'revenueData' => $revenueDataArray,
                'currentMonthTotalRevenue' => $currentMonthTotalRevenue,
                'accountCount' => $accountCount,
                'accountLabels' => $accountLabels,
                'accountData' => $accountData,
            ]);
        } catch (\Exception $e) {
            // Bắt lỗi
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function calculateCurrentMonthRevenue()
    {
        try {
            // Lấy ngày đầu tiên của tháng hiện tại
            $firstDayOfMonth = Carbon::now()->startOfMonth();

            // Lấy tổng doanh thu của tháng hiện tại
            $currentMonthRevenue = Cart::join('customers', 'carts.customer_id', '=', 'customers.id')
                ->where('carts.status', 2)
                ->whereBetween(DB::raw('DATE(customers.created_at)'), [$firstDayOfMonth, Carbon::now()])
                ->sum(DB::raw('carts.price * carts.qty'));

            // Lấy tổng doanh thu của các tháng trước
            $previousMonthsRevenue = Cart::join('customers', 'carts.customer_id', '=', 'customers.id')
                ->where('carts.status', 2)
                ->where(DB::raw('YEAR(customers.created_at)'), '=', Carbon::now()->year)
                ->where(DB::raw('MONTH(customers.created_at)'), '<', Carbon::now()->month)
                ->sum(DB::raw('carts.price * carts.qty'));

            // Tính tổng số tiền doanh thu của tháng hiện tại bằng cách trừ tổng số tiền doanh thu của các tháng trước
            $currentMonthTotalRevenue = $currentMonthRevenue - $previousMonthsRevenue;

            return $currentMonthTotalRevenue;
        } catch (\Exception $e) {
            // Bắt lỗi và trả về 0 nếu có lỗi xảy ra
            return 0;
        }
    }
}
