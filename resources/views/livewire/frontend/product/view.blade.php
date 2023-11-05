<div>
    <div class="py-3 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mt-3">
                    {{-- Ảnh sản phẩm --}}
                    <div class="bg-white border" wire:ignore>
                        @if ($product->productImages)
                            {{-- <img src="{{ asset($product->productImages[0]->image) }}" class="w-100" alt="Img"> --}}
                            <div class="exzoom" id="exzoom">
                                <!-- Images -->
                                <div class="exzoom_img_box">
                                    <ul style="list-style: none" class='exzoom_img_ul'>
                                        @foreach ($product->productImages as $itemImg)
                                            <li><img src="{{ asset($itemImg->image) }}"></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- <a href="https://www.jqueryscript.net/tags.php?/Thumbnail/">Thumbnail</a> Nav-->
                                <div class="exzoom_nav"></div>
                                <!-- Nav Buttons -->
                                <p class="exzoom_btn">
                                    <a href="javascript:void(0);" class="exzoom_prev_btn">
                                        < </a>
                                            <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                                </p>
                            </div>
                        @else
                            <h3 class="text-danger fw-bold">
                                Sản phẩm này chưa có ảnh!
                            </h3>
                        @endif

                    </div>
                </div>
                <div class="col-md-7 mt-3">
                    <div class="product-view">
                        <h4 class="product-name">
                            {{-- Tên sản phẩm --}}
                            {{ $product->name }}
                        </h4>
                        <hr>
                        <p class="product-path">
                            Danh mục sản phẩm / {{ $product->category->name }} / {{ $product->name }}
                        </p>
                        {{-- Giá tiền sản phẩm --}}
                        <div>
                            <span class="selling-price">
                                {{ number_format($product->selling_price, 0, ',', '.') }}<sup>đ</sup>
                            </span>
                            <span class="original-price">
                                {{ number_format($product->original_price, 0, ',', '.') }}<sup>đ</sup>
                            </span>
                        </div>
                        {{-- Màu sắc sản phẩm --}}
                        <div class="color">
                            Chọn màu để xem giá và chi nhánh có hàng
                            <br />
                            @if ($product->productColors->count() > 0)
                                {{-- Dòng này kiểm tra xem số lượng màu sắc của sản phẩm ($product) có lớn hơn 0 hay 
                                không. Nếu có, nó sẽ tiếp tục thực hiện các lệnh bên trong khối if. --}}
                                @if ($product->productColors)
                                    @foreach ($product->productColors as $colorItem)
                                        {{-- Dòng này kiểm tra xem productColors của $product có tồn tại hay không. 
                                    Nếu có, nó sẽ lặp qua từng phần tử màu sắc và gán mỗi phần tử cho biến 
                                    $colorItem. --}}
                                        {{-- <input type="radio" name="colorSelection" value="{{ $colorItem->id }}"/> {{ $colorItem->color->name }} --}}
                                        <label for="" class="colorSelectionLabel btn-sm fw-bold fs-6"
                                            style="background-color: {{ $colorItem->color->code }};"
                                            wire:click="colorSelected({{ $colorItem->id }})">
                                            {{ $colorItem->color->name }}
                                        </label>
                                        {{-- Dòng này hiển thị tên màu sắc ($colorItem->color->name) dưới dạng 
                                            một nhãn (label) có nền màu (style="background-color: 
                                            {{ $colorItem->color->code }};"). Khi người dùng nhấp vào nhãn, nó sẽ 
                                            gọi hàm colorSelected() với tham số là $colorItem->id. --}}
                                    @endforeach
                                @endif
                                {{-- Check số lượng màu sắc tồn kho sản phẩm --}}
                                <div class="mt-2">
                                    @if ($this->productColorSelectedQuantity == 'hethang')
                                        <label class="btn-sm py-1 text-white label-stock bg-danger fw-bold ">
                                            Hết hàng
                                        </label>
                                    @elseif ($this->productColorSelectedQuantity > 0)
                                        <label class="btn-sm py-1 text-white label-stock bg-success fw-bold ">
                                            Còn hàng
                                        </label>
                                    @endif
                                    {{-- Dòng này kiểm tra giá trị của biến $this->productColorSelectedQuantity 
                                        để xác định xem sản phẩm có tồn kho hay không. Nếu giá trị là 
                                        "hethang", nó sẽ hiển thị giá gốc của sản phẩm với nhãn có màu đỏ. 
                                        Nếu giá trị lớn hơn 0, nó sẽ hiển thị giá bán của sản phẩm với nhãn có 
                                        màu xanh --}}
                                </div>
                            @else
                                {{-- Số lương tồn kho --}}
                                @if ($product->quantity)
                                    <label class="btn-sm py-1 text-white label-stock bg-success fw-bold ">
                                        Còn hàng
                                    </label>
                                @else
                                    <label class="btn-sm py-1 text-white label-stock bg-danger fw-bold ">
                                        Hết hàng
                                    </label>
                                @endif
                                {{-- Dòng này kiểm tra giá trị của quantity của $product để xác định xem sản 
                                    phẩm còn hàng hay hết hàng. Nếu quantity lớn hơn 0, nó sẽ hiển thị nhãn 
                                    "Còn hàng" với màu nền xanh. Nếu quantity bằng 0 hoặc không tồn tại, nó sẽ
                                    hiển thị nhãn "Hết hàng" với màu nền đỏ. --}}
                            @endif

                        </div>
                        <div class="mt-2">
                            <div class="input-group">
                                <span class="btn btn1" wire:click="decrementQuantity"><i class="fa fa-minus"></i></span>
                                <input type="text" wire:model="quantityCount" value="{{ $this->quantityCount }}"
                                    readonly class="input-quantity" />
                                {{-- wire:model="quantityCount", Thuộc tính này liên kết giữa giá trị của trường input và thuộc tính quantityCount trong lớp Livewire. Khi giá trị của 
                                trường input thay đổi, thuộc tính quantityCount cũng sẽ được cập nhật tương ứng trong lớp Livewire. --}}
                                {{-- readonly là để chỉ đọc được chứ không thể chỉnh được số lượng sản phẩm --}}
                                <span class="btn btn1" wire:click="incrementQuantity"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" wire:click="addToCart({{ $product->id }})"
                                class="btn btn1 btn-danger"> <i class="fa fa-shopping-cart"></i>
                                Thêm vào giỏ hàng
                            </button>
                            <button type="button" wire:click="addToWishList({{ $product->id }})"
                                class="btn btn1 btn-success">
                                <span wire:loading.remove wire:target="addToWishList">
                                    {{-- wire:loading.remove: Đây là một chỉ thị được sử dụng để ẩn nội dung khi quá trình tải dữ liệu hoặc thực hiện một hành động thông qua Ajax đang diễn 
                                        ra. Trong trường hợp này, nội dung được đặt trong thẻ <span wire:loading.remove></span> sẽ không được hiển thị khi dữ liệu đang được tải hoặc hành 
                                        động đang được thực hiện. --}}
                                    <i class="fa fa-heart"></i> Thêm vào danh sách yêu thích
                                </span>
                                <span wire:loading wire:target="addToWishList">Đang thêm...</span>
                                {{-- wire:loading wire:target="addToWishList": Đây là một chỉ thị được sử dụng để hiển thị nội dung khi quá trình tải dữ liệu hoặc thực hiện một hành động 
                                thông qua Ajax đang diễn ra. Trong trường hợp này, nội dung được đặt trong thẻ <span wire:loading wire:target="addToWishList"></span> sẽ được hiển thị khi 
                                phương thức addToWishList() đang được thực thi thông qua Livewire. Đồng thời, nội dung này có thể được tùy chỉnh, trong ví dụ trên là "Đang thêm...". --}}
                            </button>
                        </div>
                        <div class=" col-md-12">
                            <div class="mt-4">
                                <h3 class="mb-0">Dịch vụ và thông tin khác</h3>
                                <p>
                                    {!! $product->meta_description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Mô tả và thông tin chi tiết sản phẩm --}}
            <div class="row">
                <div class="col-md-9 mt-3">
                    <div class="card fw-bold">
                        <div class="card-header">
                            <h3>Thông tin sản phẩm</h3>
                        </div>
                        <div class="card-body">
                            <p>
                                {!! $product->description !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mt-4">
                        <table class="table table-bordered table-stripped table-warning">
                            <thead>
                                <tr>
                                    <th class="border-dark border-2">
                                        <h3 class="mb-0">Mô tả sản phẩm</h3>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-dark border-2">
                                        <p>
                                            {!! $product->small_description !!}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-3 py-md-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h3>
                        Sản phẩm
                        @if ($category)
                            "{{ $category->name }}"
                        @endif
                        tương tự
                    </h3>
                    <div class="underline"></div>
                </div>
                <div class="col-md-12">
                    @if ($category)
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach ($category->relatedProducts as $relatedProductItem)
                                <div class="item mb-3">
                                    <div class="product-card">
                                        <div class="product-card-img">
                                            {{-- Ảnh sản phẩm --}}
                                            @if ($relatedProductItem->productImages->count() > 0)
                                                {{-- Đây là một câu lệnh điều kiện kiểm tra xem số lượng hình ảnh của sản phẩm 
                                                ($relatedProductItem->productImages->count()) có lớn hơn 0 hay không. Nếu có ít nhất 
                                                một hình ảnh, điều kiện trong câu lệnh if sẽ trả về giá trị true và mã bên 
                                                trong if sẽ được thực thi. --}}
                                                <a
                                                    href="{{ url('/collections/' . $relatedProductItem->category->slug . '/' . $relatedProductItem->slug) }}">
                                                    <img src="{{ asset($relatedProductItem->productImages[0]->image) }}"
                                                        alt="{{ $relatedProductItem->name }}">
                                                    {{-- Đường dẫn của hình ảnh được lấy từ phần tử đầu tiên của mảng 
                                                    $relatedProductItem->productImages (có thể là một mảng chứa nhiều hình ảnh, nhưng 
                                                    chỉ lấy hình ảnh đầu tiên). --}}
                                                </a>
                                            @endif
                                        </div>
                                        <div class="product-card-body">
                                            {{-- Thương hiệu sản phẩm --}}
                                            <p class="product-brand">{{ $relatedProductItem->brand }}</p>
                                            {{-- Tên sản phẩm --}}
                                            <h5 class="product-name">
                                                <a
                                                    href="{{ url('/collections/' . $relatedProductItem->category->slug . '/' . $relatedProductItem->slug) }}">
                                                    {{ $relatedProductItem->name }}
                                                </a>
                                            </h5>
                                            <div>
                                                <span class="selling-price">
                                                    {{ number_format($relatedProductItem->selling_price, 0, ',', '.') }}<sup>đ</sup>
                                                </span>
                                                <span class="original-price">
                                                    {{ number_format($relatedProductItem->original_price, 0, ',', '.') }}<sup>đ</sup>
                                                </span>
                                            </div>
                                            <div class="mt-2">
                                                <a href="" class="btn btn1">Thêm vào giỏ hàng</a>
                                                <a href="" class="btn btn1"> <i class="fa fa-heart"></i> </a>
                                                <a href="" class="btn btn1"> Xem sản phẩm </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="container block-info mt-3">
                            <div data-v-5a4f0845="">
                                <div data-v-5a4f0845="" class="nothing-in-cart"><svg data-v-5a4f0845=""
                                        aria-hidden="true" focusable="false" data-prefix="fas" data-icon="frown"
                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                        style="width:48px; height:60px" viewBox="0 0 496 512"
                                        class="svg-inline--fa fa-frown">
                                        <path data-v-5a4f0845="" fill="currentColor"
                                            d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm80 168c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm-160 0c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm170.2 218.2C315.8 367.4 282.9 352 248 352s-67.8 15.4-90.2 42.2c-13.5 16.3-38.1-4.2-24.6-20.5C161.7 339.6 203.6 320 248 320s86.3 19.6 114.7 53.8c13.6 16.2-11 36.7-24.5 20.4z"
                                            class=""></path>
                                    </svg>
                                    <p data-v-5a4f0845="">Không có sản phẩm tương tự nào trong danh mục này, vui
                                        lòng quay lại!
                                    </p> <a data-v-5a4f0845="" href="{{ url('/') }}" class="go-back">Quay
                                        lại
                                        trang chủ</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="py-3 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h3>
                        Thương hiệu
                        @if ($product)
                            "{{ $product->brand }}"
                        @endif
                    </h3>
                    <div class="underline"></div>
                </div>

                <div class="col-md-12">
                    @if ($category)
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach ($category->relatedProducts as $relatedProductItem)
                                @if ($relatedProductItem->brand == "$product->brand")
                                    <div class="item mb-3">
                                        <div class="product-card">
                                            <div class="product-card-img">
                                                {{-- Ảnh sản phẩm --}}
                                                @if ($relatedProductItem->productImages->count() > 0)
                                                    {{-- Đây là một câu lệnh điều kiện kiểm tra xem số lượng hình ảnh của sản phẩm 
                                            ($relatedProductItem->productImages->count()) có lớn hơn 0 hay không. Nếu có ít nhất 
                                            một hình ảnh, điều kiện trong câu lệnh if sẽ trả về giá trị true và mã bên 
                                            trong if sẽ được thực thi. --}}
                                                    <a
                                                        href="{{ url('/collections/' . $relatedProductItem->category->slug . '/' . $relatedProductItem->slug) }}">
                                                        <img src="{{ asset($relatedProductItem->productImages[0]->image) }}"
                                                            alt="{{ $relatedProductItem->name }}">
                                                        {{-- Đường dẫn của hình ảnh được lấy từ phần tử đầu tiên của mảng 
                                                $relatedProductItem->productImages (có thể là một mảng chứa nhiều hình ảnh, nhưng 
                                                chỉ lấy hình ảnh đầu tiên). --}}
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="product-card-body">
                                                {{-- Thương hiệu sản phẩm --}}
                                                <p class="product-brand">{{ $relatedProductItem->brand }}</p>
                                                {{-- Tên sản phẩm --}}
                                                <h5 class="product-name">
                                                    <a
                                                        href="{{ url('/collections/' . $relatedProductItem->category->slug . '/' . $relatedProductItem->slug) }}">
                                                        {{ $relatedProductItem->name }}
                                                    </a>
                                                </h5>
                                                <div>
                                                    <span class="selling-price">
                                                        {{ number_format($relatedProductItem->selling_price, 0, ',', '.') }}<sup>đ</sup>
                                                    </span>
                                                    <span class="original-price">
                                                        {{ number_format($relatedProductItem->original_price, 0, ',', '.') }}<sup>đ</sup>
                                                    </span>
                                                </div>
                                                <div class="mt-2">
                                                    <a href="" class="btn btn1">Thêm vào giỏ hàng</a>
                                                    <a href="" class="btn btn1"> <i class="fa fa-heart"></i>
                                                    </a>
                                                    <a href="" class="btn btn1"> Xem sản phẩm </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="container block-info mt-3">
                            <div data-v-5a4f0845="">
                                <div data-v-5a4f0845="" class="nothing-in-cart"><svg data-v-5a4f0845=""
                                        aria-hidden="true" focusable="false" data-prefix="fas" data-icon="frown"
                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                        style="width:48px; height:60px" viewBox="0 0 496 512"
                                        class="svg-inline--fa fa-frown">
                                        <path data-v-5a4f0845="" fill="currentColor"
                                            d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm80 168c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm-160 0c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm170.2 218.2C315.8 367.4 282.9 352 248 352s-67.8 15.4-90.2 42.2c-13.5 16.3-38.1-4.2-24.6-20.5C161.7 339.6 203.6 320 248 320s86.3 19.6 114.7 53.8c13.6 16.2-11 36.7-24.5 20.4z"
                                            class=""></path>
                                    </svg>
                                    <p data-v-5a4f0845="">Không có sản phẩm tương tự nào trong danh mục này, vui
                                        lòng quay lại!
                                    </p> <a data-v-5a4f0845="" href="{{ url('/') }}" class="go-back">Quay
                                        lại
                                        trang chủ</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {

                $("#exzoom").exzoom({
                    /**Đây là việc gọi phương thức exzoom() của thư viện Exzoom trên phần tử có id là exzoom. Đoạn mã này gán các cài đặt cho thư viện Exzoom để tạo hiển thị hình ảnh có chức năng 
                     * zoom và điều hướng thumbnail.*/
                    // thumbnail nav options
                    "navWidth": 60, //Chiều rộng của các thumbnail điều hướng.
                    "navHeight": 60, //Chiều cao của các thumbnail điều hướng.
                    "navItemNum": 5, //Số lượng thumbnail hiển thị cùng một lúc.
                    "navItemMargin": 7, // Khoảng cách giữa các thumbnail.
                    "navBorder": 1, //Kích thước đường viền xung quanh các thumbnail.

                    // autoplay
                    "autoPlay": true, //Tự động chuyển đổi giữa các hình ảnh.

                    // autoplay interval in milliseconds
                    "autoPlayTimeout": 3000 //Thời gian tự động chuyển đổi giữa các hình ảnh là 2 giây (2000 milliseconds).

                });

            });

            $('.four-carousel').owlCarousel({
                /**Đoạn mã bắt đầu bằng việc chọn phần tử có class "four-carousel" và áp dụng thư viện Owl Carousel vào nó. Điều này có nghĩa là carousel sẽ được tạo trong phần tử có class 
                 * "four-carousel".*/
                loop: true,
                //Tùy chọn "loop" cho phép carousel lặp vô hạn, tức là khi bạn đến cuối cùng, nó sẽ chuyển sang phần tử đầu tiên và ngược lại.
                margin: 10,
                //Tùy chọn "margin" xác định khoảng cách giữa các phần tử trong carousel, ở đây là 10px.
                responsiveClass: true,
                //Tùy chọn "responsiveClass" thêm lớp CSS vào carousel để định dạng giao diện khi thay đổi kích thước màn hình.
                responsive: {
                    /**Đây là một đối tượng chứa các tùy chọn responsive cho carousel. Nó sẽ xác định số lượng phần tử trong carousel (items) và các tùy chọn khác tương ứng với từng kích thước màn hình 
                     * khác nhau.*/
                    0: {
                        items: 1,
                        nav: true
                        //Với kích thước màn hình dưới 600px (điểm bắt đầu), sẽ hiển thị 1 phần tử trong carousel và có nút điều hướng (nav) để chuyển giữa các phần tử.
                    },
                    600: {
                        items: 3,
                        nav: false
                        //Với kích thước màn hình từ 600px đến 999px, sẽ hiển thị 3 phần tử trong carousel và không có nút điều hướng (nav).
                    },
                    1000: {
                        items: 4,
                        nav: true,
                        loop: false
                        //Với kích thước màn hình từ 1000px trở lên, sẽ hiển thị 4 phần tử trong carousel, có nút điều hướng (nav) và không lặp lại (loop: false) các phần tử.
                    }
                }
            });
        </script>
    @endpush
