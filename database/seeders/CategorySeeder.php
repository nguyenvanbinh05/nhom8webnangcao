<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'NameCategory' => 'Cà phê',
                'Description'  => 'Một loại đồ uống.',
                'Status'       => 'Available'
            ],
            [
                'NameCategory' => 'Trà sữa',
                'Description'  => 'Các loại trà sữa trân châu.',
                'Status'       => 'Available'
            ],
            [
                'NameCategory' => 'Bánh',
                'Description'  => 'Các loại bánh ngọt ăn kèm.',
                'Status'       => 'Available'
            ],
            [
                'NameCategory' => 'Sinh tố',
                'Description'  => 'Sinh tố trái cây tươi.',
                'Status'       => 'Available'
            ],
            [
                'NameCategory' => 'Nước ép',
                'Description'  => 'Nước ép trái cây nguyên chất.',
                'Status'       => 'Stopped'
            ],
        ];

        foreach ($categories as $categorydata) {
            Category::create($categorydata);
        }
    }
}
