<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('color_id')->nullable();
            /**Tạo một cột có tên là "color_id" trong bảng "product_colors". Đây cũng là một cột kiểu số nguyên không dấu 
             * (unsigned big integer) để lưu trữ ID của màu sắc. Cột này có thể có giá trị null, tức là không bắt buộc phải 
             * có màu sắc. */
            $table->integer('quantity');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');
            /**Định nghĩa ràng buộc khóa ngoại trên cột "color_id". Ràng buộc này liên kết với cột "id" trong bảng "color". 
             * Khi xóa một màu sắc trong bảng "color", cột "color_id" trong bảng "product_colors" sẽ được đặt thành giá trị 
             * null (onDelete('set null')).
             * onDelete('set null') chỉ định hành động khi xóa một hàng trong bảng "color" mà có các hàng trong bảng 
             * "product_colors" tham chiếu đến nó thông qua khóa ngoại "color_id". Trong trường hợp này, hành động được thực 
             * hiện là đặt giá trị cột "color_id" của các hàng liên quan trong bảng "product_colors" thành giá trị null. 
             * Điều này cho phép các sản phẩm trong bảng "product_colors" vẫn tồn tại mà không cần có màu sắc tương ứng. */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_colors');
    }
};
