@extends('layouts.admin')
{{-- Tiêu đề trang web --}}
@section('title', 'Đơn hàng của tôi')
{{-- Bố cục trang web --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            
            @if (session('message'))
                <div class="alert alert-success mb-3">{{ session('message') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h1 class="fw-bold">
                        Đơn hàng của tôi
                    </h1>
                </div>
                <div class="card-body">
                    <div class="shadow bg-white p-3">
                        <h2 class="text-primary">
                            <i class="fa fa-shopping-cart text-danger fw-bold"></i> <b>Thông tin đơn hàng của tôi</b>
                            <a href="{{ url('admin/orders') }}" class="btn btn-danger btn-sm fw-bold float-end text-light mx-1">
                                <span class="fa fa-arrow-left"></span>
                                Quay lại
                            </a>
                            <a href="{{ url('admin/invoice/'.$order->id.'/generate') }}" class="btn btn-success btn-sm fw-bold float-end text-light mx-1">
                                <span class="fa fa-download"></span>
                                Tải hóa đơn 
                            </a>
                            <a href="{{ url('admin/invoice/'.$order->id) }}" target="_blank" class="btn btn-primary btn-sm fw-bold float-end text-light mx-1">
                                <span class="fa fa-eye"></span>
                                Xem hóa đơn
                            </a>
                            <a href="{{ url('admin/invoice/'.$order->id.'/mail') }}" class="btn btn-info btn-sm fw-bold float-end text-light mx-1">
                                <i class="fa-regular fa-envelope fa-lg"></i>
                                Gửi Email
                            </a>
                        </h2>
                        <hr style="height: 5px;color:black;">
                        <div class="row">
                            {{-- Đơn hàng --}}
                            <div class="col-md-6">
                                <h3 class="fw-bold">Thông tin đơn hàng</h3>
                                <hr style="height: 5px;color:black;">
                                <h5><b>ID:</b> {{ $order->id }}</h5>
                                <h5><b>Mã đơn hàng:</b> {{ $order->tracking_no }}</h5>
                                <h5><b>Ngày đặt hàng:</b>
                                    <?php
                                    // Mảng ánh xạ giá trị thứ từ tiếng Anh sang tiếng Việt
                                    $daysOfWeek = [
                                        'Monday' => 'Thứ Hai',
                                        'Tuesday' => 'Thứ Ba',
                                        'Wednesday' => 'Thứ Tư',
                                        'Thursday' => 'Thứ Năm',
                                        'Friday' => 'Thứ Sáu',
                                        'Saturday' => 'Thứ Bảy',
                                        'Sunday' => 'Chủ Nhật',
                                    ];
                                    
                                    // Thiết lập múi giờ của Việt Nam
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    
                                    // Lấy ngày và giờ của Việt Nam từ đối tượng $order
                                    $dateVN = $order->created_at->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh'));
                                    
                                    ?>
                                    {{ $daysOfWeek[$dateVN->format('l')] }},
                                    {{ $dateVN->format('d-m-Y H:i:s') }}
                                </h5>
                                <h5><b>Phương thương thanh toán:</b> {{ $order->payment_mode }}</h5>
                                <h5 class="border border-dark p-2 text-success">
                                    <b>Tình trang dơn hàng:</b> <span
                                        class="text-uppercase">{{ $order->status_message }}</span>
                                </h5>
                            </div>
                            {{-- Khách hàng --}}
                            <div class="col-md-6">
                                <h3 class="fw-bold">Thông tin khách hàng</h3>
                                <hr style="height: 5px;color:black;">
                                <h5><b>Họ và tên:</b> {{ $order->fullname }}</h5>
                                <h5><b>Email:</b> {{ $order->email }}</h5>
                                <h5><b>Số điện thoại:</b> {{ $order->phone }}</h5>
                                <h5><b>Địa chỉ:</b> {{ $order->address }}</h5>
                                <h5><b>Mã bưu điện:</b> {{ $order->pincode }}</h5>
                            </div>
                        </div>
                        <br />
                        {{--  --}}
                        <h2 class="text-primary"><i class="fa fa-shopping-cart text-secondary fw-bold"></i> <b>Đơn đặt
                                hàng</b></h2>
                        <hr style="height: 5px;color:black;">
                        <div class="table-reponsive">
                            <table class="table table-bodered table-striped">
                                <thead
                                    class="btn-primary text-center text-light fw-bold table-bordered border-dark border-2">
                                    <tr>
                                        <th class="fs-5 border-dark border-2">ID</th>
                                        <th class="fs-5 border-dark border-2">Ảnh</th>
                                        <th class="fs-5 border-dark border-2">Tên sản phẩm</th>
                                        <th class="fs-5 border-dark border-2">Giá bán</th>
                                        <th class="fs-5 border-dark border-2">Số lượng</th>
                                        <th class="fs-5 border-dark border-2">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody class="btn-warning fw-bold border-dark border-2">
                                    @php
                                        $totalPrice = 0;
                                    @endphp
                                    @foreach ($order->orderItems as $orderItem)
                                        <tr class="border-dark border-2 text-center">
                                            <td width="10%" class="border-dark border-2 p-4">{{ $orderItem->id }}</td>
                                            <td  class="border-dark border-2">
                                                @if ($orderItem->product->productImages)
                                                    <div class="product-image">
                                                        <img style="height: auto; width:40%; border-radius:0px;" src="{{ asset($orderItem->product->productImages[0]->image) }}"
                                                            alt="{{ $orderItem->product->name }}">
                                                    </div>
                                                @else
                                                    <div class="product-image">
                                                        <img src="" alt="{{ $orderItem->product->name }}">
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="border-dark border-2">
                                                <h5 class="p-4">{{ $orderItem->product->name }}</h5>
                                                {{-- Màu sắc sản phẩm --}}
                                                @if ($orderItem->productColor)
                                                    {{-- kiểm tra xem giỏ hàng có thông tin về màu sắc sản phẩm không. Nếu có, hàm trả về true. --}}
                                                    @if ($orderItem->productColor->color)
                                                        {{-- kiểm tra xem sản phẩm có màu sắc được định nghĩa hay không. Nếu có, hàm trả về true. --}}
                                                        <span class="color">Màu sắc sản phẩm:
                                                            {{ $orderItem->productColor->color->name }}
                                                        </span>
                                                        {{--  sẽ được thực thi nếu cả hai điều kiện trên đúng. Nó hiển thị tên của màu sắc sản phẩm. --}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td width="10%" class="text-danger fw-bold p-4 border-dark border-2">
                                                {{ number_format($orderItem->price, 0, ',', '.') }}<sup>đ</sup>
                                            </td>
                                            <td width="10%" class="p-4">{{ $orderItem->quantity }}</td>
                                            <td width="10%" class="text-danger fw-bold p-4 border-dark border-2">
                                                {{ number_format($orderItem->quantity * $orderItem->price, 0, ',', '.') }}<sup>đ</sup>
                                            </td>
                                            {{-- Tổng tiền tất cả sản phẩm --}}
                                            @php
                                                $totalPrice += $orderItem->quantity * $orderItem->price;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    <tr class="border-dark border-2 text-center">
                                        <td width="10%" class="border-dark border-2 p-4 fw-bold fs-3" colspan="5">Tổng
                                            tiền tạm tính</td>
                                        <td width="10%" class="border-dark border-2 p-4 fw-bold fs-3 text-danger" colspan="1">
                                            {{ number_format($totalPrice, 0, ',', '.') }}<sup>đ</sup></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                .
            </div>

            <div class="card border mt-3">
                <div class="card-body">
                    <h2>Trạng thái đơn hàng(Cập nhật trạng thái đơn hàng)</h2>
                    <br />
                    <div class="row">
                        <div class="col-md-5">
                            <form action="{{ url('admin/orders/'.$order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label for="">Cập nhật trạng thái đơn hàng của bạn</label>
                                <div class="input-gruop">
                                    <select name="order_status" class="form-select">
                                        <option value="">Chọn trạng thái đơn hàng</option>
                                        <option value="Đơn hàng đang được xử lý"
                                            {{ Request::get('status') == 'Đơn hàng đang được xử lý' ? 'selected' : '' }}>
                                            {{-- Request::get('status'): Đây là cách để truy xuất giá trị tham số 'status' từ URL. 
                                            == 'Đơn hàng đang được xử lý' ? 'selected':'': Đây là một biểu thức điều kiện trong PHP. Nếu giá trị được truy xuất từ tham số 'status' trùng 
                                            khớp với 'Đơn hàng đang được xử lý', thì biểu thức sẽ trả về 'selected'. Nếu không, nó sẽ trả về một chuỗi rỗng ''. --}}
                                            Đơn hàng đang được xử lý
                                        </option>
                                        <option value="Đơn hàng đã hoàn thành"
                                            {{ Request::get('status') == 'Đơn hàng đã hoàn thành' ? 'selected' : '' }}>
                                            Đơn hàng đã hoàn thành
                                        </option>
                                        <option value="Đơn hàng chưa được xử lý"
                                            {{ Request::get('status') == 'Đơn hàng chưa được xử lý' ? 'selected' : '' }}>
                                            Đơn hàng chưa được xử lý</option>
                                        <option value="Đơn hàng bị hủy"
                                            {{ Request::get('status') == 'Đơn hàng bị hủy' ? 'selected' : '' }}>Đơn hàng bị
                                            hủy
                                        </option>
                                        <option value="Đơn hàng đang được giao"
                                            {{ Request::get('status') == 'Đơn hàng đang được giao' ? 'selected' : '' }}>
                                            Đơn hàng đang được giao
                                        </option>
                                    </select>
                                    <br/>
                                    <button type="submit" class="btn btn-info fs-bold fs-6 text-light border-dark border-3">
                                        Cập nhật
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-7">
                            <h2 class="mt-3">Trạng thái đơn hàng: 
                                <span class="text-uppercase fs-6 border border-dark p-2 text-success">
                                    {{ $order->status_message }}
                                </span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
