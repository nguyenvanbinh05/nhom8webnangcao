<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdditationImage;

class AdditationImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            ['AdditationLink' => 'images/products/san_pham.jpg', 'ProductId' => 1],
            ['AdditationLink' => 'images/products/san_pham.jpg', 'ProductId' => 1],
            ['AdditationLink' => 'images/products/san_pham.jpg', 'ProductId' => 2],
            ['AdditationLink' => 'images/products/san_pham.jpg', 'ProductId' => 4],
            ['AdditationLink' => 'images/products/san_pham.jpg', 'ProductId' => 3],
            ['AdditationLink' => 'images/products/san_pham.jpg', 'ProductId' => 5],
        ];

        foreach ($images as $img) {
            AdditationImage::create($img);
        }
    }
}
