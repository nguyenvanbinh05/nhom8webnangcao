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
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query
        $products = Product::query();
        if ($search) {
            $products->where('NameProduct', 'like', "%{$search}%")
                ->orWhere('Description', 'like', "%{$search}%");

            $products = $products->get();
            return view('admin.productViews.productManagement', compact('products', 'search'));
        }

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

        return redirect()->route('adminProduct.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'sizes', 'additationImages'])
            ->findOrFail($id);

        return view('admin.productViews.productShowInfo', compact('product'));
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
        // 1. Lấy sản phẩm theo id
        $product = Product::with('sizes', 'additationImages')->findOrFail($id);

        // 2. Validate dữ liệu đầu vào
        $request->validate([
            'NameProduct' => 'required|string|max:255',
            'CategoryId' => 'required|exists:category,idCategory',
            'Price' => 'nullable|numeric|min:0',
            'Description' => 'required|string',
            'Status' => 'required|in:Available,Stopped',
            'MainImage' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'additationImages.*' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'productType' => 'required|in:single,multiple',
            'sizes.*.Size' => 'required_if:productType,multiple',
            'sizes.*.Price' => 'required_if:productType,multiple|numeric|min:0'
        ]);

        // 3. Cập nhật thông tin cơ bản
        $product->NameProduct = $request->NameProduct;
        $product->CategoryId = $request->CategoryId;
        $product->Description = $request->Description;
        $product->Status = $request->Status;

        // 4. Xử lý ảnh chính
        if ($request->hasFile('MainImage')) {
            // Xóa ảnh cũ nếu cần
            if ($product->MainImage && file_exists(storage_path('app/public/' . $product->MainImage))) {
                unlink(storage_path('app/public/' . $product->MainImage));
            }

            // Lưu ảnh mới
            if ($request->hasFile('MainImage')) {
                $image = $request->file('MainImage');
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '_' . Str::random(20) . '.' . $extension;
                $path_image = $image->storeAs('images', $imageName);
            }
            $product->MainImage = $path_image;
        }

        // 5. Xử lý giá bán
        if ($request->productType === 'single') {
            $product->Price = $request->Price;
            // Xóa các size cũ nếu có
            $product->sizes()->delete();
        } elseif ($request->productType === 'multiple') {
            $product->Price = null;
            // Xóa size cũ trước khi thêm mới
            $product->sizes()->delete();

            if ($request->has('sizes')) {
                foreach ($request->sizes as $size) {
                    ProductSize::create([
                        'Size' => $size['Size'],
                        'Price' => $size['Price'],
                        'ProductId' => $product->idProduct,
                    ]);
                }
            }
        }

        // 6. Xử lý ảnh phụ
        if ($request->hasFile('additationImages')) {
            if ($product->additationImages) {
                foreach ($product->additationImages as $oldImage) {
                    if (Storage::exists($oldImage->AdditationLink)) {
                        Storage::delete($oldImage->AdditationLink);
                    }
                    $oldImage->delete();
                }
            }
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

        // 7. Lưu sản phẩm
        $product->save();

        return redirect()->route('adminProduct.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
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

        return redirect()->route('adminProduct.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
