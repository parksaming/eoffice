<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Libs\Constants;

class Client
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            Session::flash('message', 'Hãy đăng nhập để truy cập trang');
            Session::flash('alert-class', 'danger');
            return redirect('login');
        } else {
            if (Auth::user()->role_id != 2 && Auth::user()->role_id != 3) {
                //Session::flash('message', 'Không có quyền để truy cập trang');
                //Session::flash('alert-class', 'danger');
                if (Auth::user()->role_id == 1) {
                    return redirect('user/manage_client');
                }
                return redirect('building/view_list_building');
            }
        }
        
        return $next($request);
    }
}
