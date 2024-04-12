<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Services\Table\TableService;
use App\Models\Cart;
use App\Models\Customer;
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

        $customers = Customer::all();
        return view('admin.table.list', [
            'title' => 'Danh Sách Bàn Ăn',
            'tables' => $this->tableService->getAllTables(),
            'customers' => $customers
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
            'capacity' => 'required|numeric|min:0',

        ], [
            'name.required' => 'Tên bàn ăn không được để trống',
            'name.unique' => 'Tên bàn ăn đã tồn tại',
            'capacity.required' => 'Sức chứa của bàn không được để trống',
            'capacity.min' => 'Sức chứa của bàn phải lớn hơn 0',
        ]);
        $this->tableService->insert($request);
        return redirect()->back();
    }

    public function edit(Table $table)
    {
        return view('admin.table.edit', [
            'title' => 'Chỉnh Sửa Bàn Ăn',
            'table' => $table
        ]);
    }

    public function update(Request $request, Table $table)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'capacity' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Tên bàn ăn không được để trống',
            'capacity.required' => 'Sức chứa của bàn không được để trống',
            'capacity.min' => 'Sức chứa của bàn phải lớn hơn 0',
        ]);

        $result = $this->tableService->update($request, $table);
        if ($result) {
            return redirect('/admin/tables/list')->with('success', 'Cập nhật thành công');
        }

        return redirect()->back()->with('error', 'Có lỗi, vui lòng thử lại');
    }


    public function destroy(Request $request)
    {
        $result = $this->tableService->delete($request);
        if ($request) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công bàn ăn'
            ]);
        }

        return response()->json(['error' => true]);
    }

    public function updateStatus($id)
    {
        // Lấy thông tin bàn từ ID
        $table = Table::findOrFail($id);

        // Cập nhật trạng thái của bàn
        $table->active = request('status');
        $table->save();

        // Trả về thông báo thành công
        return response()->json(['message' => 'Trạng thái của bàn đã được cập nhật thành công']);
    }
}
