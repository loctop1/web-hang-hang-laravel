<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WishlistCount extends Component
{
    public $wishlistCount; 

    //tạo chức năng khi ta xóa sản phẩm trong danh sách yêu thích, số lượng sản phẩm sẽ đổi trực tiếp mà không phải load lại trang
    protected $listeners = ['wishlistAddedUpdated' => 'checkWishlistCount'];
    /**có tác dụng đăng ký một listener cho sự kiện Livewire có tên là 'wishlistAddedUpdated'. Khi sự kiện này được phát ra từ bất kỳ thành phần Livewire nào, phương thức 
     * 'checkWishlistCount' sẽ được gọi để kiểm tra và cập nhật số lượng sản phẩm trong danh sách yêu thích mà không cần tải lại trang.
     * wishlistAddedUpdated là tên sự kiện được phát ra khi có sự thay đổi trong danh sách yêu thích. Khi sự kiện này được phát ra, phương thức checkWishlistCount sẽ được gọi để kiểm tra 
     * và cập nhật số lượng sản phẩm trong danh sách yêu thích.
     * Điều này cho phép cập nhật số lượng sản phẩm trong danh sách yêu thích một cách trực tiếp và tự động, mà không cần phải load lại trang hoặc thực hiện các thao tác bổ sung. */
    
    //tạo chức năng kiểm tra số lượng sản phẩm trong danh sách yêu thích
    public function checkWishlistCount()
    {
        if(Auth::check()){
        //kiểm tra xem người dùng đã đăng nhập hay chưa bằng cách sử dụng Auth::check(). Nếu người dùng đã đăng nhập, chương trình sẽ tiếp tục vào khối if.
            return $this->wishlistCount = Wishlist::where('user_id', auth()->user()->id)->count();
            // thực hiện truy vấn đếm số lượng bản ghi trong bảng Wishlist dựa trên các điều kiện sau:
            /**'user_id' phải bằng ID của người dùng hiện tại (được xác định bằng auth()->user()->id).
             * Sau đó, kết quả của truy vấn được gán cho thuộc tính wishlistCount và được trả về từ hàm.
             */
        }else{ //Nếu người dùng chưa đăng nhập (không thỏa mãn Auth::check()), chương trình sẽ thực hiện khối else.
            return $this->wishlistCount = 0;
            //đặt giá trị wishlistCount là 0 và trả về từ hàm.
        }
        /**Chức năng này kiểm tra số lượng sản phẩm trong danh sách yêu thích của người dùng. Nếu người dùng đã đăng nhập, số lượng sản phẩm trong danh sách yêu thích sẽ được trả về. Nếu 
         * người dùng chưa đăng nhập, số lượng sản phẩm trong danh sách yêu thích sẽ được đặt là 0. */
    }
    
    public function render()
    {
        $this->wishlistCount = $this->checkWishlistCount();
        //Dòng đầu tiên $this->wishlistCount là một thuộc tính của lớp Livewire, được sử dụng để lưu trữ số lượng sản phẩm trong danh sách yêu thích.
        /**Bằng việc gán $this->wishlistCount bằng $this->checkWishlistCount(), phương thức checkWishlistCount() được gọi để kiểm tra số lượng sản phẩm trong danh sách yêu thích và kết quả 
         * trả về được gán cho thuộc tính $this->wishlistCount.
         * Kết quả là $this->wishlistCount sẽ chứa số lượng sản phẩm trong danh sách yêu thích sau khi được cập nhật bằng cách gọi phương thức checkWishlistCount().
         * Với việc gán $this->wishlistCount = $this->checkWishlistCount();, số lượng sản phẩm trong danh sách yêu thích sẽ được cập nhật và truyền vào view để hiển thị cho người dùng. */
        return view('livewire.frontend.wishlist-count', [
            'wishlistCount' => $this->wishlistCount
        ]);
    }
}
