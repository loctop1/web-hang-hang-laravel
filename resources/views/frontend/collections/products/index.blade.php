@extends('layouts.app')
{{-- Tiêu đề trang web --}}
@section('title')
    {{ $category->name }}
@endsection

@section('meta_keyword')
    {{ $category->meta_keyword }}
@endsection

@section('meta_description')
    {{ $category->meta_description }}
@endsection
{{-- Bố cục trang web --}}
@section('content')
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-4 fw-bold">Tất cả sản phẩm</h2>
                </div>
                {{-- Khung giao diện tất cả sản phẩm --}}
                <livewire:frontend.product.index :category="$category" />
                {{-- ":products="$products"": Đây là một biến đối tượng "$products" được truyền vào component, giả 
                định là danh sách các sản phẩm. Component sẽ sử dụng biến này để hiển thị thông tin sản phẩm.
                ":category="$category"": Đây là một biến đối tượng "$category" được truyền vào component, giả định 
                là đại diện cho một danh mục sản phẩm cụ thể. Component có thể sử dụng biến này để hiển thị tên 
                danh mục hoặc thực hiện các tác vụ liên quan đến danh mục đó.
                Tóm lại: Đoạn mã trên cung cấp một cách để sử dụng component "frontend.product.index" trong ứng 
                dụng Laravel Livewire và truyền vào danh sách sản phẩm và danh mục tương ứng để hiển thị. --}}
            </div>
        </div>
    </div>
@endsection
