<?php

namespace Database\Seeders\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SeedImage
{
    public static function put(string $filename): string
    {
        // 1) Ưu tiên lấy ở database/seeders/seed_images/<file>
        $seedDir = database_path('seeders/seed_images/' . $filename);
        // 2) Nếu không có thì lấy ở public/images/products/<file>
        $publicDir = public_path('images/products/' . $filename);

        $source = File::exists($seedDir) ? $seedDir : $publicDir;

        if (!File::exists($source)) {
            throw new \RuntimeException("Không tìm thấy file ảnh seed: {$filename}");
        }

        // Đảm bảo thư mục đích tồn tại
        Storage::disk('public')->makeDirectory('images');

        // Tên file ổn định theo hash nội dung
        $ext   = pathinfo($filename, PATHINFO_EXTENSION);
        $base  = pathinfo($filename, PATHINFO_FILENAME);
        $target = 'images/' . Str::slug($base) . '-' . substr(md5_file($source), 8, 8) . '.' . $ext;

        if (!Storage::disk('public')->exists($target)) {
            Storage::disk('public')->put($target, File::get($source)); // copy sang storage
        }

        // LƯU VÀO DB: 'images/xxx.ext' (sau hiển thị = asset('storage/'.$path))
        return $target;
    }
}
