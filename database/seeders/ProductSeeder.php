<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {

        Storage::disk('public')->makeDirectory('products');


        $catCoffee   = Category::firstOrCreate(['NameCategory' => 'Cà phê']);
        $catSmoothie = Category::firstOrCreate(['NameCategory' => 'Sinh tố']);
        $catCake     = Category::firstOrCreate(['NameCategory' => 'Bánh']);


        $pool = ['banhmi.svg', 'san_pham.jpg', 'capheden.svg', 'sinhto.svg'];
        $pick = fn() => $pool[array_rand($pool)];


        $coffeeNames = ['Cà phê đen', 'Cà phê sữa', 'Bạc xỉu', 'Cold brew', 'Americano', 'Latte', 'Cappuccino'];
        $coffeeName  = $coffeeNames[array_rand($coffeeNames)];

        Product::firstOrCreate(
            ['NameProduct' => $coffeeName],
            [
                'MainImage'   => self::copySeedImage($pick(), $coffeeName),
                'Description' => 'Mô tả ' . $coffeeName,
                'CategoryId'  => $catCoffee->idCategory,
                'Price'       => null,
                'Status'      => 'Available',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );

        $smoothies = [
            ['Sinh tố Matcha', 50000],
            ['Sinh tố Xoài',   45000],
            ['Sinh tố Dâu',    45000],
            ['Sinh tố Bơ',     55000],
        ];
        [$smoothieName, $smoothiePrice] = $smoothies[array_rand($smoothies)];

        Product::firstOrCreate(
            ['NameProduct' => $smoothieName],
            [
                'MainImage'   => self::copySeedImage($pick(), $smoothieName),
                'Description' => 'Mô tả ' . $smoothieName,
                'CategoryId'  => $catSmoothie->idCategory,
                'Price'       => $smoothiePrice,
                'Status'      => 'Available',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );

        $cakes = [
            ['Bánh mì',      30000],
            ['Tiramisu',     45000],
            ['Bánh phô mai', 49000],
        ];
        [$cakeName, $cakePrice] = $cakes[array_rand($cakes)];

        Product::firstOrCreate(
            ['NameProduct' => $cakeName],
            [
                'MainImage'   => self::copySeedImage($pick(), $cakeName),
                'Description' => 'Mô tả ' . $cakeName,
                'CategoryId'  => $catCake->idCategory,
                'Price'       => $cakePrice,
                'Status'      => 'Available',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]
        );
    }
    private static function copySeedImage(string $sourceFilename, ?string $nameHint = null): string
    {
        $src = public_path('images/products/' . $sourceFilename);
        if (! File::exists($src)) {
            throw new \RuntimeException("Seed image not found: {$src}");
        }

        $ext   = pathinfo($sourceFilename, PATHINFO_EXTENSION);
        $base  = pathinfo($sourceFilename, PATHINFO_FILENAME);
        $hint  = $nameHint ? Str::slug($nameHint, '_') : $base;
        $rnd   = Str::lower(Str::random(8));
        $file  = "{$base}_{$hint}_{$rnd}.{$ext}";
        $dest  = 'products/' . $file;

        File::copy($src, Storage::disk('public')->path($dest));

        return $dest;
    }
}
