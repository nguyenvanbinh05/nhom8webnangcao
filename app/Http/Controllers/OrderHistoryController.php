<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->withCount('items')
            ->orderByDesc('idOrder')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items')
            ->where('idOrder', $id)
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }
}
