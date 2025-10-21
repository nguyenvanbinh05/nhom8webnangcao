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
        Schema::create('Category', function (Blueprint $table) {
            $table->id('idCategory');
            $table->string('NameCategory');
            $table->text('Description')->nullable();
            $table->enum('Status', ['Available', 'Stopped'])->default('Available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Category');
    }
};
