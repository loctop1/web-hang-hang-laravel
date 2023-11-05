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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            /**Tạo một cột có tên 'slug' kiểu dữ liệu là string (chuỗi ký tự). Đây có thể là cột để lưu một phiên bản 
             * chuẩn hóa của tên, thường được sử dụng trong URL hoặc SEO. */
            $table->longText('description');
            $table->string('image')->nullable();
            /**Tạo một cột có tên 'image' kiểu dữ liệu là string (chuỗi ký tự). Cột này được đặt là null được phép, 
             * có nghĩa là nó có thể không có giá trị (không bắt buộc). Có thể được sử dụng để lưu đường dẫn 
             * hoặc tên file của hình ảnh liên quan đến mục trong bảng. */
            $table->string('meta_title');
            /**Tạo một cột có tên 'meta_title' kiểu dữ liệu là string (chuỗi ký tự). Đây có thể là cột để lưu tiêu đề meta,
             * một phần quan trọng trong SEO. */
            $table->string('meta_keyword');
            /**Tạo một cột có tên 'meta_keyword' kiểu dữ liệu là string (chuỗi ký tự). Đây có thể là cột để lưu các 
             * từ khóa meta, cũng là một yếu tố quan trọng trong SEO. */
            $table->mediumText('meta_description');
            /**Tạo một cột có tên 'meta_description' kiểu dữ liệu là mediumText (được sử dụng để lưu trữ mô tả meta). 
             * Đây có thể là cột để lưu mô tả ngắn gọn của mục trong bảng, cũng là một yếu tố quan trọng trong SEO. */
            $table->tinyInteger('status')->default('0')->comment('0=visible,1=hidden');
            /**Tạo một cột có tên 'status' kiểu dữ liệu là tinyInteger (số nguyên nhỏ). Cột này được đặt giá trị mặc định 
             * là '0' và có một comment (chú thích) để chỉ rõ ý nghĩa của các giá trị. Thường được sử dụng để lưu trạng thái 
             * của mục trong bảng, ví dụ như '0' có thể đại diện cho trạng thái "hiển thị" và '1' có thể đại diện 
             * cho trạng thái "ẩn". */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
