<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role  Vai trò được phép truy cập route này
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user || $user->role->name !== $role) {
            // Nếu không đúng quyền, chuyển người dùng về đúng dashboard của họ
            switch ($user->role->name) {
                case 'admin':
                    return redirect('/dashboard');
                case 'teacher':
                    return redirect('/teacher');
                case 'user':
                default:
                    return redirect('/home');
            }
        }

        return $next($request);
    }
}
