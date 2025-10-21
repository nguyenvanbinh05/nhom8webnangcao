<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Supplier;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = Ingredient::with('supplier')->get();
        return view('admin.ingredientViews.ingredientManagement', compact('ingredients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lấy danh sách nhà cung cấp để dropdown
        $suppliers = Supplier::all();

        return view('admin.ingredientAdd', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu nhập
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'unit' => 'nullable|string|max:50',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'import_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
        ]);

        // Tạo nguyên liệu mới
        Ingredient::create($request->all());

        return redirect()->route('ingredients.index')->with('success', 'Nguyên liệu đã được thêm thành công!');
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
        // Lấy nguyên liệu theo id
        $ingredient = Ingredient::findOrFail($id);

        // Lấy tất cả nhà cung cấp để dropdown
        $suppliers = Supplier::all();

        // Trả về view edit và truyền dữ liệu
        return view('admin.ingredientEdit', compact('ingredient', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate dữ liệu
        $request->validate([
            'name'         => 'required|string|max:255',
            'quantity'     => 'required|integer',
            'unit'         => 'nullable|string|max:50',
            'supplier_id'  => 'nullable|exists:suppliers,id',
            'import_date'  => 'nullable|date',
            'expiry_date'  => 'nullable|date',
        ]);

        // Lấy bản ghi cần cập nhật
        $ingredient = Ingredient::findOrFail($id);

        // Gán giá trị mới
        $ingredient->name         = $request->name;
        $ingredient->quantity     = $request->quantity;
        $ingredient->unit         = $request->unit;
        $ingredient->supplier_id  = $request->supplier_id;
        $ingredient->import_date  = $request->import_date;
        $ingredient->expiry_date  = $request->expiry_date;

        // Lưu lại
        $ingredient->save();

        // Quay lại trang danh sách kèm thông báo
        return redirect()->route('ingredients.index')->with('success', 'Cập nhật nguyên liệu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Ingredient::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa nhà cung cấp!');
    }
}
