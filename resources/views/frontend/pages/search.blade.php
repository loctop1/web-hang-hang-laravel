@extends('layouts.app')
{{-- Tiêu đề trang web --}}
@section('title', 'Tìm kiếm sản phẩm')
{{-- Bố cục trang web --}}
@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h2 class="fw-bold">Kết quả tìm kiếm</h2>
                    <div class="underline mb-4"></div>
                </div>
                @forelse ($searchProducts as $productItem)
                    <div class="col-md-10">
                        <div class="product-card">
                            <div class="row">
                                <div class="col-md-3">
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
                                </div>
                                <div class="col-md-9">
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
                                        <p style="height: 45px; overflow: hidden;">
                                            <b>Mô tả: </b> {{ $productItem->description }}
                                        </p>
                                        <a href="{{ url('/collections/' . $productItem->category->slug . '/' . $productItem->slug) }}"
                                            class="btn btn-outline-primary">Xem chi tiết</a>
                                        <div class="mt-2">
                                            <a href="" class="btn btn1">Thêm vào giỏ hàng</a>
                                            <a href="" class="btn btn1"> <i class="fa fa-heart"></i> </a>
                                            <a href="" class="btn btn1"> Xem sản phẩm </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="container block-info mt-3">
                        <div data-v-5a4f0845="">
                            <div data-v-5a4f0845="" class="nothing-in-cart">
                                <img src="{{ asset('uploads\slider\a60759ad1dabe909c46a817ecbf71878.png') }}"
                                    width="134px" height="134px" alt="">
                                <p data-v-5a4f0845="">Không tìm thấy kết quả nào.<br />Hãy thử sử dụng các từ khóa chung
                                    chung hơn
                                </p> <a data-v-5a4f0845="" href="{{ url('/') }}" class="go-back">Quay lại
                                    trang chủ</a>
                            </div>
                        </div>
                    </div>
                @endforelse
                <div class="col-md-10">
                    {{ $searchProducts->appends(request()->input())->links() }}
                    {{-- ->appends(request()->input()) dùng để giữ lại các tham số tìm kiếm khi người dùng chuyển qua các trang phân trang. Nó sẽ thêm các tham số hiện có trong yêu cầu (request) 
                        vào các liên kết phân trang. --}}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
