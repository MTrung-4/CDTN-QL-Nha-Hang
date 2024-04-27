<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Combo\ComboService;
use App\Models\Combo;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    protected $comboService;

    public function __construct(ComboService $comboService)
    {
        $this->comboService = $comboService;
    }

    public function index()
    {
        $combos = $this->comboService->get();
        return view('admin.combo.list', [
            'title' => 'Danh Sách Combo',
            'combos' => $combos
        ]);
    }

    public function create()
    {
        $products = $this->comboService->getAllProducts();
        $items = $this->comboService->getAllItems();

        return view('admin.combo.add', [
            'title' => 'Thêm Thực Đơn Mới',
            'products' => $products,
            'items' => $items
        ]);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:combos,name',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'items' => 'required|array',
            'items.*' => 'exists:items,id',
        ], [
            'name.required' => 'Tên combo không được để trống.',
            'name.unique' => 'Tên combo đã tồn tại.',
            'name.max' => 'Tên combo quá dài.',
            'items.required' => 'Thực đơn không được để trống.',
            'items.*' => 'Một hoặc nhiều thực đơn đã chọn không hợp lệ.',
            'products.required' => 'Sản phẩm không được để trống.',
            'products.*' => 'Một hoặc nhiều sản phẩm đã chọn không hợp lệ.',
        ]);

        $combo = Combo::create([
            'name' => $validatedData['name'],
            'price_combo' => $validatedData['price_combo'],
            'description' => $validatedData['description'],
            'active' => $request->has('active') ? $request->input('active') : 0,
            'max_order' => $validatedData['max_order'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'promotion' => $validatedData['promotion'],

        ]);

        $combo->products()->attach($validatedData['products']);
        $combo->items()->attach($validatedData['items']);

        return redirect('/admin/combos/add')->with('success', 'Thêm combo thành công');
    }

    /*  public function edit($id)
    {
        $data = $this->comboService->getComboById($id);
        $products = $this->comboService->getAllProducts();
        $items = $this->comboService->getAllItems();

        return view('admin.combo.edit', [
            'title' => 'Chỉnh Sửa Thực Đơn',
            'combo' => $data['combo'],
            'products' => $products,
            'items' => $items,
            'selectedProducts' => $data['selectedProducts'],
            'selectedItems' => $data['selectedItems']
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'items' => 'required|array',
            'items.*' => 'exists:items,id',
        ]);

        $result = $this->comboService->updateCombo($id, $validatedData);

        if ($result) {
            return redirect('/admin/combos/list');
        }

        return redirect()->back()->with('success', 'Cập nhật combo thành công');
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');

        $result = $this->comboService->deleteCombo($id);

        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công combo'
            ]);
        }

        return response()->json(['error' => true]);
    } */
}
