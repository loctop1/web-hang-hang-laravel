<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    //trang danh mục sản phẩm
    public function index()
    {
        return view('admin.category.index');
    }
    //trang thêm danh mục sản phẩm
    public function create()
    {
        return view('admin.category.create');
    }
    //tạo chức năng validate từ request và gửi dữ liệu trang form thêm danh mục sản phẩm
    public function store(CategoryFormRequest $request)
    /**phương thức store() trong một lớp controller, được sử dụng 
     * để xử lý yêu cầu lưu trữ (create) một danh mục sản phẩm mới. */
    {
        $validatedData = $request->validated();
        /**Đây là lấy dữ liệu đã được xác thực từ yêu cầu gửi đến thông qua đối tượng CategoryFormRequest. 
         * Phương thức validated() trả về một mảng chứa các giá trị đã được xác thực theo các quy tắc 
         * được định nghĩa trong CategoryFormRequest. */
        $category = new Category; //Khởi tạo một đối tượng Category mới.
        $category->name = $validatedData['name'];
        /**Dòng này gán giá trị của trường 'name' từ dữ liệu đã được xác thực ($validatedData) cho thuộc tính 'name' 
         * của đối tượng Category. Điều này đảm bảo rằng giá trị của trường 'name' trong đối tượng Category 
         * sẽ là giá trị đã được xác thực. */
        $category->slug = Str::slug($validatedData['slug']);
        /**Trước khi gán giá trị, phương thức Str::slug() được sử dụng để chuyển đổi giá trị của trường 'slug' 
         * thành một chuỗi có định dạng thân thiện với SEO (slug). Ví dụ, chuỗi "Hello World" sẽ được chuyển đổi thành 
         * "hello-world". Điều này giúp đảm bảo rằng giá trị của trường 'slug' trong đối tượng Category 
         * tuân theo quy ước về định dạng slug. */
        $category->description = $validatedData['description'];
        
        $uploadPath = 'uploads/category/';
        if($request->hasFile('image'))
        /**Có một điều kiện kiểm tra xem yêu cầu có chứa tệp tin hình ảnh không ($request->hasFile('image')). 
         * Nếu điều kiện này đúng, các dòng bên trong khối if sẽ được thực thi. */
        {
            $file = $request->file('image');
            /**Dòng này lấy đối tượng tệp tin hình ảnh từ yêu cầu sử dụng phương thức file('image'). Điều này giả định rằng 
             * yêu cầu chứa một trường với tên 'image' để tải lên tệp tin. */
            $ext = $file->getClientOriginalExtension();
            /**Dòng này lấy phần mở rộng của tệp tin gốc bằng phương thức getClientOriginalExtension(). Phần mở rộng 
             * là phần cuối cùng của tên tệp tin, ví dụ như '.png', '.jpg', '.jpeg'. Dòng này giúp lấy được phần mở rộng 
             * của tệp tin để sử dụng cho tên tệp tin mới. */
            $filename = time().'.'.$ext;
            /**Dòng này tạo tên tệp tin mới bằng cách kết hợp thời gian hiện tại (được lấy bằng time()) và phần mở rộng 
             * của tệp tin gốc ($ext). Điều này đảm bảo rằng tên tệp tin mới là duy nhất và không trùng lặp 
             * với các tệp tin khác. */
            $file->move('uploads/category/', $filename);
            /**Dòng này di chuyển tệp tin hình ảnh từ vị trí tạm thời đến thư mục 'uploads/category/' với tên tệp tin mới 
             * đã được tạo ($filename). Điều này đảm bảo rằng tệp tin hình ảnh được lưu trữ ở vị trí mong muốn trên máy chủ. */
            $category->image = $uploadPath.$filename;
            /**Dòng này gán tên tệp tin mới ($filename) cho thuộc tính 'image' của đối tượng Category. 
             * Điều này đảm bảo rằng đối tượng Category lưu trữ tên tệp tin hình ảnh tương ứng. */
        }
        $category->meta_title = $validatedData['meta_title'];
        $category->meta_keyword = $validatedData['meta_keyword'];
        $category->meta_description = $validatedData['meta_description'];
        $category->status = $request->status == true ? '1':'0';
        /**Dòng mã này sử dụng một biểu thức ba ngôi để xác định giá trị của 'status' dựa trên giá trị của status 
         * trong yêu cầu ($request->status). 
         * Nếu giá trị của $request->status là true, có nghĩa là trường 'status' trong yêu cầu đã được chọn hoặc 
         * được đánh dấu, dòng mã sẽ gán giá trị '1' cho thuộc tính 'status' của đối tượng Category. Điều này cho biết rằng 
         * danh mục là 'visible' (có thể hiển thị).
         * Ngược lại, nếu giá trị của $request->status không phải true (có thể là false, null hoặc giá trị khác 
         * không đồng nghĩa với 'true'), dòng mã sẽ gán giá trị '0' cho thuộc tính 'status' của đối tượng Category. 
         * Điều này cho biết rằng danh mục là 'hidden' (ẩn).*/
        $category->save();
        return redirect('admin/category')->with('message', 'Thêm danh mục sản phẩm thành công!');
    }
    /**Phương thức store() này thực hiện các bước xử lý và lưu trữ dữ liệu từ yêu cầu gửi đến và sau đó chuyển hướng 
     * người dùng đến một trang khác và hiển thị thông báo kết quả xử lý. */

    //xây dựng chức năng cho trang chỉnh sửa sản phẩm
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }
    //xây dựng hàm để cập nhật sản phẩm khi chỉnh sửa
    public function update(CategoryFormRequest $request, $category)
    {
        $validatedData = $request->validated();
        
        $category = Category::findOrFail($category);
        /**Hàm Category::findOrFail($category) được sử dụng để tìm kiếm một bản ghi danh mục sản phẩm dựa trên giá trị của 
         * biến $category. Nếu không tìm thấy bản ghi tương ứng, nó sẽ ném ra một ngoại lệ ModelNotFoundException. */
        $category->name = $validatedData['name'];
        /**Dòng này gán giá trị của trường 'name' từ dữ liệu đã được xác thực ($validatedData) cho thuộc tính 'name' 
         * của đối tượng Category. Điều này đảm bảo rằng giá trị của trường 'name' trong đối tượng Category 
         * sẽ là giá trị đã được xác thực. */
        $category->slug = Str::slug($validatedData['slug']);
        /**Trước khi gán giá trị, phương thức Str::slug() được sử dụng để chuyển đổi giá trị của trường 'slug' 
         * thành một chuỗi có định dạng thân thiện với SEO (slug). Ví dụ, chuỗi "Hello World" sẽ được chuyển đổi thành 
         * "hello-world". Điều này giúp đảm bảo rằng giá trị của trường 'slug' trong đối tượng Category 
         * tuân theo quy ước về định dạng slug. */
        $category->description = $validatedData['description'];
        if($request->hasFile('image'))
        /**Có một điều kiện kiểm tra xem yêu cầu có chứa tệp tin hình ảnh không ($request->hasFile('image')). 
         * Nếu điều kiện này đúng, các dòng bên trong khối if sẽ được thực thi. */
        {

            $uploadPath = 'uploads/category/';

            $path = 'uploads/category/'.$category->image;
            /**Dòng $path = 'uploads/category/'.$category->image; tạo đường dẫn tới tệp tin hình ảnh hiện tại của danh mục 
             * sản phẩm. Đường dẫn này được lưu trữ trong biến $path. Ví dụ, nếu tên tệp tin hình ảnh là "example.jpg", 
             * đường dẫn sẽ là "uploads/category/example.jpg". */
            if (File::exists($path)){
                File::delete($path);
            }
            /**Sau đó, trong khối if, dòng if (File::exists($path)) kiểm tra xem tệp tin hình ảnh có tồn tại trong đường dẫn 
             * $path hay không. Nếu tệp tin tồn tại, dòng File::delete($path) sẽ xóa tệp tin đó. Điều này đảm bảo rằng 
             * tệp tin hình ảnh cũ sẽ bị xóa trước khi cập nhật danh mục sản phẩm với hình ảnh mới. */

            $file = $request->file('image');
            /**Dòng này lấy đối tượng tệp tin hình ảnh từ yêu cầu sử dụng phương thức file('image'). Điều này giả định rằng 
             * yêu cầu chứa một trường với tên 'image' để tải lên tệp tin. */
            $ext = $file->getClientOriginalExtension();
            /**Dòng này lấy phần mở rộng của tệp tin gốc bằng phương thức getClientOriginalExtension(). Phần mở rộng 
             * là phần cuối cùng của tên tệp tin, ví dụ như '.png', '.jpg', '.jpeg'. Dòng này giúp lấy được phần mở rộng 
             * của tệp tin để sử dụng cho tên tệp tin mới. */
            $filename = time().'.'.$ext;
            /**Dòng này tạo tên tệp tin mới bằng cách kết hợp thời gian hiện tại (được lấy bằng time()) và phần mở rộng 
             * của tệp tin gốc ($ext). Điều này đảm bảo rằng tên tệp tin mới là duy nhất và không trùng lặp 
             * với các tệp tin khác. */
            $file->move('uploads/category/', $filename);
            /**Dòng này di chuyển tệp tin hình ảnh từ vị trí tạm thời đến thư mục 'uploads/category/' với tên tệp tin mới 
             * đã được tạo ($filename). Điều này đảm bảo rằng tệp tin hình ảnh được lưu trữ ở vị trí mong muốn trên máy chủ. */
            $category->image = $uploadPath.$filename;
            /**Dòng này gán tên tệp tin mới ($filename) cho thuộc tính 'image' của đối tượng Category. 
             * Điều này đảm bảo rằng đối tượng Category lưu trữ tên tệp tin hình ảnh tương ứng. */
        }
        $category->meta_title = $validatedData['meta_title'];
        $category->meta_keyword = $validatedData['meta_keyword'];
        $category->meta_description = $validatedData['meta_description'];
        $category->status = $request->status == true ? '1':'0';
        /**Dòng mã này sử dụng một biểu thức ba ngôi để xác định giá trị của 'status' dựa trên giá trị của status 
         * trong yêu cầu ($request->status). 
         * Nếu giá trị của $request->status là true, có nghĩa là trường 'status' trong yêu cầu đã được chọn hoặc 
         * được đánh dấu, dòng mã sẽ gán giá trị '1' cho thuộc tính 'status' của đối tượng Category. Điều này cho biết rằng 
         * danh mục là 'visible' (có thể hiển thị).
         * Ngược lại, nếu giá trị của $request->status không phải true (có thể là false, null hoặc giá trị khác 
         * không đồng nghĩa với 'true'), dòng mã sẽ gán giá trị '0' cho thuộc tính 'status' của đối tượng Category. 
         * Điều này cho biết rằng danh mục là 'hidden' (ẩn).*/
        $category->update();
        return redirect('admin/category')->with('message', 'Cập nhật danh mục sản phẩm thành công!');
    }
}
