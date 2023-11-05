<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public $products, $category, $brandInputs = [], $priceInput;
    /**2 Biến này được sử dụng để lưu trữ danh sách sản phẩm và đại diện cho một danh mục sản phẩm cụ thể. */

    protected $queryString = [
        'brandInputs' => ['except' => '', 'as' => 'brand'],
        //rút ngắn cái url khi lọc sản phẩm với tên đường dẫn mong muốn
        'priceInput' => ['except' => '', 'as' => 'price'],
    ];
    /**Trong Livewire, biến "$queryString" có thể được sử dụng để lưu trữ dữ liệu giữa các tương tác với các thành 
     * phần Livewire. Biến này được khởi tạo và quản lý bởi Livewire và được cập nhật tự động dựa trên các tương 
     * tác của người dùng.
     * Biến "$brandInputs" sẽ chứa giá trị của phần tử có khóa là "brandInputs" trong biến "$queryString" của 
     * thành phần Livewire hiện tại. Điều này cho phép bạn lấy giá trị được lưu trữ trong "$queryString" và sử 
     * dụng nó trong xử lý logic của thành phần Livewire. */

    public function mount($category)
    {
        $this->category = $category;
    }
    /**Hàm mount() là một hàm khởi tạo của component Livewire. Khi component được khởi tạo, hàm này sẽ được gọi và 
     * nhận vào hai tham số $products và $category. Trong hàm này, giá trị của các tham số này được gán cho biến 
     * tương ứng trong component ($this->products = $products và $this->category = $category). Điều này đảm bảo 
     * rằng giá trị của danh sách sản phẩm và danh mục được lưu trữ trong các biến của component. */

    public function render()
    {
        //chức năng bộ lọc thương hiệu sản phẩm
        $this->products = Product::where('category_id', $this->category->id)
                                    ->when($this->brandInputs, function($q){
                                    /** Đây là một phương thức điều kiện có điều kiện trong Laravel. Nó kiểm tra 
                                     * xem biến $this->brandInputs có tồn tại hay không. Nếu tồn tại, nó sẽ thực 
                                     * thi một hàm callback (truyền vào biến $q) để áp dụng điều kiện lọc thương 
                                     * hiệu vào câu truy vấn. */
                                        $q->whereIn('brand', $this->brandInputs);
                                        /** Đây là một điều kiện lọc thương hiệu. Nó kiểm tra xem trường 'brand' 
                                         * của bảng 'products' có nằm trong danh sách thương hiệu được lưu trữ 
                                         * trong biến $this->brandInputs hay không. */
                                    })
                                    ->when($this->priceInput, function($q){
                                        $q->when($this->priceInput == 'cao-den-thap', function($q2){
                                        /**Đây là một phương thức điều kiện khác trong Laravel. Nó kiểm tra xem 
                                         * biến $this->priceInput có giá trị là 'cao-den-thap' hay không. Nếu có, 
                                         * nó sẽ thực thi một hàm callback (truyền vào biến $q2) để sắp xếp các 
                                         * sản phẩm theo giá bán giảm dần. */
                                            $q2->orderBy('selling_price', 'DESC');
                                            /**Đây là một phương thức trong Laravel để sắp xếp kết quả truy vấn 
                                             * theo trường 'selling_price' (giá bán) theo thứ tự giảm dần (DESC). */
                                        })->when($this->priceInput == 'thap-den-cao', function($q2){
                                        /**Đây là một phương thức điều kiện khác trong Laravel. Nó kiểm tra xem 
                                         * biến $this->priceInput có giá trị là 'thap-den-cao' hay không. Nếu có, 
                                         * nó sẽ thực thi một hàm callback (truyền vào biến $q2) để sắp xếp các 
                                         * sản phẩm theo giá bán tăng dần. */
                                            $q2->orderBy('selling_price', 'ASC');
                                            /**Đây là một phương thức trong Laravel để sắp xếp kết quả truy vấn 
                                             * theo trường 'selling_price' (giá bán) theo thứ tự tăng dần (ASC). */
                                        });
                                    /**Đoạn mã trên sẽ áp dụng điều kiện lọc giá vào câu truy vấn chỉ khi biến 
                                     * $this->priceInput tồn tại và sắp xếp danh sách sản phẩm theo giá bán theo 
                                     * yêu cầu của người dùng. */
                                    })  
                                    ->where('status', '0')
                                    ->get();
        /**Trong đoạn mã, $this->products là một thuộc tính của component được sử dụng để lưu trữ danh sách sản 
         * phẩm sau khi được lọc. Phương thức where được gọi trên mô hình Product để áp dụng các điều kiện lọc. 
         * Điều kiện đầu tiên là 'category_id' bằng với id của danh mục sản phẩm được lưu trữ trong biến 
         * $this->category. Điều kiện thứ hai là 'status' bằng '0', có thể đại diện cho trạng thái không hoạt động 
         * của sản phẩm. */

        return view('livewire.frontend.product.index',[
            'products' => $this->products,
            'category' => $this->category,
        ]);
    }
    /**Hàm render() là một hàm override trong Livewire component và nó được sử dụng để hiển thị giao diện của 
     * component. Trong hàm này, chúng ta trả về một view có tên 'livewire.frontend.product.index'. Đồng thời, 
     * chúng ta truyền một mảng dữ liệu chứa các biến $products và $category vào view. Điều này cho phép view 
     * 'livewire.frontend.product.index' truy cập và sử dụng các giá trị của danh sách sản phẩm và danh mục trong 
     * quá trình hiển thị giao diện. */
}
