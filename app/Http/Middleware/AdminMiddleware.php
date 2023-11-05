<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::user()->role_as == '1'){
            return redirect('/home')->with('status','Truy cập bị từ chối. Vì bạn không phải là Quản trị viên');
            /**Auth::user() là một phương thức trong Laravel được sử dụng để lấy thông tin về người dùng đang được xác thực.
             * Auth::user()->role_as truy cập vào thuộc tính role_as của người dùng đang được xác thực để lấy 
             * giá trị vai trò của người dùng.
             * if (!Auth::user()->role_as == '1') kiểm tra xem vai trò của người dùng có khác '1' hay không. 
             * Nếu điều kiện này đúng (vai trò không phải là '1', tức không phải là quản trị viên), điều kiện trong lệnh if 
             * sẽ được thực thi.
             * return redirect('/home')->with('status','Truy cập bị từ chối. Vì bạn không phải là Quản trị viên'); 
             * trong trường hợp vai trò của người dùng không phải là '1', người dùng sẽ bị chuyển hướng đến đường dẫn '/home' 
             * và một thông báo "Truy cập bị từ chối. Vì bạn không phải là Quản trị viên" sẽ được gắn kèm 
             * và hiển thị cho người dùng. */
        }
        return $next($request);
    }
}
