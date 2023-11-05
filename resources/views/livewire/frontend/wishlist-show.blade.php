<div>
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <h1><i class="fa fa-heart text-danger fw-bold"></i> Danh sách sản phẩm yêu thích của bạn</h1>
            <hr style="height: 3px;color:black;">
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart">

                        <div class="cart-header d-none d-sm-none d-mb-block d-lg-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Tên sản phẩm</h4>
                                </div>
                                <div class="col-md-2">
                                    <h4>Gíá</h4>
                                </div>
                                <div class="col-md-3">
                                    <h4>Thao tác</h4>
                                </div>
                            </div>
                        </div>
                        @forelse ($wishlist as $wishlistItem)
                            @if ($wishlistItem->product)
                                <div class="cart-item">
                                    <div class="row">
                                        <div class="col-md-6 my-auto">
                                            {{-- Đường dẫn đến sản phẩm --}}
                                            <a href="{{ url('collections/'.$wishlistItem->product->category->slug.'/'.$wishlistItem->product->slug) }}">
                                                <label class="product-name">
                                                    {{-- Ảnh sản phẩm --}}
                                                    <img src="{{ $wishlistItem->product->productImages[0]->image }}" style="width: 130px; height: 130px"
                                                        alt="{{ $wishlistItem->product->name }}" />
                                                    {{-- Tên sản phẩm --}}
                                                    {{ $wishlistItem->product->name }}
                                                </label>
                                            </a>
                                        </div>
                                        {{-- Giá sản phẩm --}}
                                        <div class="col-md-2 my-auto">
                                            <label class="price">{{ number_format($wishlistItem->product->selling_price, 0, ',', '.') }}<sup>đ</sup></label>
                                        </div>
                                        
                                        <div class="col-md-4 col-12 my-auto">
                                            <div class="remove">
                                                <button type="button" wire:click="removeWishlistItem({{ $wishlistItem->id }})" class="btn btn-danger btn-sm">
                                                    <span wire:loading.remove wire:target="removeWishlistItem({{ $wishlistItem->id }})">
                                                        <i class="fa fa-trash"></i> Xóa sản phẩm
                                                    </span>
                                                    <span wire:loading wire:target="removeWishlistItem({{ $wishlistItem->id }})">
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
                                    <div data-v-5a4f0845="" class="nothing-in-cart"><svg data-v-5a4f0845=""
                                            aria-hidden="true" focusable="false" data-prefix="fas" data-icon="frown"
                                            role="img" xmlns="http://www.w3.org/2000/svg" style="width:48px; height:60px" viewBox="0 0 496 512"
                                            class="svg-inline--fa fa-frown">
                                            <path data-v-5a4f0845="" fill="currentColor"
                                                d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm80 168c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm-160 0c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm170.2 218.2C315.8 367.4 282.9 352 248 352s-67.8 15.4-90.2 42.2c-13.5 16.3-38.1-4.2-24.6-20.5C161.7 339.6 203.6 320 248 320s86.3 19.6 114.7 53.8c13.6 16.2-11 36.7-24.5 20.4z"
                                                class=""></path>
                                        </svg>
                                        <p data-v-5a4f0845="">Không có sản phẩm nào trong danh sách sản phẩm yêu thích của bạn, vui lòng quay lại!
                                        </p> <a data-v-5a4f0845="" href="{{ url('/') }}" class="go-back">Quay lại
                                            trang chủ</a>
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
