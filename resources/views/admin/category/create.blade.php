@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>
                    Thêm danh mục sản phẩm
                    <a href="{{ url('admin/category') }}" class="btn btn-primary float-end btn-sm text-light fw-bolder fst-italic">
                        Quay lại danh sách sản phẩm
                    </a>
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ url('admin/category') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h4><label for="">Tên sản phẩm</label></h4>
                            <input type="text" name="name" class="form-control" placeholder="Vui lòng điền tên sản phẩm"/>
                            <b>
                                @error('name')
                                    <small class="text-danger">{{ $message = "Vui lòng điền thông tin này!" }}</small>
                                @enderror
                            </b>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h4><label for="">Loại sản phẩm</label></h4>
                            <input type="text" name="slug" class="form-control" placeholder="Vui lòng điền tên sản phẩm"/>
                            <b>
                                @error('slug')
                                    <small class="text-danger">{{ $message = "Vui lòng điền thông tin này!" }}</small>
                                @enderror
                            </b>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h4><label for="">Mô tả sản phẩm</label></h4>
                            <textarea name="description"  class="form-control" rows="3"></textarea>
                            <b>
                                @error('description')
                                    <small class="text-danger">{{ $message = "Vui lòng điền thông tin này!" }}</small>
                                @enderror
                            </b>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h4><label for="">Ảnh sản phẩm</label></h4>
                            <input type="file" name="image" class="form-control" />
                            <b>
                                @error('name')
                                    <small class="text-danger">{{ $message = "Vui lòng chọn file ảnh!" }}</small>
                                @enderror
                            </b>    
                        </div>
                        <div class="col-md-6 mb-3">
                            <h4><label for="">Status</label></h4><br/>
                            <input type="checkbox" name="status" />
                        </div>
                        <div class="col-md-12">
                            <h3>SEO sản phẩm</h3>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h4><label for="">Meta title</label></h4>
                            <input type="text" name="meta_title" class="form-control" placeholder="Vui lòng điền tên sản phẩm"/>
                            <b>
                                @error('meta_title')
                                    <small class="text-danger">{{ $message = "Vui lòng điền thông tin này!" }}</small>
                                @enderror
                            </b>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h4><label for="">Từ khóa sản phẩm</label></h4>
                            <textarea name="meta_keyword"  class="form-control" rows="3"></textarea>
                            <b>
                                @error('meta_keyword')
                                    <small class="text-danger">{{ $message = "Vui lòng điền thông tin này!" }}</small>
                                @enderror
                            </b>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h4><label for="">Meta mô tả sản phẩm</label></h4>
                            <textarea name="meta_description"  class="form-control" rows="3"></textarea>
                            <b>
                                @error('meta_description')
                                    <small class="text-danger">{{ $message = "Vui lòng điền thông tin này!" }}</small>
                                @enderror
                            </b>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-danger float-end text-light fw-bolder fst-italic">Lưu sản phẩm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection