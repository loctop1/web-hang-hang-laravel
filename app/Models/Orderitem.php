<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\ProductColor;

class Orderitem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_color_id',
        'quantity',
        'price'
    ];
    
    // 
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
        /**Đây là một phương thức dùng để thiết lập mối quan hệ "belongs to" (thuộc về) trong Laravel giữa hai bảng. Hàm này dùng để liên kết đối tượng hiện tại của lớp với một đối 
         * tượng trong bảng "Product".
         * BelongsTo: Đây là một loại quan hệ trong Laravel, chỉ ra rằng một đối tượng thuộc về một đối tượng khác.
         * Product::class: Đây là tên của lớp đại diện cho bảng "Product" mà ta muốn thiết lập mối quan hệ.
         * 'product_id': Đây là tên cột trong bảng hiện tại mà được dùng để lưu trữ khóa ngoại (foreign key) liên kết với bảng "Product".
         * 'id': Đây là tên cột trong bảng "Product" mà được liên kết với cột "product_id" trong bảng hiện tại. */
    }

    //
    public function productColor(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id', 'id');
        /**Đây là một phương thức dùng để thiết lập mối quan hệ "belongs to" (thuộc về) trong Laravel giữa hai bảng. Hàm này dùng để liên kết đối tượng hiện tại của lớp với một đối 
         * tượng trong bảng "Product".
         * BelongsTo: Đây là một loại quan hệ trong Laravel, chỉ ra rằng một đối tượng thuộc về một đối tượng khác.
         * Product::class: Đây là tên của lớp đại diện cho bảng "Product" mà ta muốn thiết lập mối quan hệ.
         * 'product_id': Đây là tên cột trong bảng hiện tại mà được dùng để lưu trữ khóa ngoại (foreign key) liên kết với bảng "Product".
         * 'id': Đây là tên cột trong bảng "Product" mà được liên kết với cột "product_id" trong bảng hiện tại. */
    }
}
