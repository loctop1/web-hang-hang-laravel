<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Illuminate\Validation\Rules\Exists;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;
class Index extends Component
{
    use WithPagination;
    /**Đây là một trait trong Livewire được sử dụng để hỗ trợ tính năng phân trang. Bằng cách sử dụng trait này, 
     * bạn có thể sử dụng các phương thức và thuộc tính liên quan đến phân trang trong Livewire. */
    protected $paginationTheme = 'bootstrap';
    /**Đây là một thuộc tính trong Livewire để xác định giao diện phân trang được sử dụng. Trong trường hợp này, 
     * giao diện phân trang 'bootstrap' được chỉ định. Điều này đảm bảo rằng phân trang 
     * được hiển thị theo phong cách Bootstrap.*/
    
     //xây dựng giao diện chức năng xóa sản phẩm 
    public $category_id;
     
    public function deleteCategory($category_id)
    {
        $this->category_id = $category_id;
    }
    /**deleteCategory($category_id): Phương thức này được gọi khi người dùng nhấp vào liên kết "Xóa" trong danh sách 
     * sản phẩm. Nó nhận một tham số $category_id, đại diện cho ID của danh mục sản phẩm cần xóa. Phương thức này chỉ 
     * đơn giản gán giá trị của $category_id vào thuộc tính $category_id của thành phần Livewire. Điều này cho phép phương 
     * thức destroyCategory sau đó truy xuất giá trị ID này để xóa danh mục tương ứng. */

    public function destroyCategory()
    /**destroyCategory(): Phương thức này được gọi khi người dùng xác nhận muốn xóa sản phẩm thông qua modal và nhấp vào 
     * nút "Có. Xóa ngay".  */
    {
        $category = Category::find($this->category_id);
        /**Tìm danh mục sản phẩm cần xóa dựa trên giá trị $category_id được lưu trữ trong thuộc tính $category_id của 
         * thành phần Livewire, sử dụng phương thức find(). */
        $path = 'uploads/category/'.$category->image;
        /**Xây dựng đường dẫn đến tệp tin hình ảnh của danh mục sử dụng $path = 'uploads/category/'.$category->image. */
        if(File::exists($path))
        /**Kiểm tra xem tệp tin hình ảnh có tồn tại tại đường dẫn $path hay không bằng cách sử dụng File::exists($path). */
        {
            File::delete($path);
            /**Nếu tệp tin tồn tại, sử dụng File::delete($path) để xóa tệp tin hình ảnh. */
        }
        $category->delete();
        /**Sử dụng $category->delete() để xóa danh mục sản phẩm từ cơ sở dữ liệu. */
        session()->flash('message', 'Đã xóa sản phẩm thành công!');
        /**Sử dụng session()->flash('message', 'Đã xóa sản phẩm thành công!') để lưu thông báo thành công trong 
         * phiên (session). Thông báo này sau đó có thể được hiển thị cho người dùng. */
        $this->dispatchBrowserEvent('close-modal');
        /**$this->dispatchBrowserEvent('close-modal'); là một phương thức của Livewire được sử dụng để gửi một sự kiện từ 
         * phía máy chủ đến trình duyệt. Trong trường hợp này, sự kiện được gửi có tên là 'close-modal'.
         * Khi sự kiện 'close-modal' được gửi, nó sẽ được xử lý bên phía trình duyệt (JavaScript). Điều này cho phép bạn 
         * thực hiện các hành động hoặc thay đổi trạng thái của giao diện người dùng sau khi thao tác đã hoàn thành 
         * trên máy chủ.
         * Ví dụ, sau khi xóa danh mục sản phẩm thành công và gửi sự kiện 'close-modal', bạn có thể sử dụng JavaScript để 
         * đóng modal hoặc làm bất kỳ thay đổi giao diện người dùng nào khác mà bạn muốn. Cách xử lý sự kiện 'close-modal' 
         * sẽ được định nghĩa trong mã JavaScript của ứng dụng của bạn. */
    }
    /**Cả hai phương thức trên hoạt động cùng nhau để thực hiện quá trình xóa danh mục sản phẩm trong ứng dụng Laravel 
     * với sử dụng Livewire. */
    
    public function render()
    {
        $categories = Category::orderBy('id','ASC')->paginate(10);
        /** Dòng này truy vấn danh sách các danh mục sản phẩm từ cơ sở dữ liệu. Phương thức orderBy() được sử dụng để 
         * sắp xếp danh sách theo trường 'id' theo thứ tự giảm dần ('DESC'). Sau đó, phương thức paginate(10) được sử dụng 
         * để chia danh sách thành các trang có mỗi trang chứa tối đa 10 danh mục. */
        return view('livewire.admin.category.index', ['categories' => $categories]);
        /**Dòng này trả về view 'livewire.admin.category.index' và truyền biến categories chứa danh sách các danh mục 
         * vào view. Điều này cho phép giao diện hiển thị danh sách danh mục và sử dụng tính năng phân trang 
         * để hiển thị các trang kết quả. */
    }
    /**Có một phương thức render(). Phương thức này được sử dụng trong Livewire để hiển thị giao diện người dùng. 
     * Dòng mã return view('livewire.admin.category.index'); trong phương thức render() chỉ định rằng khi 
     * phương thức render() được gọi, nó sẽ trả về một view có tên là 'livewire.admin.category.index'. 
     * Cụ thể, phương thức render() được sử dụng để kết nối với giao diện người dùng của trang quản trị danh mục 
     * (admin.category.index). Giao diện này có thể chứa các thành phần Livewire khác nhau để hiển thị danh sách 
     * các danh mục sản phẩm, cho phép thêm, sửa, xóa danh mục, và tương tác với người dùng.
     * Khi phương thức render() được gọi, nó sẽ hiển thị giao diện được chỉ định và kết hợp các tương tác 
     * và dữ liệu cần thiết để tạo trải nghiệm người dùng động và tương tác trên trang quản trị danh mục.*/
}
