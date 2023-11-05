<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //giao diện danh sách đơn hàng của tôi
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);
        /**Sử dụng model Order, chúng ta sử dụng phương thức where() để lấy các đơn hàng có trường user_id trùng với id của người dùng đang đăng nhập (Auth::user()->id). Điều này giúp
         * chúng ta chỉ lấy ra các đơn hàng của người dùng hiện tại.
         * Sau khi lấy danh sách đơn hàng, chúng ta sử dụng phương thức orderBy() để sắp xếp chúng theo thời gian tạo (created_at). Chúng ta đặt thứ tự giảm dần (desc - descending) 
         * để hiển thị các đơn hàng mới nhất lên đầu danh sách. */
        return view('frontend.orders.index', compact('orders'));
    }

    //giao diện thông tin từng đơn hàng của tôi
    public function show($orderId)
    //được gọi khi người dùng truy cập vào trang hiển thị thông tin của một đơn hàng cụ thể.
    {   
        $order = Order::where('user_id', Auth::user()->id)->where('id', $orderId)->first();
        /**Chúng ta sử dụng model Order và phương thức where() để lấy thông tin của đơn hàng có id tương ứng với $orderId và có user_id trùng với id của người dùng đang đăng nhập 
         * (Auth::user()->id). Phương thức first() trả về một bản ghi đầu tiên thoả mãn điều kiện. */
        if($order){
        //Kiểm tra xem đơn hàng có tồn tại hay không. Nếu có, tiếp tục xử lý để hiển thị thông tin đơn hàng. Nếu không, chuyển hướng quay lại trang trước đó và hiển thị thông báo lỗi.
            return view('frontend.orders.view', compact('order'));
            //Nếu đơn hàng tồn tại, chuyển hướng sang view frontend.orders.view và truyền biến $order vào view để hiển thị thông tin đơn hàng.
        }else{
            return redirect()->back()->with('message', 'Đơn hàng này không tồn tại!');
            //Nếu đơn hàng không tồn tại, chuyển hướng quay lại trang trước đó (trang hiển thị danh sách đơn hàng) và kèm theo thông báo lỗi thông qua session (with('message', ...)).
        }   
    }
}
