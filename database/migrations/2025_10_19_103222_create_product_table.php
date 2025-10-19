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
        Schema::create('Product', function (Blueprint $table) {
            $table->id('idProduct'); 
            $table->string('NameProduct', 100);
            $table->string('MainImage', 255);
            $table->text('Description')->nullable();
            $table->decimal('Price', 10, 2)->nullable();
            $table->unsignedBigInteger('CategoryId');
            $table->foreign('CategoryId')->references('idCategory')->on('Category')->onDelete('restrict');
            $table->enum('Status', ['Available', 'Stopped'])->default('Available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Product');
    }
};
