<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderFormRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    //giao diện thanh trượt sản phẩm
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.slider.index', compact('sliders'));
    }

    //tạo chức năng thêm thanh trượt sản phẩm
    public function create()
    {
        return view('admin.slider.create');
    }

    //tạo chức năng gửi dữ liệu khi thêm thanh trượt sản phẩm
    public function store(SliderFormRequest $request)
    {
        $validatedData = $request->validated();

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/slider', $filename);
            $validatedData['image'] = "uploads/slider/$filename";
            /**Đoạn mã này xử lý việc lưu tên file ảnh được tải lên vào một trường dữ liệu "image" trong mảng 
             * $validatedData. Gán đường dẫn tới file ảnh vào trường "image" của mảng $validatedData. Điều này cho 
             * phép lưu đường dẫn tới file ảnh trong cơ sở dữ liệu khi tạo mới một đối tượng Slider.  */
        }
        
        $validatedData['status'] = $request->status == true ? '1':'0';

        Slider::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'],
            'status' => $validatedData['status']
        ]);
        return redirect('admin/sliders')->with('message', 'Đã thêm thanh trượt sản phẩm thành công!');
    }

    //tạo chức năng chỉnh sửa thanh trượt sản phẩm
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    //tạo chức năng cập nhật thanh trượt sản phẩm
    public function update(SliderFormRequest $request,Slider $slider)
    {   
        $validatedData = $request->validated();

        if($request->hasFile('image')){
            $destination = $slider->image;
            //biến $destination được gán bằng giá trị của trường dữ liệu image trong đối tượng $slider.
            if(File::exists($destination))
            /**Đoạn mã kiểm tra xem tập tin có tồn tại tại đường dẫn $destination hay không bằng cách sử dụng 
             * phương thức File::exists(). */
            {
                File::delete($destination);
                //Nếu tập tin tồn tại, thì đoạn mã File::delete($destination) được sử dụng để xóa tập tin đó.
            }
            /**Mục đích của việc này là xóa tập tin ảnh cũ của đối tượng $slider trước khi cập nhật bằng ảnh mới. 
             * Điều này đảm bảo chỉ có một tập tin ảnh duy nhất được lưu trữ cho mỗi đối tượng Slider. */
            
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/slider', $filename);
            $validatedData['image'] = "uploads/slider/$filename";
            /**Đoạn mã này xử lý việc lưu tên file ảnh được tải lên vào một trường dữ liệu "image" trong mảng 
             * $validatedData. Gán đường dẫn tới file ảnh vào trường "image" của mảng $validatedData. Điều này cho 
             * phép lưu đường dẫn tới file ảnh trong cơ sở dữ liệu khi tạo mới một đối tượng Slider.  */
        }
        
        $validatedData['status'] = $request->status == true ? '1':'0';

        Slider::where('id', $slider->id)->update([
        /**phương thức where('id', $slider->id) sẽ tìm đối tượng Slider trong cơ sở dữ liệu có id tương ứng với 
         * $slider->id. */
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'] ?? $slider->image,
            /**Toán tử ?? được sử dụng để kiểm tra nếu $validatedData['image'] tồn tại và không null. Nếu có, giá 
             * trị của $validatedData['image'] sẽ được sử dụng. Nếu không, giá trị của $slider->image sẽ được 
             * sử dụng thay thế.
             * $slider->image là giá trị hiện tại của trường 'image' trong đối tượng $slider. Điều này giả sử rằng 
             * $slider là một đối tượng Slider đã được truyền vào phương thức update.
             * Về cơ bản, dòng này kiểm tra nếu có giá trị mới được truyền vào cho trường 'image' 
             * (từ $validatedData['image']), nó sẽ được cập nhật. Nếu không, giá trị hiện tại của trường 'image' 
             * trong đối tượng $slider sẽ được giữ nguyên. */
            'status' => $validatedData['status']
        ]);
        /**Sau đó, phương thức update() được gọi để cập nhật các trường dữ liệu của đối tượng Slider đã tìm thấy. 
         * Các trường dữ liệu (title, description, image, status) sẽ được cập nhật với các giá trị tương ứng từ 
         * mảng $validatedData. */
        return redirect('admin/sliders')->with('message', 'Đã cập nhật thanh trượt sản phẩm thành công!');
    }

    //tạo chức xóa thanh trượt sản phẩm
    public function destroy(Slider $slider)
    {
        if ($slider->count() > 0){
        /**Kiểm tra xem số lượng bản ghi trong đối tượng $slider có lớn hơn 0 hay không. Điều này giả định rằng 
         * $slider là một collection hoặc query builder object có phương thức count(). */
            $destination = $slider->image;
            /**Gán giá trị của thuộc tính image trong đối tượng $slider cho biến $destination. Điều này giả sử rằng 
             * $slider có một thuộc tính image lưu trữ đường dẫn đến hình ảnh của thanh trượt. */
            if(File::exists($destination)){
            /**Kiểm tra xem tệp tin được chỉ định bởi biến $destination có tồn tại hay không. Đây là một kiểm tra 
             * xem liệu hình ảnh có tồn tại trước khi xóa nó hay không. */
                File::delete($destination);
                /**Xóa tệp tin được chỉ định bởi biến $destination sử dụng phương thức delete() từ lớp File. 
                 * Điều này giả sử rằng ứng dụng sử dụng lớp File để thao tác với tệp tin. */
            }
            $slider->delete();
            /**Xóa đối tượng $slider khỏi cơ sở dữ liệu. Điều này giả sử rằng $slider là một model được kế thừa từ 
             * lớp Eloquent để thao tác với cơ sở dữ liệu. */
            return redirect('admin/sliders')->with('message', 'Đã xóa thanh trượt sản phẩm thành công!');
        }
        return redirect('admin/sliders')->with('message', 'Đã xóa toàn bộ thanh trượt sản phẩm thành công!');
        /**Trường hợp không có bản ghi trong $slider, phương thức sẽ chuyển hướng người dùng đến trang 
         * 'admin/sliders' và gắn thông báo 'Đã xóa toàn bộ thanh trượt sản phẩm thành công!' vào session. Điều 
         * này giả định rằng phương thức count() trên đối tượng $slider trả về 0. */
    }
}
