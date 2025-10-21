<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categoryViews.categoryManagement', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categoryViews.categoryAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nameCategory' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'status'       => 'required|in:Available,Stopped',
        ]);

        Category::create([
            'NameCategory' => $request->nameCategory,
            'description'  => $request->description,
            'Status'       => $request->status,
        ]);

        return redirect()->route('category.index')->with('success', 'Thêm danh mục thành công!');
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
        $category = Category::findOrFail($id);
        return view('admin.categoryViews.categoryEdit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nameCategory' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'status'       => 'required|in:Available,Stopped',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'NameCategory' => $request->nameCategory,
            'description'  => $request->description,
            'Status'       => $request->status,
        ]);

        return redirect()->route('category.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            return redirect()->route('category.index')
                ->with('error', 'Không thể xóa danh mục này vì còn sản phẩm liên quan!');
        }

        $category->delete();

        return redirect()->route('category.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}
