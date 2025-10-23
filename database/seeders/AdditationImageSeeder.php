<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\AdditationImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdditationImageSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->makeDirectory('products');

        $pool = ['banhmi.svg', 'san_pham.jpg', 'capheden.svg', 'sinhto.svg'];
        $pick = fn() => $pool[array_rand($pool)];

        foreach (Product::all() as $product) {
            for ($i = 0; $i < 2; $i++) {
                $path = self::copySeedImage($pick(), $product->NameProduct ?? $product->name ?? 'product');

                AdditationImage::create([
                    'ProductId' => $product->idProduct ?? $product->id,
                    'AdditationLink'       => $path,
                ]);
            }
        }
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
        $file  = "{$base}_{$hint}_extra_{$rnd}.{$ext}";
        $dest  = 'products/' . $file;

        File::copy($src, Storage::disk('public')->path($dest));

        return $dest;
    }
}
