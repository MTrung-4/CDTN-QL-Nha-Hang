<?php

// app/Http/Middleware/CheckUserRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if ($user && (in_array('admin', $roles) || in_array('staff', $roles))) {
            return $next($request);
        }

        // Nếu người dùng đã đăng nhập nhưng không có quyền truy cập, chuyển hướng về trang 403
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }
}
