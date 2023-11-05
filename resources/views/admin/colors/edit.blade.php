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
                        Chỉnh sửa màu sắc sản phẩm
                        <a href="{{ url('admin/colors') }}"
                            class="btn btn-danger float-end btn-sm text-light fw-bolder fst-italic">
                            Quay lại danh sách màu sắc sản phẩm
                        </a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/colors/'.$color->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <h3><b><label for="">Màu sắc</label></b></h3>
                            <input type="text" name="name" value="{{ $color->name }}" class="form-control" placeholder="Vui lòng điền màu sắc sản phẩm">
                        </div>
                        <div class="mb-3">
                            <h3><b><label for="">Mã màu</label></b></h3>
                            <input type="text" name="code" value="{{ $color->code }}" class="form-control" placeholder="Vui lòng điền màu sắc sản phẩm">
                        </div>
                        <div class="mb-3">
                            <h3><b><label for="">Tùy chọn</label></b></h3><br/>
                            <input type="checkbox" name="status" {{ $color->status ? 'checked':'' }} width="40px" height="40px"> Đã chọn = Ẩn, Không chọn = Hiển thị
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
