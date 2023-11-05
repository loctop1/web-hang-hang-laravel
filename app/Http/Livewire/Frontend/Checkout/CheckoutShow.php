<?php

namespace App\Http\Livewire\Frontend\Checkout;

use App\Mail\PlaceOrderMailable;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;

class CheckoutShow extends Component
{
    public $carts, $totalProductAmount = 0;

    //khởi tạo các biến thông tin khách hàng trong hóa đơn
    public $fullname, $email, $phone, $pincode, $address, $payment_mode = NULL, $payment_id = NULL;

    //tạo chức năng validate cho form khi ấn thanh toán băng paypal
    protected $listeners = [
        'validationForAll',
        'transactionEmit' => 'paidOnlineOrder',
        //Trong trường hợp này, component lắng nghe hai sự kiện: 'validationForAll' và 'transactionEmit'. Khi sự kiện 'transactionEmit' được gửi, nó sẽ kích hoạt phương thức 'paidOnlineOrder'.
    ];

    // Phương thức được gọi khi nhận được sự kiện 'transactionEmit'
    public function paidOnlineOrder($value)
    {
        // Gán giá trị $value cho thuộc tính $payment_id
        $this->payment_id = $value;

        // Gán giá trị 'Thanh toán thành công!' cho thuộc tính $payment_mode
        $this->payment_mode = 'Thanh toán thành công!';

        // Gọi phương thức placeOrder() để đặt hàng và lưu kết quả vào biến $codOrder
        $codOrder = $this->placeOrder();

        // Kiểm tra kết quả của phương thức placeOrder()
        if ($codOrder) {
            // Nếu đặt hàng thành công, xóa giỏ hàng của người dùng và hiển thị thông báo thành công
            Cart::where('user_id', auth()->user()->id)->delete(); // Xóa các mục trong giỏ hàng của người dùng bằng cách tìm các bản ghi trong bảng Cart có user_id tương ứng và xóa chúng.

            try {
                $order = Order::findOrFail($codOrder->id);
                Mail::to("$order->email")->send(new PlaceOrderMailable($order));
            } catch (\Exception $e) {
                //throw $th;
            }

            // Lưu thông báo thành công vào session để hiển thị sau khi chuyển hướng trang
            session()->flash('message', 'Đặt hàng thành công!');

            // Gửi sự kiện 'message' đến trình duyệt để hiển thị thông báo sử dụng JavaScript
            $this->dispatchBrowserEvent('message', [
                'text' => 'Đặt hàng thành công!',
                'type' => 'success',
                'status' => 200
            ]);

            // Chuyển hướng đến trang '/thank-you' để hiển thị thông báo "thank-you"
            return redirect('thank-you')->to('/thank-you');
        } else {
            // Nếu đặt hàng không thành công, hiển thị thông báo lỗi
            $this->dispatchBrowserEvent('message', [
                'text' => 'Lỗi! Vui lòng thử lại!',
                'type' => 'error',
                'status' => 500
            ]);
        }
    }

    //tạo chức năng validate cho form khi ấn thanh toán băng paypal
    public function validationForAll()
    {
        $validatedData = $this->validate([
            'fullname' => 'required|string|max:121',
            'email' => 'required|email|max:121',
            'phone' => 'required|string|max:11|min:10',
            'pincode' => 'required|string|max:6|min:6',
            'address' => 'required|string|max:500',
        ], [
            'fullname.required' => 'Vui lòng nhập họ và tên.',
            'fullname.string' => 'Họ và tên phải là chuỗi ký tự.',
            'fullname.max' => 'Họ và tên không được vượt quá 121 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ Email không hợp lệ.',
            'email.max' => 'Địa chỉ Email không được vượt quá 121 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 11 ký tự.',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự.',
            'pincode.required' => 'Vui lòng nhập mã bưu điện.',
            'pincode.string' => 'Mã bưu điện phải là chuỗi ký tự.',
            'pincode.max' => 'Mã bưu điện phải tối thiểu 6 ký tự.',
            'pincode.min' => 'Mã bưu điện phải tối thiểu 6 ký tự.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.',
        ]);
    }

    //tạo chức năng validate cho form thông tin khách hàng
    public function rules()
    {
        return [
            'fullname' => 'required|string|max:121',
            'email' => 'required|email|max:121',
            'phone' => 'required|string|max:11|min:10',
            'pincode' => 'required|string|max:6|min:6',
            'address' => 'required|string|max:500',
        ];
    }

    //tạo chức năng đặt hàng
    public function placeOrder()
    {
        $this->validate();
        //Gọi một phương thức validate() trong cùng một lớp. Phương thức này được sử dụng để xác thực dữ liệu trước khi đặt hàng.
        $order = Order::create([
            //tạo một đối tượng Order mới và lưu nó vào cơ sở dữ liệu.
            'user_id' => auth()->user()->id,
            //Trường user_id được gán giá trị là ID của người dùng hiện tại. auth()->user() trả về đối tượng người dùng đã xác thực và ->id lấy ID của người dùng đó.
            'tracking_no' => 'Loc-' . Str::random(10),
            /**Trường tracking_no được gán giá trị là một chuỗi ngẫu nhiên có độ dài 10 ký tự, được kết hợp với chuỗi 'Loc-'. Str::random(10) trả về một chuỗi ngẫu nhiên có 
             * độ dài 10 ký tự. */
            'fullname' => $this->fullname,
            //Trường fullname được gán giá trị từ thuộc tính $fullname của đối tượng hiện tại ($this).
            'email' => $this->email,
            //Trường email được gán giá trị từ thuộc tính $email của đối tượng hiện tại ($this).
            'phone' => $this->phone,
            //Trường phone được gán giá trị từ thuộc tính $phone của đối tượng hiện tại ($this).
            'pincode' => $this->pincode,
            //Trường pincode được gán giá trị từ thuộc tính $pincode của đối tượng hiện tại ($this).
            'address' => $this->address,
            //Trường address được gán giá trị từ thuộc tính $address của đối tượng hiện tại ($this).
            'status_message' => 'Đơn hàng đang được xử lý',
            /**Trường status_message có giá trị 'in progress' là một chuỗi đại diện cho trạng thái tiến trình của một đơn hàng. Trong ngữ cảnh này, 'in progress' có thể được 
             * hiểu là đơn hàng đang được xử lý, tức là đang trong quá trình thực hiện các bước cần thiết để hoàn thành đơn hàng.
             * Trạng thái 'in progress' có thể chỉ ra rằng đơn hàng đang được xử lý, và có thể đại diện cho giai đoạn sau khi đơn hàng được đặt và trước khi nó được gửi đi 
             * hoặc giao cho người nhận.
             * Thường thì trong hệ thống đặt hàng, có thể sử dụng các trạng thái khác nhau để đại diện cho tiến trình của đơn hàng như 'pending' (đang chờ xử lý), 
             * 'processing' (đang được xử lý), 'shipped' (đã được gửi đi), 'delivered' (đã được giao), và 'cancelled' (đã bị hủy) và nhiều trạng thái khác tùy thuộc vào 
             * yêu cầu cụ thể của hệ thống. */
            'payment_mode' => $this->payment_mode,
            //Trường payment_mode được gán giá trị từ thuộc tính $payment_mode của đối tượng hiện tại ($this).
            'payment_id' => $this->payment_id,
            //Trường payment_id được gán giá trị từ thuộc tính $payment_id của đối tượng hiện tại ($this).
        ]);
        //
        foreach ($this->carts as $cartItem) {
            // Lặp qua từng sản phẩm trong giỏ hàng
            $orderItems = Orderitem::create([
                //được sử dụng để tạo một đối tượng Orderitem mới trong cơ sở dữ liệu.
                'order_id' => $order->id,
                //Trường order_id được gán giá trị là ID của đơn hàng ($order) mà ta đã tạo trong bước trước đó.
                'product_id' => $cartItem->product_id,
                //Trường product_id được gán giá trị là ID của sản phẩm ($cartItem->product_id) từ phần tử hiện tại trong vòng lặp.
                'product_color_id' => $cartItem->product_color_id,
                //Trường product_color_id được gán giá trị là ID của màu sắc sản phẩm ($cartItem->product_color_id) từ phần tử hiện tại trong vòng lặp.
                'quantity' => $cartItem->quantity,
                //Trường quantity được gán giá trị là số lượng ($cartItem->quantity) từ phần tử hiện tại trong vòng lặp.
                'price' => $cartItem->product->selling_price,
                //Trường price được gán giá trị là giá bán ($cartItem->product->selling_price) của sản phẩm từ phần tử hiện tại trong vòng lặp.
            ]);

            // Giảm số lượng sản phẩm trong kho sau khi đặt hàng thành công
            if ($cartItem->product_color_id != NULL) {
                // Kiểm tra nếu sản phẩm có màu sắc (product_color_id khác NULL)
                $cartItem->productColor()->where('id', $cartItem->product_color_id)->decrement('quantity', $cartItem->quantity);
                // Sử dụng relation productColor để truy vấn bảng product_colors và giảm số lượng sản phẩm có màu sắc
            } else {
                $cartItem->product()->where('id', $cartItem->product_id)->decrement('quantity', $cartItem->quantity);
                // Trường hợp không có màu sắc (product_color_id là NULL)
                // Sử dụng relation product để truy vấn bảng products và giảm số lượng sản phẩm
            }
            /**Giả sử có một đơn hàng với một số lượng sản phẩm và màu sắc như sau:
             * Sản phẩm A (product_id: 1) có màu sắc đỏ (product_color_id: 5)
             * Sản phẩm B (product_id: 2) không có màu sắc (product_color_id là NULL)
             * Khi đơn hàng được đặt thành công và số lượng sản phẩm được giảm theo đơn hàng, chức năng này sẽ thực hiện các thay đổi sau:
             * Sản phẩm A (màu đỏ) có số lượng giảm đi theo số lượng đã đặt trong đơn hàng.
             * Sản phẩm B (không có màu sắc) có số lượng giảm đi theo số lượng đã đặt trong đơn hàng. */
        }
        //
        return $order;
        //Cuối cùng, hàm trả về đối tượng Order vừa được tạo.
    }

    //tạo chức năng validate cho phương thức thanh toán
    public function codOrder()
    {
        $validatedData = $this->validate([
            'fullname' => 'required|string|max:121',
            'email' => 'required|email|max:121',
            'phone' => 'required|string|max:11|min:10',
            'pincode' => 'required|string|max:6|min:6',
            'address' => 'required|string|max:500',
        ], [
            'fullname.required' => 'Vui lòng nhập họ và tên.',
            'fullname.string' => 'Họ và tên phải là chuỗi ký tự.',
            'fullname.max' => 'Họ và tên không được vượt quá 121 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ Email không hợp lệ.',
            'email.max' => 'Địa chỉ Email không được vượt quá 121 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 11 ký tự.',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự.',
            'pincode.required' => 'Vui lòng nhập mã bưu điện.',
            'pincode.string' => 'Mã bưu điện phải là chuỗi ký tự.',
            'pincode.max' => 'Mã bưu điện phải tối thiểu 6 ký tự.',
            'pincode.min' => 'Mã bưu điện phải tối thiểu 6 ký tự.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự.',
        ]);

        $this->payment_mode = 'Thanh toán khi nhận hàng';
        //Gán giá trị 'Thanh toán khi nhận hàng' cho thuộc tính $payment_mode của đối tượng hiện tại ($this), để chỉ định phương thức thanh toán.
        $codOrder = $this->placeOrder();
        //Gọi phương thức placeOrder() để đặt hàng. Kết quả trả về được gán cho biến $codOrder.
        if ($codOrder) {
            /**Kiểm tra kết quả của phương thức placeOrder(). Nếu đặt hàng thành công, giỏ hàng của người dùng được xóa và hiển thị thông báo thành công. Ngược lại, hiển thị 
             * thông báo lỗi. */

            Cart::where('user_id', auth()->user()->id)->delete();
            //Xóa các mục trong giỏ hàng của người dùng bằng cách tìm các bản ghi trong bảng Cart có user_id tương ứng và xóa chúng.
            
            try {
                $order = Order::findOrFail($codOrder->id);
                Mail::to("$order->email")->send(new PlaceOrderMailable($order));
            } catch (\Exception $e) {
                //throw $th;
            }
            
            session()->flash('message', 'Đặt hàng thành công!');
            $this->dispatchBrowserEvent('message', [
                'text' => 'Đặt hàng thành công!',
                'type' => 'success',
                'status' => 200
            ]);
            return redirect('thank-you')->to('/thank-you');
        } else {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Lỗi! Vui lòng thử lại!',
                'type' => 'error',
                'status' => 500
            ]);
        }
    }

    //chức năng tổng số tiền tất cả sản phẩm trên hóa đơn
    public function totalProductAmount()
    {
        $this->carts = Cart::where('user_id', auth()->user()->id)->get();
        // Lấy danh sách sản phẩm trong giỏ hàng của người dùng hiện tại

        $this->totalProductAmount = 0; // Khởi tạo tổng giá tiền ban đầu là 0

        foreach ($this->carts as $cartItem) {
            // Lặp qua từng sản phẩm trong giỏ hàng
            $this->totalProductAmount += $cartItem->product->selling_price * $cartItem->quantity;
            // Tính tổng giá tiền bằng cách cộng giá bán của sản phẩm nhân với số lượng của sản phẩm
        }

        return $this->totalProductAmount;
        // Hàm trả về tổng số tiền của tất cả các sản phẩm trong giỏ hàng.
    }

    public function render()
    {
        $this->fullname = auth()->user()->name;
        $this->email = auth()->user()->email;
        //được sử dụng để lấy thông tin về tên đầy đủ và email của người dùng hiện tại đã đăng nhập vào hệ thống.
        //Sau khi lấy thông tin người dùng, các giá trị tương ứng được gán cho thuộc tính $this->fullname và $this->email.

        $this->phone = auth()->user()->userDetail->phone;
        /**Đoạn này gán giá trị của thuộc tính "phone" từ đối tượng "UserDetail" cho thuộc tính "phone" của lớp 
         * Livewire hiện tại. Tương tự, đối với "pin_code" và "address". */
        $this->pincode = auth()->user()->userDetail->pin_code;
        $this->address = auth()->user()->userDetail->address;
        /** Đoạn này có vẻ như bạn đang truy cập vào một mối quan hệ (relationship) trên mô hình người dùng (User). 
         * Nó có thể liên quan đến một mô hình khác, được gọi là "UserDetail". Điều này cho phép bạn truy cập các 
         * thông tin chi tiết của người dùng như số điện thoại, mã pin, địa chỉ, v.v. */

        $totalProductAmount = $this->totalProductAmount();
        // Gọi phương thức đã đổi tên để tính tổng giá tiền
        return view('livewire.frontend.checkout.checkout-show', [
            'totalProductAmount' => $this->totalProductAmount,
        ]);
    }
}
