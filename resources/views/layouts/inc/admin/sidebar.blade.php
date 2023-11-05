<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item {{ Request::is('admin/dashboard') ? 'active':'' }}">
      {{-- thực hiện việc kiểm tra xem URL hiện tại có khớp với mẫu 'admin/dashboard' không. Điều này thường được sử dụng để xác định xem trang hiện tại là trang chủ hay không, và nếu đúng 
      thì thêm lớp 'active' vào phần tử HTML để làm nổi bật mục đang được chọn trong menu điều hướng.
      Request::is('admin/dashboard'): Đây là một phương thức của Laravel, được sử dụng để so sánh một biểu thức đường dẫn với URL hiện tại. Trong trường hợp này, biểu thức là 
      'admin/dashboard', nghĩa là nó kiểm tra xem URL có chứa "admin/dashboard" không.
      ? 'active':'': Đây là một biểu thức ba ngôi. Nếu biểu thức Request::is('admin/dashboard') đúng (tức là URL hiện tại khớp với "admin/dashboard"), thì nó sẽ trả về chuỗi 'active', 
      ngược lại nó sẽ trả về chuỗi trống ''. --}}
        <a class="nav-link" href="{{ url('admin/dashboard') }}">
          <i class="mdi mdi-home menu-icon"></i>
          <span class="menu-title">Trang chủ</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="mdi mdi-account menu-icon"></i>
          <span class="menu-title">Danh mục</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href={{ url('admin/category/create') }}> Thêm danh mục sản phẩm </a></li>
            <li class="nav-item"> <a class="nav-link" href={{ url('admin/products') }}> Danh sách sản phẩm </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pages/forms/basic_elements.html">
          <i class="mdi mdi-cart-outline menu-icon"></i>
          <span class="menu-title">Sản phẩm</span>
        </a>
        
      </li>
      <li class="nav-item {{ Request::is('admin/brands') ? 'active':'' }}">
        <a class="nav-link" href="{{ url('admin/brands') }}"> 
          <i class="mdi mdi-cart-outline menu-icon"></i>
          <span class="menu-title">Thương hiệu</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('admin/colors') ? 'active':'' }}">
        <a class="nav-link" href="{{ url('admin/colors') }}"> 
          <i class="mdi mdi-border-color menu-icon"></i>
          <span class="menu-title">Màu sắc</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('admin/orders') ? 'active':'' }}">
        <a class="nav-link" href={{ url('admin/orders') }}>
          <i class="mdi mdi-sale menu-icon"></i>
          <span class="menu-title">Đơn hàng</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pages/icons/mdi.html">
          <i class="mdi mdi-emoticon menu-icon"></i>
          <span class="menu-title">Biểu tượng</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <i class="mdi mdi-account menu-icon"></i>
          <span class="menu-title">Trang người dùng</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href={{ url('admin/users/create') }}> Thêm khách hàng </a></li>
            <li class="nav-item"> <a class="nav-link" href={{ url('admin/users') }}> Danh sách khách hàng </a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ Request::is('admin/sliders') ? 'active':'' }}">
        <a class="nav-link" href="{{ url('admin/sliders') }}">
          <i class="mdi mdi-view-carousel menu-icon"></i>
          <span class="menu-title">Thanh trượt</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('admin/settings') ? 'active':'' }}">
        <a class="nav-link" href="{{ url('admin/settings') }}">
          <i class="mdi mdi-settings menu-icon"></i>
          <span class="menu-title">Cài đặt chung</span>
        </a>
      </li>
    </ul>
  </nav>