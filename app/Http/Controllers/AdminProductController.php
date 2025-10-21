<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\AdditationImage;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy tất cả sản phẩm kèm category, size và ảnh bổ sung
        $products = Product::with(['category', 'sizes', 'additationImages'])->get();

        return view('admin.productViews.productManagement', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View('admin.productViews.productAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $selectedSizes = [];

        // Kiểm tra xem có mảng 'sizes' được gửi lên không
        if ($request->has('sizes')) {
            foreach ($request->input('sizes') as $item) {
                if (isset($item['Size']) && isset($item['Price']) && $item['Price'] !== '' && $item['Price'] !== null) {
                    $selectedSizes[] = [
                        'Size'  => $item['Size'],
                        'Price' => $item['Price'],
                    ];
                }
            }
        }

        $request->merge(['sizes' => $selectedSizes]);

        $request->validate([
            'NameProduct' => 'required|string|max:100',
            'MainImage' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'Description' => 'nullable|string',
            'CategoryId' => 'required|exists:category,idCategory',
            'Price' => 'required_without:sizes|nullable|numeric',
            'sizes' => 'required_without:Price|nullable|array',
            'sizes.*.Size' => 'required_with:sizes|in:S,M,L',
            'sizes.*.Price' => 'required_with:sizes|numeric',
            'additationImages' => 'nullable|array',
            'additationImages.*' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'Status' => 'required|in:Available,Stopped',
        ]);

        if ($request->hasFile('MainImage')) {
            $image = $request->file('MainImage');
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_' . Str::random(20) . '.' . $extension;
            $path_image = $image->storeAs('images', $imageName);
        }

        // Tạo sản phẩm
        $product = Product::create([
            'NameProduct' => $request->NameProduct,
            'MainImage' => $path_image,
            'Description' => $request->Description,
            'CategoryId' => $request->CategoryId,
            'Price' => $request->Price ?? null, // Nếu có size thì để null
            'Status' => $request->Status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Nếu có size, lưu vào bảng product_sizes
        if ($request->has('sizes')) {
            foreach ($request->sizes as $size) {
                ProductSize::create([
                    'Size' => $size['Size'],
                    'Price' => $size['Price'],
                    'ProductId' => $product->idProduct,
                ]);
            }
        }

        // Nếu có ảnh bổ sung
        if ($request->hasFile('additationImages')) {
            foreach ($request->file('additationImages') as $image) {
                $additation_img_extension = $image->getClientOriginalExtension();
                $additation_img_name = time() . '_' . Str::random(20) . '.' . $additation_img_extension;
                $path = $image->storeAs('images', $additation_img_name);
                AdditationImage::create([
                    'AdditationLink' => $path,
                    'ProductId' => $product->idProduct,
                ]);
            }
        }

        return redirect()->route('product.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with(['category', 'sizes', 'additationImages'])->findOrFail($id);
        $categories = Category::all();
        return view('admin.productViews.productEdit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = Product::findOrFail($id);

        $mainImagePath = str_replace('storage/', '', $product->MainImage);
        $additionalImagePaths = $product->additationImages()->pluck('AdditationLink')->map(function ($path) {
            return str_replace('storage/', '', $path);
        })->all();


        if (!empty($mainImagePath)) {
            Storage::disk('public')->delete($mainImagePath);
        }

        if (!empty($additionalImagePaths)) {
            Storage::disk('public')->delete($additionalImagePaths);
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
