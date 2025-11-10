<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        // === 1️⃣ Xác định khoảng ngày filter ===

        $start = $request->query('start')
            ? Carbon::parse($request->query('start'))->startOfDay() // 00:00:00
            : Carbon::now()->startOfMonth()->startOfDay();

        $end = $request->query('end')
            ? Carbon::parse($request->query('end'))->endOfDay() // 23:59:59
            : Carbon::now()->endOfMonth()->endOfDay();

        // === 2️⃣ Lấy doanh thu theo ngày trong khoảng từ $start → $end ===
        $revenueData = DB::table('orders')
            ->select(
                DB::raw('DATE(created_at) as label'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->where('status', 'Completed')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'), 'ASC')
            ->get();

        $dates = $revenueData->pluck('label');
        $totals = $revenueData->pluck('total_revenue');

        // === 3️⃣ Top 5 sản phẩm bán chạy ===
        $topProducts = DB::table('order_items')
            ->join('product', 'order_items.product_id', '=', 'product.idProduct')
            ->select(
                'product.NameProduct as product_name',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.idOrder')
            ->where('orders.status', 'Completed')
            ->groupBy('product.idProduct', 'product.NameProduct')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $productNames = $topProducts->pluck('product_name');
        $productSales = $topProducts->pluck('total_sold');

        // === 4️⃣ Top 5 đơn hàng mới nhất ===
        $latestOrders = Order::with('user')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // === 5️⃣ Truyền dữ liệu qua view ===
        return view('admin.reportView', compact(
            'dates',
            'totals',
            'productNames',
            'productSales',
            'latestOrders',
            'start',
            'end'
        ));
    }
}
