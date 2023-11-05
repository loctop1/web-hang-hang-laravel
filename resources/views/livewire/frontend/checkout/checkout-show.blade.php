<div>
    <div class="py-3 py-md-4 checkout">
        <div class="container">
            <h1 class="fw-bold">Thanh toán</h1>
            <hr>

            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="shadow bg-white p-3">
                        <h3 class="text-primary fw-bold">
                            Tổng số tiền đơn hàng:
                            <span
                                class="float-end text-danger fw-bold">{{ number_format($this->totalProductAmount, 0, ',', '.') }}<sup>đ</sup></span>
                        </h3>
                        <hr>
                        <small>* Sản phẩm sẽ được giao trong vòng 3 - 5 ngày.</small>
                        <br />
                        <small>* Bao gồm thuế và các khoản phí khác?</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="shadow bg-white p-3">
                        <h3 class="text-primary fs-2 fw-bold">
                            Thông tin cơ bản
                        </h3>
                        <hr>

                        @if ($this->totalProductAmount != '0')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fs-3">Họ và tên</label>
                                    <input type="text" wire:model.defer="fullname" id="fullname"
                                        class="form-control" placeholder="Nhập họ và tên" />
                                    {{-- khi người dùng nhập vào trường input fullname, dữ liệu không tự động gửi lên server. Sau khi người dùng nhấn vào nút "thanh toán" 
                                    (kích hoạt sự kiện wire:click="codOrder"), dữ liệu fullname sẽ được gửi lên server và xử lý trong phương thức save của component Livewire.
                                    Sử dụng wire:model.defer có thể giúp tối ưu hiệu năng của ứng dụng trong trường hợp bạn chỉ muốn gửi dữ liệu khi người dùng thực sự muốn 
                                    thực hiện một hành động cụ thể, như khi nhấn nút "Lưu" hoặc thực hiện một hành động khác. --}}
                                    @error('fullname')
                                        <small class="text-danger fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fs-3">Số điện thoại</label>
                                    <input type="number" wire:model.defer="phone" id="phone" class="form-control"
                                        placeholder="Nhập số điện thoại" />
                                    @error('phone')
                                        <small class="text-danger fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fs-3">Địa chỉ Email</label>
                                    <input type="email" wire:model.defer="email" id="email" class="form-control"
                                        placeholder="Nhập địa chỉ Email" />
                                    @error('email')
                                        <small class="text-danger fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fs-3">Mã bưu chính</label>
                                    <input type="number" wire:model.defer="pincode" id="pincode" class="form-control"
                                        placeholder="Nhập mã bưu chính" />
                                    @error('pincode')
                                        <small class="text-danger fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="fs-3  ">Địa chỉ đầy đủ</label>
                                    <textarea wire:model.defer="address" id="address" class="form-control" rows="2"></textarea>
                                    @error('address')
                                        <small class="text-danger fw-bold">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3" wire:ignore>
                                    {{-- được sử dụng để đánh dấu một phần tử <div> với ID là "paypal-button-container" là một phần tử mà Livewire sẽ bỏ qua và 
                                    không thêm bất kỳ sự tương tác hoặc quản lý sự kiện nào cho nó. Điều này cho phép bạn sử dụng mã JavaScript một cách độc 
                                    lập cho phần tử này mà không gặp xung đột với Livewire. Trong trường hợp của bạn, có thể rằng bạn đang sử dụng mã 
                                    JavaScript từ PayPal SDK để tạo nút thanh toán PayPal, và việc bỏ qua bằng wire:ignore giúp tránh xung đột với Livewire. --}}
                                    <label class="fs-3">Vui lòng chọn phương thức thanh toán: </label>
                                    <div class="d-md-flex align-items-start fs-5">
                                        <div class="nav col-md-3 flex-column nav-pills me-3" id="v-pills-tab"
                                            role="tablist" aria-orientation="vertical">
                                            <button wire:loading.attr="disabled"
                                                class="nav-link active fw-bold text-start" id="cashOnDeliveryTab-tab"
                                                data-bs-toggle="pill" data-bs-target="#cashOnDeliveryTab" type="button"
                                                role="tab" aria-controls="cashOnDeliveryTab"
                                                aria-selected="true">Thanh toán khi nhận hàng</button>
                                            <button wire:loading.attr="disabled" class="nav-link fw-bold text-start"
                                                id="onlinePayment-tab" data-bs-toggle="pill"
                                                data-bs-target="#onlinePayment" type="button" role="tab"
                                                aria-controls="onlinePayment" aria-selected="false">Thanh toán trực
                                                tuyến</button>
                                        </div>
                                        <div class="tab-content col-md-9" id="v-pills-tabContent">
                                            <div class="tab-pane active show fade" id="cashOnDeliveryTab"
                                                role="tabpanel" aria-labelledby="cashOnDeliveryTab-tab" tabindex="0">
                                                <h6>Phương thức thanh toán khi nhận hàng</h6>
                                                <hr />
                                                <button type="button" wire:loading.attr="disabled"
                                                    wire:click="codOrder" class="btn btn-primary">
                                                    <span wire:loading.remove wire:target="codOrder">
                                                        Đặt hàng (Thanh toán khi nhận hàng)
                                                    </span>
                                                    <span wire:loading wire:target="codOrder">
                                                        Đang xử lý đơn hàng (Xin vui lòng chờ trong giây lát)
                                                    </span>
                                                </button>

                                            </div>
                                            <div class="tab-pane fade" id="onlinePayment" role="tabpanel"
                                                aria-labelledby="onlinePayment-tab" tabindex="0">
                                                <h6>Phương thức thanh toán trực tuyến</h6>
                                                <hr />
                                                {{-- <button type="button" wire:loading.attr="disabled" class="btn btn-warning">
                                                    Thanh toán ngay (Thanh toán trực tuyến)
                                                </button> --}}
                                                <div>
                                                    <div id="paypal-button-container"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @else
                            {{-- Ngược lại khi thanh toán hết sản phẩm trong hóa đơn thành công sẽ ko còn sản phẩm trong nào trong hóa đơn bán hàng --}}
                            <div class="card card-body shadow text-center p-md-5">
                                <div class="container block-info mt-3">
                                    <div data-v-5a4f0845="">
                                        <div data-v-5a4f0845="" class="nothing-in-cart">
                                            <svg data-v-5a4f0845="" aria-hidden="true" focusable="false"
                                                data-prefix="fas" data-icon="frown" role="img"
                                                xmlns="http://www.w3.org/2000/svg" style="width:48px; height:60px"
                                                viewBox="0 0 496 512" class="svg-inline--fa fa-frown">
                                                <path data-v-5a4f0845="" fill="currentColor"
                                                    d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm80 168c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm-160 0c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm170.2 218.2C315.8 367.4 282.9 352 248 352s-67.8 15.4-90.2 42.2c-13.5 16.3-38.1-4.2-24.6-20.5C161.7 339.6 203.6 320 248 320s86.3 19.6 114.7 53.8c13.6 16.2-11 36.7-24.5 20.4z"
                                                    class=""></path>
                                            </svg>
                                            <p data-v-5a4f0845="">Không có sản phẩm nào trong hóa đơn của bạn, vui lòng
                                                quay lại!
                                            </p>
                                            <a data-v-5a4f0845="" href="{{ url('/') }}" class="go-back">Quay lại
                                                trang
                                                chủ</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Thêm phương thức thanh toán PAYPAL --}}
@push('scripts')
    <!-- Thay thế "thử nghiệm" bằng ID ứng dụng ứng dụng tài khoản doanh nghiệp sandbox của riêng bạn -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=Adp1-PSzwjF2WALQg4VRkKqT-CvwCOauTdeZ19glkEiem9_A6r3rIteQREIhlni56cblOlNZh5LcpGQe&currency=USD">
    </script>
    {{-- Dòng này là một thẻ <script> để tải SDK của PayPal vào trang web. SDK này cung cấp các chức năng tích hợp thanh toán PayPal. --}}
    <script>
        paypal.Buttons({
            /**Đây là một cách để tạo và hiển thị nút PayPal trên trang web. Hàm paypal.Buttons({...}) tạo một nút thanh toán PayPal có chức năng như đã được định nghĩa trong 
             * đối tượng cung cấp.*/
            onClick: function() {
                // Hiển thị lỗi validation xác thực nếu form bị bỏ trống
                if (!document.getElementById('fullname').value ||
                    !document.getElementById('phone').value ||
                    !document.getElementById('email').value ||
                    !document.getElementById('pincode').value ||
                    !document.getElementById('address').value
                    /**Đây là một câu lệnh if kiểm tra tính hợp lệ của các trường nhập liệu (input fields) trong form. Nếu bất kỳ trường nào trong danh sách các trường (fullname, phone, email, pincode, address) không 
                     * được điền (có giá trị rỗng), điều kiện trong câu lệnh if sẽ đánh giá là đúng (true).*/
                ) {
                    Livewire.emit('validationForAll');
                    /**Trong trường hợp một hoặc nhiều trường nhập liệu không được điền, hàm này sẽ gửi một sự kiện tới Livewire có tên 'validationForAll'. Điều này giả định rằng Livewire đã cài đặt một xử lý sự kiện có 
                     * tên 'validationForAll' để hiển thị thông báo lỗi hoặc thực hiện các xử lý kiểm tra hợp lệ.*/
                    return false;
                    /**Nếu có bất kỳ trường nhập liệu nào không được điền, hàm sẽ trả về giá trị false, ngăn không cho hành động tiếp theo (nếu có) trong trình duyệt được thực hiện. Điều này có thể giúp ngăn chặn việc 
                     * gửi dữ liệu không hợp lệ hoặc ngăn chặn chuyển hướng đến một trang khác.*/
                } else {
                    @this.set('fullname', document.getElementById('fullname').value);
                    @this.set('phone', document.getElementById('phone').value);
                    @this.set('email', document.getElementById('email').value);
                    @this.set('pincode', document.getElementById('pincode').value);
                    @this.set('address', document.getElementById('address').value);
                    /**Trong khối else {...}, dòng mã này sử dụng cú pháp của Laravel Livewire để cập nhật dữ liệu trên phía máy chủ. Nó sẽ cập nhật các biến Livewire tương ứng 
                     * (fullname, phone, email, pincode, address) với giá trị mới từ các trường nhập liệu tương ứng (fullname, phone, email, pincode, address). Điều này cho phép bạn lưu trữ dữ liệu nhập liệu và xử 
                     * lý chúng bên phía máy chủ.*/
                }
            },

            // Đơn hàng được tạo trên máy chủ và id đơn hàng được trả về
            createOrder: (data, actions) => { 
            // Định nghĩa hàm createOrder với tham số data và actions.
                return actions.order.create({ 
                // Gọi phương thức order.create() của đối tượng actions.
                    purchase_units: [{ 
                    // Bắt đầu định nghĩa đối tượng purchase_units.
                        amount: { 
                        // Bắt đầu định nghĩa đối tượng amount.
                            value: '0.1'//'{{ $this->totalProductAmount }}' 
                            // Lấy giá trị của biến $this->totalProductAmount và gán cho thuộc tính value (số tiền đơn hàng).
                        }
                    }] // Kết thúc định nghĩa đối tượng purchase_units.
                }); // Kết thúc gọi phương thức order.create().
            }, // Kết thúc định nghĩa hàm createOrder.

            // Hoàn tất giao dịch trên máy chủ sau khi người thanh toán chấp thuận
            onApprove: (data, actions) => { 
            // Định nghĩa hàm onApprove với tham số data và actions.
                return actions.order.capture().then(function(orderData) { 
                // Gọi phương thức order.capture() của đối tượng actions và sử dụng promise để thực hiện hành động sau khi hoàn tất.
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2)); 
                    // Ghi thông tin chi tiết về đơn hàng đã hoàn tất vào console.
                    const transaction = orderData.purchase_units[0].payments.captures[0]; 
                    // Trích xuất thông tin về giao dịch hoàn tất từ dữ liệu đơn hàng.
                    if (transaction.status == "COMPLETED") { 
                    // Kiểm tra trạng thái giao dịch có phải là "COMPLETED" hay không.
                        Livewire.emit('transactionEmit', transaction.id); 
                        // Nếu giao dịch hoàn tất, phát ra sự kiện "transactionEmit" kèm theo ID của giao dịch.
                    }
                    // Có một số lời gọi đến hàm alert() và một số lựa chọn xử lý khi đã sẵn sàng hoạt động, nhưng chúng đã bị comment lại.
                });
            } // Kết thúc định nghĩa hàm onApprove.

        }).render('#paypal-button-container');
        // Sau đó, .render('#paypal-button-container') dùng để hiển thị nút PayPal trong phần tử có ID là paypal-button-container.
    </script>
@endpush
