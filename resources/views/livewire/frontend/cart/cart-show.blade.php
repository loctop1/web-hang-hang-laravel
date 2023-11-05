<div>
    <div class="py-3 py-md-5">
        <div class="container">
            <h2><i class="fa fa-shopping-cart text-danger fw-bold fs-2"></i> Giỏ hàng của tôi</h2>
            <hr style="height: 3px;color:black;">
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart">
                        <div class="cart-header d-none d-sm-none d-mb-block d-lg-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Tên sản phẩm</h5>
                                </div>
                                <div class="col-md-1">
                                    <h5>Giá</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>Số lượng</h5>
                                </div>
                                <div class="col-md-2">
                                    <h5>Tổng tiền</h5>
                                </div>
                                <div class="col-md-1">
                                    <h5>Thao tác</h5>
                                </div>
                            </div>
                        </div>
                        @forelse ($cart as $cartItem)
                            @if ($cartItem->product)
                                <div class="cart-item">
                                    <div class="row">
                                        <div class="col-md-6 my-auto">
                                            <a
                                                href="{{ url('collections/' . $cartItem->product->category->slug . '/' . $cartItem->product->slug) }}">
                                                <div class="product-details">
                                                    @if ($cartItem->product->productImages)
                                                        <div class="product-image">
                                                            <img src="{{ asset($cartItem->product->productImages[0]->image) }}"
                                                                alt="{{ $cartItem->product->name }}">
                                                        </div>
                                                    @else
                                                        <div class="product-image">
                                                            <img src="" alt="{{ $cartItem->product->name }}">
                                                        </div>
                                                    @endif
                                                    <div class="product-name">
                                                        <h5>{{ $cartItem->product->name }}</h5>
                                                        {{-- Màu sắc sản phẩm --}}
                                                        @if ($cartItem->productColor)
                                                        {{-- kiểm tra xem giỏ hàng có thông tin về màu sắc sản phẩm không. Nếu có, hàm trả về true. --}}
                                                            @if ($cartItem->productColor->color)
                                                            {{-- kiểm tra xem sản phẩm có màu sắc được định nghĩa hay không. Nếu có, hàm trả về true. --}}
                                                                <span class="color">Màu sắc sản phẩm:
                                                                    {{ $cartItem->productColor->color->name }}
                                                                </span>
                                                                {{--  sẽ được thực thi nếu cả hai điều kiện trên đúng. Nó hiển thị tên của màu sắc sản phẩm. --}}
                                                            @endif
                                                        @endif
                                                        {{-- Tóm lại, đoạn mã trên kiểm tra và hiển thị thông tin về màu sắc của một sản phẩm trong giỏ hàng, nếu thông tin màu sắc có sẵn.  --}}
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-1 my-auto">
                                            <span class="price">
                                                {{ number_format($cartItem->product->selling_price, 0, ',', '.') }}<sup>đ</sup>
                                            </span>
                                        </div>
                                        <div class="col-md-2 col-7 my-auto">
                                            <div class="quantity">
                                                <div class="input-group">
                                                    <button type="button"
                                                        wire:loading.attr="disabled"
                                                        wire:click="decrementQuantity({{ $cartItem->id }})"
                                                        class="btn btn1"><i class="fa fa-minus"></i>
                                                    </button>
                                                    <input type="text" value="{{ $cartItem->quantity }}"
                                                        class="input-quantity" readonly />
                                                    <button type="button" 
                                                        wire:loading.attr="disabled"
                                                        wire:click="incrementQuantity({{ $cartItem->id }})"
                                                        class="btn btn1"><i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 my-auto">
                                            <span class="price">
                                                {{ number_format($cartItem->product->selling_price * $cartItem->quantity, 0, ',', '.') }}<sup>đ</sup>
                                                {{-- Tổng giá tiền toàn bộ sản phẩm trong giỏ hàng --}}
                                                @php
                                                   $totalPrice += $cartItem->product->selling_price * $cartItem->quantity 
                                                @endphp
                                            </span>
                                        </div>
                                        <div class="col-md-1 my-auto">
                                            <div class="remove">
                                                <button type="button" wire:loading.attr="disabled" wire:click="removeCartItem({{ $cartItem->id }})" class="btn btn-danger btn-sm">
                                                    <span wire:loading.remove wire:target="removeCartItem({{ $cartItem->id }})">
                                                        <i class="fa fa-trash"></i> Xóa sản phẩm
                                                    </span>
                                                    <span wire:loading wire:target="removeCartItem({{ $cartItem->id }})">
                                                        <i class="fa fa-trash"></i> Đang xóa
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="container block-info mt-3">
                                <div data-v-5a4f0845="">
                                    <div data-v-5a4f0845="" class="nothing-in-cart">
                                        <svg data-v-5a4f0845="" aria-hidden="true" focusable="false" data-prefix="fas"
                                            data-icon="frown" role="img" xmlns="http://www.w3.org/2000/svg"
                                            style="width:48px; height:60px" viewBox="0 0 496 512"
                                            class="svg-inline--fa fa-frown">
                                            <path data-v-5a4f0845="" fill="currentColor"
                                                d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm80 168c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm-160 0c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm170.2 218.2C315.8 367.4 282.9 352 248 352s-67.8 15.4-90.2 42.2c-13.5 16.3-38.1-4.2-24.6-20.5C161.7 339.6 203.6 320 248 320s86.3 19.6 114.7 53.8c13.6 16.2-11 36.7-24.5 20.4z"
                                                class=""></path>
                                        </svg>
                                        <p data-v-5a4f0845="">Không có sản phẩm nào trong giỏ hàng của bạn, vui lòng quay lại!
                                        </p>
                                        <a data-v-5a4f0845="" href="{{ url('/') }}" class="go-back">Quay lại trang
                                            chủ</a>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div data-v-55408f28="" class="bottom-bar container mt-auto block-box">
    <div data-v-55408f28="" class="total-box d-flex justify-content-between align-items-start">
        <p data-v-55408f28="" class="title-temp fw-bold fs-2">Tổng tiền tạm tính:</p>
        <div data-v-55408f28="" class="price d-flex flex-column align-items-end">
            <span data-v-55408f28="" class="total">
                <div class="shadow-sm bg-white p-2 fs-3">
                    <span class="float-end">{{ number_format($totalPrice, 0, ',', '.') }}<sup>đ</sup></span>
                </div>
            </span>
        </div>
    </div>
    <div data-v-55408f28="" class="btn-submit mt-2">
        <a  href="{{ url('/checkout') }}" 
            data-v-55408f28=""
            class="button__go-next btn btn-danger d-flex flex-column justify-content-center align-items-center w-100 mb-2 bg-danger text-light">
            Tiến hành đặt hàng
        </a>
        <a data-v-55408f28="" href="{{ url('/collections') }}"
            class="button__go-home btn btn-outline-danger d-flex flex-column justify-content-center align-items-center w-100">
            Chọn thêm sản phẩm khác
        </a>
    </div>
</div>
