<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Wishlist;
use Livewire\Component;

class WishlistShow extends Component
{
    //tạo chức năng xóa sản phẩm trong danh sách yêu thích
    public function removeWishlistItem(int $wishlistId)
    //Hàm removeWishlistItem nhận vào một tham số là wishlistId, kiểu dữ liệu là integer (số nguyên). Giả sử tham số này là ID của sản phẩm trong danh sách yêu thích cần được xóa.
    {
       Wishlist::where('user_id', auth()->user()->id)->where('id', $wishlistId)->delete();
       //thực hiện việc xóa một sản phẩm trong bảng Wishlist dựa trên các điều kiện:
       /**'user_id' phải bằng ID của người dùng hiện tại (được xác định bằng auth()->user()->id).
        * 'id' phải bằng $wishlistId (ID của sản phẩm trong danh sách yêu thích cần xóa).*/
        
        //tạo chức năng khi ta xóa sản phẩm trong danh sách yêu thích, số lượng sản phẩm sẽ đổi trực tiếp mà không phải load lại trang
        $this->emit('wishlistAddedUpdated');
        /**có nhiệm vụ kích hoạt sự kiện Livewire với tên là 'wishlistAddedUpdated'. Điều này có thể được sử dụng để thông báo cho các thành phần Livewire khác về việc cập nhật danh sách 
         * yêu thích.
         * Khi được gọi, sự kiện 'wishlistAddedUpdated' sẽ được phát ra (emit) và các thành phần Livewire khác có thể lắng nghe (listen) và thực hiện các hành động tương ứng. Các thành 
         * phần Livewire có thể đăng ký nghe sự kiện này bằng cách sử dụng phương thức @listen trong file Blade của chúng.
         * Sử dụng $this->emit('wishlistAddedUpdated'); có thể giúp đồng bộ hóa và cập nhật các thành phần Livewire khác khi có thay đổi trong danh sách yêu thích, sau khi một sản phẩm 
         * được xóa thành công. */

       $this->dispatchBrowserEvent('message', [
            'text' => 'Đã xóa sản phẩm khỏi danh sách yêu thích!',
            'type' => 'success',
            'status' => 200
       ]);
    }

    //giao diện danh sách sản phẩm yêu thích
    public function render()
    {
        $wishlist = Wishlist::where('user_id', auth()->user()->id)->get();
        //Khai báo biến $wishlist để lưu trữ danh sách sản phẩm yêu thích.
        /**Sử dụng câu truy vấn Wishlist::where('user_id', auth()->user()->id)->get() để lấy danh sách sản phẩm yêu thích từ bảng Wishlist. Điều kiện truy vấn là user_id bằng với id của 
         * người dùng đã đăng nhập (auth()->user()->id). */
        return view('livewire.frontend.wishlist-show',[
            'wishlist' => $wishlist 
        ]);
        //Trả về view wishlist-show và truyền biến wishlist chứa danh sách sản phẩm yêu thích vào view.
    }
}
