<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" />
    {{-- Link fontsomeware --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .sidebar .nav .nav-item.active{
            background-color: #e9e9e9 
        }
    </style>
    @livewireStyles
</head>

<body>
    <div class="container-scroller">
         {{-- navbar --}}
        @include('layouts.inc.admin.navbar')
        <div class="container-fluid page-body-wrapper">
            {{-- sidebar --}}
            @include('layouts.inc.admin.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    {{-- content --}}
                    @yield('content')
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('admin/vendors/base/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('admin/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>

    <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/js/template.js') }}"></script>

    <!-- Custom js for this page-->
    <script src="{{ asset('admin/js/dashboard.js') }}"></script>
    <script src="{{ asset('admin/js/data-table.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.bootstrap4.js') }}"></script>
    <!-- End custom js for this page-->
    @yield('scripts')
    @livewireScripts
    @stack('script')
    {{-- @stack('script') là một directive trong Laravel Blade template engine được sử dụng để định nghĩa một stack 
    (ngăn xếp) script trong tệp Blade.
    Directive @stack được sử dụng để khai báo một vị trí trong tệp Blade để chứa mã script. Bất kỳ đoạn mã script nào 
    được khai báo bằng directive @push hoặc @pushonce trong các tệp Blade khác có thể được thêm vào ngăn xếp script này. --}}
</body>

</html>
