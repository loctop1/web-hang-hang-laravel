<div>
    <div class="row">
        {{-- Bộ lọc thương hiệu sản phẩm --}}
        <div class="col-md-3">
            @if ($category->brands)
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h4><b>Bộ lọc tìm kiếm</b></h4>
                    </div>
                    <div class="card-body">
                        <p class="fs-5 fw-bold">Thương hiệu sản phẩm</p>
                        @foreach ($category->brands as $brandItem)
                            <label class="d-block">
                                <input type="checkbox" wire:model="brandInputs" value="{{ $brandItem->name }}" />
                                {{ $brandItem->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif
    
            {{-- Bộ lọc sắp xếp giá tiền sản phẩm --}}
            <div class="card mt-3">
                <div class="card-body">
                    <p class="fs-5 fw-bold">Giá tiền</p>
                        <label class="d-block">
                            <input type="radio" name="priceSort" wire:model="priceInput" value="cao-den-thap" /> 
                            Giá: Cao đến Thấp
                        </label>
                        <label class="d-block">
                            <input type="radio" name="priceSort" wire:model="priceInput" value="thap-den-cao" /> 
                            Giá: Thấp đến Cao
                        </label>
                </div>
            </div>
        {{-- Giao diện sản phẩm --}}
        </div>
        <div class="col-md-9">
            <div class="row">
                @forelse ($products as $productItem)
                    <div class="col-md-4">
                        <div class="product-card">
                            <div class="product-card-img">
                                {{-- Số lượng sản phẩm --}}
                                @if ($productItem->quantity > 0)
                                    <label class="stock bg-success fw-bold">Còn hàng</label>
                                @else
                                    <label class="stock bg-danger fw-bold">Hết hàng</label>
                                @endif

                                {{-- Ảnh sản phẩm --}}
                                @if ($productItem->productImages->count() > 0)
                                    {{-- Đây là một câu lệnh điều kiện kiểm tra xem số lượng hình ảnh của sản phẩm 
                                            ($productItem->productImages->count()) có lớn hơn 0 hay không. Nếu có ít nhất 
                                            một hình ảnh, điều kiện trong câu lệnh if sẽ trả về giá trị true và mã bên 
                                            trong if sẽ được thực thi. --}}
                                    <a
                                        href="{{ url('/collections/' . $productItem->category->slug . '/' . $productItem->slug) }}">
                                        <img src="{{ asset($productItem->productImages[0]->image) }}"
                                            alt="{{ $productItem->name }}">
                                        {{-- Đường dẫn của hình ảnh được lấy từ phần tử đầu tiên của mảng 
                                                $productItem->productImages (có thể là một mảng chứa nhiều hình ảnh, nhưng 
                                                chỉ lấy hình ảnh đầu tiên). --}}
                                    </a>
                                @endif
                            </div>
                            <div class="product-card-body">
                                {{-- Thương hiệu sản phẩm --}}
                                <p class="product-brand">{{ $productItem->brand }}</p>
                                {{-- Tên sản phẩm --}}
                                <h5 class="product-name">
                                    <a
                                        href="{{ url('/collections/' . $productItem->category->slug . '/' . $productItem->slug) }}">
                                        {{ $productItem->name }}
                                    </a>
                                </h5>
                                <div>
                                    <span class="selling-price">
                                        {{ number_format($productItem->selling_price, 0, ',', '.') }}<sup>đ</sup>
                                    </span>
                                    <span class="original-price">
                                        {{ number_format($productItem->original_price, 0, ',', '.') }}<sup>đ</sup>
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <a href="" class="btn btn1">Thêm vào giỏ hàng</a>
                                    <a href="" class="btn btn1"> <i class="fa fa-heart"></i> </a>
                                    <a href="" class="btn btn1"> Xem sản phẩm </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="p-2">
                            <h4 class="text-danger fw-bold">
                                Không có sản phẩm nào cho danh mục "{{ $category->name }}"
                            </h4>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
