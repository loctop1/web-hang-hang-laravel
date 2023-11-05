<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists';

    protected $fillable = [
        'user_id',
        'product_id'
    ];

    //tạo chức năng quan hệ 1 nhiều trong danh mục sản phẩm yêu thích
    public function product(): BelongsTo
    // Tạo một quan hệ "belongsTo" với mô hình Product
    // Mô hình Wishlist "thuộc về" một mô hình Product
    // Sử dụng cột 'product_id' của mô hình Wishlist và cột 'id' của mô hình Product để xác định quan hệ
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
        /**Trong hàm product(), bạn định nghĩa một quan hệ "belongsTo" với mô hình Product. Mô hình Wishlist "thuộc về" một mô hình Product. Quan hệ này được xác định bằng cách sử dụng cột 
         * product_id của mô hình Wishlist và cột id của mô hình Product để xác định quan hệ giữa chúng.
         * Quan hệ "belongsTo" cho phép bạn truy cập vào mô hình Product từ mô hình Wishlist. Ví dụ: $wishlist->product sẽ trả về mô hình Product tương ứng với mục yêu thích trong danh sách. */
    }
}
