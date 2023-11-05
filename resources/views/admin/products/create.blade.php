@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Thêm sản phẩm
                        <a href="{{ url('admin/products') }}"
                            class="btn btn-info float-end btn-sm text-light fw-bolder fst-italic fs-5">
                            Quay lại danh sách sản phẩm
                        </a>
                    </h3>
                </div>
                <div class="col-md-12 text-start">
                    @if ($errors->any())
                        <div class="text-danger fw-bold alert alert-warning">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="card-body d-flex justify-content-center align-items-center ">
                    <form action="{{ url('admin/products') }}" class="col-md-11 btn btn-warning text-start" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <ul class="nav nav-tabs " id="myTab" role="tablist">
                            <li class="nav-item " role="presentation">
                                <button class="nav-link active text-dark fw-bold fs-4" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">Trang chủ</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark fw-bold fs-4" id="seotag-tab" data-bs-toggle="tab"
                                    data-bs-target="#seotag-tab-pane" type="button" role="tab"
                                    aria-controls="seotag-tab-pane" aria-selected="false">SEO Sản Phẩm</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark fw-bold fs-4" id="details-tab" data-bs-toggle="tab"
                                    data-bs-target="#details-tab-pane" type="button" role="tab"
                                    aria-controls="details-tab-pane" aria-selected="false">Chi tiết sản phẩm</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark fw-bold fs-4" id="image-tab" data-bs-toggle="tab"
                                    data-bs-target="#image-tab-pane" type="button" role="tab"
                                    aria-controls="image-tab-pane" aria-selected="false">Ảnh sản phẩm</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-dark fw-bold fs-4" id="color-tab" data-bs-toggle="tab"
                                    data-bs-target="#color-tab-pane" type="button" role="tab"
                                    aria-controls="color-tab-pane" aria-selected="false">Màu sắc sản phẩm</button>
                            </li>
                        </ul><br />
                        {{-- Thông tin sản phẩm --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade border p-3 show active" id="home-tab-pane" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                <div class="mb-3">
                                    <h3><b><label for="">Danh sách sản phẩm</label></b></h3>
                                    <select name="category_id"
                                        class="form-control btn btn-danger text-start text-light tw-bold">
                                        <option value="">Chọn danh sách sản phẩm</option>
                                        @foreach ($categories as $category)
                                            <option class="btn btn-success text-start text-light"
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Vui lòng nhập tên sản phẩm" />
                                </div>
                                <div class="mb-3">
                                    <label for="">Từ khóa</label>
                                    <input type="text" name="slug" class="form-control"
                                        placeholder="Vui lòng nhập tư khóa sản phẩm" />
                                </div>
                                <div class="mb-3">
                                    <h3><b><label for="">Chọn thương hiệu sản phẩm</label></b></h3>
                                    <select name="brand"
                                        class="form-control btn btn-danger text-start text-light tw-bold">
                                        <option value="">Chọn thương hiệu sản phẩm</option>
                                        @foreach ($brands as $brand)
                                            <option class="btn btn-success text-start text-light"
                                                value="{{ $brand->name }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <h3><b><label for="">Mô tả ngắn sản phẩm (500 từ)</label></b></h3>
                                    <textarea name="small_description" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="mb-3">
                                    <h3><b><label for="">Mô tả sản phẩm</label></b></h3>
                                    <textarea name="description" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                            {{-- SEO sản phẩm --}}
                            <div class="tab-pane fade border p-3" id="seotag-tab-pane" role="tabpanel"
                                aria-labelledby="seotag-tab" tabindex="0">
                                <div class="mb-3">
                                    <h3><b><label for="">Hastag</label></b></h3>
                                    <input type="text" name="meta_title" class="form-control"
                                        placeholder="Vui lòng nhập tư khóa sản phẩm" />
                                </div>
                                <div class="mb-3">
                                    <h3><b><label for="">Hastag mô tả sản phẩm</label></b></h3>
                                    <textarea name="meta_description" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="mb-3">
                                    <h3><b><label for="">Từ khóa sản phẩm</label></b></h3>
                                    <textarea name="meta_keyword" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                            {{-- chi tiết sản phẩm --}}
                            <div class="tab-pane fade border p-3" id="details-tab-pane" role="tabpanel"
                                aria-labelledby="details-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Giá gốc</label></b></h3>
                                            <input type="text" name="original_price" class="form-control"
                                                placeholder="Vui lòng nhập giá tiền sản phẩm" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Giảm giá</label></b></h3>
                                            <input type="text" name="selling_price" class="form-control"
                                                placeholder="Vui lòng nhập giá sale" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Số lượng</label></b></h3>
                                            <input type="number" name="quantity" class="form-control"
                                                placeholder="Vui lòng nhập số lượng" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Sản phẩm theo xu hướng</label></b></h3>
                                            <input type="checkbox" name="trending" style="width:20px; height:20px;" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Sản phẩm nổi bật</label></b></h3>
                                            <input type="checkbox" name="featured" style="width:20px; height:20px;" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <h3><b><label for="">Tùy chọn</label></b></h3>
                                            <input type="checkbox" name="status" style="width:20px; height:20px;" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Ảnh sản phẩm --}}
                            <div class="tab-pane fade border p-3" id="image-tab-pane" role="tabpanel"
                                aria-labelledby="image-tab" tabindex="0">
                                <div class="md-3">
                                    <h3><b><label for="">Tải ảnh sản phẩm</label></b></h3>
                                    <input type="file" name="image[]" multiple class="form-control" />
                                </div>
                            </div><br />
                            {{-- Màu sắc sản phẩm --}}
                            <div class="tab-pane fade border p-3" id="color-tab-pane" role="tabpanel"
                                aria-labelledby="color-tab" tabindex="0">
                                <div class="md-3">
                                    <h3><b><label for="">Chọn màu sản phẩm</label></b></h3>
                                    <hr
                                        style="height: 7px; border-style: 4px solid; border-width: 4; color: red; background-color: red;" />
                                    <div class="row">
                                        @forelse ($colors as $coloritem)
                                            <div class="col-md-4 fs-5 fw-bold">
                                                <div class="p-2 border border-dark border-3">
                                                    Màu sắc: <input type="checkbox" name="colors[{{ $coloritem->id }}]"
                                                        style="width:15px; height:15px;" value="{{ $coloritem->id }}" />
                                                    {{-- name="colors[{{ $coloritem->id }}]": Đây là thuộc tính name của 
                                                        input checkbox. Nó được định danh cho mỗi màu sắc trong danh sách 
                                                        $colors. Biến $coloritem->id được sử dụng để tạo ra một khóa duy 
                                                        nhất cho mỗi checkbox màu sắc. Khi form được gửi đi, các checkbox 
                                                        được chọn sẽ gửi giá trị của thuộc tính value tương ứng với khóa này. --}}
                                                    <b class="fs-5">{{ $coloritem->name }}</b>
                                                    <br /><br />
                                                    <p class="fs-5">Số lượng sản phẩm:</p><input type="number"
                                                        name="colorquantity[{{ $coloritem->id }}]"
                                                        style="width:70px; border:2px solid" />
                                                    {{-- name="quantity[{{ $coloritem->id }}]": Đây là thuộc tính name 
                                                        của input số (input type="number"). Tương tự như trên, nó cũng được 
                                                        định danh cho mỗi màu sắc trong danh sách $colors. Biến 
                                                        $coloritem->id được sử dụng để tạo ra một khóa duy nhất cho mỗi 
                                                        input số. Khi form được gửi đi, giá trị số lượng sản phẩm nhập vào 
                                                        sẽ được gửi đi kèm với khóa này. --}}
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-md-12">
                                                <h1 style="color:red;">Không có màu sắc nào!</h1>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div><br />
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary text-light fw-bold fs-5">Gửi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
