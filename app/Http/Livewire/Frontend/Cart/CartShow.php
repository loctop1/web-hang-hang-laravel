<?php

namespace App\Http\Livewire\Frontend\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartShow extends Component
{
    public $cart, $totalPrice = 0;

    //chức nằng giảm số lượng sản phẩm
    public function decrementQuantity(int $cartId)
    {
        $cartData = Cart::where('id', $cartId)->where('user_id', auth()->user()->id)->first();
        /**Dòng này truy vấn trong bảng Cart để lấy thông tin của giỏ hàng có id tương ứng với $cartId và user_id tương ứng với người dùng đang xác thực (auth()->user()->id). Kết quả truy 
         * vấn được gán cho biến $cartData. */
        if ($cartData) {
            //Kiểm tra xem có tồn tại dữ liệu giỏ hàng hay không.
            if ($cartData->productColor()->where('id', $cartData->product_color_id)->exists()) {
                //Kiểm tra xem có sản phẩm màu sắc tương ứng trong giỏ hàng hay không bằng cách sử dụng mối quan hệ productColor. Nếu có, thực hiện các lệnh bên trong khối này.
                $productColor = $cartData->productColor()->where('id', $cartData->product_color_id)->first();
                //Truy vấn để lấy thông tin chi tiết của sản phẩm màu sắc trong giỏ hàng. Kết quả truy vấn được gán cho biến $productColor.
                if ($cartData->quantity > 1) {
                    //Kiểm tra xem số lượng sản phẩm trong giỏ hàng có lớn hơn 1 hay không.
                    $cartData->decrement('quantity');
                    //Giảm số lượng sản phẩm trong giỏ hàng đi 1 đơn vị bằng phương thức decrement().
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Số lượng sản phẩm đã được cập nhật!',
                        'type' => 'success',
                        'status' => 200
                    ]);
                    //Gửi một sự kiện tới trình duyệt để hiển thị thông báo thành công.
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Số lượng sản phẩm đã đạt đến giới hạn tối thiểu!',
                        'type' => 'error',
                        'status' => 404
                    ]);
                    //Nếu số lượng sản phẩm trong giỏ hàng đã là 1, gửi một sự kiện tới trình duyệt để hiển thị thông báo lỗi.
                }
            } else {
                if ($cartData->quantity > 1) {
                    $cartData->decrement('quantity');
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Số lượng sản phẩm đã được cập nhật!',
                        'type' => 'success',
                        'status' => 200
                    ]);
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Số lượng sản phẩm đã đạt đến giới hạn tối thiểu!',
                        'type' => 'error',
                        'status' => 404
                    ]);
                }
                /**Nếu không có sản phẩm màu sắc tương ứng, kiểm tra số lượng sản phẩm trong giỏ hàng. Nếu lớn hơn 1, giảm số lượng sản phẩm đi 1 đơn vị và gửi thông báo thành công. 
                 * Ngược lại, gửi thông báo lỗi. */
            }
        } else {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Không hợp lệ!',
                'type' => 'error',
                'status' => 404
            ]);
            //Nếu không tìm thấy dữ liệu giỏ hàng tương ứng với $cartId, gửi thông báo lỗi.
        }
    }

    //chức nằng tăng số lượng sản phẩm
    public function incrementQuantity(int $cartId)
    {
        $cartData = Cart::where('id', $cartId)->where('user_id', auth()->user()->id)->first();

        if ($cartData) {
            if ($cartData->productColor()->where('id', $cartData->product_color_id)->exists()) {
                $productColor = $cartData->productColor()->where('id', $cartData->product_color_id)->first();

                if ($productColor->quantity > $cartData->quantity) {
                    //Kiểm tra xem số lượng sản phẩm màu sắc có lớn hơn số lượng hiện tại trong giỏ hàng hay không.
                    $cartData->increment('quantity');
                    //Tăng số lượng sản phẩm trong giỏ hàng lên 1 đơn vị bằng phương thức increment().
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Số lượng sản phẩm đã được cập nhật!',
                        'type' => 'success',
                        'status' => 200
                    ]);
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Số lượng sản phẩm đã đạt đến giới hạn tối đa!',
                        'type' => 'error',
                        'status' => 404
                    ]);
                    //Nếu số lượng sản phẩm màu sắc đã đạt đến giới hạn, gửi một sự kiện tới trình duyệt để hiển thị thông báo lỗi.
                }
            } else {
                if ($cartData->product->quantity > $cartData->quantity) {
                    $cartData->increment('quantity');
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Số lượng sản phẩm đã được cập nhật!',
                        'type' => 'success',
                        'status' => 200
                    ]);
                } else {
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'Số lượng sản phẩm đã đạt đến giới hạn tối đa!',
                        'type' => 'error',
                        'status' => 404
                    ]);
                }
                /**Nếu không có sản phẩm màu sắc tương ứng, kiểm tra số lượng sản phẩm trong giỏ hàng. Nếu lớn hơn số lượng hiện tại, tăng số lượng sản phẩm lên 1 đơn vị và gửi thông báo 
                 * thành công. Ngược lại, gửi thông báo lỗi. */
            }
        } else {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Không hợp lệ!',
                'type' => 'error',
                'status' => 404
            ]);
            //Nếu không tìm thấy dữ liệu giỏ hàng tương ứng với $cartId, gửi thông báo lỗi.
        }
    }

    //chức năng xóa sản phẩm
    public function removeCartItem(int $cartId)
    {
        $cartRemoveData =  Cart::where('user_id', auth()->user()->id)->where('id', $cartId)->first();
        /**Dòng này tìm kiếm dữ liệu sản phẩm trong giỏ hàng bằng cách sử dụng model Cart và phương thức where để so khớp user_id (ID người dùng) và id (ID của sản phẩm trong giỏ hàng) với 
         * dữ liệu tương ứng trong CSDL. Sau đó, first() được gọi để trả về bản ghi đầu tiên. */
        if ($cartRemoveData) {
        /**kiểm tra xem có dữ liệu sản phẩm trong giỏ hàng hay không. Nếu có ($cartRemoveData tồn tại), mã bên trong khối if sẽ được thực thi. Nếu không có, mã bên trong khối else sẽ được 
         * thực thi. */
            $cartRemoveData->delete();
            /**Nếu dữ liệu sản phẩm tồn tại, phương thức delete() sẽ được gọi để xóa bản ghi sản phẩm khỏi CSDL. */
            $this->emit('CartAddedUpdated');
            //Sau khi xóa sản phẩm khỏi giỏ hàng, sự kiện Livewire CartAddedUpdated được gửi để cập nhật giỏ hàng trên giao diện người dùng.
            $this->dispatchBrowserEvent('message', [
                'text' => 'Xóa sản phẩm thành công!',
                'type' => 'success',
                'status' => 200
            ]);
            /**Hàm dispatchBrowserEvent được sử dụng để gửi thông báo từ phía máy chủ tới trình duyệt của người dùng. Trong trường hợp này, thông báo có tên là 'message' và nó chứa một 
             * mảng dữ liệu với các thông tin như text (nội dung thông báo), type (loại thông báo) và status (mã trạng thái). */
        }else{
            $this->dispatchBrowserEvent('message', [
                'text' => 'Lỗi! Không xóa được sản phẩm này!',
                'type' => 'error',
                'status' => 500
            ]);
            /**mã trạng thái 500 được sử dụng để thông báo lỗi cho người dùng. Điều này cho thấy rằng có sự cố xảy ra và máy chủ không thể xóa sản phẩm từ giỏ hàng. Thông báo lỗi có thể 
             * được hiển thị cho người dùng để thông báo về sự cố và hướng dẫn họ trong trường hợp xảy ra lỗi. */
        }
    }

    public function render()
    {
        $this->cart = Cart::where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.cart.cart-show', [
            'cart' => $this->cart
        ]);
    }
}
