<div class="main-navbar shadow-sm sticky-top">
    <div class="top-navbar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 my-auto d-none d-sm-none d-md-block d-lg-block">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('uploads\slider\tải xuống.png') }}" alt="" style="width:220px;height:auto">
                    </a>
                    <h5 class="brand-name text-center">{{ $appSetting->website_name ?? 'website name' }}</h5>
                </div>
                <div class="col-md-4 my-auto">
                    <form action="{{ url('search') }}" method="GET" role="search" style="margin-bottom: -9px;">
                        <div class="input-group">
                            <input type="search" placeholder="Tìm kiếm sản phẩm..." name="search" value="{{ Request::get('search') }}" class="form-control text-start fw-bold" />
                            <button class="btn bg-light fw-bold fs-6 text-danger" type="submit">
                                Tìm kiếm <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 my-auto">
                    <ul class="nav justify-content-end">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('cart') }}">
                                <i class="fa fa-shopping-cart text-warning fw-bold fs-4"></i> Giỏ hàng (<livewire:frontend.cart.cart-count/>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('wishlist') }}">
                                <i class="fa fa-heart text-danger fw-bold fs-4"></i> Danh sách sản phẩm yêu thích (<livewire:frontend.wishlist-count/>)
                            </a>
                        </li>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link float-end" href="{{ route('register') }}">{{ __('Đăng ký') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link float-end" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user fs-4 fw-bold"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item fw-bold" href="{{ url('profile') }}"><i class="fa fa-user"></i> Thông tin cá
                                            nhân</a>
                                    </li>
                                    <li><a class="dropdown-item fw-bold" href="#"><i class="fa fa-list"></i> Đơn đặt hàng của
                                            bạn</a>
                                    </li>
                                    <li><a class="dropdown-item fw-bold" href="#"><i class="fa fa-heart"></i> Danh sách sản
                                            phẩm yêu thích của bạn</a>
                                    </li>
                                    <li><a class="dropdown-item fw-bold" href="#"><i class="fa fa-shopping-cart"></i> Giỏ hàng
                                            của bạn</a></li>
                                    <li>
                                        <a class="dropdown-item fw-bold" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out"></i> {{ __('Đăng xuất') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>

                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid bg-danger">
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><b class="text-center">☰</b></span>
            </button>
            <div class="collapse navbar-collapse fw-bold" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ url('/') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ url('/collections') }}">Tất cả danh mục sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ url('/new-arrivals') }}">Sản phẩm mới</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ url('/featured-products') }}">Sản phẩm nổi bật</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Thiết bị điện tử</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Thời trang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Phụ kiện</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">Thiết bị gia dụng</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
