<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //giao diện trang chủ
    public function index()
    {
        $sliders = Slider::where('status', '0')->get();
        //Giao diện sản phẩm phổ biến 
        $trendingProducts = Product::where('trending', '1')->latest()->take(15)->get();
        /**Product::where('trending', '1'): Đây là một câu truy vấn dùng để chọn các bản ghi trong bảng "Product" (giả sử "Product" là một bảng trong cơ sở dữ liệu) mà có trường "trending" có 
         * giá trị là 1. Trường "trending" có thể là một trường dữ liệu kiểu boolean hoặc là một trường lưu trạng thái nổi bật của sản phẩm.
         * latest(): Phương thức này được gọi trên kết quả của câu truy vấn trước đó và nó sắp xếp các bản ghi theo trường "created_at" theo thứ tự mới nhất. Trường "created_at" là một trường 
         * dữ liệu đặc biệt trong Laravel tự động ghi lại thời gian khi một bản ghi được tạo.
         * Phương thức này giới hạn số lượng bản ghi trả về, chỉ lấy 15 bản ghi đầu tiên. Nếu có nhiều hơn 15 sản phẩm "trending", chỉ có 15 sản phẩm mới nhất được lấy.
         * Kết quả cuối cùng là một bộ sưu tập (collection) chứa 15 bản ghi sản phẩm mới nhất và nổi bật được lấy từ cơ sở dữ liệu, và biến $trendingProducts sẽ giữ bộ sưu tập này để sử dụng 
         * trong giao diện trang chủ. */
        //Giao diện danh mục sản phẩm 
        $categories = Category::where('status', '0')->get();
        //giao diện các sản phẩm mới
        $newArrivalsProducts = Product::latest()->take(14)->get();
        //giao diện sản phẩm nổi bật
        $featuredProducts = Product::where('featured', '1')->latest()->take(14)->get();
        return view('frontend.index', compact('sliders', 'trendingProducts', 'categories', 'newArrivalsProducts', 'featuredProducts'));
    }

    //giao diện tìm kiếm sản phẩm
    public function searchProducts(Request $request)
    {
        if($request->search){
        /**Điều kiện kiểm tra xem nếu giá trị search được gửi từ trình duyệt thông qua yêu cầu ($request) tồn tại và không rỗng, thì tiến hành tìm kiếm sản phẩm. */
            $searchProducts = Product::where('name', 'LIKE', '%'.$request->search.'%')->latest()->paginate(5);
            /**Dòng này sử dụng Eloquent ORM để tìm kiếm các sản phẩm dựa trên tên sản phẩm.
             * Product::where('name', 'LIKE', '%'.$request->search.'%'): Đây là câu truy vấn để lấy các sản phẩm có tên chứa đoạn văn bản được cung cấp trong biến $request->search. 
             * Phần 'LIKE', '%'.$request->search.'%' sử dụng để tìm kiếm tên sản phẩm chứa chuỗi cụ thể.
             * ->latest(): Điều này sắp xếp các kết quả theo thứ tự mới nhất (dựa trên thời gian tạo/chỉnh sửa).
             * ->paginate(15): Kết quả được chia thành các trang, mỗi trang chứa tối đa 15 sản phẩm. Điều này giúp quản lý và hiển thị dữ liệu dễ dàng hơn. */
            return view('frontend.pages.search', compact('searchProducts'));
        }else{
            return redirect()->back()->with('message', 'Không tìm thấy kết quả nào. Hãy thử sử dụng các từ khóa chung chung hơn');
        }
    }
    
    //giao diện các sản phẩm mới
    public function newArrival()
    {
        $newArrivalsProducts = Product::latest()->take(16)->get();
        /**Đoạn này thực hiện truy vấn CSDL để lấy danh sách các sản phẩm mới nhất. Đầu tiên, nó sử dụng model Product để tạo một truy vấn. Product có thể là tên model của các bảng chứa thông 
         * tin về sản phẩm trong CSDL của bạn.
         * latest() sắp xếp các sản phẩm theo thời gian tạo mới nhất (hoặc cập nhật mới nhất) trước. Sau đó, take(16) giới hạn kết quả chỉ lấy 16 sản phẩm mới nhất. Cuối cùng, get() thực thi 
         * truy vấn và trả về một bộ sưu tập (collection) chứa các sản phẩm mới nhất. */
        return view('frontend.pages.new-arrival', compact('newArrivalsProducts'));
    }

    //giao diện các sản phẩm nổi bật
    public function featuredProducts()
    {
        $featuredProducts = Product::where('featured', '1')->latest()->get();
        /**Đoạn này truy vấn vào cơ sở dữ liệu để lấy các sản phẩm được đánh dấu là "nổi bật" (featured) trong bảng Product. Product là một model trong Laravel, đại diện cho 
         * bảng sản phẩm trong cơ sở dữ liệu.
         * Product::where('featured', '1'): Điều này chỉ định điều kiện để lấy các sản phẩm có trường featured có giá trị là 1, nghĩa là các sản phẩm nổi bật.
         * latest(): Phương thức latest() được sử dụng để sắp xếp kết quả theo thứ tự mới nhất (theo thời gian tạo ra). */
        return view('frontend.pages.featured-products', compact('featuredProducts'));
    }

    //giao diện danh mục sản phẩm
    public function categories()
    {
        $categories = Category::where('status', '0')->get();
        return view('frontend.collections.category.index', compact('categories'));
    }

    //giao diện phân loại các danh mục sản phẩm
    public function products($category_slug)
    {
        $category = Category::where('slug',$category_slug)->first();
        /**tìm kiếm một bản ghi từ bảng categories trong cơ sở dữ liệu với trường slug khớp với giá trị của biến 
         * $category_slug. Hàm first() trả về bản ghi đầu tiên tìm thấy hoặc null nếu không tìm thấy. */
        if($category){
        /**Tiếp theo, if($category) kiểm tra xem biến $category có tồn tại hay không. Nếu tồn tại, điều này có nghĩa 
         * là một danh mục được tìm thấy với slug tương ứng. */
            return view('frontend.collections.products.index', compact('category'));
        }else{
            return redirect()->back();
            //được sử dụng để chuyển hướng ngược trở lại trang trước đó nếu không tìm thấy danh mục.
        }
    }

    //giao diện thông tin chi tiết từng sản phẩm
    public function productView(string $category_slug, string $product_slug)
    /**Phương thức này nhận vào hai tham số là $category_slug và $product_slug, đại diện cho slug của danh mục và slug của 
     * sản phẩm. */
    {
        $category = Category::where('slug',$category_slug)->first();
        /**tìm kiếm một bản ghi từ bảng categories trong cơ sở dữ liệu với trường slug khớp với giá trị của biến 
         * $category_slug. Hàm first() trả về bản ghi đầu tiên tìm thấy hoặc null nếu không tìm thấy. */
        if($category){
        /**Tiếp theo, if($category) kiểm tra xem biến $category có tồn tại hay không. Nếu tồn tại, điều này có nghĩa 
         * là một danh mục được tìm thấy với slug tương ứng. */
            $product = $category->products()->where('slug', $product_slug)->where('status', '0')->first();
            /** Dòng này kiểm tra xem sản phẩm có thuộc danh mục đã tìm thấy và có trạng thái '0' hay không. Phương thức 
             * first() để lấy ra kết quả đầu tiên (sản phẩm đầu tiên) từ câu truy vấn. Phương thức này trả về một đối tượng 
             * Product hoặc null nếu không có kết quả nào.
             * Tổng cộng, đoạn mã trên có tác dụng lấy ra sản phẩm đầu tiên từ một danh mục ($category) dựa trên giá trị của 
             * trường 'slug' và trường 'status' của sản phẩm. */
            if ($product) {
            /**Dòng này kiểm tra xem biến $product có tồn tại hay không. Nếu tồn tại, điều này có nghĩa là đã tìm thấy 
             * sản phẩm trong danh mục và có trạng thái '0'. */
                return view('frontend.collections.products.view', compact('product','category'));
                /**Dòng này trả về giao diện 'frontend.collections.products.view' và truyền biến 'category' vào giao diện để 
                 * hiển thị thông tin chi tiết sản phẩm. */
            }else{
                return redirect()->back();
                /**Dòng này chuyển hướng ngược trở lại trang trước đó nếu không tìm thấy sản phẩm hoặc danh mục. */
            }
        }else{
            return redirect()->back();
            //được sử dụng để chuyển hướng ngược trở lại trang trước đó nếu không tìm thấy danh mục.
        }
    }

    //giao diện nói lời cảm ơn đến khách hàng khi đã mua hàng
    public function thankyou()
    {
        return view('frontend.thank-you');
    }
}
