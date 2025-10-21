<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.supplierViews.supplierManagement', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        Supplier::create($request->all());
        return redirect()->back()->with('success', 'Thêm nhà cung cấp thành công!');
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
        // Lấy dữ liệu nhà cung cấp cần sửa
        $supplier = Supplier::findOrFail($id);
        // Trả về view kèm dữ liệu
        return view('admin.supplierEdit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplierName' => 'required|string|max:255',
            'phone'        => 'nullable|string|max:20',
            'email'        => 'nullable|email|max:255',
            'address'      => 'nullable|string|max:255',
            'note'         => 'nullable|string|max:500',
        ]);

        // Lấy bản ghi cần cập nhật
        $supplier = Supplier::findOrFail($id);

        // Gán giá trị mới
        $supplier->name    = $request->supplierName;
        $supplier->phone   = $request->phone;
        $supplier->email   = $request->email;
        $supplier->address = $request->address;
        $supplier->note    = $request->note;

        // Lưu lại
        $supplier->save();

        // Quay lại trang danh sách kèm thông báo
        return redirect()->route('supplier.index')->with('success', 'Cập nhật nhà cung cấp thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Supplier::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa nhà cung cấp!');
    }
}
