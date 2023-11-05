<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;


class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'status'
    ];
    
    //ta xây dựng hàm products để chạy tính năng validate products bên controller
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id','id');
        /**hasMany(Product::class, 'category_id', 'id'): Đây là một phương thức kế thừa từ lớp cơ sở (thường là lớp Model 
         * của Laravel) và xác định mối quan hệ One-to-Many với mô hình Product. Giá trị đầu tiên (Product::class) xác định 
         * mô hình liên kết với mối quan hệ. Giá trị thứ hai ('category_id') xác định tên cột khóa ngoại trong mô hình 
         * Product để xác định quan hệ. Giá trị thứ ba ('id') xác định tên cột khóa chính trong lớp hiện tại (lớp chứa 
         * phương thức này).
         * Tóm lại, phương thức products() trả về một bộ sưu tập (Collection) các đối tượng Product có category_id tương ứng 
         * với id của lớp hiện tại. */
    }

    //xây dựng tính năng quan hệ 1 nhiều các sản phẩm tương tự
    public function relatedProducts()
    {
        return $this->hasMany(Product::class, 'category_id','id')->latest()->take(100);
    }

    //ta xây dựng hàm brands để chạy tính năng bộ lọc cho thương hiệu sản phẩm
    public function brands(){
        return $this->hasMany(Brand::class, 'category_id','id')->where('status', '0');
    }
}
