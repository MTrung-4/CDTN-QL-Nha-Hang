<?php


namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $products = [];

        if ($query) {
            // Thực hiện tìm kiếm sản phẩm theo tên hoặc các tiêu chí khác của bạn
            $products = Product::where('name', 'like', "%{$query}%")->get();
        }

        return view('products.result', [
            'title' => 'Kết Quả Tìm Kiếm',
            'products' => $products,
        ]);
    }
}
