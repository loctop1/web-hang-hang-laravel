@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Chỉnh sửa sản phẩm
                        <a href="{{ url('admin/products/') }}"
                            class="btn btn-info float-end btn-sm text-light fw-bolder fst-italic fs-5">
                            Quay lại danh sách sản phẩm
                        </a>
                    </h3>
                </div>
                <div class="col-md-12 text-start">
                    @if ($errors->any())
                        <div class="text-danger fw-bold alert alert-warning">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="card-body d-flex justify-content-center align-items-center ">
                    <form action="{{ url('admin/products/' . $product->id) }}" class="col-md-11 btn btn-warning text-start"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- Thông báo đã xóa sản phẩm thành công --}}
                        @if (session('message3'))
                            <h4 class="alert alert-success mb-2">{{ session('message3') }}</h4>
                        @endif
                        <ul class="nav nav-tabs " id="myTab" role="tablist">
                            <li class="nav-item " role="presentation">
                                <button class="nav-link active text-dark fw-bold fs-4" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">
                                    Trang chủ
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark fw-bold fs-4" id="seotag-tab" data-bs-toggle="tab"
                                    data-bs-target="#seotag-tab-pane" type="button" role="tab"
                                    aria-controls="seotag-tab-pane" aria-selected="false">
                                    SEO Sản Phẩm
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark fw-bold fs-4" id="details-tab" data-bs-toggle="tab"
                                    data-bs-target="#details-tab-pane" type="button" role="tab"
                                    aria-controls="details-tab-pane" aria-selected="false">
                                    Chi tiết sản phẩm
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark fw-bold fs-4" id="image-tab" data-bs-toggle="tab"
                                    data-bs-target="#image-tab-pane" type="button" role="tab"
                                    aria-controls="image-tab-pane" aria-selected="false">
                                    Ảnh sản phẩm
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark fw-bold fs-4" id="colors-tab" data-bs-toggle="tab"
                                    data-bs-target="#colors-tab-pane" type="button" role="tab">
                                    Màu sắc sản phẩm
                                </button>
                            </li>
                        </ul><br />
                        {{-- Thông tin sản phẩm --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade border p-3 show active" id="home-tab-pane" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                <div class="mb-3">
                                    <h3><b><label for="">Danh sách sản phẩm</label></b></h3>
                                    <select name="category_id"
                                        class="form-control btn btn-danger text-start text-light tw-bold">
                                        <option value="">Chọn danh mục sản phẩm</option>
                                        @foreach ($categories as $category)
                                            <option class="btn success text-start text-light" value="{{ $category->id }}"
                                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                {{-- {{ $category->id == $product->category_id ? 'Đã chọn':'' }} Biểu 
                                                thức này kiểm tra xem ID của danh mục hiện tại ($category->id) có 
                                                khớp với ID của danh mục của sản phẩm ($product->category_id) hay 
                                                không. Nếu điều kiện này trả về true, tức là danh mục hiện tại đang 
                                                được lặp qua trong vòng lặp là danh mục đã chọn ban đầu của sản phẩm, 
                                                thì chuỗi 'Đã chọn' sẽ được xuất ra. Ngược lại, nếu điều kiện trả về 
                                                false, không có gì được xuất ra. --}}
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">Tên sản phẩm</label>
                                    <input type="text" name="name" value="{{ $product->name }}" class="form-control"
                                        placeholder="Vui lòng nhập tên sản phẩm" />
                                </div>
                                <div class="mb-3">
                                    <label for="">Từ khóa</label>
                                    <input type="text" name="slug" value="{{ $product->slug }}" class="form-control"
                                        placeholder="Vui lòng nhập tư khóa sản phẩm" />
                                </div>
                                <div class="mb-3">
                                    <h3><b><label for="">Chọn thương hiệu sản phẩm</label></b></h3>
                                    <select name="brand"
                                        class="form-control btn btn-danger text-start text-light tw-bold">
                                        <option value="">Chọn thương hiệu sản phẩm</option>
                                        @foreach ($brands as $brand)
                                            <option class="btn btn-success text-start text-light"
                                                value="{{ $brand->name }}"
                                                {{ $brand->name == $product->brand ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <h3><b><label for="">Mô tả ngắn sản phẩm (500 từ)</label></b></h3>
                                    <textarea name="small_description" class="form-control" rows="4">{{ $product->small_description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <h3><b><label for="">Mô tả sản phẩm</label></b></h3>
                                    <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                                </div>
                            </div>
                            {{-- SEO sản phẩm --}}
                            <div class="tab-pane fade border p-3" id="seotag-tab-pane" role="tabpanel"
                                aria-labelledby="seotag-tab" tabindex="0">
                                <div class="mb-3">
                                    <h3><b><label for="">Hastag</label></b></h3>
                                    <input type="text" name="meta_title" value="{{ $product->meta_title }}"
                                        class="form-control" placeholder="Vui lòng nhập tư khóa sản phẩm" />
                                </div>
                                <div class="mb-3">
                                    <h3><b><label for="">Hastag mô tả sản phẩm</label></b></h3>
                                    <textarea name="meta_description" class="form-control" rows="4">{{ $product->meta_description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <h3><b><label for="">Từ khóa sản phẩm</label></b></h3>
                                    <textarea name="meta_keyword" class="form-control" rows="4">{{ $product->meta_keyword }}</textarea>
                                </div>
                            </div>
                            {{-- chi tiết sản phẩm --}}
                            <div class="tab-pane fade border p-3" id="details-tab-pane" role="tabpanel"
                                aria-labelledby="details-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Giá gốc</label></b></h3>
                                            <input type="text" name="original_price"
                                                value="{{ $product->original_price }}" class="form-control"
                                                placeholder="Vui lòng nhập giá tiền sản phẩm" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Giảm giá</label></b></h3>
                                            <input type="text" name="selling_price"
                                                value="{{ $product->selling_price }}" class="form-control"
                                                placeholder="Vui lòng nhập giá sale" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Số lượng</label></b></h3>
                                            <input type="number" name="quantity" value="{{ $product->quantity }}"
                                                class="form-control" placeholder="Vui lòng nhập số lượng" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Sản phẩm theo xu hướng</label></b></h3>
                                            <input type="checkbox" name="trending"
                                                {{ $product->trending == '1' ? 'checked' : '' }} width="50px;"
                                                height="50px;" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Sản phẩm nổi bật</label></b></h3>
                                            <input type="checkbox" name="featured"
                                                {{ $product->featured == '1' ? 'checked' : '' }} width="50px;"
                                                height="50px;" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Tùy chọn</label></b></h3>
                                            <input type="checkbox" name="status"
                                                {{ $product->status == '1' ? 'checked' : '' }} width="50px;"
                                                height="50px;" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Ảnh sản phẩm --}}
                            <div class="tab-pane fade border p-3" id="image-tab-pane" role="tabpanel"
                                aria-labelledby="image-tab" tabindex="0">
                                <div class="md-3">
                                    <h3><b><label for="">Tải ảnh sản phẩm</label></b></h3>
                                    <input type="file" name="image[]" multiple class="form-control" />
                                </div><br />
                                <div>
                                    @if ($product->productImages)
                                        {{-- kiểm tra xem biến $product->productImages trong model product có tồn tại hay không. --}}
                                        <div class="row">
                                            @foreach ($product->productImages as $image)
                                                <div class="col-md-4">
                                                    <img src="{{ asset($image->image) }}"
                                                        class="me-4 border border-3 border-dark rounded" alt="image"
                                                        width="100%;" height="200px;" />
                                                    <br /><br /><a
                                                        href="{{ url('admin/product-image/' . $image->id . '/delete') }}"
                                                        class="d-block btn btn-danger btn-sm text-light fw-bold fs-5">
                                                        Xóa
                                                    </a><br />
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <h5 class="text-danger">Không có ảnh sản phẩm nào!</h5>
                                    @endif
                                </div>
                            </div><br />
                            {{-- Thêm màu sắc sản phẩm --}}
                            <div class="tab-pane fade border p-3" id="colors-tab-pane" role="tabpanel" tabindex="0">
                                <div class="md-3">
                                    <h3>Thêm màu sắc sản phẩm</h3>
                                    <h4><b><label for="">Chọn màu sản phẩm</label></b></h4>
                                    <hr
                                        style="height: 7px; border-style: 4px solid; border-width: 4; color: red; background-color: red;" />
                                    <div class="row">
                                        @forelse ($colors as $coloritem)
                                            <div class="col-md-4 fs-5 fw-bold">
                                                <div class="p-2 border border-dark border-3">
                                                    Màu sắc: <input type="checkbox" name="colors[{{ $coloritem->id }}]"
                                                        style="width:15px; height:15px;" value="{{ $coloritem->id }}" />
                                                    {{-- name="colors[{{ $coloritem->id }}]": Đây là thuộc tính name của 
                                                        input checkbox. Nó được định danh cho mỗi màu sắc trong danh sách 
                                                        $colors. Biến $coloritem->id được sử dụng để tạo ra một khóa duy 
                                                        nhất cho mỗi checkbox màu sắc. Khi form được gửi đi, các checkbox 
                                                        được chọn sẽ gửi giá trị của thuộc tính value tương ứng với khóa này. --}}
                                                    <b class="fs-5">{{ $coloritem->name }}</b>
                                                    <br /><br />
                                                    <p class="fs-5">Số lượng sản phẩm:</p>
                                                    <input type="number" name="colorquantity[{{ $coloritem->id }}]"
                                                        style="width:70px; border:2px solid" />
                                                    {{-- name="quantity[{{ $coloritem->id }}]": Đây là thuộc tính name 
                                                        của input số (input type="number"). Tương tự như trên, nó cũng được 
                                                        định danh cho mỗi màu sắc trong danh sách $colors. Biến 
                                                        $coloritem->id được sử dụng để tạo ra một khóa duy nhất cho mỗi 
                                                        input số. Khi form được gửi đi, giá trị số lượng sản phẩm nhập vào 
                                                        sẽ được gửi đi kèm với khóa này. --}}
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-md-12">
                                                <h4 style="color:red;">Không có màu sắc nào!</h4>
                                            </div>
                                        @endforelse
                                    </div>
                                </div><br />
                                {{-- Danh sách màu sắc sản phẩm --}}
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="btn-primary text-light fw-bold table-bordered border-dark border-2">
                                            <tr class="">
                                                <th class="fs-3 border-dark border-2">ID</th>
                                                <th class="fs-3 border-dark border-2">Số lượng</th>
                                                <th class="fs-3 border-dark border-2">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody class="btn-warning fw-bold border-dark border-2">
                                            @foreach ($product->productColors as $prodColor)
                                                <tr class="prod-color-tr fs-5 border-dark border-2">
                                                    <td class="fs-5 border-dark border-2">
                                                        @if ($prodColor->color->name)
                                                            {{ $prodColor->color->name }}
                                                            {{-- Ta xây dựng hàm color() bên model ProductColor để kế thừa cái
                                                                model Color quan hệ 1 nhiều color_id với id và kết quả sẽ hiển
                                                                thị tên màu sắc --}}
                                                        @else
                                                            <h4 class="text-danger fw-bold">
                                                                Sản phẩm này không có màu sắc
                                                            </h4>
                                                        @endif
                                                    </td>
                                                    <td class="fs-5 border-dark border-2">
                                                        <div class="input-gruop mb-3" style="width:92px;">
                                                            <input type="number" value="{{ $prodColor->quantity }}"
                                                                class="productColorQuantity form-control form-control-sm"><br />
                                                            <button type="button" value="{{ $prodColor->id }}"
                                                                class="updateProductColorBtn btn btn-success btn-sm text-light fw-bold">
                                                                Cập nhật
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" value="{{ $prodColor->id }}"
                                                            class="deleteProductColorBtn btn btn-danger btn-sm text-light fw-bold">
                                                            Xóa
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary text-light fw-bold fs-5">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Tạo sự kiện khi ấn vào nút cập nhật thì hiện thông báo bằng jquery --}}
@section('scripts')
    <script>
        $.ajaxSetup({
            /**Phương thức ajaxSetup() được sử dụng để thiết lập các tùy chọn mặc định cho các yêu cầu Ajax.*/
            headers: {
                //Thuộc tính headers trong đối tượng tùy chọn được sử dụng để đặt các tiêu đề yêu cầu.
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                /**Đây là cặp key-value trong đối tượng headers. Key là 'X-CSRF-TOKEN' và giá trị là 'content' của thẻ meta 
                 * có thuộc tính name là 'csrf-token'. Đoạn mã $('meta[name="csrf-token"]').attr('content') được sử dụng để 
                 * lấy giá trị của thuộc tính content của thẻ meta.*/
            }
        });
        /**Đoạn mã $.ajaxSetup({...}) được sử dụng để thiết lập các tùy chọn mặc định cho tất cả các yêu cầu Ajax trong 
         * jQuery. Trong trường hợp này, nó được sử dụng để đặt tiêu đề X-CSRF-TOKEN trong mỗi yêu cầu Ajax. Đây là một 
         * biện pháp bảo mật thường được sử dụng trong các ứng dụng web Laravel để bảo vệ khỏi tấn công CSRF 
         * (Cross-Site Request Forgery).*/

        $(document).ready(function() {
            /*Đoạn mã trong ngoặc nhọn này được thực thi khi trang tải xong và sẵn sàng để tương tác.*/
            $(document).on('click', '.updateProductColorBtn', function() {
                /**Đoạn mã trong ngoặc nhọn này được thực thi khi một phần tử có class "updateProductColorBtn" được nhấp. 
                 * Điều này cho phép bạn gắn sự kiện "click" cho các phần tử được tạo ra sau khi trang tải.*/
                var product_id = "{{ $product->id }}";
                /**Dòng này lấy giá trị của thuộc tính "id" của một đối tượng "product" trong Laravel và lưu trữ nó trong 
                 * biến "product_id". Đây có vẻ như một biến blade template được truyền vào trong mã JavaScript.*/
                var prod_color_id = $(this).val();
                /**Dòng này lấy giá trị của thuộc tính "value" của phần tử hiện tại (nút được nhấp) và lưu trữ nó trong biến 
                 * "prod_color_id".*/
                var qty = $(this).closest('.prod-color-tr').find('.productColorQuantity').val();
                /**var qty = $(this).closest('.prod-color-tr').find('.productColorQuantity').val()
                 * find('.productColorQuantity') tìm kiếm các phần tử con của phần tử có class là "productColorQuantity".
                 * Phương thức closest('.prod-color-tr') tìm kiếm phần tử cha gần nhất có class "prod-color-tr" và phương 
                 * thức find('.productColorQuantity') tìm kiếm các phần tử con có class "productColorQuantity" bên trong 
                 * phần tử cha đó. Kết hợp cả hai phương thức, bạn có thể truy cập vào phần tử con mong muốn của phần tử cha 
                 * gần nhất.
                 * Trong trường hợp của bạn, truy cập vào phần tử con có class "productColorQuantity" bên trong phần tử cha 
                 * gần nhất có class "prod-color-tr", và trả về giá trị của thuộc tính "value" của phần tử đó. */
                //alert(prod_color_id);

                if (qty <= 0) {
                    alert('Vui lòng nhập số lượng màu sắc!')
                    return false;
                };
                /**Đoạn mã trong ngoặc nhọn này kiểm tra nếu "qty" nhỏ hơn hoặc bằng 0, hiển thị một thông báo cảnh báo và 
                 * trả về false, ngăn không cho mã tiếp tục thực thi.*/

                var data = {
                    'product_id': product_id,
                    'qty': qty
                };
                /**Dòng này tạo một đối tượng JavaScript có hai thuộc tính là "product_id" và "qty", giá trị của thuộc tính 
                 * này lấy từ biến "product_id" và "qty" đã lưu trữ.*/

                $.ajax({
                    /**Đây là một cuộc gọi AJAX sử dụng thư viện jQuery. Nó gửi một yêu cầu POST đến URL "/admin/product-color" 
                     * kèm theo "prod_color_id" và dữ liệu đã được định dạng thành JSON trong biến "data".*/
                    type: "POST",
                    //Yêu cầu gửi đi là một yêu cầu POST.
                    url: "/admin/product-color/" + prod_color_id,
                    /**URL mà yêu cầu AJAX được gửi đến. "prod_color_id" được ghép vào URL để tạo thành đường dẫn tới tài 
                     * nguyên cụ thể.*/
                    data: data,
                    //Dữ liệu gửi đi trong yêu cầu POST.
                    success: function(response) {
                        /**Đoạn mã trong ngoặc nhọn này được thực thi khi yêu cầu AJAX thành công. Biến "response" chứa phản hồi 
                         * từ máy chủ.*/
                        alert(response.message);
                        //Hiển thị thông báo thành công từ phản hồi AJAX.                        
                    }
                });
            });

            //tạo sự kiện xóa sản phẩm
            $(document).on('click', '.deleteProductColorBtn', function() {
            //Cụ thể, khi một phần tử có class "deleteProductColorBtn" được nhấp chuột, hàm này sẽ được thực thi.
                var prod_color_id = $(this).val();
                /**Biến prod_color_id được gán giá trị của thuộc tính "value" của phần tử đã được nhấp chuột 
                 * ($(this).val()). Điều này giả định rằng phần tử có class "deleteProductColorBtn" chứa một thuộc 
                 * tính "value" có giá trị là prod_color_id.*/
                var thisClick = $(this);
                /**Biến thisClick được gán giá trị $(this), đại diện cho phần tử đã được nhấp chuột (phần tử có 
                 * class "deleteProductColorBtn").*/

                $.ajax({
                    type: "GET",
                    url: "/admin/product-color/" + prod_color_id + "/delete",
                    /**Một yêu cầu AJAX được gửi đi bằng phương thức GET tới một URL cụ thể 
                     * ("/admin/product-color/" + prod_color_id + "/delete"). Điều này giả định rằng có một đường 
                     * dẫn như "/admin/product-color/{prod_color_id}/delete" được định nghĩa trên máy chủ. Yêu cầu 
                     * AJAX này sẽ gọi đến URL này và thực thi một hàm thành công (success) hoặc lỗi (error), 
                     * tùy thuộc vào kết quả từ máy chủ.*/
                    success: function(response) {
                        thisClick.closest('.prod-color-tr').remove();
                        /**Trong hàm thành công (success), thisClick.closest('.prod-color-tr').remove(); được sử 
                         * dụng để xóa phần tử gần nhất có class "prod-color-tr", là phần tử cha của phần tử đã được 
                         * nhấp chuột. Điều này giả định rằng phần tử có class "prod-color-tr" chứa phần tử có 
                         * class "deleteProductColorBtn".*/
                        alert(response.message);
                        //Một cảnh báo (alert) được hiển thị với nội dung được trả về từ máy chủ (response.message).
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        /**Trong hàm lỗi (error), console.log(xhr.responseText) được sử dụng để ghi thông báo lỗi 
                         * vào console.*/
                    }
                });
            });
        });
    </script>
@endsection
