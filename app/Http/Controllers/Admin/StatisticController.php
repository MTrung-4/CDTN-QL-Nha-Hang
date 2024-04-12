<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function statistics()
    {
        //----Thống kê sản phẩm----//
        // Đếm số lượng sản phẩm hiện có
        $productsCount = Product::count();

        // Lấy dữ liệu sản phẩm theo ngày
        $productsData = Product::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as quantity')
        )
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
        $cartCount = Cart::where('status', 0)->count();
        // Lấy thông tin đơn hàng từ bảng cart và customer
        $cartData = Cart::join('customers', 'carts.customer_id', '=', 'customers.id')
            ->where('carts.status', 0)
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
            ->where('carts.status', 0)
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


        // Tính toán phần trăm tăng trưởng so với ngày trước đó
        $growthRate = $this->calculateRevenueGrowthRate($revenueData);

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
            'growthRate' =>  $growthRate
        ]);
    }



    // Hàm tính toán phần trăm tăng trưởng doanh thu
    private function calculateRevenueGrowthRate($revenueData)
    {
        // Lấy doanh thu của ngày hiện tại
        $currentDateRevenue = $revenueData->firstWhere('date', now()->toDateString())->total_revenue ?? 0;

        // Lấy doanh thu của ngày trước đó
        $previousDateRevenue = $revenueData->firstWhere('date', '<', now()->toDateString())->total_revenue ?? 0;

        // Tính toán phần trăm tăng trưởng doanh thu
        if ($previousDateRevenue != 0) {
            $growthRate = (($currentDateRevenue - $previousDateRevenue) / $previousDateRevenue) * 100;
        } else {
            $growthRate = 0;
        }

        return $growthRate;
    }
}
