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


        $thumbs = collect()
            ->when($product->MainImage, fn($c) => $c->push($product->MainImage))
            ->merge($product->additationImages->pluck('AdditationLink'))
            ->values();


        $sizesSorted  = $product->sizes->sortBy('Price')->values();
        $defaultSize  = $sizesSorted->first();
        $hasLabeled   = $product->sizes->whereNotNull('Size')->isNotEmpty();
        $currentPrice = $defaultSize?->Price
            ?? $product->Price
            ?? null;


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
