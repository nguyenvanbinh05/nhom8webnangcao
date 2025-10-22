<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\AdditationImage;
use Database\Seeders\Support\SeedImage;

class AdditationImageSeeder extends Seeder
{
    public function run(): void
    {
        // Mảng các ảnh mẫu
        $pool = ['banhmi.svg', 'san_pham.jpg', 'capheden.svg', 'sinhto.svg'];
        // Hàm chọn ảnh ngẫu nhiên
        $pick = fn() => $pool[array_rand($pool)];

        // Lấy tất cả sản phẩm
        $products = Product::get(['idProduct']);

        // Duyệt từng sản phẩm
        foreach ($products as $p) {
            // Mỗi sản phẩm sẽ có 1–2 ảnh bổ sung
            $count = rand(1, 1); // Số lượng ảnh bổ sung ngẫu nhiên

            // Lặp qua số ảnh cần tạo cho mỗi sản phẩm
            for ($i = 0; $i < $count; $i++) {
                AdditationImage::firstOrCreate(
                    [
                        'ProductId'      => $p->idProduct, // Liên kết ảnh với sản phẩm
                        'AdditationLink' => SeedImage::put($pick()), // Lấy ảnh ngẫu nhiên từ mảng và xử lý lưu trữ
                    ],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
