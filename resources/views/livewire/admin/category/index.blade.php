<div>
    <!-- Modal popup xóa sản phẩm-->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        {{-- wire:ignore.self là một directive trong Livewire được sử dụng trong thẻ <div> để bỏ qua quá trình xử lý của 
            Livewire đối với chính phần tử đó và các phần tử con bên trong nó.
            wire:ignore.self được áp dụng trên thẻ <div> có class "modal fade" để không áp dụng Livewire cho modal này. 
            Điều này có nghĩa là các sự kiện và tương tác trong modal không sẽ gây ảnh hưởng đến quá trình Livewire
            đang chạy.
            Directive này hữu ích khi bạn muốn giữ lại tính năng mặc định của một phần tử trong HTML, mà không muốn 
            Livewire can thiệp vào nó. Trong trường hợp này, bạn có thể xử lý các sự kiện như submit form mà không cần 
            tải lại trang. --}}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa sản phẩm</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent = "destroyCategory" >
                    {{-- wire:submit.prevent là một directive của Livewire, một thư viện giúp xây dựng giao diện người dùng 
                        tương tác theo thời gian thực trong ứng dụng Laravel. 
                        wire:submit.prevent được sử dụng để xử lý sự kiện khi người dùng nhấn nút submit trong form. 
                        Directive này chặn sự kiện mặc định của form (tránh tải lại trang) và cho phép xử lý sự kiện 
                        mà không cần gửi yêu cầu HTTP mới.
                        được sử dụng để kích hoạt phương thức "destroyCategory" trong thành phần Livewire hiện tại khi 
                        người dùng nhấn nút "Có. Xóa ngay". Khi người dùng nhấn nút đó, phương thức "destroyCategory" sẽ 
                        được gọi và xử lý việc xóa sản phẩm tương ứng. --}}
                    <div class="modal-body">
                        <h6>Bạn có chắc chắn muốn xóa sản phẩm này không?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-light fw-bolder" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary text-light fw-bolder">Có. Xóa ngay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>
                        Danh mục sản phẩm
                        <a href="{{ url('admin/category/create') }}"
                            class="btn btn-primary float-end btn-sm text-light fw-bolder fst-italic">
                            Thêm danh mục sản phẩm
                        </a>
                    </h3>
                </div>
                {{-- Hiển thị danh sách sản phẩm --}}
                <div class="card-body">
                    <table class="table table-bodered table-striped table-info">
                        <thead>
                            <tr class="table-warning">
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Status</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="table-secondary">
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    {{-- Hiển thị ảnh sản phẩm --}}
                                    <td>
                                        <img style="width:50%;height:60px;"
                                            src="{{ asset('uploads/category/' . $category->image) }}"
                                            alt="{{ $category->name }}">
                                        {{-- Sử dụng hàm asset() để tạo đường dẫn đầy đủ đến tệp hình ảnh. Đường dẫn này 
                                        kết hợp thư mục uploads/category/ với tên tệp $category->image.
                                        {{ $category->name }}: Sử dụng thuộc tính name của đối tượng $category làm giá trị 
                                        thuộc tính alt của hình ảnh. --}}
                                    </td>
                                    <td>{{ $category->status == '0' ? 'Hiển thị' : 'Ẩn' }}</td>
                                    <td>
                                        <a href="{{ url('admin/category/' . $category->id . '/edit') }}"
                                            class="btn btn-success">Sửa</a>
                                        {{-- Trong trường hợp này, url('admin/category/'.$category->id.'/edit') tạo ra một URL 
                                    có định dạng /admin/category/{id}/edit, trong đó {id} là giá trị của thuộc tính id 
                                    của danh mục. 
                                    Khi người dùng nhấp vào liên kết này, nó sẽ chuyển hướng đến trang chỉnh sửa danh mục 
                                    với id tương ứng để người dùng có thể sửa thông tin danh mục đó. --}}
                                        <a href="{{ url('admin/category/' . $category->name) }}" wire:click = "deleteCategory({{ $category->id }})" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            class="btn btn-danger">Xóa</a>
                                        {{-- wire:click là một directive của Livewire được sử dụng để xử lý sự kiện khi 
                                            người dùng nhấp vào một phần tử trên trang web.
                                            wire:click được sử dụng để kích hoạt phương thức deleteCategory trong thành 
                                            phần Livewire hiện tại khi người dùng nhấp vào liên kết "Xóa". Directive này 
                                            cho phép bạn thực hiện một hành động ngay trên trang web mà không cần gửi 
                                            yêu cầu HTTP mới.
                                            wire:click được sử dụng để gọi phương thức "deleteCategory" và truyền đối số 
                                            {{ $category->id }} cho nó. Điều này cho phép phương thức deleteCategory nhận
                                             và xử lý ID của danh mục sản phẩm để thực hiện xóa. --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Hiển thị chức năng phân trang danh sách sản phẩm --}}
                    <div>
                        {{ $categories->links() }}
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
            $('#deleteModal').modal('hide');
            /*Đây là một hàm jQuery để ẩn modal có id "deleteModal". Hàm này được gọi khi sự kiện "close-model" xảy ra. 
            Bằng cách gọi phương thức modal('hide'), modal sẽ được ẩn đi và không còn hiển thị trên giao diện người dùng.*/
        });
    </script>
@endpush
{{-- @push('script') là một lệnh Blade trong Laravel để đẩy mã JavaScript vào phần đầu hoặc cuối của phần mở rộng <script> 
    trong tệp layout chính. Trong trường hợp này, mã JavaScript sẽ được đẩy vào cuối phần mở rộng <script>. --}}