<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceOrderMailable;

class OrderController extends Controller
{
    //giao diện trang quan trị đơn hàng
    public function index(Request $request)
    {    
        // $todayDate = Carbon::now();
        // /**Đoạn này sử dụng thư viện Carbon để lấy thời gian hiện tại. Carbon là một thư viện hỗ trợ công việc 
        //  * xử lý ngày tháng trong PHP. */
        // $orders = Order::whereDate('created_at', $todayDate)->paginate(10);
        // /**Đoạn này lấy các đơn hàng từ cơ sở dữ liệu. `Order::` truy vấn đến mô hình (model) `Order`, giả sử 
        //  * mô hình này liên kết với bảng chứa thông tin về đơn hàng trong cơ sở dữ liệu. Phương thức 
        //  * `whereDate()` sẽ lọc các đơn hàng có trường `created_at` (thời gian tạo) bằng với `$todayDate`, 
        //  * tức là chỉ lấy các đơn hàng được tạo trong ngày hôm nay. Phương thức `paginate(10)` sẽ chia danh 
        //  * sách các đơn hàng thành các trang và mỗi trang chứa tối đa 10 đơn hàng. */

        //Xây dựng chức năng lọc hóa đơn sản phẩm trong trang admin
        $todayDate = Carbon::now()->format('Y-m-d');
        /**Đoạn mã này sử dụng thư viện Carbon để lấy thời gian hiện tại (ngày hôm nay) và định dạng nó thành chuỗi 'Y-m-d' (năm-tháng-ngày). Điều này sẽ lấy ngày hiện tại trong định 
         * dạng chuẩn để so sánh với ngày tạo của đơn hàng. */
        $orders = Order::when($request->date != null, function($q) use ($request){
        /**Đoạn mã này sử dụng hàm when() của Laravel để thực hiện các điều kiện dựa trên giá trị của $request->date. Nếu $request->date không null (tức là người dùng đã gửi dữ liệu từ 
         * ngày tháng trên form), thì hàm callback đầu tiên được thực thi */    
            return $q->whereDate('created_at', $request->date);
            /**Đoạn mã này thêm điều kiện vào truy vấn $q (đối tượng query builder) để lọc các đơn hàng có trường created_at bằng với ngày được truyền từ $request->date. Nếu 
             * $request->date không có giá trị, điều kiện này sẽ bị bỏ qua. */
        }, function($q) use ($todayDate){
            /**ngược lại, hàm callback thứ hai được thực thi. */
            return $q->whereDate('created_at', $todayDate);
            /**Đoạn mã này thêm điều kiện vào truy vấn $q (đối tượng query builder) để lọc các đơn hàng có trường created_at bằng với ngày hôm nay ($todayDate). Điều này xảy ra khi người 
             * dùng không cung cấp ngày tháng trong form. */
        })
        ->when($request->status != null, function($q) use ($request){
        /**Đoạn mã này tương tự như trên, nhưng dựa trên giá trị của $request->status để thêm điều kiện lọc trạng thái đơn hàng. */
            return $q->where('status_message', $request->status);
            /**Đoạn mã này thêm điều kiện vào truy vấn $q để lọc các đơn hàng có trường status_message bằng với giá trị trạng thái được truyền từ $request->status. */
        })
        ->paginate(10);
        //Đoạn mã này thêm phần phân trang vào truy vấn. Nó chia danh sách các đơn hàng thành các trang, mỗi trang chứa tối đa 10 đơn hàng.
        return view('admin.orders.index', compact('orders'));
    }
    //giao diện thị danh sách hóa đơn trong trang admin
    public function show(int $orderId)
    {
        $order = Order::where('id', $orderId)->first();
        /**Dòng này thực hiện truy vấn CSDL để lấy thông tin hóa đơn có id trùng khớp với giá trị của biến $orderId. Đoạn mã dùng model Order để thực hiện truy vấn. Hàm where dùng để 
         * tìm kiếm hóa đơn có trường id bằng $orderId, và first sẽ lấy bản ghi đầu tiên tìm thấy (nếu có) và gán cho biến $order. */
        if($order)
        {
            return view('admin.orders.view', compact('order'));
            /**Đoạn mã này kiểm tra xem có hóa đơn nào trùng khớp với id đã truyền vào hay không. Nếu có, nó sẽ chuyển đến view có tên admin.orders.view và truyền biến $order vào view 
             * để hiển thị thông tin chi tiết của hóa đơn. */
        }else{
            return redirect('admin/orders')->with('message', 'Hóa đơn này không tồn tại');
            /**Nếu không có hóa đơn nào trùng khớp, điều này có nghĩa là hóa đơn không tồn tại trong CSDL. Phương thức sẽ chuyển hướng về trang danh sách hóa đơn trong trang admin 
             * (admin/orders) và đồng thời gắn một thông báo ('message') để thông báo cho người dùng rằng hóa đơn không tồn tại. */
        }
    }

    //giao diện chỉnh sửa thông tin hóa đơn
    public function updateOrderStatus(int $orderId, Request $request)
    /**Phương thức updateOrderStatus nhận hai tham số: $orderId (kiểu số nguyên) là ID của hóa đơn cần cập nhật và 
     * $request là đối tượng Request của Laravel, chứa các dữ liệu gửi lên từ form. */
    {
        $order = Order::where('id', $orderId)->first();
        /**Dòng này thực hiện truy vấn CSDL để lấy thông tin hóa đơn có id trùng khớp với giá trị của biến $orderId. Đoạn mã dùng model Order để thực hiện truy vấn. Hàm where dùng để 
         * tìm kiếm hóa đơn có trường id bằng $orderId, và first sẽ lấy bản ghi đầu tiên tìm thấy (nếu có) và gán cho biến $order. */
        if($order)
        /**Kiểm tra xem có tồn tại hóa đơn có id tương ứng không. Nếu $order tồn tại (không null), tức là hóa đơn có ID 
         * $orderId tồn tại. */
        {
            $order->update([
                'status_message' => $request->order_status, 
            ]);
            /**Nếu hóa đơn tồn tại, dòng này sẽ cập nhật trạng thái của hóa đơn dựa trên giá trị order_status được 
             * truyền từ form thông qua đối tượng $request. */
            return redirect('admin/orders/'.$orderId)->with('message', 'Hóa đơn này đã được cập nhật');
            /**Sau khi cập nhật xong, phương thức chuyển hướng người dùng trở lại trang hiển thị thông tin hóa đơn với 
             * thông báo thành công được đặt trong session với key là message. */
        }else{
            return redirect('admin/orders/'.$orderId)->with('message', 'Hóa đơn này không tồn tại');
        }
    }

    //giao diện hóa đơn khi đã tải file lên thành công
    public function viewInvoice(int $orderId)
    {
        $order = Order::findOrFail($orderId);
        /**Dòng này lấy dữ liệu đơn hàng từ cơ sở dữ liệu. Đối tượng Order là một model (mô hình) trong Laravel đại diện 
         * cho bảng orders. Hàm findOrFail() tìm đơn hàng với orderId tương ứng trong cơ sở dữ liệu. Nếu không tìm thấy 
         * đơn hàng, nó sẽ ném một ngoại lệ (Exception). */
        return view('admin.invoice.generate-invoice', compact('order'));
    }

    //giao diện download file PDF sản phẩm lên web
    public function generateInvoice(int $orderId){
        $order = Order::findOrFail($orderId);
        
        //chức năng tải file PDF
        $data = [
            'order' => $order
        ];
        /**Dòng này tạo một mảng $data có một phần tử có key là 'order' và value là biến $order. Mục đích là để truyền biến $order vào giao diện PDF. */
        $pdf = Pdf::loadView('admin.invoice.generate-invoice', $data);
        /**Dòng này sử dụng thư viện PDF để tạo một đối tượng PDF từ giao diện blade có tên 'admin.invoice.generate-invoice' và dữ liệu $data. Giao diện blade này sẽ được sử dụng để hiển thị 
         * nội dung của file PDF. */
        $todayDate = Carbon::now()->format('d-m-Y');
        //Dòng này sử dụng thư viện Carbon để lấy ngày hiện tại và định dạng thành chuỗi theo định dạng 'd-m-Y', tức là ngày-tháng-năm.
        return $pdf->download('Hóa đơn-'.$order->id.'-'.$todayDate.'.pdf');
        /** Dòng này trả về file PDF để tải về với tên file có dạng 'Hóa đơn-{orderId}-{ngày hiện tại}.pdf'. Ví dụ: Nếu $order->id là 123 và $todayDate là '01-08-2023', thì tên file sẽ là 
         * 'Hóa đơn-123-01-08-2023.pdf'. */
    }

    //chức năng gửi Email hóa đơn sản phẩm
    public function mailInvoice(int $orderId){
        try{
            $order = Order::findOrFail($orderId);
            // Dòng này sử dụng hàm tĩnh 'findOrFail' của model 'Order' để tìm đơn hàng với ID tương ứng.
            
            Mail::to("$order->email")->send(new InvoiceOrderMailable($order));
            // Dòng này sử dụng lớp 'Mail' để gửi email.
            // Hàm 'to' được sử dụng để chỉ định địa chỉ email đích của email.
            // Hàm 'send' được sử dụng để thực hiện việc gửi email.
            // Tạo một thể hiện của lớp 'InvoiceOrderMailable' và truyền vào đối tượng đơn hàng.
            
            return redirect('admin/orders/'.$orderId)->with('message', 'Gửi Email thành công đến tài khoản: '.$order->email);
            // Nếu không có ngoại lệ xảy ra, chương trình sẽ tiếp tục dòng này.
            // Nó sẽ chuyển hướng người dùng đến trang 'admin/orders/'.$orderId với thông báo thành công.
        }catch(\Exception $e){
            return redirect('admin/orders/'.$orderId)->with('message', 'Gửi Email không thành công. Vui lòng thử lại sau!');
            // Nếu có ngoại lệ xảy ra (ví dụ: không tìm thấy đơn hàng hoặc lỗi khi gửi email), chương trình sẽ vào khối catch.
            // Nó sẽ chuyển hướng người dùng đến trang 'admin/orders/'.$orderId với thông báo lỗi.
        }
    }
}
