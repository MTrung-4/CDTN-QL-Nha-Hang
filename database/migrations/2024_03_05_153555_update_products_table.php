<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột menu_id
            $table->unsignedBigInteger('menu_id');
            // Định nghĩa khóa ngoại
            $table->foreign('menu_id')->references('id')->on('menus');
            // Hoặc nếu bạn muốn xóa cả dòng khi xóa menu thì sử dụng
            // $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->longText('description');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Xóa khóa ngoại trước khi xóa cột
            $table->dropForeign(['menu_id']);
            // Xóa cột menu_id
            $table->dropColumn('menu_id');
            $table->dropColumn('description');
        });
    }
};

