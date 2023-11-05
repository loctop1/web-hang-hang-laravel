<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ColorFormRequest;
use App\Models\Color;

class ColorController extends Controller
{   
    //giao diện danh sách màu sắc sản phẩm
    public function index()
    {
        $colors = Color::all();
        return view('admin.colors.index', compact('colors'));
    }

    //giao diện thêm màu sắc sản phẩm
    public function create()
    {
        return view('admin.colors.create');
    }

    //tạo chức năng validate từ request và gửi dữ liệu trang form thêm màu sắc sản phẩm
    public function store(ColorFormRequest $request)
    {
        $validatedData = $request->validated();
        //Dòng này lấy dữ liệu đã xác nhận từ đối tượng $request thông qua phương thức validated().
        //Điều này giúp bạn có được các dữ liệu đã được kiểm tra và xác nhận theo quy tắc trong lớp ColorFormRequest.
        $validatedData['status'] = $request->status == true ? '1': '0';
        //Dòng này kiểm tra giá trị của thuộc tính "status" trong đối tượng $request.
        //Nếu giá trị là true, nó sẽ gán giá trị '1' cho phần tử có khóa "status" trong mảng $validatedData.
        //Nếu giá trị là false, nó sẽ gán giá trị '0'.
        Color::create($validatedData);
        //Dòng này sử dụng phương thức tĩnh create() trên lớp Color để tạo một bản ghi mới trong cơ sở dữ liệu.
        //Dữ liệu của bản ghi mới sẽ được lấy từ mảng $validatedData.
        return redirect('admin/colors')->with('message', 'Thêm màu sắc sản phẩm thành công!');
    }
    /**Tóm lại, đoạn mã trên xác nhận và xử lý dữ liệu gửi từ form thêm màu sắc sản phẩm. Sau đó, nó tạo một bản ghi mới 
     * trong cơ sở dữ liệu và chuyển hướng người dùng đến trang danh sách màu sắc sản phẩm, đồng thời hiển thị một thông báo 
     * thành công. */

    //tạo chức năng chỉnh sửa màu sắc sản phẩm
    public function edit(Color $color)
    {   
        return view('admin.colors.edit', compact('color'));
    }

    //tạo chức năng cập nhật màu sắc sản phẩm
    public function update(ColorFormRequest $request, $color_id)
    /**Phương thức này chấp nhận hai tham số: $request có kiểu là ColorFormRequest và $color_id đại diện cho ID của màu sắc 
     * sản phẩm cần cập nhật. */
    {
        $validatedData = $request->validated();
        $validatedData['status'] = $request->status == true ? '1': '0';
        Color::find($color_id)->update($validatedData);
        /**Dòng này sử dụng phương thức tĩnh find() trên lớp Color để tìm kiếm một bản ghi cụ thể trong cơ sở dữ liệu dựa 
         * trên $color_id.
         * Sau đó, phương thức update() được gọi để cập nhật các trường của bản ghi đó với dữ liệu từ mảng $validatedData. */
        return redirect('admin/colors')->with('message', 'Cập nhật màu sắc sản phẩm thành công!');
    }
    /**Tóm lại, đoạn mã trên xác nhận và xử lý dữ liệu gửi từ form cập nhật màu sắc sản phẩm. Sau đó, nó tìm kiếm và cập nhật 
     * bản ghi tương ứng trong cơ sở dữ liệu và chuyển hướng người dùng đến trang danh sách màu sắc sản phẩm, đồng thời hiển 
     * thị một thông báo thành công. */

    //tạo chức năng xóa màu sắc sản phẩm
    public function destroy(int $color_id)
    {
        $color = Color::findOrFail($color_id);
        $color->delete();
        //xóa đối tượng Product khỏi cơ sở dữ liệu.
        return redirect()->back()->with('message', 'Đã xóa màu sắc sản phẩm thành công!');
    }
}
