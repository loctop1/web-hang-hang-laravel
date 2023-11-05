<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //Bảng thông tin hóa đơn khách hàng
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('tracking_no');
            //cột lưu mã theo dõi đơn hàng.
            $table->string('fullname');
            $table->string('email');
            $table->string('phone');
            $table->string('pincode');
            //cột lưu mã vùng (mã bưu điện) của địa chỉ người nhận đơn hàng.
            $table->mediumText('address');
            $table->string('status_message');
            //cột lưu thông báo trạng thái của đơn hàng.
            $table->string('payment_mode');
            //cột lưu phương thức thanh toán của đơn hàng.
            $table->string('payment_id')->nullable();
            //cột lưu ID thanh toán (nếu có) của đơn hàng. Cột này cho phép giá trị rỗng (nullable()).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
