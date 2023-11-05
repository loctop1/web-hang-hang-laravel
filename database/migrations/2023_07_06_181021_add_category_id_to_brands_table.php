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
        //tạo bảo thêm danh mục sản phẩm vào từng thương hiệu sản phẩm
        Schema::table('brands', function (Blueprint $table) {
            $table->integer('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
};
