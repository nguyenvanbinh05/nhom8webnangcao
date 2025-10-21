<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Sản phẩm có size -> Price = null
            [
                'NameProduct' => 'Cà phê sữa đá',
                'MainImage' => 'images/products/san_pham.jpg',
                'Description' => 'Cà phê phin truyền thống, kết hợp sữa đặc thơm béo.',
                'CategoryId' => 1,
                'Price' => null,
                'Status' => 'Available',
            ],
            [
                'NameProduct' => 'Trà sữa trân châu đường đen',
                'MainImage' => 'images/products/san_pham.jpg',
                'Description' => 'Trà sữa béo ngậy, trân châu dai ngọt.',
                'CategoryId' => 2,
                'Price' => null,
                'Status' => 'Available',
            ],
            [
                'NameProduct' => 'Sinh tố bơ',
                'MainImage' => 'images/products/san_pham.jpg',
                'Description' => 'Sinh tố làm từ bơ tươi, ngọt mát và bổ dưỡng.',
                'CategoryId' => 4,
                'Price' => null,
                'Status' => 'Available',
            ],
            // Sản phẩm không size -> Price cố định
            [
                'NameProduct' => 'Bánh Tiramisu',
                'MainImage' => 'images/products/san_pham.jpg',
                'Description' => 'Bánh ngọt Ý, lớp kem béo nhẹ và cacao đậm vị.',
                'CategoryId' => 3,
                'Price' => 50000,
                'Status' => 'Available',
            ],
            [
                'NameProduct' => 'Nước ép cam',
                'MainImage' => 'images/products/san_pham.jpg',
                'Description' => 'Nước ép cam tươi nguyên chất, nhiều vitamin C.',
                'CategoryId' => 5,
                'Price' => 30000,
                'Status' => 'Available',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
