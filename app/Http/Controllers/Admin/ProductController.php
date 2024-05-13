<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Services\Product\ProductAdminService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductAdminService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.product.list', [
            'title' => 'Danh Sách Sản Phẩm',
            'products' => $this->productService->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Product::distinct()->pluck('type')->toArray();
        $units = Product::distinct()->pluck('unit')->toArray();
        if (empty($types)) {
            $types = [];
        }

        if (empty($units)) {
            $units = [];
        }

        // Thêm các giá trị mẫu vào mảng types và units
        $types = array_merge($types, ['type1', 'type2', 'type3']);
        $units = array_merge($units, ['unit1', 'unit2', 'unit3']);

        return view('admin.product.add', [
            'title' => 'Thêm Sản Phẩm Mới',
            'menus' => $this->productService->getMenu(),
            'types' => $types,
            'units' => $units
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:products,name',
            'thumb' => 'required',
            'type' => 'required',
            'unit' => 'required',
        ], [
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'thumb.required' => 'Ảnh không được để trống',
            'type' => 'Kiểu không được để trống',
            'unit' => 'Đơn vị không được để trống',
        ]);
        $this->productService->insert($request);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function edit(Product $product)
    {
        $types = Product::distinct()->pluck('type')->toArray();
        $units = Product::distinct()->pluck('unit')->toArray();
        if (empty($types)) {
            $types = [];
        }

        if (empty($units)) {
            $units = [];
        }

        // Thêm các giá trị mẫu vào mảng types và units
        $types = array_merge($types, ['Món ăn', 'Thức uống']);
        $units = array_merge($units, ['Phần', 'Hộp']);

        return view('admin.product.edit', [
            'title' => 'Chỉnh Sửa Sản Phẩm',
            'product' => $product,
            'menus' => $this->productService->getMenu(),
            'types' => $types,
            'units' => $units
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'thumb' => 'required',
            'type' => 'required',
            'unit' => 'required',
        ], [
            'name.required' => 'Tên sản phẩm không được để trống',
            'thumb.required' => 'Ảnh không được để trống',
            'type' => 'Kiểu không được để trống',
            'unit' => 'Đơn vị không được để trống',
        ]);
        $result = $this->productService->update($request, $product);
        if ($result) {
            return redirect('/admin/products/list');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        $result = $this->productService->delete($request);
        if ($request) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công sản phẩm'
            ]);
        }

        return response()->json(['error' => true]);
    }
     
}
