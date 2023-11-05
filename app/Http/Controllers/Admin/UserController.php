<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //giao diện quản trị người dùng
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    //giao diện thêm tài khoản người dùng trang quản Admin
    public function create()
    {
        return view('admin.users.create');
    }

    //chức năng gửi dữ liệu khi gửi thông tin khách hàng
    public function store(Request $request)
    {
        $customAttributes = [
            'name' => 'Tên',
            'email' => 'Địa chỉ email',
            'password' => 'Mật khẩu',
            'role_as' => 'Vai trò',
        ];
    
        $customMessages = [
            'required' => ':attribute không được bỏ trống.',
            'email' => ':attribute phải là địa chỉ email hợp lệ.',
            'unique' => ':attribute đã tồn tại.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'min' => ':attribute tối thiểu phải có ít nhất :min ký tự.',
            'integer' => ':attribute phải là số nguyên.',
        ];
    
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role_as' => ['required', 'integer'],
        ], $customMessages, $customAttributes);

        User::create([
        /**Đây là phương thức của model User (giả sử bạn có một model User) trong Laravel. Nó được sử dụng để tạo một bản ghi mới trong bảng users của cơ sở dữ liệu. Các trường được cung cấp 
         * dưới dạng một mảng liệt kê. */
            'name' => $request->name,
            /**Đây là trường tên người dùng. Dữ liệu được lấy từ yêu cầu ($request) bằng cách sử dụng phương thức name, tức là giá trị được gửi từ form với trường tên là name. */
            'email' => $request->email,
            /**Đây là trường địa chỉ email của người dùng. Tương tự như trên, dữ liệu được lấy từ yêu cầu thông qua phương thức email. */
            'password' => Hash::make($request->password),
            /**Đây là trường mật khẩu của người dùng. Dữ liệu mật khẩu từ yêu cầu được mã hóa bằng cách sử dụng hàm Hash::make(). Điều này đảm bảo rằng mật khẩu không được lưu dưới dạng văn bản 
             * thường trong cơ sở dữ liệu, mà thay vào đó là phiên bản đã được mã hóa. */
            'role_as' => $request->role_as,
            /**Đây là trường vai trò (role) của người dùng. Tương tự như trên, dữ liệu từ yêu cầu được lấy thông qua phương thức role_as. */
        ]);
        return redirect('/admin/users')->with('message3', 'Thêm tài khoản người dùng thành công!');
    }

    //chức năng chỉnh sửa thông tin người dùng
    public function edit(int $userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.users.edit', compact('user'));
    }

    //chức năng cập nhật thông tin tài khoản người dùng
    public function update(Request $request, int $userId)
    {
        $customAttributes = [
            'name' => 'Tên',
            'password' => 'Mật khẩu',
            'role_as' => 'Vai trò',
        ];
    
        $customMessages = [
            'required' => ':attribute không được bỏ trống.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'min' => ':attribute tối thiểu phải có ít nhất :min ký tự.',
            'integer' => ':attribute phải là số nguyên.',
        ];
    
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'role_as' => ['required', 'integer'],
        ], $customMessages, $customAttributes);

        User::findOrFail($userId)->update([
            'name' => $request->name,
            /**Đây là trường tên người dùng. Dữ liệu được lấy từ yêu cầu ($request) bằng cách sử dụng phương thức name, tức là giá trị được gửi từ form với trường tên là name. */
            'password' => Hash::make($request->password),
            /**Đây là trường mật khẩu của người dùng. Dữ liệu mật khẩu từ yêu cầu được mã hóa bằng cách sử dụng hàm Hash::make(). Điều này đảm bảo rằng mật khẩu không được lưu dưới dạng văn bản 
             * thường trong cơ sở dữ liệu, mà thay vào đó là phiên bản đã được mã hóa. */
            'role_as' => $request->role_as,
            /**Đây là trường vai trò (role) của người dùng. Tương tự như trên, dữ liệu từ yêu cầu được lấy thông qua phương thức role_as. */
        ]);
        return redirect('/admin/users')->with('message3', 'Cập nhật thông tin tài khoản người dùng thành công!');
    }

    //chức năng xóa tài khoản người dùng
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        return redirect('/admin/users')->with('message3', 'Đã xóa tài khoản người dùng thành công!');
    }
}
