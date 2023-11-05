<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'Brands';
    //xây dựng model lọc nhãn hiệu sản phẩm
    protected $fillable = [
        'name',
        'slug',
        'status',
        'category_id' 
    ];

    //tạo chức năng quan hệ một nhiều thương hiệu sản phẩm với danh mục sản phẩm
    public function category()
    {
        return $this->belongsTo(category::class, 'category_id', 'id');
    }
}
