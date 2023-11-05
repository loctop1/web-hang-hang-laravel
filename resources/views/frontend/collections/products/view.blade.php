@extends('layouts.app')
{{-- Tiêu đề trang web --}}
@section('title')
    {{ $product->name }}
@endsection

@section('meta_keyword')
    {{ $product->meta_keyword }}
@endsection

@section('meta_description')
    {{ $product->meta_description }}
@endsection
{{-- Bố cục trang web --}}
@section('content')
    {{-- Thông tin sản phẩm --}}
    <div>
        <livewire:frontend.product.view :category="$category" :product="$product" />
    </div>
@endsection