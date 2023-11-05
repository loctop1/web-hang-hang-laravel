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
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('role_as')->default('0')->comment('0=user,1=admin');
            /**tinyInteger('role_as'): Tạo một cột mới có tên 'role_as' với kiểu dữ liệu là tinyInteger trong bảng 'users'. 
             * Kiểu dữ liệu tinyInteger cho phép lưu trữ các giá trị số nguyên nhỏ 
             * trong khoảng từ -128 đến 127 (hoặc 0 đến 255 nếu không âm). 
             * default('0'): Đặt giá trị mặc định cho cột 'role_as' là 0. Nghĩa là nếu không có giá trị được cung cấp 
             * khi thêm một bản ghi mới vào bảng 'users', giá trị của cột 'role_as' sẽ được đặt là 0.
             * comment('0=user,1=admin'): Thêm một chú thích (comment) cho cột 'role_as' để mô tả rõ ràng vai trò 
             * của các giá trị trong cột. Ở đây, comment cho biết giá trị 0 tương ứng với vai trò 'user' và giá trị 1 
             * tương ứng với vai trò 'admin'.*/
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_as');
            /**Hàm dropColumn('role_as') có tác dụng xóa cột có tên 'role_as' khỏi bảng 'users'. 
             * Nếu bạn chạy phương thức down(), cột 'role_as' sẽ bị xóa và không còn tồn tại trong bảng 'users' nữa. */
        });
    }
};
