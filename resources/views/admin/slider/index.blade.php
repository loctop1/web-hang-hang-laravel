@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>
                        Danh sách thanh trượt sản phẩm
                        <a href="{{ url('admin/sliders/create') }}"
                            class="btn btn-danger float-end btn-sm text-light fw-bolder fst-italic">
                            Thêm thanh trượt sản phẩm
                        </a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="btn-primary text-light fw-bold table-bordered border-dark border-2">
                            <tr>
                                <th class="fs-5 border-dark border-2">ID</th>
                                <th class="fs-5 border-dark border-2">Tên sản phẩm</th>
                                <th class="fs-5 border-dark border-2">Mô tả</th>
                                <th class="fs-5 border-dark border-2">Ảnh</th>
                                <th class="fs-5 border-dark border-2">Tùy chọn</th>
                                <th class="fs-5 border-dark border-2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="btn-warning fw-bold border-dark border-2">
                            @foreach ($sliders as $slider)
                                <tr>
                                    <td class="border-dark border-2">{{ $slider->id }}</td>
                                    <td class="border-dark border-2">{{ $slider->title }}</td>
                                    <td class="border-dark border-2">{{ $slider->description }}</td>
                                    <td class="border-dark border-2">
                                        <img src="{{ asset($slider->image) }}" style="width:100px;height:100px;"
                                            alt="">
                                    </td>
                                    <td class="border-dark border-2">{{ $slider->status == '0' ? 'Hiển thị' : 'Ẩn' }}</td>
                                    <td class="border-dark border-2">
                                        <a href="{{ url('admin/sliders/' . $slider->id . '/edit') }}"
                                            class="btn btn-success text-light fw-bold">Sửa</a>
                                        <a href="{{ url('admin/sliders/' . $slider->id . '/delete') }}"
                                            class="btn btn-danger text-light fw-bold" 
                                            onclick="return confirm('Bạn có muốn xóa thanh trượt sản phẩm này không?');">
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
