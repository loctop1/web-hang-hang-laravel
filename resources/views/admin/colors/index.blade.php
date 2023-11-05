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
                        Danh sách màu sắc sản phẩm
                        <a href="{{ url('admin/colors/create') }}"
                            class="btn btn-danger float-end btn-sm text-light fw-bolder fst-italic">
                            Thêm màu sắc sản phẩm
                        </a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <thead class="btn-primary text-light fw-bold table-bordered border-dark border-2">
                            <tr>
                                <th class="fs-5 border-dark border-2">ID</th>
                                <th class="fs-5 border-dark border-2">Màu sắc sản phẩm</th>
                                <th class="fs-5 border-dark border-2">Mã màu</th>
                                <th class="fs-5 border-dark border-2">Tùy chọn</th>
                                <th class="fs-5 border-dark border-2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="btn-warning fw-bold border-dark border-2">
                            @foreach ($colors as $item)
                                <tr class="border-dark border-2">
                                    <td class="border-dark border-2">{{ $item->id }}</td>
                                    <td class="border-dark border-2">{{ $item->name }}</td>
                                    <td class="border-dark border-2">{{ $item->code }}</td>
                                    <td class="border-dark border-2">{{ $item->status ? 'Ẩn':'Hiển thị' }}</td>
                                    <td class="border-dark border-2">
                                        <a href="{{ url('admin/colors/' . $item->id . '/edit') }}"
                                            class="btn btn-sm btn-success">Sửa</a>
                                        <a href="{{ url('admin/colors/'. $item->id .'/delete') }}" onclick="return confirm('Bạn có chắc chắn muốn xóa màu sắc sản phẩm này không?')"
                                            class="btn btn-sm btn-danger">Xóa</a>
                                        {{-- return comfirm được sử dụng để trả về giá trị true hoặc false cho sự kiện 
                                        onclick. Khi giá trị trả về là true, sự kiện sẽ được kích hoạt và liên kết 
                                        sẽ chuyển hướng đến đích đã được định nghĩa trong thuộc tính href. Khi giá 
                                        trị trả về là false, sự kiện sẽ không được kích hoạt và không có hành động 
                                        tiếp theo xảy ra.
                                        Khi người dùng nhấp vào liên kết "Xóa", hộp thoại xác nhận sẽ xuất hiện với 
                                        câu thông báo "Bạn có chắc chắn muốn xóa sản phẩm này không!". Nếu người 
                                        dùng nhấn "OK" trong hộp thoại, sự kiện xóa sẽ được kích hoạt và ngược lại, 
                                        nếu người dùng nhấn "Cancel", sự kiện xóa sẽ không được kích hoạt. --}}
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
