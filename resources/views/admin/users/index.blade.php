@extends('layouts.admin')
@section('title', 'Danh sách khách hàng');
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message3'))
                <div class="alert alert-success fw-bold">
                    {{ session('message3') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>
                        Danh sách khách hàng
                        <a href="{{ url('admin/users/create') }}"
                            class="btn btn-danger float-end btn-sm text-light fw-bolder fst-italic">
                            Quay lại danh sách khách hàng
                        </a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped ">
                        <thead class="btn-primary text-light fw-bold table-bordered border-dark border-2">
                            <tr>
                                <th class="fs-5 border-dark border-2">ID</th>
                                <th class="fs-5 border-dark border-2">Tên khách hàng</th>
                                <th class="fs-5 border-dark border-2">Email</th>
                                <th class="fs-5 border-dark border-2">Chức vụ</th>
                                <th class="fs-5 border-dark border-2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="btn-warning fw-bold border-dark border-2">
                            @forelse ($users as $user)
                                <tr class="border-dark border-2">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->role_as == '0')
                                        {{-- Nó kiểm tra xem giá trị của thuộc tính "role_as" của đối tượng người dùng có bằng '0' hay không. --}}
                                            <label for="" class="badge btn-primary fw-bold">Khách hàng</label>
                                            {{-- Nếu giá trị của "role_as" là '0', đoạn mã này sẽ hiển thị một nhãn (label) có màu nền và chữ màu trắng, có gắn lớp (class) để tạo hiệu ứng badge 
                                            và đậm (bold). Nội dung của nhãn là "Khách hàng". --}}
                                        @elseif ($user->role_as == '1')
                                        {{-- Nếu giá trị của "role_as" không phải '0', thì nó sẽ kiểm tra xem có phải là '1' hay không. --}}
                                            <label for="" class="badge btn-success fw-bold">Người quản trị</label>
                                            {{-- Nếu giá trị của "role_as" là '1', đoạn mã này sẽ hiển thị một nhãn (label) tương tự như trên, nhưng với nội dung "Người quản trị". --}}
                                        @else
                                            <label for="" class="badge btn-danger fw-bold">Không có thông tin</label>
                                            {{-- Nếu không có điều kiện nào trong IF hoặc ELSEIF được thỏa mãn, đoạn mã này sẽ hiển thị một nhãn (label) với nội dung "Không có thông tin". --}}
                                        @endif
                                    </td>
                                    <td class="border-dark border-2">
                                        <a href="{{ url('admin/users/' . $user->id . '/edit') }}"
                                            class="btn btn-sm btn-success text-light fw-bold">Sửa</a>
                                        <a href="{{ url('admin/users/'. $user->id .'/delete') }}" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không?')"
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
                                    <td class="fs-6" colspan="5" style="color: red;">Không có tài khoản nào
                                        hàng</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
