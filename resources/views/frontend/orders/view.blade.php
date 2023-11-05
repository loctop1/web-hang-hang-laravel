@extends('layouts.app')
{{-- Tiêu đề trang web --}}
@section('title', 'Thông tin chi tiết đơn hàng')
{{-- Bố cục trang web --}}
@section('content')
    <div class="py-3 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="shadow bg-white p-3">
                        <h2 class="text-primary">
                            <i class="fa fa-shopping-cart text-danger fw-bold"></i> <b>Thông tin đơn hàng của tôi</b>
                            <a href="{{ url('orders/') }}" class="btn btn-danger btn-sm fw-bold float-end">Quay lại</a>
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
                                    <b>Tình trạng đơn hàng:</b> <span
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
                        <h2 class="text-primary"><i class="fa fa-shopping-cart text-secondary fw-bold"></i> <b>Đơn đặt hàng</b></h2>
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
                                            <td width="10%" class="border-dark border-2">
                                                @if ($orderItem->product->productImages)
                                                    <div class="product-image">
                                                        <img src="{{ asset($orderItem->product->productImages[0]->image) }}"
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
                                            <td width="10%" class="text-danger fw-bold p-4">
                                                {{ number_format($orderItem->price, 0, ',', '.') }}<sup>đ</sup>
                                            </td>
                                            <td width="10%" class="p-4">{{ $orderItem->quantity }}</td>
                                            <td width="10%" class="text-danger fw-bold p-4">
                                                {{ number_format($orderItem->quantity *  $orderItem->price, 0, ',', '.')}}<sup>đ</sup>
                                            </td>
                                            {{-- Tổng tiền tất cả sản phẩm --}}
                                            @php
                                                $totalPrice += $orderItem->quantity *  $orderItem->price;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    <tr class="border-dark border-2 text-center">
                                        <td width="10%" class="border-dark border-2 p-4 fw-bold fs-3" colspan="5">Tổng tiền tạm tính</td>
                                        <td width="10%" class="border-dark border-2 p-4 fw-bold fs-3" colspan="1">{{ number_format($totalPrice, 0, ',', '.') }}<sup>đ</sup></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
