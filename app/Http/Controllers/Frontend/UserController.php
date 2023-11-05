<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{   
    //giao diện form thông tin người dùng
    public function index()
    {
        return view('frontend.users.profile');
    }

    //chức năng cập nhật dữ liệu form thông tin người dùng
    public function updateUserDetails(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'phone' => ['required', 'digits:10'],
            'pin_code' => ['required', 'digits:6'],
            'address' => ['required', 'string', 'max:499'],
        ],[
            'username.required' => 'Vui lòng nhập tên người dùng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.digits' => 'Số điện thoại phải có 10 chữ số.',
            'pin_code.required' => 'Vui lòng nhập mã pin.',
            'pin_code.digits' => 'Mã pin phải có 6 chữ số.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.max' => 'Địa chỉ không được vượt quá :max ký tự.',
        ]);

        $user = User::findOrFail(Auth::user()->id);
        /**lấy thông tin người dùng hiện đang đăng nhập bằng cách sử dụng Auth::user() và sau đó tìm kiếm dựa trên ID của người dùng. Nếu không tìm thấy, findOrFail sẽ trả về một ngoại lệ. */
        $user->update([
            'name' => $request->username,     
        ]);
        /**cập nhật tên người dùng dựa trên dữ liệu gửi từ form. */
        $user->userDetail()->updateOrCreate([
            'user_id' => $user->id,
        ],[
            'phone' => $request->phone,
            'pin_code' => $request->pin_code,
            'address' => $request->address,
        ]);
        /**cập nhật hoặc tạo mới thông tin chi tiết của người dùng. Điều này liên quan đến mối quan hệ giữa người dùng và thông tin chi tiết trong cơ sở dữ liệu.
         * Trong dòng này, updateOrCreate cố gắng cập nhật thông tin chi tiết của người dùng dựa trên điều kiện nếu đã tồn tại, hoặc tạo mới nếu chưa tồn tại.
         * Dữ liệu của thông tin chi tiết được cập nhật bằng cách sử dụng dữ liệu gửi từ form.
         */
        return redirect()->back()->with('message', 'Thông tin người dùng đã được cập nhật!');
    }   

    //giao diện thay đổi mật khẩu người dùng
    public function passwordCreate()
    {
        return view('frontend.users.change-password');
    }

    //chức năng thay đổi mật khẩu thành công khi gửi dữ liệu
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required','string','min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ],[
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'current_password.min' => 'Mật khẩu hiện tại phải có ít nhất :min ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu mới phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);
        /**Sử dụng hàm Hash::check để so sánh mật khẩu hiện tại nhập vào từ người dùng với mật khẩu đã được mã hóa trong cơ sở dữ liệu của người dùng hiện tại. */
        if($currentPasswordStatus){

            User::findOrFail(Auth::user()->id)->update([
                'password' => Hash::make($request->password),
            ]);
            /**Nếu mật khẩu hiện tại đã được xác minh chính xác, mã sẽ tìm và cập nhật mật khẩu mới cho người dùng hiện tại.
             * Sử dụng User::findOrFail(Auth::user()->id) để tìm người dùng theo ID và sau đó cập nhật trường password trong cơ sở dữ liệu bằng cách sử dụng Hash::make để mã hóa mật khẩu 
             * mới. */

            return redirect()->back()->with('message','Cập Nhật Mật Khẩu Thành Công!');

        }else{

            return redirect()->back()->with('message','Mật Khẩu Hiện Tại Không Khớp với Mật Khẩu Cũ');
        }
    }
}
