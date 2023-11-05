@extends('layouts.app')
{{-- Tiêu đề trang web --}}
@section('title', 'Sản phẩm nổi bật')
{{-- Bố cục trang web --}}
@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="fw-bold">Sản phẩm nổi bật</h2>
                    <div class="underline mb-4"></div>
                </div>
                
                    @forelse ($featuredProducts as $productItem)
                    <div class="col-md-3">
                        <div class="product-card">
                            <div class="product-card-img">
                                <label class="stock bg-danger fw-bold">Hàng mới về</label>
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
                    @empty
                        <div class="container block-info mt-3">
                            <div data-v-5a4f0845="">
                                <div data-v-5a4f0845="" class="nothing-in-cart"><svg data-v-5a4f0845=""
                                        aria-hidden="true" focusable="false" data-prefix="fas" data-icon="frown"
                                        role="img" xmlns="http://www.w3.org/2000/svg" style="width:48px; height:60px" viewBox="0 0 496 512"
                                        class="svg-inline--fa fa-frown">
                                        <path data-v-5a4f0845="" fill="currentColor"
                                            d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm80 168c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm-160 0c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm170.2 218.2C315.8 367.4 282.9 352 248 352s-67.8 15.4-90.2 42.2c-13.5 16.3-38.1-4.2-24.6-20.5C161.7 339.6 203.6 320 248 320s86.3 19.6 114.7 53.8c13.6 16.2-11 36.7-24.5 20.4z"
                                            class=""></path>
                                    </svg>
                                    <p data-v-5a4f0845="">Không có sản phẩm nổi bật nào trong danh mục này, vui lòng quay lại!
                                    </p> <a data-v-5a4f0845="" href="{{ url('/') }}" class="go-back">Quay lại
                                        trang chủ</a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                    <div class="text-center">
                        <a href="{{ url('collections') }}" class="btn btn-danger fw-bold fs-5">XEM THÊM</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
