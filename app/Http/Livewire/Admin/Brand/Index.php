<?php

namespace App\Http\Livewire\Admin\Brand;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{   
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $slug, $status, $brand_id, $category_id;
    
    //tạo validate cho form
    public function rules() 
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string',
            'category_id' => 'required|integer',
            'status' => 'nullable'
            /**'nullable' được sử dụng để cho phép giá trị của trường 'status' có thể là null. Điều này có nghĩa là trường 
             * 'status' không bắt buộc phải có giá trị và có thể bỏ qua hoặc không nhập giá trị cho nó. Cho phép bạn không 
             * phải yêu cầu trường 'status' phải được điền giá trị khi gửi form. Nếu trường được bỏ trống hoặc không có 
             * giá trị, Laravel sẽ không áp dụng bất kỳ quy tắc nào khác đối với nó.
             * Tóm lại, 'status' => 'nullable' cho phép trường 'status' có thể là null hoặc có giá trị, và không yêu cầu 
             * áp dụng bất kỳ quy tắc xác thực nào khác nếu trường được bỏ trống. */
        ];
    }
    
    //tạo chức năng xóa sạch dữ liệu khi đã gửi dữ liệu vào form, làm mới form
    public function resetInput()
    /**Xóa dữ liệu đã nhập: Khi bạn muốn xóa dữ liệu đã được nhập trong các phần tử input hoặc form, bạn có thể gọi 
     * phương thức resetInput() để đặt lại các thuộc tính tương ứng về NULL. Điều này giúp làm sạch các phần tử input và 
     * chuẩn bị cho việc nhập liệu mới.
     * Sau khi hoàn thành một hành động: Sau khi bạn đã thực hiện một hành động nhất định, như thêm mới hoặc cập nhật dữ 
     * liệu, bạn có thể sử dụng resetInput() để đặt lại các thuộc tính liên quan về giá trị mặc định. Điều này giúp làm 
     * sạch các phần tử input và chuẩn bị cho các hành động tiếp theo.
     * Làm mới trạng thái: Trong một số trường hợp, khi bạn muốn làm mới trạng thái của component Livewire và đặt lại các 
     * thuộc tính về giá trị ban đầu, bạn có thể gọi resetInput() để làm điều này. */
    {
        $this->name = NULL;
        $this->slug = NULL;
        $this->status = NULL;
        $this->brand_id = NULL;
        $this->category_id = NULL;
    }
    /**Làm sạch form: Khi bạn muốn làm sạch dữ liệu đã nhập trong form và đưa các trường về trạng thái rỗng hoặc mặc định, 
     * bạn có thể sử dụng $this->name = NULL;, $this->slug = NULL;, và $this->status = NULL; và $this->brand_id = NULL;.
     * Đặt lại trạng thái: Khi bạn muốn đặt lại trạng thái của component Livewire về trạng thái ban đầu, bạn có thể sử dụng 
     * các dòng mã này để đặt lại các thuộc tính về NULL.
     * Chuẩn bị cho việc nhập liệu mới: Nếu bạn muốn chuẩn bị cho việc nhập liệu mới sau khi đã hoàn thành một hành động, 
     * việc đặt lại các thuộc tính về NULL sẽ làm sạch các trường và chuẩn bị cho việc nhập liệu mới.
     * Tóm lại, đoạn mã $this->name = NULL;, $this->slug = NULL;, và $this->status = NULL;, $this->brand_id = NULL; được sử 
     * dụng để đặt lại giá trị của các thuộc tính trong component Livewire về NULL, đồng thời làm sạch dữ liệu và chuẩn bị 
     * cho việc nhập liệu mới hoặc đặt lại trạng thái. */

    //tạo chức năng xử lý dự liệu khi người dùng ấn lưu form
    public function storeBrand()
    {   
        $validatedData = $this->validate();
        Brand::create([
            'name' => $this->name,
            'slug' =>Str::slug($this->slug),
            'status' =>$this->status == true ? '1':'0',
            /**Nếu giá trị của $this->status là true, tức là đúng, điều kiện $this->status == true sẽ trả về true. 
             * Khi đó, giá trị '1' sẽ được gán cho trường 'status'. Ngược lại, nếu giá trị của $this->status là false, 
             * tức là sai, điều kiện $this->status == true sẽ trả về false. Khi đó, giá trị '0' sẽ được gán cho trường 
             * 'status'. Điều này đảm bảo rằng giá trị của trường 'status' được gán theo quy tắc logic, trong đó '1' 
             * thể hiện trạng thái "kích hoạt" và '0' thể hiện trạng thái "không kích hoạt". */
            'category_id' => $this->category_id
            //chức năng thêm danh mục sản phẩm
        ]);
        session()->flash('message', 'Thêm thương hiệu sản phẩm thành công!');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
        //resetInput() là để làm mới trạng thái của form
    }
    //tạo chức khi click vào thêm thương hiệu sản phẩm nó sẽ không hiện dữ liệu đã sửa ở dưới
    public function closeModal()
    {
        $this->resetInput();
    }

    public function openModal()
    {
        $this->resetInput();
    }

    //tạo chức năng chỉnh sửa thương hiệu sản phẩm, khi ấn sửa sẽ hiện luôn dữ liệu đã cập nhật
    public function editBrand(int $brand_id)
    {
        $this->brand_id = $brand_id;
        /**$this->brand_id = $brand_id; được sử dụng để gán giá trị của biến $brand_id (được truyền vào phương thức 
         * editBrand()) cho thuộc tính brand_id của đối tượng hiện tại. */
        $brand = Brand::findOrFail($brand_id);
        /**Dòng thứ 2 Brand::findOrFail($brand_id) được sử dụng để tìm một bản ghi của mô hình Brand với id tương ứng. 
         * Nếu không tìm thấy bản ghi, nó sẽ ném ra một ngoại lệ ModelNotFoundException.
         * Biến $brand được gán bằng bản ghi tìm thấy ở bước trước. Bạn có thể sử dụng biến này để truy cập và lấy giá trị 
         * của các thuộc tính của đối tượng Brand. */
        $this->name = $brand->name;
        /**$this->name = $brand->name; gán giá trị của thuộc tính name của đối tượng $brand cho thuộc tính name của đối 
         * tượng hiện tại (gọi phương thức này). Điều này giả định rằng editBrand là một phương thức của một lớp hoặc đối 
         * tượng có các thuộc tính name, slug, và status tương ứng. */
        $this->slug = $brand->slug;
        $this->status = $brand->status;
        /**Việc gán giá trị từ $brand cho các thuộc tính của đối tượng hiện tại giúp cập nhật giá trị của đối tượng hiện tại
         * với các giá trị từ bản ghi tương ứng được tìm thấy trong cơ sở dữ liệu. */
        $this->category_id = $brand->category_id;
        //chức năng chỉnh sửa danh mục sản phẩm
    }

    //tạo chức năng cập nhật thương hiệu sản phẩm
    public function updateBrand()
    {   
        $validatedData = $this->validate();
        Brand::findOrFail($this->brand_id)->update([
        /**Brand::findOrFail($this->brand_id)->update([...]); được sử dụng để tìm và cập nhật bản ghi thương hiệu sản phẩm 
         * có id là $this->brand_id. Trong đoạn mã bạn đã cung cấp, các trường dữ liệu được cập nhật là 'name', 'slug', và 
         * 'status'. Giá trị mới của các trường này được lấy từ các thuộc tính của component Livewire, như $this->name, 
         * $this->slug, và $this->status. Phương thức findOrFail() sẽ tìm bản ghi theo id nhưng nếu không tìm thấy, nó sẽ 
         * ném ra một ngoại lệ ModelNotFoundException.*/
            'name' => $this->name,
            'slug' =>Str::slug($this->slug),
            'status' =>$this->status == true ? '1':'0',
            /**Nếu giá trị của $this->status là true, tức là đúng, điều kiện $this->status == true sẽ trả về true. 
             * Khi đó, giá trị '1' sẽ được gán cho trường 'status'. Ngược lại, nếu giá trị của $this->status là false, 
             * tức là sai, điều kiện $this->status == true sẽ trả về false. Khi đó, giá trị '0' sẽ được gán cho trường 
             * 'status'. Điều này đảm bảo rằng giá trị của trường 'status' được gán theo quy tắc logic, trong đó '1' 
             * thể hiện trạng thái "kích hoạt" và '0' thể hiện trạng thái "không kích hoạt". */
            'category_id' => $this->category_id
            //chức năng cập nhật danh mục sản phẩm
        ]);
        session()->flash('message1', 'Cập nhật thương hiệu sản phẩm thành công!');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
        //resetInput() là để làm mới trạng thái của form
    }

    //tạo chức năng xóa thương hiệu sản phẩm
    public function deleteBrand($brand_id)
    {
        $this->brand_id = $brand_id;
    } 
    //tạo chức năng xóa vĩnh viễn thương hiệu sản phẩm
    public function destroyBrand()
    {
        Brand::findOrFail($this->brand_id)->delete();
        /**Brand::findOrFail($this->brand_id)->delete(); được sử dụng để xóa bản ghi thương hiệu sản phẩm từ cơ sở dữ liệu.
         * Brand::findOrFail($this->brand_id) sẽ tìm bản ghi thương hiệu sản phẩm với id tương ứng với giá trị của thuộc 
         * tính brand_id trong đối tượng hiện tại. Nếu không tìm thấy bản ghi, nó sẽ ném ra một ngoại lệ 
         * ModelNotFoundException.
         * Sau đó, phương thức delete() được gọi trên đối tượng Brand đã tìm thấy để thực hiện xóa bản ghi từ cơ sở dữ liệu.
         */
        session()->flash('message2', 'Bạn đã xóa thương hiệu sản phẩm thành công!');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
        //resetInput() là để làm mới trạng thái của form
    }

    //giao diện của trang nhãn hiệu sản phẩm
    public function render()
    {
        //chức năng chọn danh mục sản phẩm
        $categories = Category::where('status', '0')->get();       
        
        $brands = Brand::orderBy('id', 'ASC')->paginate(10);
        return view('livewire.admin.brand.index', ['brands' => $brands, 'categories' => $categories])
                    /**Mảng ['brands' => $brands] được truyền vào view để chuyển đạt dữ liệu brands cho giao diện người dùng. */
                    ->extends('layouts.admin')
                    /**->extends('layouts.admin') sử dụng phương thức extends() để mở rộng layout 'layouts.admin'. 
                     * Bạn cần thay thế 'layouts.admin' bằng tên layout thích hợp cho ứng dụng của bạn. */
                    ->section('content');
                    /**->section('content') sử dụng phương thức section() để chỉ định rằng phần nội dung của trang sẽ được 
                     * đặt trong phần @section('content') trong layout đã mở rộng. */
    }
}
