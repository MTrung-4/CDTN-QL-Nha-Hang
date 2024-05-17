<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Account\AccountService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $account;

    public function __construct(AccountService $account)
    {
        $this->account = $account;

        $this->middleware('checkRole:admin, staff');
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('admin.account.add', [
            'title' => 'Thêm Người Dùng Mới',
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:users,name',
            'role' => 'required|in:user,admin',
            'password' => 'required|string|min:6|confirmed',
            'email' => 'required|email|unique:users,email',
        ], [
            'name.required' => 'Tên Tài Khoản không được để trống',
            'name.unique' => 'Tên Tài Khoản đã tồn tại',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật Khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu và xác nhận mật khẩu không khớp.'
        ]);

        $this->account->insert($request);

        return redirect()->back();
    }

    public function index()
    {
        $this->authorize('create', User::class);
        return view('admin.account.list', [
            'title' => 'Danh Sách Người Dùng',
            'accounts' => $this->account->get()
        ]);
    }

    public function edit(User $account)
    {
        $this->authorize('edit', User::class);
        return view('admin.account.edit', [
            'title' => 'Chỉnh Sửa Người Dùng',
            'account' => $account,
        ]);
    }

    public function update(Request $request, User $account)
    {
        $this->authorize('update', User::class);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'password' => 'confirmed',
        ], [
            'name.required' => 'Tên Tài Khoản không được để trống',
            'email.required' => 'Email không được để trống',
            'password.confirmed' => 'Mật khẩu và xác nhận mật khẩu không khớp.'
        ]);

        $result = $this->account->update($request, $account);
        if ($result) {
            return redirect('/admin/accounts/list');
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $this->authorize('delete', User::class);
        $result = $this->account->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công Tài Khoản'
            ]);
        }

        return response()->json(['error' => true]);
    }


    public function information()
    {
        $user = Auth::user();
        return view('login.save_infor', [
            'title' => 'Cập nhật thông tin',
            'user' => $user
        ]);
    }

    public function save_infor(Request $request)
    {
        try {
            $user = Auth::user();

            $accountService = new AccountService();
            $accountService->update($request, $user);

            return redirect()->route('account')->with('success', 'Thông tin cá nhân đã được cập nhật.');
        } catch (\Exception $err) {
            // Xử lý lỗi nếu có
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi cập nhật thông tin cá nhân.');
        }
    }
}
