<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Http\Services\Item\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index()
    {

        return view('admin.item.list', [
            'title' => 'Danh Sách Thực Đơn',
            'items' => $this->itemService->get()
        ]);
    }

    public function create()
    {
        $products = $this->itemService->getAllProducts(); // Lấy danh sách sản phẩm
        return view('admin.item.add', [
            'title' => 'Thêm Thực Đơn Mới',
            'products' => $products, // Truyền danh sách sản phẩm vào view
        ]);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255|unique:items,name',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'products' => 'required|array', 
                'products.*' => 'exists:products,id',
            ],
            [
                'name.required' => 'Tên thực đơn không được để trống',
                'name.unique' => 'Tên thực đơn đã tồn tại',
                'price.required' => 'Giá tiền không được để trống',
                'price.min' => 'Giá tiền phải lớn hơn 0',
                'products.required' => 'Sản phẩm không được để trống',
            ]
        );

        // Tạo thực đơn mới
        $item = Item::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
            'active' => $request->has('active') ? $request->input('active') : 0,
        ]);


        // Thêm các sản phẩm được chọn vào thực đơn mới
        $item->products()->attach($validatedData['products']);

        return redirect('/admin/items/add')->with('success', 'Thêm thực đơn thành công');
    }

    public function edit($id)
    {
        $data = $this->itemService->getItemById($id);
        $products = $this->itemService->getAllProducts(); // Lấy danh sách sản phẩm

        return view('admin.item.edit', [
            'title' => 'Chỉnh Sửa Thực Đơn',
            'item' => $data['item'],
            'products' => $products,
            'selectedProducts' => $data['selectedProducts'], // Truyền danh sách sản phẩm đã chọn vào view
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'products' => 'required|array',
                'products.*' => 'exists:products,id',
            ],
            [
                'name.required' => 'Tên thực đơn không được để trống',
                'price.required' => 'Giá tiền không được để trống',
                'price.min' => 'Giá tiền phải lớn hơn 0',
                'products.required' => 'Sản phẩm không được để trống',
            ]
        );
        $result = $this->itemService->updateItem($id, $validatedData);
        if ($result) {
            return redirect('/admin/items/list');
        }

        return redirect()->back()->with('success', 'Cập nhật thực đơn thành công');
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id'); // Lấy id từ request

        $result = $this->itemService->deleteItem($id); // Gọi phương thức deleteItem từ service

        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công thực đơn'
            ]);
        }

        return response()->json(['error' => true]);
    }
}
