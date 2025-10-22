<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSize;

class ProductSizeSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy tất cả sản phẩm cần size: hoặc theo category, hoặc theo Price=null
        $products = Product::whereNull('Price') // coi như có size
            ->get(['idProduct', 'NameProduct']);

        foreach ($products as $p) {
            // Không tạo trùng
            $ensure = function (string $size, int $price) use ($p) {
                ProductSize::firstOrCreate(
                    ['ProductId' => $p->idProduct, 'Size' => $size],
                    ['Price' => $price, 'created_at' => now(), 'updated_at' => now()]
                );
            };
            // Giá ví dụ (tuỳ chỉnh)
            $ensure('S', 25000);
            $ensure('M', 30000);
            $ensure('L', 35000);
        }
    }
}
