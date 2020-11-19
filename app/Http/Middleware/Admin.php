<?php

namespace App\Http\Middleware;

use App\Http\Controllers\UserController;
use App\Models\User;
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
//       $userSession = $request->session()->get('user');
//        $users=\Illuminate\Support\Facades\Session::get('users');
//        dd($users);
//       //dd($userSession);
//        if (isset($userSession) && $userSession != null){
//
//        }else{
//            return redirect('http://localhost/dieuhanhtacnghiep/dang-nhap.html');
//        }

        if (!\Illuminate\Support\Facades\Session::get('user')) {
            if (request()->has('login')){
                $id = request()->login;
                $token = request()->token;
                $verify = request()->verify;
                if ($id && $token && $verify){
                    $idDecode = base64_decode($id);
                    $user =  User::where('id', $idDecode)->first();
                    $users = Session::put('user', $user->toArray());
                }
            }else{
                $users=\Illuminate\Support\Facades\Session::get('users');
            }
          if ($users){
                //dd('vao day');
          }else{
              return redirect('http://dieuhanh.ute.udn.vn/dang-nhap.html');
          }

        }

        return $next($request);
    }
}
