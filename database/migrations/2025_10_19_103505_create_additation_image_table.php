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
        Schema::create('Additation_Image', function (Blueprint $table) {
            $table->id('idAdditationImage');
            $table->string('AdditationLink', 255);
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
        Schema::dropIfExists('Additation_Image');
    }
};
