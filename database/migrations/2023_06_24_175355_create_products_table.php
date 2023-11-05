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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            /**Tạo một cột có tên "category_id" với kiểu dữ liệu unsignedBigInteger. Cột này được sử dụng để lưu trữ khóa 
             * ngoại tham chiếu đến bảng "categories". Kiểu dữ liệu unsignedBigInteger: Được sử dụng để lưu trữ giá trị 
             * không âm của khóa ngoại. UnsignedBigInteger hỗ trợ các giá trị từ 0 đến 18,446,744,073,709,551,615. */
            $table->string('name');
            $table->string('slug');
            $table->string('brand')->nullable();
            $table->mediumText('small_description')->nullable();
            $table->longText('description')->nullable();

            //tạo các bảng giá tiền sản phẩm
            $table->integer('original_price');
            $table->integer('selling_price');
            //Tạo một cột có tên "quantity" để lưu trữ số lượng sản phẩm.
            $table->integer('quantity');
            $table->tinyInteger('trending')->default('0')->comment('1=trending,0=not-trending');
            /**Tạo một cột có tên "trending" với kiểu dữ liệu tinyInteger. Cột này được sử dụng để lưu trữ trạng thái của 
             * sản phẩm có đang trở thành xu hướng hay không.
             * Phương thức default() xác định giá trị mặc định cho cột "trending" là 0. Điều này có nghĩa là nếu không có 
             * giá trị được cung cấp khi tạo mới một bản ghi, giá trị của cột "trending" sẽ được đặt là 0.
             * Phương thức comment() được sử dụng để thêm chú thích cho cột "trending". Trong trường hợp này, chú thích là 
             * "1=trending,0=not-trending" để mô tả ý nghĩa của giá trị 1 và 0 trong cột "trending". */
            $table->tinyInteger('featured')->default('0')->comment('1=featured,0=not-featured');
            $table->tinyInteger('status')->default('0')->comment('1=hidden,0=visible');
            /**Tạo một cột có tên "status" với kiểu dữ liệu tinyInteger. Cột này được sử dụng để lưu trữ trạng thái của 
             * sản phẩm (ẩn hoặc hiển thị).
             * Phương thức default() xác định giá trị mặc định cho cột "status" là 0. Điều này có nghĩa là nếu không có 
             * giá trị được cung cấp khi tạo mới một bản ghi, giá trị của cột "status" sẽ được đặt là 0.
             * Phương thức comment() được sử dụng để thêm chú thích cho cột "status". Trong trường hợp này, chú thích là 
             * "1=hidden,0=visible" để mô tả ý nghĩa của giá trị 1 và 0 trong cột "status". */

            //tạo các bảng từ khóa sản phẩm
            $table->string('meta_title')->nullable();
            $table->mediumText('meta_keyword')->nullable();
            $table->mediumText('meta_description')->nullable();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            /**Phương thức foreign() được sử dụng để khai báo rằng cột category_id sẽ là một khóa ngoại (foreign key) 
             * trong bảng products. 
             * Phương thức references() xác định cột trong bảng categories mà khóa ngoại category_id tham chiếu đến. 
             * Trong trường hợp này, nó tham chiếu đến cột id trong bảng categories.
             * Phương thức on() chỉ định bảng mà khóa ngoại category_id tham chiếu đến. Trong trường hợp này, nó tham chiếu 
             * đến bảng categories.
             * Phương thức onDelete() được sử dụng để xác định hành động xảy ra khi bản ghi trong bảng categories bị xóa. 
             * Trong trường hợp này, quy tắc onDelete('cascade') được áp dụng, nghĩa là khi một bản ghi trong bảng 
             * categories bị xóa, tất cả các bản ghi tương ứng trong bảng products cũng sẽ bị xóa.*/
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
