<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Orderitem;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'tracking_no',
        'fullname',
        'email',
        'phone',
        'pincode',
        'address',
        'status_message',
        'payment_mode',
        'payment_id',
    ];
    
    //tạo chức năng quan hệ 1 nhiều các hóa đơn sản phẩm 
    public function orderItems(): HasMany
    {
        return $this->hasMany(Orderitem::class, 'order_id', 'id');
        // 1. Định nghĩa mối quan hệ "hasMany" với mô hình Orderitem.
        //    Đối số đầu tiên là tên lớp của mô hình liên kết (Orderitem::class).
        //    Đối số thứ hai là khóa ngoại trong bảng Orderitem để ánh xạ với khóa chính trong bảng hiện tại ('order_id').
        //    Đối số thứ ba là khóa chính trong bảng liên kết mà mô hình hiện tại sẽ liên kết ('id').
        //    Hàm này sẽ giúp xác định mối quan hệ "một-nhiều" giữa hai bảng, trong đó bảng hiện tại là "một" và bảng liên kết là "nhiều".
    }
}
