@extends('layouts.app')
{{-- Tiêu đề trang web --}}
@section('title', 'Thông tin cá nhân')
{{-- Bố cục trang web --}}
@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h2 class="fw-bold">
                        Thông tin cá nhân
                        <a href="{{ url('change-password') }}" class="btn btn-warning fw-bold float-end">Quên mật khẩu?</a>
                    </h2>
                    <div class="underline mb-4"></div>
                </div>

                <div class="col-md-10">

                    @if (session('message'))
                        <p class="alert alert-success">
                            {{ session('message') }}
                        </p>
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
                                Thông tin người dùng
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('profile') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Tên đăng nhập</label>
                                            <input type="text" name="username" value="{{ Auth::user()->name }}"
                                                placeholder="Vui lòng điền tên đăng nhập" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Địa chỉ Email</label>
                                            <input type="email" readonly value="{{ Auth::user()->email }}"
                                                placeholder="Vui lòng điền Email" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Số điện thoại</label>
                                            <input type="text" name="phone" value="{{ Auth::user()->userDetail->phone ?? '' }}"
                                                placeholder="Vui lòng nhập số điện thoại" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Mã pin</label>
                                            <input type="text" name="pin_code" value="{{ Auth::user()->userDetail->pin_code ?? '' }}"
                                                placeholder="Vui lòng điền mã Pin" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="">Địa chỉ</label>
                                            <textarea name="address" class="form-control" rows="3">{{ Auth::user()->userDetail->address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary fw-bold">Lưu thông tin</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
