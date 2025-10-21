<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(int $idProduct)
    {
        $product = Product::with([
            'category:idCategory,NameCategory',
            'sizes:idProductSize,Size,Price,ProductId',
            'additationImages:idAdditationImage,AdditationLink,ProductId',
        ])->where('idProduct', $idProduct)->firstOrFail();

        // Ảnh: ảnh chính + ảnh phụ (theo đúng thứ tự bạn muốn)
        $thumbs = collect()
            ->when($product->MainImage, fn($c) => $c->push($product->MainImage))
            ->merge($product->additationImages->pluck('AdditationLink'))
            ->values();

        // Size: mặc định = giá nhỏ nhất
        $sizesSorted  = $product->sizes->sortBy('Price')->values();
        $defaultSize  = $sizesSorted->first();               // có thể là size NULL nếu bạn seed kiểu không-size
        $hasLabeled   = $product->sizes->whereNotNull('Size')->isNotEmpty(); // chỉ hiện khu chọn size khi có S/M/L
        $currentPrice = $defaultSize?->Price;

        // Sản phẩm liên quan (tuỳ chọn)
        $related = Product::with('sizes:idProductSize,Size,Price,ProductId')
            ->where('CategoryId', $product->CategoryId)
            ->where('idProduct', '!=', $product->idProduct)
            ->where('Status', '!=', 'Stopped')
            ->orderBy('NameProduct')
            ->take(5)
            ->get();

        return view('customer.product-detail', compact(
            'product',
            'thumbs',
            'sizesSorted',
            'hasLabeled',
            'currentPrice',
            'related'
        ));
    }
}
