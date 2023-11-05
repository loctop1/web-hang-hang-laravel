@extends('layouts.admin')
@section('content')
    <style>
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card label {
            font-size: 14px;
            color: #ffffff;
            display: block;
            margin-bottom: 10px;
        }

        .card h1 {
            font-size: 36px;
            color: #ff8a00;
            margin: 0;
        }

        .card a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 20px;
            background-color: #000000;
            color: #fff;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .card a:hover {
            background-color: #ff8a00;
        }

        hr {
            border: none;
            border-top: 1px solid #e0e0e0;
            margin: 20px 0;
        }
    </style>
    <div class="row">
        <div class="col-md-12 grid-margin">
            @if (session('message'))
                <h2 class="alert alert-success">{{ session('message') }}</h2>
                {{-- @if (session('message')): Đây là một câu lệnh điều kiện trong blade template của Laravel. 
          Nó kiểm tra xem có một session có tên là 'message' được thiết lập hay không. Nếu session tồn tại và có giá trị,
          câu lệnh trong khối @if sẽ được thực thi.
          <h1 style="color: green;">{{ session('message') }}</h1>: Đây là một phần tử HTML <h1> được sử dụng 
          để hiển thị nội dung của session có tên là 'message'. Nếu session tồn tại, nội dung sẽ được hiển thị 
          bên trong thẻ <h1> và có màu chữ là màu xanh lá cây.  --}}
            @endif
            <div class="me-md-3 me-xl-5">
                <h2>Trang chủ</h2>
                <p class="mb-md-0">
                    Trang quản trị cửa hàng
                </p>
                <hr style="height: 3px;color:black;">
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-body bg-primary text-white mb-3 fw-bold">
                        <label for="">Tổng đơn hàng</label>
                        <h1>{{ $totalOrder }}</h1>
                        <a href="{{ url('admin/orders') }}" class="text-white fw-bold">Xem</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body bg-success text-white mb-3 fw-bold">
                        <label for="">Ngày đặt hàng</label>
                        <h1>{{ $todayOrder }}</h1>
                        <a href="{{ url('admin/orders') }}" class="text-white fw-bold">Xem</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body bg-warning text-white mb-3 fw-bold">
                        <label for="">Tháng</label>
                        <h1>{{ $thisMonthOrder }}</h1>
                        <a href="{{ url('admin/orders') }}" class="text-white fw-bold">Xem</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body bg-danger text-white mb-3 fw-bold">
                        <label for="">Năm</label>
                        <h1>{{ $thisYearOrder }}</h1>
                        <a href="{{ url('admin/orders') }}" class="text-white fw-bold">Xem</a>
                    </div>
                </div>
            </div>

            <hr style="height: 3px;color:black;">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-body bg-primary text-white mb-3 fw-bold">
                        <label for="">Tổng số sản phẩm</label>
                        <h1>{{ $totalProducts }}</h1>
                        <a href="{{ url('admin/products') }}" class="text-white fw-bold">Xem</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body bg-success text-white mb-3 fw-bold">
                        <label for="">Tổng danh mục sản phẩm</label>
                        <h1>{{ $totalCategories }}</h1>
                        <a href="{{ url('admin/category') }}" class="text-white fw-bold">Xem</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body bg-warning text-white mb-3 fw-bold">
                        <label for="">Tổng thương hiệu sản phẩm</label>
                        <h1>{{ $totalBrands }}</h1>
                        <a href="{{ url('admin/brands') }}" class="text-white fw-bold">Xem</a>
                    </div>
                </div>
            </div>

            <hr style="height: 3px;color:black;">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-body bg-primary text-white mb-3 fw-bold">
                        <label for="">Tất cả tài khoản</label>
                        <h1>{{ $totalAllUsers }}</h1>
                        <a href="{{ url('admin/users') }}" class="text-white fw-bold">Xem</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body bg-success text-white mb-3 fw-bold">
                        <label for="">Tổng số khách hàng</label>
                        <h1>{{ $totalUser }}</h1>
                        <a href="{{ url('admin/users') }}" class="text-white fw-bold">Xem</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body bg-warning text-white mb-3 fw-bold">
                        <label for="">Tổng người quản trị</label>
                        <h1>{{ $totalAdmin }}</h1>
                        <a href="{{ url('admin/users') }}" class="text-white fw-bold">Xem</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
