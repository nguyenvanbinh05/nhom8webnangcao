<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(int $idProduct)
    {
        $product = Product::with([
            'category:idCategory,NameCategory',
            'sizes:idProductSize,Size,Price,ProductId',
            'additationImages:idAdditationImage,AdditationLink,ProductId',
        ])
            ->where('idProduct', $idProduct)
            ->firstOrFail();

        // size nhỏ nhất (hoặc null nếu không có size)
        $minSize = $product->sizes->sortBy('Price')->first();

        // gợi ý sản phẩm cùng danh mục (trừ chính nó)
        $related = Product::with('sizes:idProductSize,Size,Price,ProductId')
            ->where('CategoryId', $product->CategoryId)
            ->where('idProduct', '!=', $product->idProduct)
            ->orderBy('NameProduct')
            ->take(8)
            ->get();

        return view('costumer.product-detail', compact('product', 'minSize', 'related'));
    }
}
