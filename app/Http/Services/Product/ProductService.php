<?php


namespace App\Http\Services\Product;


use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    const LIMIT = 16;

    public function get($page = null)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->orderByDesc('id')
            ->when($page != null, function ($query) use ($page) {
                $query->offset($page * self::LIMIT);
            })
            ->limit(self::LIMIT)
            ->get();
    }

    public function show($id)
    {
        return Product::where('id', $id)
            ->where('active', 1)
            ->with('menu')
            ->firstOrFail();
    }

    public function more($id)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->where('id', '!=', $id)
            ->orderByDesc('id')
            ->limit(8)
            ->get();
    }

    public function filter(Request $request)
    {
        // Bắt đầu với một truy vấn cơ bản
        $query = Product::query();

        // Áp dụng lọc theo giá nếu có tham số 'price' trong yêu cầu
        if ($request->has('price')) {
            if ($request->price == 'asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->price == 'desc') {
                $query->orderBy('price', 'desc');
            }
        }

        // Trả về kết quả sau khi áp dụng bộ lọc
        return $query->get();
    }
}
