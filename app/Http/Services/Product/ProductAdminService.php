<?php


namespace App\Http\Services\Product;

use App\Models\Brand;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProductAdminService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }

    public function insert($request)
    {
        try {
            $request->except('_token');
            Product::create($request->all());

            Session::flash('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm sản phẩm thất bại');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }

    public function get()
    {
        return Product::with('menu')
            ->orderByDesc('id')->paginate(10);
    }

    public function update($request, $product)
    {
        try {
            $product->fill($request->input());
            $product->save();
            Session::flash('success', 'Cập nhật thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Có lỗi, vui lòng thử lại');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function delete($request)
    {
        $product = Product::where('id', $request->input('id'))->first();
        if ($product) {
            $product->delete();
            return true;
        }

        return false;
    }
}
