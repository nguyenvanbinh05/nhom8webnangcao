<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // /menu: tất cả + tìm kiếm
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));

        $categories = Category::orderBy('NameCategory')
            ->get(['idCategory', 'NameCategory']);

        $products = Product::with([
            'category:idCategory,NameCategory',
            'sizes:idProductSize,Size,Price,ProductId',
            'additationImages:idAdditationImage,AdditationLink,ProductId',
        ])
            ->where('Status', '!=', 'Stopped')
            ->when($search, fn($q) => $q->where('NameProduct', 'like', "%{$search}%"))
            ->orderBy('NameProduct')
            ->get();

        // Nhóm theo tên danh mục khi ở "Tất cả"
        $grouped = $products->groupBy(fn($p) => optional($p->category)->NameCategory ?? 'Khác');

        return view('costumer.menu', [
            'categories' => $categories,
            'grouped'    => $grouped,
            'paginator'  => null,
            'activeId'   => null,
            'search'     => $search,
        ]);
    }

    // /menu/category/{id}: chỉ hiển thị 1 danh mục
    public function byCategory(Request $request, int $idCategory)
    {
        $search = trim((string) $request->query('q'));

        $categories = Category::orderBy('NameCategory')
            ->get(['idCategory', 'NameCategory']);
        $active = $categories->firstWhere('idCategory', $idCategory);

        $products = Product::with([
            'category:idCategory,NameCategory',
            'sizes:idProductSize,Size,Price,ProductId',
            'additationImages:idAdditationImage,AdditationLink,ProductId',
        ])
            ->where('CategoryId', $idCategory)
            ->where('Status', '!=', 'Stopped')
            ->when($search, fn($q) => $q->where('NameProduct', 'like', "%{$search}%"))
            ->orderBy('NameProduct')
            ->get();

        $groupName = $active?->NameCategory ?? 'Danh mục';
        $grouped   = collect([$groupName => $products]);

        return view('costumer.menu', [
            'categories' => $categories,
            'grouped'    => $grouped,
            'paginator'  => null,
            'activeId'   => $idCategory,
            'search'     => $search,
        ]);
    }
}
