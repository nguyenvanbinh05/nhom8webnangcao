<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Cà phê',
            'Trà sữa',
            'Bánh',
            'Sinh tố',
            'Nước ép',
        ];

        foreach ($categories as $name) {
            Category::create(['NameCategory' => $name]);
        }
    }
}
