<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $t) {
            $t->bigIncrements('idOrderItem');

            $t->unsignedBigInteger('order_id')->index();     // FK -> orders.idOrder
            $t->unsignedBigInteger('product_id')->index();   // FK -> Product.idProduct

            // snapshot để không bị đổi tên/ảnh khi product thay đổi
            $t->string('product_name', 150);
            $t->string('product_image', 255)->nullable();

            // biến thể
            $t->enum('size', ['S', 'M', 'L'])->nullable();

            // tiền
            $t->unsignedInteger('unit_price');          // giá 1 sp tại thời điểm mua
            $t->unsignedInteger('quantity')->default(1);
            $t->unsignedBigInteger('line_total');       // unit_price * quantity

            $t->timestamps();

            $t->foreign('order_id')->references('idOrder')->on('orders')->cascadeOnDelete();

            // LƯU Ý: bảng product của bạn tên là "Product" và PK là "idProduct"
            $t->foreign('product_id')->references('idProduct')->on('Product')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
