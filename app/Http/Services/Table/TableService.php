<?php

namespace App\Http\Services\Table;

use App\Models\Table;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TableService
{
    public function getAllTables()
    {
        return Table::all();
    }

    public function insert($request)
    {
        try {
            $request->except('_token');
            Table::create($request->all());

            Session::flash('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm sản phẩm thất bại');
            Log::info($err->getMessage());
            return false;
        }

        return true;
    }

    public function getTableById($id)
    {
        return Table::findOrFail($id);
    }

    public function update($request, $table)
    {
        try {
            $table->fill($request->input());
            $table->save();
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
        $table = Table::where('id', $request->input('id'))->first();
        if ($table) {
            $table->delete();
            return true;
        }

        return false;
    }
}
