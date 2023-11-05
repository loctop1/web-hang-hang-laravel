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
                        Danh sách sản phẩm
                        <a href="{{ url('admin/products/create') }}"
                            class="btn btn-danger float-end btn-sm text-light fw-bolder fst-italic">
                            Thêm sản phẩm
                        </a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <thead class="btn-primary text-light fw-bold table-bordered border-dark border-2">
                            <tr>
                                <th class="fs-5 border-dark border-2">ID</th>
                                <th class="fs-5 border-dark border-2">Danh mục sản phẩm</th>
                                <th class="fs-5 border-dark border-2">Sản phẩm</th>
                                <th class="fs-5 border-dark border-2">Giá tiền</th>
                                <th class="fs-5 border-dark border-2">Số lượng</th>
                                <th class="fs-5 border-dark border-2">Tùy chọn</th>
                                <th class="fs-5 border-dark border-2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="btn-warning fw-bold border-dark border-2">
                            @forelse ($products as $product)
                                <tr class="border-dark border-2">
                                    <td class="border-dark border-2">{{ $product->id }}</td>
                                    <td class="border-dark border-2">
                                        @if ($product->category)
                                            {{ $product->category->name }}
                                        @else
                                            <p class="text-danger">Không có danh mục sản phẩm nào</p>
                                        @endif
                                    </td>
                                    <td class="border-dark border-2">{{ $product->name }}</td>
                                    <td class="border-dark border-2">{{ number_format($product->selling_price, 0, ',','.') }}₫</td>
                                    <td class="border-dark border-2">{{ $product->quantity }}</td>
                                    <td class="border-dark border-2">{{ $product->status == '1' ? 'Ẩn' : 'Hiển thị' }}</td>
                                    <td class="border-dark border-2">
                                        <a href="{{ url('admin/products/' . $product->id . '/edit') }}"
                                            class="btn btn-sm btn-success text-light fw-bold">Sửa</a>
                                        <a href="{{ url('admin/products/'. $product->id .'/delete') }}" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')"
                                            class="btn btn-sm btn-danger text-light fw-bold">Xóa</a>
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
                            @empty
                                <tr class="fw-bold ">
                                    <td class="fs-6" colspan="7" style="color: red;">Không có sản phẩm nào trong giỏ
                                        hàng</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
