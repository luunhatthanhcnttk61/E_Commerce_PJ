<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
        return redirect()->route('admin.auth.login')
                ->with('error', 'Vui lòng đăng nhập');
        }

        if (!Auth::user()->canAccessDashboard()) {
            return redirect()->route('client.home')
                    ->with('error', 'Bạn không có quyền truy cập trang quản trị');
        }

        return $next($request);
    }
}