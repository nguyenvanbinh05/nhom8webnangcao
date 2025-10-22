<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $t) {
            $t->bigIncrements('idOrder');
            $t->unsignedBigInteger('user_id')->nullable()->index();
            $t->string('code', 32)->unique();

            // thông tin KH + giao hàng
            $t->string('full_name', 120);
            $t->string('phone', 20);
            $t->string('email', 120)->nullable();
            $t->string('address', 500);

            // thanh toán / ghi chú
            $t->enum('payment_method', ['COD'])->default('COD');
            $t->text('note')->nullable();

            // tổng tiền
            $t->unsignedBigInteger('subtotal')->default(0);
            $t->unsignedBigInteger('shipping')->default(0);
            $t->unsignedBigInteger('discount')->default(0);
            $t->unsignedBigInteger('total')->default(0);

            $t->enum('status', ['Pending', 'Processing', 'Completed', 'Cancelled'])->default('Pending');

            $t->timestamps();

            $t->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
