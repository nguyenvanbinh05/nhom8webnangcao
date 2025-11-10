<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $suppliers = Supplier::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->get();

        return view('admin.supplierViews.supplierManagement', compact('suppliers', 'search'));
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
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20|unique:suppliers,phone',
            'email'   => 'nullable|email|unique:suppliers,email',
            'address' => 'nullable|string|max:255',
            'note'    => 'nullable|string|max:500',
        ], [
            'phone.unique' => 'Số điện thoại này đã tồn tại.',
            'email.unique' => 'Email này đã tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'create'); // đánh dấu form create lỗi
        }

        Supplier::create($request->all());

        return redirect()->route('supplier.index')->with('success', 'Thêm nhà cung cấp thành công!');
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
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect()->route('supplier.index')
                ->with('error', 'Nhà cung cấp không tồn tại!');
        }

        $validator = Validator::make($request->all(), [
            'supplierName' => 'required|string|max:255',
            'phone'        => 'nullable|string|max:20|unique:suppliers,phone,' . $supplier->id,
            'email'        => 'nullable|email|max:255|unique:suppliers,email,' . $supplier->id,
            'address'      => 'nullable|string|max:255',
            'note'         => 'nullable|string|max:500',
        ], [
            'phone.unique' => 'Số điện thoại này đã tồn tại.',
            'email.unique' => 'Email này đã tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'edit')
                ->with('route', route('supplier.update', $supplier->id));
        }

        $supplier->name    = $request->supplierName;
        $supplier->phone   = $request->phone;
        $supplier->email   = $request->email;
        $supplier->address = $request->address;
        $supplier->note    = $request->note;

        $supplier->save();

        return redirect()->route('supplier.index')
            ->with('success', 'Cập nhật nhà cung cấp thành công!');
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
