@extends('layouts.app')
@section('title', 'Quên mật khẩu?')
@section('content')

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                @if (session('message'))
                    <h5 class="alert alert-success mb-2">{{ session('message') }}</h5>
                @endif

                @if ($errors->any())
                <div class="text-danger fw-bold alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <div class="text-danger fw-bold fs-5">{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <div class="card shadow">
                    <div class="card-header bg-primary">
                        <h4 class="mb-0 text-white">
                            Thay Đổi Mật Khẩu
                            <a href="{{ url('profile') }}" class="btn btn-danger fw-bold float-end">Quay lại</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('change-password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật Khẩu Hiện Tại</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Nhập mật khẩu hiện tại" />
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật Khẩu Mới</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới" />
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Xác Nhận Mật Khẩu</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu mới" />
                            </div>
                            <div class="mb-3 text-end">
                                <hr>
                                <button type="submit" class="btn btn-primary">Cập Nhật Mật Khẩu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
