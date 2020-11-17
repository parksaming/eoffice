<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Libs\Constants;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Models\CheckUser;
use App\Models\User;
use App\Models\VanbanUser;
use App\Models\VanbanXuLy;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\MasterKeyCloak\MasterKeyCloak;

//require_once(' ..\Auth\MasterKeyCloak\MasterKeyCloak.php');
//require_once('..\Auth\MasterKeyCloak\KeyCloak.php');
use App\Http\Controllers\Auth\MasterKeyCloak\KeyCloak;

class LoginController extends Controller
{
    public $url = 'http://hrm.udn.vn/';
    public $masterKeycloak;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Handle a login request to the application
     *
     * @param  \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $email = Input::get('email');
        $password = Input::get('password');

        $data['User']['email'] = $email;
        $data['User']['password'] = $password;
        $result = $this->postApi('http://hrm.udn.vn/apis/login', $data);

        $user_email = '';
        if ($result['error'] != 0) {
            $user = User::select('users.*')->where('users.email', '=', $email)->first();
            if ($user) {
                // $user->type = 'local';
                if (Hash::check($password, $user->password)) {
                    $user_email = $user->email;
                    $user->user_id_login = $user->id;
                    $user->type = 'local';
                    Session::put('user', $user->toArray());
                    Session::put('user_logged_username', $user->email);
                    return redirect('/');
                } else {
                    Session::flash('message', 'Email sai hoặc mật khẩu không đúng');
                    Session::flash('alert-class', "danger");
                    return redirect('dang-nhap');
                }
            } else {
                Session::flash('message', 'Email sai hoặc mật khẩu không đúng');
                Session::flash('alert-class', "danger");
                return redirect('dang-nhap');
            }

//        }elseif($result['error'] == 0) {
//            $check_user = CheckUser::select('check_user.*')->where('check_user.username', '=', $result['data']['User']['username'])->first();
//            $result['data']['User']['type']= 'hrm';
//            $result['data']['User']['user_id_login'] = $check_user->id;
//            $result['data']['User']['donvi_id'] = $check_user->madonvi;
//            Session::put('user', $result['data']['User']);
//            Session::put('user_logged_username',$result['data']['User']['username']);
//            $user_name = $result['data']['User']['username'];
            return redirect('/');
        }
    }

    function postApi($url, $pvars)
    {
        $timeout = 30;
        $curl = curl_init();
        $post = http_build_query($pvars);

        /*if(isset($referer)){
            curl_setopt ($curl, CURLOPT_REFERER, $referer);
        }*/
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        //curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/x-www-form-urlencoded"));
        $html = curl_exec($curl);
        curl_close($curl);

        return json_decode($html, true);
    }


    public function index()
    {
        return view('auth.login1');
        //dd('vao day');
        //$getUrlLogin = new MasterKeyCloak();
        //$url_login = $getUrlLogin->GetLoginUrl();
        //$sessionUrl = $_SESSION["url_login"] = $url_login;

        //return redirect($url_login);
    }

    public function login_by_sso()
    {
        $getMasterKeyCloak = new MasterKeyCloak();
        $url_login = $getMasterKeyCloak->GetLoginUrl();
        $sso = \Illuminate\Support\Facades\Session::get('sso_data');
        $user = \Illuminate\Support\Facades\Session::get('user');

        if ($user) {
            return redirect('/');

        }
        if (isset($_GET['code']) && isset($_GET['session_state']) && $sso) {
            $code = $_GET['code'];

            $grantCode = $getMasterKeyCloak->LoginByCode($code);
            $sso_data = unserialize($sso);
            $session_state = $_GET['session_state'];
            $url = $this->url . 'apis/check365';
            $data['office365mail'] = $grantCode->access_token->payload['email'];
            $user = User::select('users.*')->where('users.azure_id', '=', $data['office365mail'])->first();

            if ($user) {
                if ($user['User']['sso_id']) {
                    Session::flash('message', 'Tài khoản của bạn đã được liên kết với tài khoản khác. Vui lòng kiểm tra lại.');
                    Session::flash('alert-class', "danger");
                    return redirect('dang-nhap');
                }

                $user2['User']['sso_id'] = $sso_data->access_token->payload['sub'];
                User::where('id', $user->id)->update(array('sso_id' => $sso_data->access_token->payload['sub']));

                return redirect('/');
            } else
                Session::flash('message', 'Mật khẩu không đúng. Vui lòng kiểm tra lại.');
                Session::flash('alert-class', "danger");
                return redirect('dang-nhap');
        }elseif(isset($_GET['code'])) {
            $grant = $getMasterKeyCloak->LoginByCode($_GET['code']);
           // var_dump($grant);die();
            if (!$grant) {
                Session::flash('message', 'Đăng nhập lỗi. Vui lòng kiểm tra lại.');
                Session::flash('alert-class', "danger");
                return redirect('dang-nhap');
            }
            $user = User::where('users.azure_id',$grant->access_token->payload['email'])->where('users.sso_id', $grant->access_token->payload['sub'])->first();

            if ($user) {
                $_SESSION["Auth"] = $user;
                $user->user_id_login = $user->id;
                $user->type = 'local';
                Session::put('user', $user->toArray());
                Session::put('user_logged_username', $user->username);
                return redirect('/');
            } else {
                $user_add = User::where('users.azure_id',$grant->access_token->payload['preferred_username'])->first();
                if($user_add){
                    $user_add->user_id_login = $user_add->id;
                    $user_add->type = 'local';
                    Session::put('user', $user_add->toArray());
                    Session::put('user_logged_username', $user_add->username);
                    User::where('id', $user_add->id)->update(array('sso_id' => $grant->access_token->payload['sub']));
                    $_SESSION["Auth"] = $user_add;
                    return redirect('/');
                }else{
                    if (isset($_SERVER['HTTP_COOKIE'])) {
                        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                        foreach($cookies as $cookie) {
                            $parts = explode('=', $cookie);
                            $name = trim($parts[0]);
                            setcookie($name, '', time()-1000);
                            setcookie($name, '', time()-1000, '/');
                        }
                    }
                    $getUrlLogout = new MasterKeyCloak();
                    $url = $getUrlLogout->GetLogoutUrl();

                    return redirect($url);
                }

            }
        }

    }

    public function cap_nhat_thong_tin()
    {
        $user = \Illuminate\Support\Facades\Session::get('user');
        $data['User']['username'] = $user['username'];;
        $data['User']['password'] = '';
        $data = $this->en_cription($data);

        return redirect('http://hrm.udn.vn/users/cap_nhat_thong_tin_ca_nhan/' . $data);
    }

    function en_cription($data)
    {
        $data = json_encode($data);
        $iv = mcrypt_create_iv(
            mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM
        );
        $encrypted = base64_encode(
            $iv .
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_256, hash('sha256', 'tnvhung120587', true), $data, MCRYPT_MODE_CBC, $iv
            )
        );
        return rtrim(strtr($encrypted, '+/', '-_'), '=');
    }

    function de_cription($json)
    {
        $data = base64_decode(str_pad(strtr($json, '-_', '+/'), strlen($json) % 4, '=', STR_PAD_RIGHT));
        $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
        $decrypted = rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_256, hash('sha256', 'tnvhung120587', true), substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)), MCRYPT_MODE_CBC, $iv
            ), "\0"
        );
        return json_decode($decrypted, true);
    }

    public function quick_login($json)
    {
        $data = $this->de_cription($json);
        $result = $this->postApi('http://hrm.udn.vn/apis/quicklogin', $data);
        if ($result['error'] == 0) {
            $check_user = CheckUser::select('check_user.*')->where('check_user.username', '=', $result['data']['User']['username'])->get();
            \Illuminate\Support\Facades\Session::put('user', $result['data']['User']);
            if (sizeof($check_user) > 0) {
                return redirect('/');
            } else {
                return redirect('guibaocao');
            }
        }

    }

    public function doi_mat_khau($id)
    {
        $users = User::select('users.*')->where('users.id', '=', $id)->first();
        $oldpass = Input::get('oldpass', null);

        if (sizeof($oldpass)) {
            if (Hash::check($oldpass, $users->password)) {
                return ("0");
            } else {
                return ("1");
            }
        } else {
            return view('auth.doi_mat_khau', compact('users'));
        }

    }

    public function cap_nhat_mat_khau($userId)
    {
        $inputs = Input::all();
        $users = User::findOrFail($userId);

        $users->password = bcrypt($inputs['password']);
        if ($users->update()) {
            flash('Thay đổi mật khẩu thành công.');
        } else {
            flash('Thay đổi mật khẩu thất bại')->error();
        }
        return redirect('doi-mat-khau/' . $userId);
    }
//    public function logout(Request $request)
//    {
//        //die('ád');
//        $request->session()->flush();
//        Cookie::forget();
//    }
    public function logout(Request $request)
    {

        //$getUrlLogout = new MasterKeyCloak();
        //$url = $getUrlLogout->GetLogoutUrl();

        //return redirect($url);
        $request->session()->flush();

        return redirect('dang-nhap');
    }
    public function logout_by_sso(Request $request){
        $request->session()->flush();

        $request->session()->regenerate();
        // unset cookies
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }
        $getUrlLogout = new MasterKeyCloak();
        $url2 = $getUrlLogout->GetLogoutUrl2();
        return redirect($url2);
    }

}
