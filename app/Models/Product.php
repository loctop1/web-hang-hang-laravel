<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;
use App\Models\ProductColor;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = 
    [
        'category_id',
        'name',
        'slug',
        'brand',
        'small_description',
        'description',
        'original_price',
        'selling_price',
        'quantity',
        'trending',
        'featured',
        'status',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];
    
    //xây dựng chức năng quản hệ nhiều một giữa các sản phẩm với danh mục sản phẩm
    public function category()
    {
       return $this->belongsTo(Category::class, 'category_id', 'id' );
       /**belongsto() đây là một phương thức của Eloquent ORM trong Laravel, dùng để thiết lập mối quan hệ 
        * "nhiều-một" (many-to-one) giữa hai bảng. Nó cho biết rằng một sản phẩm thuộc về một danh mục cụ thể. */ 
    }
    
    //ta xây dựng hàm productImage để chạy tính năng validate ảnh sản phẩm bên controller
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
        /**Là một phương thức của Eloquent ORM trong Laravel, dùng để thiết lập mối quan hệ "một-nhiều" 
         * (one-to-many) giữa hai bảng. Trong trường hợp này, nó cho biết rằng một sản phẩm có thể có nhiều hình ảnh 
         * sản phẩm (one-to-many relationship).
         * ProductImage::class chỉ định mô hình (model) Eloquent được sử dụng để đại diện cho bảng "product_images".
         * 'product_id' là tên cột trong bảng "product_images" mà sẽ được sử dụng để xác định mối quan hệ với cột 
         * "id" trong bảng "products".
         * 'id' là tên cột trong bảng "products" đại diện cho khóa chính. */
    }

    //ta xây dựng hàm productColors để chạy tính năng validate màu sắc sản phẩm bên controller
    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'product_id', 'id');
    }
}
