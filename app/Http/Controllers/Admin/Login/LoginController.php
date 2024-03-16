<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.users.login', [
            'title' => 'Đăng nhập hệ thống'
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
        ],[
            'name.required' => 'Tên đăng nhập không được để trống',
            'password.required' => 'Mật khẩu không được để trống'
        ]);
        
        if (Auth::attempt([
            'name' => $request->input('name'),
            'password' => $request->input('password')
        ], $request->input('remember'))) {
            return redirect()->route('admin');
        }
        
        session()->flash('error', 'Tên đăng nhập hoặc mật khẩu không đúng');
        return redirect()->back();
        
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/users/login');
    }
}
