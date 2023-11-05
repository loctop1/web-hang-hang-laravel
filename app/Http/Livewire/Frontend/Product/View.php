<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class View extends Component
{
    public $category, $product, $productColorSelectedQuantity, $quantityCount = 1, $productColorId;

    //tạo chức năng thêm sản phẩm vào danh sách yêu thích
    public function addToWishList($productId)
    //Đây là khai báo của phương thức "addToWishList" với một tham số là "$productId", đại diện cho ID của sản phẩm được thêm vào danh sách yêu thích.
    {
        if (Auth::check()) {
            //Kiểm tra xem người dùng đã đăng nhập hay chưa bằng cách sử dụng hàm "Auth::check()". Nếu người dùng đã đăng nhập, tiếp tục thực hiện các bước trong khối này.
            if (Wishlist::where('user_id', auth()->user()->id)->where('product_id', $productId)->exists()) {
                /**Kiểm tra xem sản phẩm đã tồn tại trong danh sách yêu thích của người dùng hay chưa. Sử dụng model "Wishlist" để truy vấn trong cơ sở dữ liệu. Điều kiện truy vấn là "user_id" 
                 * phải trùng khớp với ID của người dùng hiện tại và "product_id" phải trùng khớp với "$productId" được truyền vào. */
                session()->flash('message', 'Sản phẩm này đã tồn tại trong danh mục yêu thích!');
                /**Nếu sản phẩm đã tồn tại trong danh sách yêu thích, sử dụng "session()->flash()" để đặt thông báo "Sản phẩm này đã tồn tại trong danh mục yêu thích!". */
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Sản phẩm này đã tồn tại trong danh mục yêu thích!',
                    'type' => 'error',
                    //hiện thông báo với màu đỏ
                    'status' => 409
                    //Đây là mã trạng thái HTTP, ở đây là 409 để chỉ rằng thao tác thêm sản phẩm vào danh mục yêu thích không thành công do sản phẩm đã tồn tại.
                ]);
                return false; //Trả về false để chỉ ra rằng thêm sản phẩm không thành công.
            } else {
                Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId
                ]);
                /**Ngược lại, Nếu sản phẩm chưa tồn tại trong danh sách yêu thích, sử dụng model "Wishlist" và phương thức "create()" để tạo một bản ghi mới trong bảng "Wishlist". Bản ghi 
                 * mới này chứa thông tin về người dùng và sản phẩm (user_id và product_id). */

                ////tạo chức năng khi ta thêm sản phẩm vàos danh sách yêu thích, số lượng sản phẩm sẽ đổi trực tiếp mà không phải load lại trang
                $this->emit('wishlistAddedUpdated');

                session()->flash('message', 'Thêm sản phẩm vào danh mục yêu thích thành công!');
                //Hiển thị thông báo "Thêm sản phẩm vào danh mục yêu thích thành công!".
                $this->dispatchBrowserEvent('message', [
                    //'message': Đây là tên sự kiện mà trình duyệt sẽ lắng nghe để thực hiện một hành động tương ứng.
                    'text' => 'Thêm sản phẩm vào danh mục yêu thích thành công!',
                    'type' => 'success',
                    //Loại thông báo, ở đây là "success" để chỉ rằng thông báo là thành công.
                    'status' => 200
                    //Mã trạng thái HTTP, ở đây là 200 (OK) để chỉ ra rằng thao tác thêm sản phẩm vào danh mục yêu thích thành công.
                ]);
                /**Đoạn mã này được sử dụng để gửi một sự kiện tới trình duyệt với thông báo thành công, loại thông báo và mã trạng thái tương ứng để trình duyệt có thể thực hiện hành động 
                 * phù hợp, chẳng hạn như hiển thị thông báo cho người dùng. Cách xử lý sự kiện này trong trình duyệt sẽ phụ thuộc vào cách mà mã JavaScript được triển khai trong ứng 
                 * dụng web của bạn. */
            }
        } else {
            session()->flash('message', 'Vui lòng đăng nhập để tiếp tục!');
            //Nếu người dùng chưa đăng nhập, sử dụng "session()->flash()" để đặt thông báo "Vui lòng đăng nhập để tiếp tục!".
            $this->dispatchBrowserEvent('message', [
                //Dòng này gọi đến một sự kiện trình duyệt thông qua $this->dispatchBrowserEvent(). Đoạn mã trên truyền một mảng dữ liệu với các trường sau:
                'text' => 'Vui lòng đăng nhập để tiếp tục!',
                //'text' => 'Vui lòng đăng nhập để tiếp tục!': Đây là nội dung thông báo được hiển thị cho người dùng, trong trường hợp này là "Vui lòng đăng nhập để tiếp tục!".
                'type' => 'error',
                //Loại thông báo, ở đây là "error" để chỉ thông báo có tính chất thông tin.
                'status' => 401
                //Mã trạng thái HTTP, ở đây là 401 (Unauthorized) để chỉ ra rằng người dùng chưa được xác thực.
            ]);
            //Đoạn mã này có thể được sử dụng để thông báo cho trình duyệt rằng người dùng cần đăng nhập để tiếp tục thực hiện hành động thêm sản phẩm vào danh sách yêu thích.
            return false;
            //Trả về false để chỉ ra rằng thêm sản phẩm không thành công khi người dùng chưa đăng nhập.
        }
    }

    //tạo chức năng chọn màu cho sản phẩm
    public function colorSelected($productColorId)
    {
        $this->productColorId = $productColorId;
        $productColor = $this->product->productColors()->where('id', $productColorId)->first();
        /**Trong dòng này, chúng ta lấy thông tin của màu sắc ($productColor) bằng cách truy vấn qua mối quan 
         * hệ productColors() của đối tượng $this->product. Chúng ta sử dụng phương thức 
         * where('id', $productColorId) để lấy màu sắc với ID tương ứng được truyền vào từ tham số 
         * $productColorId. Phương thức first() trả về bản ghi đầu tiên phù hợp với điều kiện truy vấn. */
        $this->productColorSelectedQuantity = $productColor->quantity;
        /**Trong dòng này, chúng ta gán giá trị của thuộc tính quantity của màu sắc đã chọn 
         * ($productColor->quantity) cho biến $this->productColorSelectedQuantity. Điều này cho phép chúng ta 
         * lưu trữ số lượng hàng tồn kho của màu sắc đã chọn để sử dụng sau này. */
        if ($this->productColorSelectedQuantity == 0) {
            $this->productColorSelectedQuantity = 'hethang';
        }
        /**Trong dòng này, chúng ta kiểm tra xem $this->productColorSelectedQuantity có bằng 0 hay không. 
         * Nếu có, tức là màu sắc đã chọn không còn hàng tồn kho, chúng ta gán giá trị 'hethang' cho 
         * $this->productColorSelectedQuantity. Điều này cho phép chúng ta đánh dấu rằng màu sắc đã chọn hiện 
         * đang hết hàng. */
    }

    //tạo chức năng tăng số lượng số sản phẩm
    public function incrementQuantity()
    {
        if ($this->quantityCount < 10) {
            $this->quantityCount++;
        }
        //tối đa có thể tăng số lượng sản phẩm là 10
    }
    //tạo chức năng giảm số lượng số sản phẩm
    public function decrementQuantity()
    {
        if ($this->quantityCount > 1) {
            $this->quantityCount--;
        }
        //tối đa có thể giảm số lượng sản phẩm là không được dưới 1
    }

    //tạo chức năng thêm sản phẩm vào giỏ hàng
    public function addToCart(int $productId)
    {
        if (Auth::check()) {
        //kiểm tra xem người dùng đã đăng nhập hay chưa bằng cách sử dụng Auth::check(). Nếu người dùng đã đăng nhập, điều kiện này sẽ trả về true.
            if ($this->product->where('id', $productId)->where('status', '0')->exists()) {
                /**Dòng này kiểm tra xem sản phẩm có tồn tại và có trạng thái là "0" hay không.
                 * $this->product là một instance của một model sản phẩm trong Laravel.
                 * Đoạn mã sử dụng where() để xác định điều kiện, sau đó sử dụng exists() để kiểm tra xem có sản phẩm nào thỏa mãn điều kiện đó hay không. */
                
                //kiểm tra số lượng màu sản phẩm và thêm vào giỏ hàng
                if ($this->product->productColors()->count() > 1) {
                /**Dòng này kiểm tra xem số lượng màu sắc của sản phẩm có lớn hơn 1 hay không.
                 * $this->product->productColors() là một quan hệ trong model sản phẩm để lấy danh sách các màu sắc của sản phẩm.
                 * count() được sử dụng để đếm số lượng màu sắc. */
                    
                    if ($this->productColorSelectedQuantity != NULL) {
                    /**Dòng này kiểm tra xem người dùng đã chọn số lượng màu sắc của sản phẩm hay chưa.
                     * $this->productColorSelectedQuantity là biến lưu trữ số lượng màu sắc được chọn.
                     * Nếu giá trị của biến này khác NULL, điều kiện này sẽ trả về true. */
                        if (Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->where('product_color_id', $this->productColorId)->exists()) {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Sản phẩm này đã ở trong giỏ hàng của bạn!',
                                'type' => 'warning',
                                'status' => 200
                            ]);
                        /**Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của người dùng hay chưa bằng cách sử dụng model Cart và phương thức where(). Điều kiện kiểm tra được xác định 
                         * bằng cách sử dụng các phương thức where() để xác định user_id, product_id, và product_color_id của sản phẩm. Điều kiện này kiểm tra xem đã có bản ghi nào trong 
                         * giỏ hàng trùng khớp với các điều kiện đó hay không. Nếu điều kiện đúng, tức là sản phẩm đã tồn tại trong giỏ hàng, thông báo cảnh báo được gửi đến giao diện 
                         * người dùng thông qua dispatchBrowserEvent(). */
                        }else{
                            
                            $productColor = $this->product->productColors()->where('id', $this->productColorId)->first();
                            /**Lấy thông tin về màu sắc của sản phẩm. Sử dụng quan hệ productColors() của đối tượng $this->product (một instance của model sản phẩm) để truy cập các màu sắc. 
                             * Sử dụng phương thức where('id', $this->productColorId) để xác định màu sắc có ID trùng khớp với $this->productColorId. Cuối cùng, sử dụng phương thức 
                             * first() để lấy bản ghi đầu tiên kết quả trả về. */
                            if ($productColor->quantity > 0) {

                                if ($productColor->quantity > $this->quantityCount) {
                                    //chức năng thêm sản phẩm vào giỏ hàng
                                    Cart::create([
                                        'user_id' => auth()->user()->id,
                                        'product_id' => $productId,
                                        'product_color_id' => $this->productColorId,
                                        'quantity' => $this->quantityCount
                                    ]);
                                    //cập nhật số lượng sản phẩm khi đã thêm vào giỏ hàng
                                    $this->emit('CartAddedUpdated');

                                    $this->dispatchBrowserEvent('message', [
                                        'text' => 'Thêm sản phẩm vào giỏ hàng thành công!',
                                        'type' => 'success',
                                        'status' => 200
                                    ]);
                                    // Hiển thị thông báo thành công
                                }else{
                                    $this->dispatchBrowserEvent('message', [
                                        'text' => 'Còn ' . $productColor->quantity . ' sản phẩm!',
                                        'type' => 'error',
                                        'status' => 404
                                    ]);
                                }
                                // Nếu số lượng màu sắc không đủ, hiển thị thông báo lỗi
                            }else{
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Sản phẩm này đã hết hàng!',
                                    'type' => 'error',
                                    'status' => 404
                                ]);
                            }
                            // Nếu màu sắc đã hết hàng, hiển thị thông báo lỗi
                        }
                        /**Trong đoạn mã này, ta kiểm tra số lượng sản phẩm trong màu sắc đã chọn và số lượng sản phẩm được thêm vào giỏ hàng. Nếu số lượng sản phẩm trong màu sắc lớn hơn 0 
                         * và lớn hơn số lượng sản phẩm được thêm vào giỏ hàng, ta thêm sản phẩm vào giỏ hàng và hiển thị thông báo thành công. Nếu số lượng sản phẩm trong màu sắc không 
                         * đủ, ta hiển thị thông báo lỗi với số lượng sản phẩm còn lại. Nếu số lượng sản phẩm trong màu sắc là 0, ta hiển thị thông báo lỗi rằng sản phẩm đã hết hàng. */
                    }else{
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Vui lòng chọn màu sắc!',
                            'type' => 'error',
                            'status' => 404
                        ]);
                    }
                    //Trong trường hợp không có màu sắc nào được chọn, ta hiển thị thông báo lỗi yêu cầu chọn màu sắc.
                }else{

                    if (Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->exists()) {
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Sản phẩm này đã ở trong giỏ hàng của bạn!',
                            'type' => 'warning',
                            'status' => 200
                        ]);
                    //Nếu sản phẩm đã tồn tại trong giỏ hàng của người dùng, ta hiển thị thông báo cảnh báo.
                    }else{

                        if ($this->product->quantity > 0) {

                            if ($this->product->quantity > $this->quantityCount) {
                                //chức năng thêm sản phẩm vào giỏ hàng
                                Cart::create([
                                    'user_id' => auth()->user()->id,
                                    'product_id' => $productId,
                                    'quantity' => $this->quantityCount
                                ]);
                                //cập nhật số lượng sản phẩm khi đã thêm vào giỏ hàng
                                $this->emit('CartAddedUpdated');
                                
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Thêm sản phẩm vào giỏ hàng thành công!',
                                    'type' => 'success',
                                    'status' => 200
                                ]);
                                // Hiển thị thông báo thành công
                            }else{
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Còn ' . $this->product->quantity . ' sản phẩm!',
                                    'type' => 'error',
                                    'status' => 404
                                ]);
                            }
                            // Nếu số lượng màu sắc không đủ, hiển thị thông báo lỗi
                        }else{
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Sản phẩm này đã hết hàng!',
                                'type' => 'error',
                                'status' => 404
                            ]);
                        }
                        // Nếu màu sắc đã hết hàng, hiển thị thông báo lỗi
                    }
                }
                /**Trong đoạn mã này, ta kiểm tra xem sản phẩm đã chọn có số lượng lớn hơn 0 hay không. Nếu có, ta tiếp tục kiểm tra xem số lượng sản phẩm đủ để thêm vào giỏ hàng hay 
                 * không. Nếu đủ, ta thêm sản phẩm vào giỏ hàng và hiển thị thông báo thành công. Nếu số lượng sản phẩm không đủ, ta hiển thị thông báo lỗi với số lượng sản phẩm còn lại. 
                 * Nếu số lượng sản phẩm là 0, ta hiển thị thông báo lỗi rằng sản phẩm đã hết hàng.
                 * Nếu sản phẩm không có màu sắc, ta sẽ tiếp tục vào đoạn mã này để kiểm tra số lượng sản phẩm và thêm sản phẩm vào giỏ hàng tương tự như trên.
                 * Nếu số lượng sản phẩm không đủ, ta hiển thị thông báo lỗi với số lượng sản phẩm còn lại.
                 * Nếu số lượng sản phẩm là 0, ta hiển thị thông báo lỗi rằng sản phẩm đã hết hàng. */
            }else{
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Sản phẩm này chưa được thêm vào giỏ hàng!',
                    'type' => 'error',
                    'status' => 404
                ]);
            }
            //Trong trường hợp sản phẩm không tồn tại hoặc có trạng thái không hợp lệ, ta hiển thị thông báo lỗi rằng sản phẩm chưa được thêm vào giỏ hàng.
        }else{
            $this->dispatchBrowserEvent('message', [
                //Dòng này gọi đến một sự kiện trình duyệt thông qua $this->dispatchBrowserEvent(). Đoạn mã trên truyền một mảng dữ liệu với các trường sau:
                'text' => 'Vui lòng đăng nhập để tiếp tục!',
                //'text' => 'Vui lòng đăng nhập để tiếp tục!': Đây là nội dung thông báo được hiển thị cho người dùng, trong trường hợp này là "Vui lòng đăng nhập để tiếp tục!".
                'type' => 'error',
                //Loại thông báo, ở đây là "error" để chỉ thông báo có tính chất thông tin.
                'status' => 401
                //Mã trạng thái HTTP, ở đây là 401 (Unauthorized) để chỉ ra rằng người dùng chưa được xác thực.
            ]);
        }
        //Nếu người dùng chưa đăng nhập, ta hiển thị thông báo lỗi yêu cầu đăng nhập.
    }

    public function mount($category, $product)
    {
        $this->category = $category;
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.frontend.product.view', [
            'category' => $this->category,
            'product' => $this->product
        ]);
    }
}
