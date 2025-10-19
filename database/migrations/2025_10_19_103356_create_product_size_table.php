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
        Schema::create('Product_Size', function (Blueprint $table) {
            $table->id('idProductSize');
            $table->enum('Size', ['S','M','L']);
            $table->decimal('Price', 10, 2);
            $table->unsignedBigInteger('ProductId');
            $table->foreign('ProductId')->references('idProduct')->on('Product')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Product_Size');
    }
};
