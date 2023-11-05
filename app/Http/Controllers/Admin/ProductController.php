<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFormRequest;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }

    //xây dựng tính năng thêm sản phẩm
    public function create()
    {
        $categories = Category::all();
        //lấy toàn bộ dữ liệu của danh mục sản phẩm
        $brands = Brand::all();
        //lấy toàn bộ dữ liệu của thương hiệu sản phẩm

        //tạo chức năng thêm màu sắc sản phẩm
        $colors = Color::where('status', '0')->get();
        /**Color::where('status','0'): Đây là một truy vấn để lấy các bản ghi từ bảng Color trong cơ sở dữ liệu. Hàm where 
         * được sử dụng để áp dụng điều kiện cho trường status là '0'. Điều này có nghĩa là chỉ các bản ghi có giá trị 
         * trường status là '0' sẽ được lấy.
         * ->get(): Phương thức get() được gọi để thực hiện truy vấn và trả về tất cả các bản ghi phù hợp với điều kiện 
         * đã được chỉ định trong hàm where.
         * Kết quả của truy vấn này sẽ là một collection chứa tất cả các bản ghi màu sắc sản phẩm có trạng thái '0'. Sau đó, 
         * biến $colors được gán giá trị của collection này để sử dụng trong quá trình xây dựng giao diện người dùng (view). */
        return view('admin.products.create', compact('categories', 'brands', 'colors'));
    }
    //tạo chức năng validate từ request và gửi dữ liệu trang form thêm sản phẩm
    public function store(ProductFormRequest $request)
    {
        $validatedData = $request->validated();
        /**Dòng này lấy dữ liệu đã được xác thực từ $request. Phương thức validated() trả về một mảng chứa các giá trị đã 
         * được xác thực theo các quy tắc được định nghĩa trong ProductFormRequest. */
        $category = Category::findOrFail($validatedData['category_id']);
        /**Dòng này lấy đối tượng Category từ cơ sở dữ liệu dựa trên category_id đã xác thực từ $validatedData. Phương thức 
         * findOrFail() tìm kiếm đối tượng theo khóa chính (id) và nếu không tìm thấy sẽ ném ra một ngoại lệ 
         * ModelNotFoundException. */
        $product = $category->products()->create([
            /**Dòng này tạo một đối tượng Product mới trong cơ sở dữ liệu và liên kết nó với Category đã lấy được trước đó. 
             * Phương thức create() là một phương thức kế thừa từ lớp Model của Laravel và tạo một bản ghi mới trong cơ sở 
             * dữ liệu. Đối số truyền vào là một mảng chứa các giá trị để gán cho các trường trong bản ghi. */
            'category_id'  => $validatedData['category_id'],
            'name'  => $validatedData['name'],
            'slug'  => Str::slug($validatedData['slug']),
            /**Gán giá trị slug của $validatedData['slug'] cho trường 'slug'. Hàm Str::slug() sẽ chuyển đổi chuỗi thành một 
             * slug hợp lệ, phục vụ cho việc tạo URL thân thiện với SEO. */
            'brand' => $validatedData['brand'],
            'small_description' => $validatedData['small_description'],
            'description' => $validatedData['description'],
            'original_price' => $validatedData['original_price'],
            'selling_price' => $validatedData['selling_price'],
            'quantity' => $validatedData['quantity'],
            'trending' => $request->trending == true ? '1' : '0',
            'featured' => $request->featured == true ? '1' : '0',
            'status' => $request->status == true ? '1' : '0',
            /**Gán giá trị cho trường 'status' dựa trên giá trị của $request->status. Tương tự như trường 'trending', 
             * nếu $request->status là true, thì trường 'status' sẽ được gán giá trị '1', ngược lại nếu là false, thì sẽ 
             * được gán giá trị '0'. */
            'meta_title' => $validatedData['meta_title'],
            'meta_keyword' => $validatedData['meta_keyword'],
            'meta_description' => $validatedData['meta_description'],
        ]);

        if ($request->hasFile('image'))
        /**kiểm tra xem có tệp tin 'image' được tải lên hay không. */
        {
            $uploadPath = 'uploads/products/';
            /**đường dẫn nơi tệp tin sẽ được lưu trữ. Trong trường hợp này, tệp tin được tải lên sẽ được lưu trong thư mục 
             * 'uploads/products'. */
            $i = 1;
            /**là để tăng số lần upload file theo trình tự */
            foreach ($request->file('image') as $imageFile)
            /**lặp qua các tệp tin 'image' được tải lên */
            {
                $extention = $imageFile->getClientOriginalExtension();
                /**lấy phần mở rộng của tệp tin gốc (ví dụ: jpg, png, ...). */
                $filename = time() . $i++ . '.' . $extention;
                /**tạo tên tệp tin mới bằng việc kết hợp thời gian hiện tại và phần mở rộng của tệp tin gốc. Điều này đảm bảo tên tệp tin là duy nhất. */
                $imageFile->move($uploadPath, $filename);
                //di chuyển tệp tin tải lên vào đường dẫn đích.
                $finalImagePathName = $uploadPath . $filename;
                /**lưu đường dẫn cuối cùng của tệp tin đã được tải lên. */

                $product->productImages()->create([
                    /**tạo một bản ghi mới trong bảng 'productImage' và liên kết nó với sản phẩm hiện tại. */
                    'product_id' => $product->id,
                    /**gán giá trị của $product->id cho trường 'product_id' trong bảng 'productImage'. Điều này tạo liên kết giữa 
                     * sản phẩm và hình ảnh của nó. */
                    'image' => $finalImagePathName,
                    /**gán giá trị của $finalImagePathName cho trường 'image' trong bảng 'productImage'. Đây là đường dẫn tệp tin 
                 * cuối cùng đã được tải lên và lưu trữ. */
                ]);
            }
            /**Với mỗi tệp tin 'image' được tải lên, nó sẽ di chuyển tệp tin đó vào thư mục 'uploads/products' và lưu đường 
             * dẫn cuối cùng vào biến $finalImagePathName. */
        }

        //tạo chức năng gửi dữ liệu màu sắc sản phẩm và số lượng sản phẩm
        if ($request->colors)
        /** Kiểm tra xem $request->colors có tồn tại hay không. $request->colors đề cập đến giá trị được gửi từ form với 
         * thuộc tính name là "colors". Nếu giá trị này tồn tại, điều kiện trong khối if sẽ được thực hiện. */
        {
            foreach ($request->colors as $key => $color)
            /**Bắt đầu vòng lặp foreach để lặp qua mảng $request->colors. Biến $key(colors[{{ $coloritem->id }}]) đại diện cho 
             * khóa của mảng và $color đại diện cho giá trị tại khóa đó. */
            {
                $product->productColors()->create([
                    /**Gọi phương thức productColors() trên đối tượng $product để tạo một bản ghi mới trong bảng 
                     * "product_colors". Phương thức này trả về một đối tượng Builder cho phép chúng ta tạo một bản ghi 
                     * liên quan. */
                    'product_id' => $product->id,
                    /**Gán giá trị của cột "product_id" trong bảng "product_colors" bằng giá trị ID của sản phẩm hiện tại. */
                    'color_id' => $color,
                    /**Gán giá trị của cột "color_id" trong bảng "product_colors" bằng giá trị màu sắc được lặp qua trong 
                     * vòng lặp. */
                    'quantity' => $request->colorquantity[$key] ?? 0
                    /**Gán giá trị của cột "quantity" trong bảng "product_colors" bằng giá trị số lượng sản phẩm tương ứng 
                 * với màu sắc. Giá trị này được lấy từ mảng $request->colorquantity với khóa tương ứng là 
                 * $key(colorquantity[{{ $coloritem->id }}). Nếu không có giá trị tương ứng, mặc định sẽ là 0. */
                ]);
            }
        }
        return redirect('/admin/products')->with('message3', 'Thêm sản phẩm thành công!');
    }

    //xây dựng chức năng chỉnh sửa sản phẩm
    public function edit(int $category_id)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product = Product::findOrFail($category_id);
        /**có nhiệm vụ tìm kiếm một sản phẩm cụ thể dựa trên product_id được truyền vào và gán kết quả vào biến 
         * $product. Nếu sản phẩm không tồn tại, phương thức findOrFail sẽ ném ra một ngoại lệ ModelNotFoundException. */

        //Xây dựng chức năng thêm màu sắc
        $product_color = $product->productColors->pluck('color_id')->toArray();
        /**Trong đoạn này, $product là một đối tượng sản phẩm.
         * $product->productColors đề cập đến một quan hệ (relationship) "productColors" trên đối tượng $product. Đây có thể 
         * là một quan hệ "one-to-many" (một sản phẩm có thể có nhiều màu sắc) hoặc "many-to-many" (một sản phẩm có thể 
         * thuộc nhiều màu sắc và ngược lại).
         * pluck('color_id') lấy ra giá trị của cột 'color_id' từ tất cả các bản ghi trong quan hệ "productColors" và trả về 
         * một Collection chứa các giá trị này.
         * toArray() chuyển đổi Collection thành một mảng.
         */
        $colors = Color::whereNotIn('id', $product_color)->get();
        /**Color::whereNotIn('id', $product_color) là một truy vấn dữ liệu trên mô hình "Color" để lấy ra các màu sắc không 
         * nằm trong danh sách $product_color đã thu thập ở trên.
         * whereNotIn('id', $product_color) xác định điều kiện truy vấn, trong trường hợp này, nó tìm các bản ghi trong bảng 
         * "colors" (được đại diện bởi mô hình "Color") có cột 'id' không nằm trong mảng $product_color.
         * get() thực thi truy vấn và trả về một Collection chứa các màu sắc phù hợp với điều kiện. */
        return view('admin.products.edit', compact('categories', 'brands', 'product', 'colors'));
    }

    //xây dựng tính năng cập nhật sản phẩm khi gửi dữ liệu form
    public function update(ProductFormRequest $request, int $product_id)
    {
        $validatedData = $request->validated();

        $product = Category::findOrFail($validatedData['category_id'])
            /**Đây là một phương thức tĩnh trong model Category (giả sử là một model trong Laravel). findOrFail() là 
             * một phương thức có sẵn trong Laravel Eloquent ORM, được sử dụng để tìm một bản ghi trong cơ sở dữ liệu 
             * dựa trên một điều kiện. Trong trường hợp này, nó tìm kiếm một bản ghi trong bảng categories với giá trị 
             * id tương ứng với $validatedData['category_id']. */
            ->products()
            /**Đây là một phương thức tương ứng với một mối quan hệ trong model Category. Nó trả về 
             * một đối tượng quan hệ của mô hình Product. Điều này giả định rằng có một mối quan hệ 
             * "sản phẩm thuộc về danh mục" đã được xác định trong model Category. */
            ->where('id', $product_id)
            /**Đây là một điều kiện truy vấn dùng để lọc kết quả của mối quan hệ "sản phẩm thuộc về 
             * danh mục". Nó giới hạn kết quả chỉ chứa bản ghi với giá trị id tương ứng với 
             * $product_id. */
            ->first();
        /**Đây là một phương thức để trả về bản ghi đầu tiên tìm thấy trong kết quả truy vấn. 
         * Trong trường hợp này, nó trả về một đối tượng Product đại diện cho sản phẩm cần 
         * cập nhật. */
        /**Về cơ bản, đoạn mã trên tìm kiếm một sản phẩm trong một danh mục được chỉ định 
         * ($validatedData['category_id']) với một id cụ thể ($product_id). Nếu tìm thấy sản phẩm, nó sẽ gán đối 
         * tượng sản phẩm vào biến $product để tiếp tục xử lý trong phần còn lại của hàm update(). */
        if ($product) {
            $product->update([
                'category_id'  => $validatedData['category_id'],
                'name'  => $validatedData['name'],
                'slug'  => Str::slug($validatedData['slug']),
                /**Gán giá trị slug của $validatedData['slug'] cho trường 'slug'. Hàm Str::slug() sẽ chuyển đổi chuỗi thành một 
                 * slug hợp lệ, phục vụ cho việc tạo URL thân thiện với SEO. */
                'brand' => $validatedData['brand'],
                'small_description' => $validatedData['small_description'],
                'description' => $validatedData['description'],
                'original_price' => $validatedData['original_price'],
                'selling_price' => $validatedData['selling_price'],
                'quantity' => $validatedData['quantity'],
                'trending' => $request->trending == true ? '1' : '0',
                'featured' => $request->featured == true ? '1' : '0',
                'status' => $request->status == true ? '1' : '0',
                /**Gán giá trị cho trường 'status' dựa trên giá trị của $request->status. Tương tự như trường 'trending', 
                 * nếu $request->status là true, thì trường 'status' sẽ được gán giá trị '1', ngược lại nếu là false, thì sẽ 
                 * được gán giá trị '0'. */
                'meta_title' => $validatedData['meta_title'],
                'meta_keyword' => $validatedData['meta_keyword'],
                'meta_description' => $validatedData['meta_description'],
            ]);

            if ($request->hasFile('image'))
            /**kiểm tra xem có tệp tin 'image' được tải lên hay không. */
            {
                $uploadPath = 'uploads/products/';
                /**đường dẫn nơi tệp tin sẽ được lưu trữ. Trong trường hợp này, tệp tin được tải lên sẽ được lưu trong thư mục 
                 * 'uploads/products'. */
                $i = 1;
                /**là để tăng số lần upload file theo trình tự */
                foreach ($request->file('image') as $imageFile)
                /**lặp qua các tệp tin 'image' được tải lên */
                {
                    $extention = $imageFile->getClientOriginalExtension();
                    /**lấy phần mở rộng của tệp tin gốc (ví dụ: jpg, png, ...). */
                    $filename = time() . $i++ . '.' . $extention;
                    /**tạo tên tệp tin mới bằng việc kết hợp thời gian hiện tại và phần mở rộng của tệp tin gốc. Điều này đảm bảo tên tệp tin là duy nhất. */
                    $imageFile->move($uploadPath, $filename);
                    //di chuyển tệp tin tải lên vào đường dẫn đích.
                    $finalImagePathName = $uploadPath . $filename;
                    /**lưu đường dẫn cuối cùng của tệp tin đã được tải lên. */

                    $product->productImages()->create([
                        /**tạo một bản ghi mới trong bảng 'productImage' và liên kết nó với sản phẩm hiện tại. */
                        'product_id' => $product->id,
                        /**gán giá trị của $product->id cho trường 'product_id' trong bảng 'productImage'. Điều này tạo liên kết giữa 
                         * sản phẩm và hình ảnh của nó. */
                        'image' => $finalImagePathName,
                        /**gán giá trị của $finalImagePathName cho trường 'image' trong bảng 'productImage'. Đây là đường dẫn tệp tin 
                     * cuối cùng đã được tải lên và lưu trữ. */
                    ]);
                }
                /**Với mỗi tệp tin 'image' được tải lên, nó sẽ di chuyển tệp tin đó vào thư mục 'uploads/products' và lưu đường 
                 * dẫn cuối cùng vào biến $finalImagePathName. */
            }

            //tạo chức năng cập nhật màu sắc sản phẩm
            if ($request->colors)
            /** Kiểm tra xem $request->colors có tồn tại hay không. $request->colors đề cập đến giá trị được gửi từ form với 
             * thuộc tính name là "colors". Nếu giá trị này tồn tại, điều kiện trong khối if sẽ được thực hiện. */
            {
                foreach ($request->colors as $key => $color)
                /**Bắt đầu vòng lặp foreach để lặp qua mảng $request->colors. Biến $key(colors[{{ $coloritem->id }}]) đại diện cho 
                 * khóa của mảng và $color đại diện cho giá trị tại khóa đó. */
                {
                    $product->productColors()->create([
                        /**Gọi phương thức productColors() trên đối tượng $product để tạo một bản ghi mới trong bảng 
                         * "product_colors". Phương thức này trả về một đối tượng Builder cho phép chúng ta tạo một bản ghi 
                         * liên quan. */
                        'product_id' => $product->id,
                        /**Gán giá trị của cột "product_id" trong bảng "product_colors" bằng giá trị ID của sản phẩm hiện tại. */
                        'color_id' => $color,
                        /**Gán giá trị của cột "color_id" trong bảng "product_colors" bằng giá trị màu sắc được lặp qua trong 
                         * vòng lặp. */
                        'quantity' => $request->colorquantity[$key] ?? 0
                        /**Gán giá trị của cột "quantity" trong bảng "product_colors" bằng giá trị số lượng sản phẩm tương ứng 
                     * với màu sắc. Giá trị này được lấy từ mảng $request->colorquantity với khóa tương ứng là 
                     * $key(colorquantity[{{ $coloritem->id }}). Nếu không có giá trị tương ứng, mặc định sẽ là 0. */
                    ]);
                }
            }

            return redirect('/admin/products')->with('message3', 'Cập nhật sản phẩm thành công!');
        } else {
            return redirect('admin/products')->with('message3', 'Không tìm sản phẩm nào!');
        }
    }

    //tạo chức năng xóa ảnh sản phẩm
    public function destroyImage(int $product_image_id)
    //Hàm destroyImage nhận một tham số $product_image_id đại diện cho ID của ảnh sản phẩm cần xóa.
    {
        $productImage = ProductImage::findOrFail($product_image_id);
        /**truy vấn và lấy đối tượng ProductImage tương ứng với $product_image_id. Nếu không tìm thấy, nó sẽ ném một 
         * ngoại lệ ModelNotFoundException. */
        if (File::exists($productImage->image)) {
            //kiểm tra xem tập tin ảnh thực sự tồn tại trên đĩa hay không.
            File::delete($productImage->image);
            //Nếu tập tin ảnh tồn tại, dòng File::delete($productImage->image); sẽ xóa tập tin ảnh khỏi đĩa.
        }
        $productImage->delete();
        //xóa đối tượng ProductImage khỏi cơ sở dữ liệu.
        return redirect()->back()->with('message3', 'Đã xóa ảnh sản phẩm thành công!');
        /**có chức năng chuyển hướng người dùng trở lại trang trước đó và gắn một thông báo thành công với 
         * key 'message3'.*/
    }

    //tạo chức năng xóa sản phẩm
    public function destroy(int $product_id)
    {
        $product = Product::findOrFail($product_id);
        if ($product->productImages) {
            foreach ($product->productImages as $image) {
                if (File::exists($image->image)) {
                    File::delete($image->image);
                }
            }
        }
        /**Chúng ta kiểm tra xem sản phẩm có ảnh sản phẩm hay không bằng cách sử dụng $product->productImages. 
         * Nếu có, chúng ta sử dụng vòng lặp foreach để duyệt qua từng ảnh sản phẩm ($image) của sản phẩm và kiểm 
         * tra xem tập tin ảnh có tồn tại trên đĩa không (File::exists($image->image)). Nếu tập tin ảnh tồn tại, 
         * chúng ta sẽ xóa tập tin đó khỏi đĩa bằng File::delete($image->image). */
        $product->delete();
        //xóa đối tượng Product khỏi cơ sở dữ liệu.
        return redirect()->back()->with('message3', 'Đã xóa sản phẩm và ảnh sản phẩm thành công!');
    }

    //tạo chức năng cập nhật số lượng màu sắc sản phẩm
    public function updateProdColorQty(Request $request, $prod_color_id)
    /**Đây là phương thức trong controller được định nghĩa để xử lý yêu cầu cập nhật số lượng màu sắc của sản phẩm. Nó nhận 
     * hai tham số: $request là đối tượng Request chứa dữ liệu gửi lên từ phía client, và $prod_color_id là ID của màu sắc 
     * sản phẩm cần cập nhật. */
    {
        $productColorData = Product::findOrFail($request->product_id)->productColors()->where('id', $prod_color_id)->first();
        /**Dòng này lấy đối tượng sản phẩm thông qua ID sản phẩm ($request->product_id). Sau đó, qua mối quan hệ 
         * "productColors()" của sản phẩm, nó tìm kiếm màu sắc sản phẩm với ID là $prod_color_id. Phương thức first() trả về 
         * kết quả đầu tiên tìm thấy. */
        $productColorData->update([
            'quantity' => $request->qty
        ]);
        /**Dòng này cập nhật số lượng màu sắc sản phẩm bằng cách gọi phương thức update() trên đối tượng $productColorData. 
         * Trong trường hợp này, chỉ có thuộc tính 'quantity' được cập nhật, giá trị được lấy từ $request->qty. */
        return response()->json(['message' => 'Số lượng màu sắc sản phẩm đã được cập nhật!']);
        /**Dòng này trả về một phản hồi JSON chứa một mảng với thuộc tính 'message' thông báo rằng số lượng màu sắc sản phẩm 
         * đã được cập nhật thành công. */
    }

    //tạo chức năng xóa màu sắc sản phẩm bằng ajax
    public function deleteProdColor($prod_color_id)
    {
        try {
            // Tìm kiếm màu sắc sản phẩm với ID đã cung cấp
            $prodColor = ProductColor::findOrFail($prod_color_id);
            // Xóa màu sắc sản phẩm
            $prodColor->delete();

            // Trả về phản hồi JSON với thông báo thành công
            return response()->json(['message' => 'Đã xóa màu sắc sản phẩm này!']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Xử lý ngoại lệ nếu không tìm thấy màu sắc sản phẩm
            return response()->json(['message' => 'Không tìm thấy màu sắc sản phẩm.'], 404);
        } catch (\Exception $e) {
            // Xử lý ngoại lệ khác (nếu có) trong quá trình xóa màu sắc sản phẩm
            return response()->json(['message' => 'Lỗi: Không thể xóa màu sắc sản phẩm.'], 500);
        }
    }
}
