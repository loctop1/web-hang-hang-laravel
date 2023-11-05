@extends('layouts.admin')
@section('title', 'Cài đặt chung')
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        @if (session('message'))
            <div class="alert alert-success mb-3">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ url('/admin/settings') }}" method="POST">
            @csrf
            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h2 class="text-white mb-0">
                        Cài dặt trang Web
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4" >Tên trang Web</label>
                            <input type="text" name="website_name" value="{{ $setting->website_name ?? '' }}" class="form-control border-dark border-2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Đường dẫn URL</label>
                            <input type="text" name="website_url" value="{{ $setting->website_url ?? '' }}" class="form-control border-dark border-2">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="fw-bold fs-4">Tiêu đề trang Web</label>
                            <input type="text" name="page_title" value="{{ $setting->page_title ?? '' }}" class="form-control border-dark border-2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Từ khóa</label>
                            <textarea name="meta_keyword" class="form-control border-dark border-2" rows="3">{{ $setting->meta_keyword ?? ''}}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Mô tả</label>
                            <textarea name="meta_description" class="form-control border-dark border-2" rows="3">{{ $setting->meta_description ?? ''}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h2 class="text-white mb-0">
                        Thông tin trang Web
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="" class="fw-bold fs-4" >Địa chỉ trang Web</label>
                            <textarea name="address" id="" class="form-control border-dark border-2" rows="3">{{ $setting->address ?? ''}}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Số điện thoại 1 *</label>
                            <input type="text" name="phone1" value="{{ $setting->phone1 ?? ''}}" class="form-control border-dark border-2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Điện thoại 2 *</label>
                            <input type="text" name="phone2" value="{{ $setting->phone2 ?? ''}}" class="form-control border-dark border-2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Email Id 1 *</label>
                            <input type="text" name="email1" value="{{ $setting->email1 ?? '' }}" class="form-control border-dark border-2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Email Id 2 *</label>
                            <input type="text" name="email2" value="{{ $setting->email2 ?? '' }}" class="form-control border-dark border-2">
                        </div>                
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h2 class="text-white mb-0">
                        Mạng xã hội
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Facebook (Tùy chọn)</label>
                            <input type="text" name="facebook" value="{{ $setting->facebook ?? '' }}" class="form-control border-dark border-2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Twitter (Tùy chọn)</label>
                            <input type="text" name="twitter" value="{{ $setting->twitter ?? ''}}" class="form-control border-dark border-2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Instagram (Thùy chọn)</label>
                            <input type="text" name="instagram" value="{{ $setting->instagram ?? ''}}" class="form-control border-dark border-2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="fw-bold fs-4">Youtube (Tùy chọn)</label>
                            <input type="text" name="youtube" value="{{ $setting->youtube ?? ''}}" class="form-control border-dark border-2">
                        </div>                
                    </div>
                </div>
            </div>
            
            <div class="text-end">
                <button type="submit" class="btn btn-primary text-white fw-bold fs-3">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
@endsection