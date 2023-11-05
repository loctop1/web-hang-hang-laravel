<div>
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('uploads\slider\tải xuống.png') }}" alt="" style="width:250px;height:auto">
                    </a>
                    <div class="footer-underline"></div>
                    <h4 class="footer-heading">Công ty TNHH Thương mại và Dịch vụ Kỹ thuật Diệu Phúc</h4>
                </div>
                <div class="col-md-3">
                    <h4 class="footer-heading">Liên kết nhanh</h4>
                    <div class="footer-underline"></div>
                    <div class="mb-2"><a href="{{ url('/') }}" class="text-white">Trang chủ</a></div>
                    <div class="mb-2"><a href="{{ url('/about-us') }}" class="text-white">Về chúng tôi</a></div>
                    <div class="mb-2"><a href="{{ url('/contact-us') }}" class="text-white">Liên hệ</a></div>
                    <div class="mb-2"><a href="{{ url('/blogs') }}" class="text-white">Blog</a></div>
                    <div class="mb-2">
                        <a href="{{ url('/') }}" class="text-white">Sơ đồ trang web</a>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.5378807525176!2d105.80563787603428!3d21.05116878700719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752fe8b842b23b%3A0x97f6c4ab2aa3d89f!2zQ2VsbHBob25lUyAtIEPhu61hIGjDoG5nIMSRaeG7h24gdGhv4bqhaSBjaMOtbmggaMOjbmcgZ2nDoSB04buRdA!5e0!3m2!1svi!2s!4v1691261877945!5m2!1svi!2s" width="250" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-md-3">
                    <h4 class="footer-heading">Mua ngay</h4>
                    <div class="footer-underline"></div>
                    <div class="mb-2"><a href="{{ url('/collections') }}" class="text-white">Bộ sưu tập</a></div>
                    <div class="mb-2"><a href="{{ url('/new-arrivals') }}" class="text-white">Sản phẩm đang hot</a></div>
                    <div class="mb-2"><a href="{{ url('/new-arrivals') }}" class="text-white">Sản phẩm mới</a></div>
                    <div class="mb-2"><a href="{{ url('/featured-products') }}" class="text-white">Sản phẩm nổi bật</a></div>
                    <div class="mb-2"><a href="{{ url('/cart') }}" class="text-white">Giỏ hàng</a></div>
                </div>
                <div class="col-md-3">
                    <h4 class="footer-heading">Liên hệ chúng tôi</h4>
                    <div class="footer-underline"></div>
                    <div class="mb-2">
                        <p>
                            <i class="fa fa-map-marker"></i> {{ $appSetting->address ?? 'address' }}
                        </p>
                    </div>
                    <div class="mb-2">
                        <a href="" class="text-white">
                            <i class="fa fa-phone"></i> {{ $appSetting->phone1 ?? 'phone1' }}
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="" class="text-white">
                            <a href="https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox">
                                <i class="fa fa-envelope"></i> {{ $appSetting->email1 ?? 'email1' }}
                            </a>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class=""> &copy; 2022 - Công ty TNHH Thương mại và Dịch vụ Kỹ thuật Diệu Phúc. Đã đăng ký bản quyền. </p>
                </div>
                <div class="col-md-4">
                    <div class="social-media">
                        Kết nối với chúng tôi:
                        @if ($appSetting->facebook)
                            <a href="{{ $appSetting->facebook }}" target="_blank"><i class="fa fa-facebook"></i></a>
                        @endif
                        @if ($appSetting->twitter)
                            <a href="{{ $appSetting->twitter }}" target="_blank"><i class="fa fa-twitter"></i></a>
                        @endif
                        @if ($appSetting->instagram)
                            <a href="{{ $appSetting->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a>
                        @endif
                        @if ($appSetting->youtube)
                            <a href="{{ $appSetting->youtube }}" target="_blank"><i class="fa fa-youtube"></i></a>
                        @endif     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
