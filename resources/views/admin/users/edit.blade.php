@extends('layouts.admin')
@section('title', 'Chỉnh sửa thông tin người dùng');
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message3'))
                <div class="alert alert-success fw-bold">
                    {{ session('message3') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="text-danger fw-bold alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div class="text-danger fw-bold fs-5">{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>
                        Chỉnh sửa thông tin người dùng
                        <a href="{{ url('admin/users') }}"
                            class="btn btn-danger float-end btn-sm text-light fw-bolder fst-italic">
                            Quay lại danh sách khách hàng
                        </a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/users/' . $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Tên khách hàng</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control border-dark"
                                    placeholder="Vui lòng điền tên khách hàng">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email</label> 
                                <input type="email" name="email" readonly value="{{ $user->email }}" class="form-control border-dark"
                                    placeholder="Vui lòng điền Email">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Mật khẩu</label>
                                <input type="password" name="password" class="form-control border-dark"
                                    placeholder="Vui lòng điền mật khẩu">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Chọn chức vụ</label>
                                <select name="role_as" class="form-control border-dark">
                                    <option value="" class="fw-bold text-dark">Vui lòng chọn chức vụ</option>
                                    <option value="0" {{ $user->role_as == '0' ? 'selected':'' }}>Khách hàng</option>
                                    <option value="1" {{ $user->role_as == '1' ? 'selected':'' }}>Người quản trị</option>
                                </select>
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary text-light fw-bold">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
