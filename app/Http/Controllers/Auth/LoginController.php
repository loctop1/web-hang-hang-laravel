<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
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
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    
    protected function authenticated()
    /**authenticated() được gọi tự động sau khi người dùng đăng nhập thành công. Nhiệm vụ chính của phương thức này 
     * là xác định vai trò của người dùng và chuyển hướng người dùng đến trang phù hợp sau khi đăng nhập. */
    {   
        if(Auth::user()->role_as == '1'){
            return redirect('admin/dashboard')->with('message', 'Chào mừng bạn đến với trang quản trị!');
            /**return redirect('admin/dashboard')->with('status', 'Chào mừng bạn đến với trang quản trị!'); 
             * trong trường hợp vai trò của người dùng là '1', người dùng sẽ được chuyển hướng đến trang quản trị 
             * 'admin/dashboard' và nhận được thông báo "Chào mừng bạn đến với trang quản trị!". */
        }else{
            return redirect('/home')->with('status', 'Bạn đã đăng nhập thành công!');
            /**Nếu vai trò của người dùng không phải là '1' (không phải quản trị viên), lệnh else sẽ được thực thi.
             * return redirect('/home')->with('status', 'Bạn đã đăng nhập thành công!'); trong trường hợp vai trò 
             * của người dùng không phải là '1', người dùng sẽ được chuyển hướng đến trang '/home' 
             * và nhận được thông báo "Bạn đã đăng nhập thành công!". */
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
