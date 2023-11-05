<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\ProductColor;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'product_id',
        'product_color_id',
        'quantity'
    ];

    //tạo chức năng quan hệ một nhiều các sản phẩm trong giỏ hàng
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    //tạo chức năng quan hệ một nhiều các màu sắc sản phẩm trong giỏ hàng
    public function productColor(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id', 'id');
    }
}