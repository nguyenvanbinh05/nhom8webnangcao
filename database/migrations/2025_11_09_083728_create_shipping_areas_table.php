<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_areas', function (Blueprint $table) {
            $table->id();
            $table->string('province_id')->index(); // ID tỉnh từ API
            $table->string('province_name');
            $table->string('district_id')->nullable()->index(); // NULL = toàn tỉnh
            $table->string('district_name')->nullable();
            $table->string('ward_id')->nullable()->index(); // NULL = toàn huyện
            $table->string('ward_name')->nullable();
            $table->integer('shipping_cost'); // phí ship (0 = không hỗ trợ)
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Đảm bảo không trùng lặp
            $table->unique(['province_id', 'district_id', 'ward_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_areas');
    }
};
