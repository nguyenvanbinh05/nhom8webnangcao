<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderManagementContronller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.orderViews.orderManagement', compact('orders'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Lấy order và các sản phẩm kèm thông tin sản phẩm
        $order = Order::with('items.product')->findOrFail($id);

        return view('admin.orderViews.orderdetailShow', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        //
    }

    public function confirm(Request $request, Order $order)
    {
        // Chỉ cập nhật nếu đang ở trạng thái pending
        if ($order->status === 'Pending') {
            $order->status = 'Processing'; // chuyển sang processing
            $order->save();
            return redirect()->route('orderManagement.index')->with('success', 'Đơn hàng đã được xác nhận!');
        }

        if ($order->status === 'Processing') {
            $order->status = 'Completed'; // chuyển sang processing
            $order->save();
            return redirect()->route('orderManagement.index')->with('success', 'Cập nhật trạng thái thành công');
        }

        // Nếu đã xác nhận rồi, có thể cho phép thay đổi trạng thái khác
        return redirect()->route('orderManagement.index')->with('info', 'Đơn hàng đã được xác nhận trước đó. Bạn có thể cập nhật trạng thái khác.');
    }
}
