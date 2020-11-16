<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Libs\Constants;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)    {

        if (!\Illuminate\Support\Facades\Session::get('user')) {
            $users=\Illuminate\Support\Facades\Session::get('users');
          if ($users){

          }else{
              return redirect('dang-nhap');
          }

        }
        return $next($request);
    }
}
