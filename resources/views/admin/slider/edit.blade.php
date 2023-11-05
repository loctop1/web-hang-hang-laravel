@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message3'))
                <div class="alert alert-success">
                    {{ session('message3') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>
                        Chỉnh sửa thanh trượt sản phẩm
                        <a href="{{ url('admin/sliders/') }}"
                            class="btn btn-danger float-end btn-sm text-light fw-bolder fst-italic">
                            Quay lại danh sách thanh trượt sản phẩm
                        </a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/sliders/'.$slider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <h3><b><label for="">Tên sản phẩm</label></b></h3>
                            <input type="text" name="title" value="{{ $slider->title }}" class="form-control"
                                placeholder="Vui lòng điền tên sản phẩm" />
                        </div>
                        <div class="mb-3">
                            <h3><b><label for="">Mô tả</label></b></h3>
                            <textarea name="description" class="form-control" rows="3">{{ $slider->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <h3><b><label for="">Ảnh</label></b></h3>
                            <input type="file" name="image" class="form-control" />
                            <img src="{{ asset("$slider->image") }}" style="widht:100px;height:100px;" alt="Slider" />
                        </div>
                        <div class="mb-3">
                            <h3><b><label for="">Tùy chọn</label></b></h3><br />
                            <input type="checkbox" name="status" {{ $slider->status == '1' ? 'checked' : '' }}
                                style="width: 17px;height:17px;" /> Đã chọn = Ẩn, Không chọn = Hiển thị
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary text-light fw-bold fs-5">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
