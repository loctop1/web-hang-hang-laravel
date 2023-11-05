@extends('layouts.app')
{{-- Tiêu đề trang web --}}
@section('title', 'Trang chủ')
{{-- Bố cục trang web --}}
@section('content')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-inner">
            @foreach ($sliders as $key => $sliderItem)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    {{-- {{ $key == 0 ? 'active':'' }}: Đây là một biểu thức điều kiện trong Laravel Blade. Nếu $key 
                (biến chỉ số của vòng lặp) bằng 0, thì chuỗi 'active' sẽ được thêm vào lớp CSS của phần tử hiện tại. 
                Điều này đảm bảo rằng phần tử đầu tiên trong carousel sẽ có lớp CSS 'active', để nó được hiển thị 
                trước tiên khi trang được tải.
                Ví dụ: Nếu $key là 0, thì đoạn mã sẽ trở thành <div class="carousel-item active">. Nếu $key không 
                phải là 0, thì đoạn mã sẽ trở thành <div class="carousel-item">. --}}
                    {{-- Ảnh sản phẩm --}}
                    @if ($sliderItem->image)
                        <img src="{{ asset("$sliderItem->image") }}" class="d-block w-100" style="width:auto;height:500px;"
                            alt="...">
                    @endif
                    <div class="carousel-caption d-none d-md-block">
                        <div class="custom-carousel-content">
                            <h1>
                                {!! $sliderItem->title !!}
                            </h1>
                            <p>
                                {!! $sliderItem->description !!}
                            </p>
                            <div>
                                <a href="#" class="btn btn-slider">
                                    Xem thêm<main></main>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="fw-bold">Danh mục sản phẩm</h2>
                    <div class="underline mb-4"></div>
                </div>
                @forelse ($categories as $categoryItem)
                    <div class="col-6 col-md-3">
                        <div class="category-card">
                            <a href="{{ url('/collections/'.$categoryItem->slug) }}">
                                <div class="category-card-img">
                                    <img src="{{ asset("$categoryItem->image") }}" class="w-100 h-100" alt="Laptop">
                                </div>
                                <div class="category-card-body">
                                    <h5>{{ $categoryItem->name }}</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <h5 class="text-danger fw-bold">Không có danh mục sản phẩm nào</h5>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="fw-bold">Sản phẩm phổ biến</h2>
                    <div class="underline mb-4"></div>
                </div>
                @if ($trendingProducts)
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach ($trendingProducts as $productItem)
                                <div class="item">
                                    <div class="product-card">
                                        <div class="product-card-img">
                                            <label class="stock bg-danger fw-bold">Sản phẩm mới</label>
                                            {{-- Ảnh sản phẩm --}}
                                            @if ($productItem->productImages->count() > 0)
                                                {{-- Đây là một câu lệnh điều kiện kiểm tra xem số lượng hình ảnh của sản phẩm 
                                            ($productItem->productImages->count()) có lớn hơn 0 hay không. Nếu có ít nhất 
                                            một hình ảnh, điều kiện trong câu lệnh if sẽ trả về giá trị true và mã bên 
                                            trong if sẽ được thực thi. --}}
                                                <a
                                                    href="{{ url('/collections/' . $productItem->category->slug . '/' . $productItem->slug) }}">
                                                    <img src="{{ asset($productItem->productImages[0]->image) }}"
                                                        alt="{{ $productItem->name }}">
                                                    {{-- Đường dẫn của hình ảnh được lấy từ phần tử đầu tiên của mảng 
                                                $productItem->productImages (có thể là một mảng chứa nhiều hình ảnh, nhưng 
                                                chỉ lấy hình ảnh đầu tiên). --}}
                                                </a>
                                            @endif
                                        </div>
                                        <div class="product-card-body">
                                            {{-- Thương hiệu sản phẩm --}}
                                            <p class="product-brand">{{ $productItem->brand }}</p>
                                            {{-- Tên sản phẩm --}}
                                            <h5 class="product-name">
                                                <a
                                                    href="{{ url('/collections/' . $productItem->category->slug . '/' . $productItem->slug) }}">
                                                    {{ $productItem->name }}
                                                </a>
                                            </h5>
                                            <div>
                                                <span class="selling-price">
                                                    {{ number_format($productItem->selling_price, 0, ',', '.') }}<sup>đ</sup>
                                                </span>
                                                <span class="original-price">
                                                    {{ number_format($productItem->original_price, 0, ',', '.') }}<sup>đ</sup>
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
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="p-2">
                            <h4 class="text-danger fw-bold">
                                Không có sản phẩm nào
                            </h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="py-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="fw-bold">Sản phẩm mới</h2>
                    <a href="{{ url('new-arrivals') }}" class="btn btn-warning float-end">
                        Xem thêm >
                    </a><br>
                    <div class="underline mb-4"></div>
                </div>
                @if ($newArrivalsProducts)
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach ($newArrivalsProducts as $productItem)
                                <div class="item">
                                    <div class="product-card">
                                        <div class="product-card-img">
                                            <label class="stock bg-danger fw-bold">Sản phẩm mới</label>
                                            {{-- Ảnh sản phẩm --}}
                                            @if ($productItem->productImages->count() > 0)
                                                {{-- Đây là một câu lệnh điều kiện kiểm tra xem số lượng hình ảnh của sản phẩm 
                                            ($productItem->productImages->count()) có lớn hơn 0 hay không. Nếu có ít nhất 
                                            một hình ảnh, điều kiện trong câu lệnh if sẽ trả về giá trị true và mã bên 
                                            trong if sẽ được thực thi. --}}
                                                <a
                                                    href="{{ url('/collections/' . $productItem->category->slug . '/' . $productItem->slug) }}">
                                                    <img src="{{ asset($productItem->productImages[0]->image) }}"
                                                        alt="{{ $productItem->name }}">
                                                    {{-- Đường dẫn của hình ảnh được lấy từ phần tử đầu tiên của mảng 
                                                $productItem->productImages (có thể là một mảng chứa nhiều hình ảnh, nhưng 
                                                chỉ lấy hình ảnh đầu tiên). --}}
                                                </a>
                                            @endif
                                        </div>
                                        <div class="product-card-body">
                                            {{-- Thương hiệu sản phẩm --}}
                                            <p class="product-brand">{{ $productItem->brand }}</p>
                                            {{-- Tên sản phẩm --}}
                                            <h5 class="product-name">
                                                <a
                                                    href="{{ url('/collections/' . $productItem->category->slug . '/' . $productItem->slug) }}">
                                                    {{ $productItem->name }}
                                                </a>
                                            </h5>
                                            <div>
                                                <span class="selling-price">
                                                    {{ number_format($productItem->selling_price, 0, ',', '.') }}<sup>đ</sup>
                                                </span>
                                                <span class="original-price">
                                                    {{ number_format($productItem->original_price, 0, ',', '.') }}<sup>đ</sup>
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
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="p-2">
                            <h4 class="text-danger fw-bold">
                                Không có sản phẩm mới nào
                            </h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="fw-bold">Sản phẩm nổi bật</h2>
                    <a href="{{ url('featured-products') }}" class="btn btn-warning float-end fw-bold">
                        Xem thêm >
                    </a><br>
                    <div class="underline mb-4"></div>
                </div>
                @if ($featuredProducts)
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach ($featuredProducts as $productItem)
                                <div class="item">
                                    <div class="product-card">
                                        <div class="product-card-img">
                                            <label class="stock bg-danger fw-bold">Sản phẩm mới</label>
                                            {{-- Ảnh sản phẩm --}}
                                            @if ($productItem->productImages->count() > 0)
                                                {{-- Đây là một câu lệnh điều kiện kiểm tra xem số lượng hình ảnh của sản phẩm 
                                            ($productItem->productImages->count()) có lớn hơn 0 hay không. Nếu có ít nhất 
                                            một hình ảnh, điều kiện trong câu lệnh if sẽ trả về giá trị true và mã bên 
                                            trong if sẽ được thực thi. --}}
                                                <a
                                                    href="{{ url('/collections/' . $productItem->category->slug . '/' . $productItem->slug) }}">
                                                    <img src="{{ asset($productItem->productImages[0]->image) }}"
                                                        alt="{{ $productItem->name }}">
                                                    {{-- Đường dẫn của hình ảnh được lấy từ phần tử đầu tiên của mảng 
                                                $productItem->productImages (có thể là một mảng chứa nhiều hình ảnh, nhưng 
                                                chỉ lấy hình ảnh đầu tiên). --}}
                                                </a>
                                            @endif
                                        </div>
                                        <div class="product-card-body">
                                            {{-- Thương hiệu sản phẩm --}}
                                            <p class="product-brand">{{ $productItem->brand }}</p>
                                            {{-- Tên sản phẩm --}}
                                            <h5 class="product-name">
                                                <a
                                                    href="{{ url('/collections/' . $productItem->category->slug . '/' . $productItem->slug) }}">
                                                    {{ $productItem->name }}
                                                </a>
                                            </h5>
                                            <div>
                                                <span class="selling-price">
                                                    {{ number_format($productItem->selling_price, 0, ',', '.') }}<sup>đ</sup>
                                                </span>
                                                <span class="original-price">
                                                    {{ number_format($productItem->original_price, 0, ',', '.') }}<sup>đ</sup>
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
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="p-2">
                            <h4 class="text-danger fw-bold">
                                Không có sản phẩm nổi bật nào
                            </h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
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
        })
    </script>
@endsection
