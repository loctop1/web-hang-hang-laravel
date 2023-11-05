<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Hóa đơn #{{ $order->id }}</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: aozoraminchomedium;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        label {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }

        table thead th {
            height: 28px;
            text-align: center;
            font-size: 24px;
            font-family: Arial, sans-serif;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 20px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: Arial, sans-serif;
        }

        .small-heading {
            font-size: 18px;
            font-family: Arial, sans-serif;
        }

        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: Arial, sans-serif;
        }

        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }

        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: center;
            font-size: 30px;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
            font-size: 24px;
            color: #333;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: 400;
        }

        .no-border {
            border: 1px solid #fff !important;
        }

        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }

        .product-image img {
            width: 200px;
        }

        td.text-danger.border-dark.border-2.p-4.fw-bold.fs-3 {
            color: red;
            font-weight: 600;
            font-size: 30px;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h2>Xin chân thành cảm ơn!</h2>
        <p>
            Cảm ơn bạn đã ủng hộ {{ $appSetting->website_name ?? 'loctop1' }}
            <br/>
            Đơn hàng của bạn đã được gửi về Mail!
        </p>
    </div>
    <table class="order-details">
        <thead>
            <tr>
                <th width="50%" colspan="2">
                    <h2 class="text-start">Hóa đơn sản phẩm</h2>
                </th>
                <th width="50%" colspan="2" class="text-end company-data">
                    <span>Mã hóa đơn: #{{ $order->id }}</span> <br>
                    <span>Ngày: {{ date('d / m / Y') }}</span> <br>
                    <span>Mã bưu điện: {{ $order->pincode }}</span> <br>
                    <span>Địa chỉ: Số 2 Ngách 4, Thụy Khuê, Tây Hồ, Hà Nội</span> <br>
                </th>
            </tr>
            <tr class="bg-blue">
                <th width="50%" colspan="2">Thông tin đơn hàng</th>
                <th width="50%" colspan="2">Thông tin người dùng</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mã đơn hàng:</td>
                <td>{{ $order->id }}</td>

                <td>Họ và tên:</td>
                <td>{{ $order->fullname }}</td>
            </tr>
            <tr>
                <td>Mã số theo dõi/Chưa có:</td>
                <td>{{ $order->tracking_no }}</td>

                <td>Email:</td>
                <td>{{ $order->email }}</td>
            </tr>
            <tr>
                <td>Ngày đặt hàng:</td>
                <td>
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
                </td>
                <td>Số điện thoại:</td>
                <td>{{ $order->phone }}</td>
            </tr>
            <tr>
                <td>Phương thức thanh toán:</td>
                <td>{{ $order->payment_mode }}</td>

                <td>Địa chỉ:</td>
                <td>{{ $order->address }}</td>
            </tr>
            <tr>
                <td>Tình trạng đơn hàng:</td>
                <td>{{ $order->status_message }}</td>

                <td>Mã bưu điện:</td>
                <td>{{ $order->pincode }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                    Các mặt hàng trong đơn hàng
                </th>
            </tr>
            <tr class="bg-blue">
                <th>ID</th>
                <th>Ảnh</th>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng cộng</th>
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
                        @if ($orderItem->product->productImages->isNotEmpty())
                            <div class="product-image">
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($orderItem->product->productImages[0]->image))) }}"
                                    alt="{{ $orderItem->product->name }}">
                            </div>
                        @else
                            <div class="product-image">
                                <img src="{{ asset('path/to/placeholder/image.jpg') }}"
                                    alt="{{ $orderItem->product->name }}">
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
                    <td width="15%" class="text-danger fw-bold p-4">
                        {{ number_format($orderItem->quantity * $orderItem->price, 0, ',', '.') }}<sup>đ</sup>
                    </td>
                    {{-- Tổng tiền tất cả sản phẩm --}}
                    @php
                        $totalPrice += $orderItem->quantity * $orderItem->price;
                    @endphp
                </tr>
            @endforeach
            <tr class="border-dark border-2 text-center">
                <td width="10%" class="border-dark border-2 p-4 fw-bold fs-3 total-heading" colspan="5">Tổng
                    tiền tạm tính</td>
                <td width="10%" class="text-danger border-dark border-2 p-4 fw-bold fs-3 total-heading"
                    colspan="1">
                    {{ number_format($totalPrice, 0, ',', '.') }}<sup>đ</sup></td>
            </tr>
        </tbody>
    </table>

    <br>
    <p class="text-center">
        Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi.
    </p>

</body>


</html>
