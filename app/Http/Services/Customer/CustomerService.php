<?php

namespace App\Http\Services\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CustomerService
{
    public function insert($request)
    {
        try {
            $request->except('_token');
            Customer::create($request->input());

            Session::flash('success', 'Thêm Khách Hàng mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Khách Hàng lỗi');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function get()
    {
        return Customer::orderByDesc('id')->paginate(15);
    }

    public function update($request, $customer)
    {
        try {
            $customer->fill($request->input());
            $customer->save();
            Session::flash('success', 'Cập nhật Khách Hàng thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật Khách Hàng lỗi');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request)
    {
        $customer = Customer::where('id', $request->input('id'))->first();
        if ($customer) {
            $path = str_replace('storage', 'public', $customer->thumb);
            Storage::delete($path);
            $customer->delete();
            return true;
        }

        return false;
    }


}
