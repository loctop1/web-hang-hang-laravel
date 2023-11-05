<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <meta name="description" content="@yield('meta_description')">
    <meta name="keyword" content="@yield('meta_keyword')">
    <meta name="author" content="Lộc Top1">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    
    {{-- Owl Carousel --}}
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/owl.theme.default.min.css') }}" rel="stylesheet">

    {{-- Exzoom - Prod Image --}}
    <link href="{{ asset('assets/exzoom/jquery.exzoom.css') }}" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @livewireStyles
</head>

<body>
    <div id="app">
        {{-- Header --}}
        @include('layouts.inc.frontend.navbar')
        {{-- Content --}}
        <main>
            @yield('content')
        </main>
        {{-- Footer --}}
        @include('layouts.inc.frontend.footer');
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- JavaScript -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
        window.addEventListener('message', event => {
            /**Đây là một sự kiện lắng nghe ('message') được gắn với cửa sổ trình duyệt. Khi một sự kiện 'message' được kích hoạt, một hàm callback được gọi với thông tin sự kiện truyền vào 
             * biến event.*/
            if (event.detail) {
                alertify.set('notifier', 'position', 'top-right');
                /**alertify.set('notifier', 'position', 'top-right'); - Đây là hàm của thư viện Alertify để thiết lập vị trí hiển thị thông báo. Hàm này sử dụng phương thức set() để đặt giá trị 
                 * position là 'top-right', tức là thông báo sẽ hiển thị ở góc phải trên cùng của trang web.*/
                alertify.notify(event.detail.text, event.detail.type);
                /**alertify.notify(...): Đây là phương thức của thư viện Alertify để hiển thị thông báo.
                 * event.detail.text: Đây là trường dữ liệu chứa nội dung thông báo, được truyền từ phía máy chủ qua sự kiện 'message'.
                 * event.detail.type: Đây là trường dữ liệu chứa loại thông báo, được truyền từ phía máy chủ qua sự kiện 'message'.
                 * Với alertify.notify(event.detail.text, event.detail.type);, thông báo sẽ được hiển thị bằng thư viện Alertify, với nội dung và loại tương ứng từ dữ liệu được truyền qua sự 
                 * kiện 'message'. Thư viện Alertify có thể được cấu hình trước để xác định vị trí và giao diện thông báo.*/
            }
        });
        /**Tổng kết lại, đoạn mã trên lắng nghe sự kiện 'message' trong trình duyệt và khi có sự kiện xảy ra, nó sử dụng thư viện Alertify để hiển thị thông báo thành công ở vị trí 
         * 'top-right' trên trang web. Nội dung thông báo được lấy từ trường 'text' của sự kiện.*/
    </script>
    {{-- Đoạn mã trên là một đoạn mã JavaScript sử dụng thư viện Alertify để hiển thị thông báo thành công ở góc phải trên cùng của trang web. --}}

    {{-- Owl Carousel --}}
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    
    {{-- Exzoom - Prod Image --}}
    <script src="{{ asset('assets/exzoom/jquery.exzoom.js') }}"></script>

    @yield('script')

    @livewireScripts
    @stack('scripts')
</body>

</html>
