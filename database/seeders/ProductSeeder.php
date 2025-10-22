<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Database\Seeders\Support\SeedImage;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Đảm bảo thư mục images tồn tại trên disk public
        Storage::disk('public')->makeDirectory('images');

        // Tạo categories (nếu chưa có)
        $catCoffee   = Category::firstOrCreate(['NameCategory' => 'Cà phê']);
        $catSmoothie = Category::firstOrCreate(['NameCategory' => 'Sinh tố']);
        $catCake     = Category::firstOrCreate(['NameCategory' => 'Bánh']);

        $pool = ['banhmi.svg', 'san_pham.jpg', 'capheden.svg', 'sinhto.svg'];

        // Helper chọn ảnh bất kỳ
        $pick = fn() => $pool[array_rand($pool)];

        // ===== Cà phê (có size) =====
        $coffeeNames = ['Cà phê đen', 'Cà phê sữa', 'Bạc xỉu', 'Cold brew', 'Americano', 'Latte', 'Cappuccino'];
        foreach ($coffeeNames as $name) {
            Product::firstOrCreate(
                ['NameProduct' => $name],
                [
                    'MainImage'  => SeedImage::put($pick()),
                    'Description' => 'Mô tả ' . $name,
                    'CategoryId' => $catCoffee->idCategory,
                    'Price'      => null,              // CÓ size => để null
                    'Status'     => 'Available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // ===== Sinh tố (không size) =====
        $smoothies = [
            ['Sinh tố Matcha', 50000],
            ['Sinh tố Xoài',   45000],
            ['Sinh tố Dâu',    45000],
            ['Sinh tố Bơ',     55000],
        ];
        foreach ($smoothies as [$name, $price]) {
            Product::firstOrCreate(
                ['NameProduct' => $name],
                [
                    'MainImage'  => SeedImage::put($pick()),
                    'Description' => 'Mô tả ' . $name,
                    'CategoryId' => $catSmoothie->idCategory,
                    'Price'      => $price,            // KHÔNG size => đặt giá ở cột Product.Price
                    'Status'     => 'Available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // ===== Bánh (không size) =====
        $cakes = [
            ['Bánh mì',     30000],
            ['Tiramisu',    45000],
            ['Bánh phô mai', 49000],
        ];
        foreach ($cakes as [$name, $price]) {
            Product::firstOrCreate(
                ['NameProduct' => $name],
                [
                    'MainImage'  => SeedImage::put($pick()),
                    'Description' => 'Mô tả ' . $name,
                    'CategoryId' => $catCake->idCategory,
                    'Price'      => $price,
                    'Status'     => 'Available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
