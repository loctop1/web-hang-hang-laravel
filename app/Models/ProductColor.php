<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $table = 'product_colors';

    protected $fillable = [
        'product_id',
        'color_id',
        'quantity'
    ];

    /**Ta xây dựng hàm color() bên model ProductColor để kế thừa cái model Color quan hệ 1 nhiều color_id với id và kết quả 
     * sẽ hiển thị tên màu sắc */
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }
}
