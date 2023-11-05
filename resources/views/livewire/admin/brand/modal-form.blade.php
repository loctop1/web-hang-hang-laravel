<!-- Modal -->
<div wire:ignore.self class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm thương hiệu sản phẩm</h1>
                <button type="button" wire:click = "closeModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="storeBrand()">
                <div class="modal-body">
                    {{-- Chọn danh mục sản phẩm --}}
                    <div class="mb-3">
                        <label for="">Chọn danh mục sản phẩm</label>
                        <select wire:model.defer = "category_id" class="form-control bg-primary fw-bold text-light" required>
                            <option value="">-- Chọn danh mục sản phẩm --</option>
                            @foreach ($categories as $cateItem)
                                <option value="{{ $cateItem->id }}" class="bg-danger fw-bold">{{ $cateItem->name }}</option>
                            @endforeach
                        </select>
                        <p>
                            @error('category_id')
                                <small class="text-danger">{{ $message= "Vui lòng điền thông tin này!" }}</small>
                            @enderror
                        </p>
                    </div>
                    <div class="mb-3">
                        <label>Tên thương hiệu sản phẩm</label>
                        <input type="text" wire:model.defer = "name" class="form-control">
                        <p>
                            @error('name')
                                <small class="text-danger">{{ $message= "Vui lòng điền thông tin này!" }}</small>
                            @enderror
                        </p>
                        {{-- wire:model.defer="name" là một directive Livewire được sử dụng để kết nối dữ liệu giữa 
                        trình duyệt và phần tử input.
                        wire:model cho phép bạn liên kết giá trị của phần tử input với một biến hoặc thuộc tính trong 
                        component Livewire. Khi giá trị của phần tử input thay đổi, biến hoặc thuộc tính tương ứng cũng 
                        sẽ được cập nhật tự động.
                        Được sử dụng để kết nối giá trị của phần tử input với thuộc tính "name" của component Livewire. 
                        Directive .defer được sử dụng để trì hoãn việc gửi yêu cầu cập nhật đến server cho đến khi người 
                        dùng kết thúc nhập liệu trong input hoặc có một sự kiện khác kích hoạt. --}}
                    </div>
                    <div class="mb-3">
                        <label>Từ khóa thương hiệu sản phẩm</label>
                        <input type="text" wire:model.defer = "slug" class="form-control">
                        <p>
                            @error('slug')
                                <small class="text-danger">{{ $message= "Vui lòng điền thông tin này!" }}</small>
                            @enderror
                        </p>
                    </div>
                    <div class="mb-3">
                        <label>Tùy chọn</label><br/>
                        <input type="checkbox" wire:model.defer = "status"/> Chọn = Ẩn, Không chọn = Hiển thị
                        <p>
                            @error('status')
                                <small class="text-danger">{{ $message= "Vui lòng điền thông tin này!" }}</small>
                            @enderror
                        </p>
                    </div>
                </div>
                <div class="modal-footer">  
                    <button type="button" wire:click = "closeModal" class="btn btn-danger fw-bold text-light" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary fw-bold text-light">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal chỉnh sửa thương hiệu sản phẩm -->
<div wire:ignore.self class="modal fade" id="updateBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh sửa thương hiệu sản phẩm</h1>
                <button type="button" class="btn-close" wire:click = "closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                {{-- wire:click = "closeModal" là khi click vào thêm thương hiệu sản phẩm nó sẽ không hiện dữ liệu đã 
                sửa ở dưới --}}
            </div>
            {{-- Tạo hiệu ứng icon loading --}}
            <div wire:loading class="p-2">
                {{-- wire:loading được sử dụng để hiển thị các phần tử hoặc nội dung khi một hành động đang được thực hiện.
                    Khi wire:loading được đặt trên một phần tử, nội dung của phần tử đó sẽ chỉ được hiển thị trong quá trình 
                    tải dữ liệu hoặc xử lý hành động. Trong đoạn mã của bạn, <div wire:loading> là một phần tử chứa một 
                    spinner (biểu tượng quay) và thông báo "Đang tải, xin vui lòng chờ trong giây lát...". Khi có một 
                    yêu cầu gửi đi hoặc một hành động đang được xử lý, phần tử này sẽ hiển thị. --}}
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden"></span>
                </div>Đang tải, xin vui lòng chờ trong giây lát...
            </div>
            <div wire:loading.remove>
                {{-- wire:loading.remove được sử dụng để ẩn các phần tử hoặc nội dung trong quá trình tải dữ liệu hoặc xử 
                    lý hành động. Khi wire:loading.remove được đặt trên một phần tử, phần tử đó sẽ chỉ được hiển thị khi 
                    không có hành động nào đang được thực hiện. Trong đoạn mã của bạn, <div wire:loading.remove> chứa một 
                    biểu mẫu (<form>) để cập nhật thông tin thương hiệu. Khi không có yêu cầu gửi đi hoặc không có hành 
                    động nào đang được xử lý, phần tử này sẽ được hiển thị. --}}
                <form wire:submit.prevent="updateBrand()">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="">Chọn danh mục sản phẩm</label>
                            <select wire:model.defer = "category_id" class="form-control bg-primary fw-bold text-light" required>
                                <option value="">-- Chọn danh mục sản phẩm --</option>
                                @foreach ($categories as $cateItem)
                                    <option value="{{ $cateItem->id }}" class="bg-danger fw-bold">{{ $cateItem->name }}</option>
                                @endforeach
                            </select>
                            <p>
                                @error('category_id')
                                    <small class="text-danger">{{ $message= "Vui lòng điền thông tin này!" }}</small>
                                @enderror
                            </p>
                        </div>
                        <div class="mb-3">
                            <label>Tên thương hiệu sản phẩm</label>
                            <input type="text" wire:model.defer = "name" class="form-control">
                            <p>
                                @error('name')
                                    <small class="text-danger">{{ $message= "Vui lòng điền thông tin này!" }}</small>
                                @enderror
                            </p>
                            {{-- wire:model.defer="name" là một directive Livewire được sử dụng để kết nối dữ liệu giữa 
                            trình duyệt và phần tử input.
                            wire:model cho phép bạn liên kết giá trị của phần tử input với một biến hoặc thuộc tính trong 
                            component Livewire. Khi giá trị của phần tử input thay đổi, biến hoặc thuộc tính tương ứng cũng 
                            sẽ được cập nhật tự động.
                            Được sử dụng để kết nối giá trị của phần tử input với thuộc tính "name" của component Livewire. 
                            Directive .defer được sử dụng để trì hoãn việc gửi yêu cầu cập nhật đến server cho đến khi người 
                            dùng kết thúc nhập liệu trong input hoặc có một sự kiện khác kích hoạt. --}}
                        </div>
                        <div class="mb-3">
                            <label>Từ khóa thương hiệu sản phẩm</label>
                            <input type="text" wire:model.defer = "slug" class="form-control">
                            <p>
                                @error('slug')
                                    <small class="text-danger">{{ $message= "Vui lòng điền thông tin này!" }}</small>
                                @enderror
                            </p>
                        </div>
                        <div class="mb-3">
                            <label>Tùy chọn</label><br/>
                            <input type="checkbox" wire:model.defer = "status" style="width: 18px; height: 18px;"/> Chọn=Ẩn, Không chọn=Hiển thị
                            <p>
                                @error('status')
                                    <small class="text-danger">{{ $message= "Vui lòng điền thông tin này!" }}</small>
                                @enderror
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">  
                        <button type="button" wire:click = "closeModal" class="btn btn-danger fw-bold text-light" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary fw-bold text-light">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal xóa thương hiệu sản phẩm -->
<div wire:ignore.self class="modal fade" id="deleteBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa thương hiệu sản phẩm</h1>
                <button type="button" class="btn-close" wire:click = "closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
                {{-- wire:click = "closeModal" là khi click vào thêm thương hiệu sản phẩm nó sẽ không hiện dữ liệu đã 
                sửa ở dưới --}}
            </div>
            {{-- Tạo hiệu ứng icon loading --}}
            <div wire:loading class="p-2">
                {{-- wire:loading được sử dụng để hiển thị các phần tử hoặc nội dung khi một hành động đang được thực hiện.
                    Khi wire:loading được đặt trên một phần tử, nội dung của phần tử đó sẽ chỉ được hiển thị trong quá trình 
                    tải dữ liệu hoặc xử lý hành động. Trong đoạn mã của bạn, <div wire:loading> là một phần tử chứa một 
                    spinner (biểu tượng quay) và thông báo "Đang tải, xin vui lòng chờ trong giây lát...". Khi có một 
                    yêu cầu gửi đi hoặc một hành động đang được xử lý, phần tử này sẽ hiển thị. --}}
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden"></span>
                </div>Đang tải, xin vui lòng chờ trong giây lát...
            </div>
            <div wire:loading.remove>
                {{-- wire:loading.remove được sử dụng để ẩn các phần tử hoặc nội dung trong quá trình tải dữ liệu hoặc xử 
                    lý hành động. Khi wire:loading.remove được đặt trên một phần tử, phần tử đó sẽ chỉ được hiển thị khi 
                    không có hành động nào đang được thực hiện. Trong đoạn mã của bạn, <div wire:loading.remove> chứa một 
                    biểu mẫu (<form>) để cập nhật thông tin thương hiệu. Khi không có yêu cầu gửi đi hoặc không có hành 
                    động nào đang được xử lý, phần tử này sẽ được hiển thị. --}}
                <form wire:submit.prevent="destroyBrand()">
                    <div class="modal-body">
                        <h4>Bạn có chắc chắn muốn xóa thương hiệu sản phẩm này không?</h4>
                    </div>
                    <div class="modal-footer">  
                        <button type="button" wire:click = "closeModal" class="btn btn-warning fw-bold text-light" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger text-light fw-bold">Có. Xóa ngay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>