<div>
    @include('livewire.admin.brand.modal-form')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            @if (session('message1'))
                <div class="alert alert-success">{{ session('message1') }}</div>
            @endif
            @if (session('message2'))
                <div class="alert alert-success">{{ session('message2') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>
                        Danh sách thương hiệu sản phẩm
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addBrandModal"
                            class="btn btn-primary btn-sm float-end text-light fw-bold">
                            Thêm thương hiệu sản phẩm
                        </a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-warning">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên thương hiệu</th>
                                <th>Danh mục sản phẩm</th>
                                <th>Từ khóa</th>
                                <th>Status</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $brand )
                                <tr>
                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        @if ($brand->category)
                                            {{ $brand->category->name }}
                                        @else
                                            <h6 class="text-danger fw-bold">
                                                Không có danh mục sản phẩm nào cho thương hiệu "{{ $brand->name }}".
                                            </h6>
                                        @endif
                                    </td>
                                    <td>{{ $brand->slug }}</td>
                                    <td>{{ $brand->status == '1' ? 'ẨN':'Hiển thị' }}</td>
                                    <td>
                                        <a href="" wire:click = "editBrand({{ $brand->id }})" data-bs-toggle="modal" data-bs-target="#updateBrandModal" class="btn btn-success text-light fw-bold">
                                            Sửa 
                                        </a>
                                        <a href="" wire:click = "deleteBrand({{ $brand->id }})" data-bs-toggle="modal" data-bs-target="#deleteBrandModal" class="btn btn-danger text-light fw-bold">
                                            Xóa
                                        </a>
                                    </td>                                   
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="color: red;"><b>Không có thương hiệu sản phẩm nào!</b></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        window.addEventListener('close-modal', event => {
            /*Đây là hàm để đăng ký một sự kiện nghe (event listener) cho sự kiện có tên là "close-model". Khi sự kiện này 
            được kích hoạt (thông qua lệnh window.dispatchEvent), đoạn mã trong hàm sẽ được thực thi. */
            $('#addBrandModal').modal('hide');
            /*Đây là một hàm jQuery để ẩn modal có id "deleteModal". Hàm này được gọi khi sự kiện "close-model" xảy ra. 
            Bằng cách gọi phương thức modal('hide'), modal sẽ được ẩn đi và không còn hiển thị trên giao diện người dùng.*/
            $('#updateBrandModal').modal('hide');
            $('#deleteBrandModal').modal('hide');
        });
    </script>
@endpush
{{-- @push('script') là một lệnh Blade trong Laravel để đẩy mã JavaScript vào phần đầu hoặc cuối của phần mở rộng <script> 
    trong tệp layout chính. Trong trường hợp này, mã JavaScript sẽ được đẩy vào cuối phần mở rộng <script>. --}}
