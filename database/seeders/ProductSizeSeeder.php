<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductSize;

class ProductSizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            // Cà phê sữa đá (idProduct = 1)
            ['Size' => 'S', 'Price' => 25000, 'ProductId' => 1],
            ['Size' => 'M', 'Price' => 30000, 'ProductId' => 1],
            ['Size' => 'L', 'Price' => 35000, 'ProductId' => 1],

            // Trà sữa trân châu (idProduct = 2)
            ['Size' => 'M', 'Price' => 35000, 'ProductId' => 2],
            ['Size' => 'L', 'Price' => 40000, 'ProductId' => 2],

            // Sinh tố bơ (idProduct = 3)
            ['Size' => 'M', 'Price' => 40000, 'ProductId' => 3],
            ['Size' => 'L', 'Price' => 45000, 'ProductId' => 3],

            ['Price' => 45000, 'ProductId' => 4]
        ];

        foreach ($sizes as $size) {
            ProductSize::create($size);
        }
    }
}
