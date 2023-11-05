@extends('layouts.admin')
{{-- Tiêu đề trang web --}}
@section('title', 'Danh sách đơn hàng của tôi')
{{-- Bố cục trang web --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="fw-bold">
                        Danh sách đơn hàng của tôi
                    </h1>
                </div>
                <div class="card-body">
                    {{-- Form lọc sản phẩm --}}
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="fs-4 fw-bold">Ngày</label>
                                <input type="date" name="date" value="{{ Request::get('date') ?? date("Y-m-d") }}" class="form-control border-dark border-3">
                            </div>
                            <div class="col-md-3">
                                <label for="" class="fs-4 fw-bold">Trạng thái đơn hàng</label>
                                <br/>
                                <select name="status" id="" class="form-select border-dark border-3">
                                    <option value="">Tất cả</option>
                                    <option value="Đơn hàng đang được xử lý" {{ Request::get('status') == 'Đơn hàng đang được xử lý' ? 'selected':'' }}>
                                        {{-- Request::get('status'): Đây là cách để truy xuất giá trị tham số 'status' từ URL. 
                                            == 'Đơn hàng đang được xử lý' ? 'selected':'': Đây là một biểu thức điều kiện trong PHP. Nếu giá trị được truy xuất từ tham số 'status' trùng 
                                            khớp với 'Đơn hàng đang được xử lý', thì biểu thức sẽ trả về 'selected'. Nếu không, nó sẽ trả về một chuỗi rỗng ''.--}}
                                        Đơn hàng đang được xử lý
                                    </option>
                                    <option value="Đơn hàng đã hoàn thành" {{ Request::get('status') == 'Đơn hàng đã hoàn thành' ? 'selected':'' }}>
                                        Đơn hàng đã hoàn thành
                                    </option>
                                    <option value="Đơn hàng chưa được xử lý" {{ Request::get('status') == 'Đơn hàng chưa được xử lý' ? 'selected':'' }}>
                                        Đơn hàng chưa được xử lý</option>
                                    <option value="Đơn hàng bị hủy" {{ Request::get('status') == 'Đơn hàng bị hủy' ? 'selected':'' }}>Đơn hàng bị hủy
                                    </option>
                                    <option value="Đơn hàng đang được giao" {{ Request::get('status') == 'Đơn hàng đang được giao' ? 'selected':'' }}>
                                        Đơn hàng đang được giao
                                    </option>
                                </select>
                                <button></button>
                            </div>
                            <div class="col-md-6">
                                <br/>
                                <button type="submit" class="btn btn-info fs-bold fs-4 text-light border-dark border-3">
                                    Lọc
                                </button>
                            </div>
                        </div>
                    </form>
                    <br/>
                    <div class="table-reponsive">
                        <table class="table table-bodered table-striped">
                            <thead class="btn-primary text-center text-light fw-bold table-bordered border-dark border-2">
                                <tr>
                                    <th class="fs-5 border-dark border-2">ID</th>
                                    <th class="fs-5 border-dark border-2">Mã đơn hàng</th>
                                    <th class="fs-5 border-dark border-2">Tên khách hàng</th>
                                    <th class="fs-5 border-dark border-2">Phương thức thanh toán</th>
                                    <th class="fs-5 border-dark border-2">Ngày đặt hàng</th>
                                    <th class="fs-5 border-dark border-2">Trạng thái đơn hàng</th>
                                    <th class="fs-5 border-dark border-2">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="btn-warning fw-bold border-dark border-2">
                                @forelse ($orders as $item)
                                    <tr class="border-dark border-2 text-center">
                                        <td class="border-dark border-2">{{ $item->id }}</td>
                                        <td class="border-dark border-2">{{ $item->tracking_no }}</td>
                                        <td class="border-dark border-2">{{ $item->fullname }}</td>
                                        <td class="border-dark border-2">{{ $item->payment_mode }}</td>
                                        {{-- Chức năng hiển thị tiếng việt cho ngày tháng năm --}}
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
                                        ?>

                                        <!-- Trong view của bạn -->
                                        <td class="border-dark border-2">
                                            {{ $daysOfWeek[$item->created_at->format('l')] }},
                                            {{ $item->created_at->format('d-m-Y') }}
                                        </td>
                                        <td class="border-dark border-2">{{ $item->status_message }}</td>
                                        <td class="border-dark border-2">
                                            <a href="{{ url('admin/orders/'.$item->id) }}"
                                                class="btn btn-primary btn-sm text-light fw-bold">Xem</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="card card-body shadow text-center p-md-5">
                                                <div class="container block-info mt-3">
                                                    <div data-v-5a4f0845="">
                                                        <div data-v-5a4f0845="" class="nothing-in-cart">
                                                            <svg data-v-5a4f0845="" aria-hidden="true" focusable="false"
                                                                data-prefix="fas" data-icon="frown" role="img"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                style="width:60px; height:60px" viewBox="0 0 496 512"
                                                                class="svg-inline--fa fa-frown">
                                                                <path data-v-5a4f0845="" fill="currentColor"
                                                                    d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm80 168c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm-160 0c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zm170.2 218.2C315.8 367.4 282.9 352 248 352s-67.8 15.4-90.2 42.2c-13.5 16.3-38.1-4.2-24.6-20.5C161.7 339.6 203.6 320 248 320s86.3 19.6 114.7 53.8c13.6 16.2-11 36.7-24.5 20.4z"
                                                                    class=""></path>
                                                            </svg>
                                                            <p data-v-5a4f0845="">Không có sản phẩm nào danh sách đơn hàng
                                                                của bạn, vui lòng
                                                                quay lại!
                                                            </p>
                                                            <a data-v-5a4f0845="" href="{{ url('/') }}"
                                                                class="go-back">Quay lại
                                                                trang
                                                                chủ</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div>
                            <ul class="custom-pagination">
                                {{ $orders->links() }}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
