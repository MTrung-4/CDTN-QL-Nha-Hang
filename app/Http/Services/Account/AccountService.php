<?php

namespace App\Http\Services\Account;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AccountService
{
    public function insert($request)
    {
        try {
            $request->except('_token');
            User::create($request->input());

            Session::flash('success', 'Thêm Tài Khoản mới thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Thêm Tài Khoản lỗi');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function get()
    {
        return User::orderByDesc('id')->paginate(15);
    }

    public function update($request, $user)
    {
        try {
            $user->fill($request->input());
            $user->save();
            Session::flash('success', 'Cập nhật Tài Khoản thành công');
        } catch (\Exception $err) {
            Session::flash('error', 'Cập nhật Tài Khoản lỗi');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request)
    {
        $user = User::where('id', $request->input('id'))->first();
        if ($user) {
            $path = str_replace('storage', 'public', $user->thumb);
            Storage::delete($path);
            $user->delete();
            return true;
        }

        return false;
    }

    /*    public function show()
    {
        return user$user$user::where('active', 1)->orderByDesc('sort_by')->get();
    } */
}
