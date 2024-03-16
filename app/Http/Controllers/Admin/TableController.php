<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Services\Table\TableService;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function index()
    {

        return view('admin.table.list', [
            'title' => 'Danh Sách Bàn Ăn',
            'tables' => $this->tableService->getAllTables()
        ]);
    }

    public function create()
    {
        return view('admin.table.add', [
            'title' => 'Thêm Bàn Ăn Mới'
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:products,name',

        ], [
            'name.required' => 'Tên Sản Phẩm không được để trống',
            'name.unique' => 'Tên Sản Phẩm đã tồn tại',
        ]);
        $this->tableService->insert($request);
        return redirect()->back();
    }

    public function edit($id)
    {
        return view('admin.tables.edit', [
            'title' => 'Chỉnh Sửa Bàn Ăn',
            'table' => $this->tableService->getTableById($id)
        ]);
    }

    public function update(Request $request, Table $table)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',

        ], [
            'name.required' => 'Tên Sản Phẩm không được để trống',

        ]);
        $result = $this->tableService->update($request, $table);
        if ($result) {
            return redirect('/admin/table/list');
        }

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->tableService->delete($request);
        if ($request) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công sản phẩm'
            ]);
        }

        return response()->json(['error' => true]);
    }

    public function selectTable(Request $request) {
        // Lấy ID của bàn được chọn từ request
        $tableId = $request->table_id;
    
        // Lấy đơn hàng của người dùng hiện tại (nếu có)
        $cart = Auth::user()->cart;
    
        // Nếu người dùng có đơn hàng, cập nhật cột table_id trong đơn hàng
        if ($cart) {
            // Kiểm tra xem đơn hàng có thuộc tính customer_id không trước khi sử dụng nó
            if ($cart->customer_id !== null) {
                $cart->table_id = $tableId;
                $cart->save();
                return response()->json(['success' => true]);
            } else {
                // Trả về lỗi nếu không tìm thấy customer_id trong đơn hàng
                return response()->json(['error' => true, 'message' => 'Không tìm thấy thông tin đơn hàng của người dùng'], 404);
            }
        }
    
        // Trả về lỗi nếu không tìm thấy đơn hàng cho người dùng hiện tại
        return response()->json(['error' => true, 'message' => 'Không tìm thấy đơn hàng của người dùng'], 404);
    }
    
}
