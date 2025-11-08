<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderManagementContronller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');
        $status = $request->input('status');

        // Tạo query cơ bản, kèm quan hệ user
        $query = Order::with('user');

        // Nếu có từ khóa tìm kiếm
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Nếu có chọn trạng thái đơn hàng
        if ($status) {
            $query->where('status', $status);
        }

        // Lấy danh sách đơn hàng (sắp xếp theo ngày mới nhất)
        $orders = $query->orderBy('created_at', 'desc')->get();

        // Trả về view
        return view('admin.orderViews.orderManagement', compact('orders', 'search', 'status'));
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
    }

    public function cancel(Request $request, $idOrder)
{
    $order = Order::findOrFail($idOrder);
    $order->status = 'Cancelled';
    $order->cancel_reason = $request->input('cancel_reason');
    $order->save();

    return redirect()->back()->with('success', 'Đơn hàng đã được hủy!');
}
}
