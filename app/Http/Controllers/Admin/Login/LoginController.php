<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Controllers\Controller;
use App\Http\Services\Account\AccountService;
use App\Jobs\SendRegistrationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyAccount;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    protected $userService;

    public function __construct(AccountService $accountService)
    {
        $this->userService = $accountService;
    }

    public function index()
    {
        return view('admin.login.login', [
            'title' => 'Đăng nhập hệ thống'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|exists:users,name',
        ], [
            'name.required' => 'Vui lòng nhập tên đăng nhập.',
            'name.exists' => 'Tên đăng nhập không tồn tại',
        ]);
    
        $credentials = $request->only('name', 'password');
    
        if (Auth::attempt($credentials, $request->input('remember'))) {
            if (Auth::user()->role === 'admin' || Auth::user()->role === 'staff') {
                return redirect()->route('admin')->with('success', 'Đăng nhập thành công!');
            } else {
                // Kiểm tra xem người dùng đã xác thực email chưa
                if (Auth::user()->email_verified_at !== null) {
                    return redirect()->route('home')->with('success', 'Đăng nhập thành công!'); // Đổi thành route của trang chính của user
                } else {
                    Auth::logout(); // Đăng xuất người dùng nếu chưa xác thực email
                    return redirect()->back()->withErrors([
                        'error' => 'Tài khoản của bạn cần phải xác thực email để đăng nhập.'
                    ]);
                }
            }
        }
    
        return redirect()->back()->withInput()->withErrors([
            'password' => 'Mật khẩu không chính xác.',
            'name.exists' => 'Tên đăng nhập không tồn tại',
        ]);
    }
    


    public function register(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:6|confirmed',
            'email' => 'required|email|unique:users,email',
        ], [
            'name.required' => 'Tên Tài Khoản là trường bắt buộc.',
            'name.string' => 'Tên Tài Khoản phải là chuỗi.',
            'name.max' => 'Tên Tài Khoản không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên Tài Khoản đã tồn tại.',
            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.string' => 'Mật khẩu phải là chuỗi.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu và xác nhận mật khẩu không khớp.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
        ]);

        // Tạo tài khoản với role mặc định là 'user'
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role' => $request->role ?? 'user', // Nếu không có role được cung cấp, sử dụng 'user' làm giá trị mặc định
        ]);

        if ($user) {
            SendRegistrationEmail::dispatch($user);
            return view('admin.login.success');
        } else {
            // Trả về view đăng ký với thông báo lỗi nếu có lỗi xảy ra
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function verify($email)
    {
        $user = User::where('email', $email)->whereNULL('email_verified_at')->firstOrFail();
        User::where('email', $email)->update(['email_verified_at' => date('Y-m-d H:i:s')]);
        return view('admin.login.verify_success');
    }

    public function signup()
    {
        return view('admin.login.register', [
            'title' => 'Đăng kí hệ thống'
        ]);
    }

    public function showLinkRequestForm()
    {
        return view('admin.login.forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }


    public function showResetForm(Request $request, $token)
    {
        return view('admin.login.update_password', [
            'request' => $request,
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:6',
            'email' => 'required|email',
        ], [
            'password.string' => 'Mật khẩu phải là chuỗi.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu và xác nhận mật khẩu không khớp.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
        ]);


        // Tìm người dùng bằng địa chỉ email
        $user = User::where('email', $request->input('email'))->first();

        // Kiểm tra nếu người dùng tồn tại
        if ($user) {
            // Cập nhật mật khẩu
            $user->password = Hash::make($request->input('password'));
            $user->save();

            // Chuyển hướng người dùng sau khi cập nhật mật khẩu thành công
            return redirect()->route('login')->with('success', 'Mật khẩu đã được cập nhật thành công. Vui lòng đăng nhập bằng mật khẩu mới của bạn.');
        } else {
            // Người dùng không tồn tại
            return back()->withErrors(['email' => 'Không tìm thấy người dùng với địa chỉ email đã cung cấp.']);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/users/login');
    }

     // Đăng xuất cho trang web
     public function logoutWeb(Request $request)
     {
         Auth::logout();
 
         $request->session()->invalidate();
 
         $request->session()->regenerateToken();
 
         return redirect('/');
     }

    public function infor()
    {
        $user = Auth::user();

        return view(
            'login.account',
            [
                'title' => 'Thông tin tài khoản',
                'user' => $user,
            ]
        );
    }


    public function showChangePasswordForm()
    {
        return view('login.change_password',[
            'title' => 'Thay đổi mật khẩu',
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ],[
            'current_password.required' => ' Mật khẩu cũ không được để trống',
            'new_password.min' => 'Mật khẩu phải dài ít nhất 6 kí tự',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng');
        }

        $this->userService->changePassword($user, $request->new_password);

        return redirect()->route('account')->with('success', 'Đổi mật khẩu thành công');
    }
}
