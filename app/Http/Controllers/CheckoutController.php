<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\Cart;
use App\Models\Order;

class CheckoutController extends Controller
{
    protected function resolveCart(Request $request): Cart
    {
        // Bạn đã có giỏ (guest/user). Ở đây vì bắt buộc đăng nhập, dùng giỏ theo user_id:
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function show(Request $request)
    {
        $cart  = $this->resolveCart($request)->load([
            'items.product' => fn($q) => $q->select('idProduct', 'NameProduct', 'MainImage', 'Status')
        ]);
        $items = $cart->items->filter(fn($i) => $i->product && $i->product->Status !== 'Stopped');

        if ($items->isEmpty()) {
            return redirect()->route('menu.index')->with('cart_toast', [
                'type' => 'error',
                'title' => 'Giỏ hàng trống',
                'message' => 'Vui lòng chọn sản phẩm trước khi thanh toán.'
            ]);
        }

        $subtotal = $items->sum(fn($i) => $i->price * $i->quantity);
        $shipping = 0;
        $discount = 0;
        $total    = $subtotal + $shipping - $discount;

        return view('customer.checkout', compact('items', 'subtotal', 'shipping', 'discount', 'total'));
    }

    public function place(Request $request)
    {
        // validate bắt buộc chọn Tỉnh/Quận/Phường & địa chỉ chi tiết và ghép address (client JS sẽ gộp vào full_address)
        $data = $request->validate([
            'name'            => 'required|string|max:120',
            'phone'           => 'required|string|max:20',
            'email'           => 'nullable|email|max:120',

            'city_id'         => 'required|string',
            'city_name'       => 'required|string|max:120',
            'district_id'     => 'required|string',
            'district_name'   => 'required|string|max:120',
            'ward_id'         => 'required|string',
            'ward_name'       => 'required|string|max:120',

            'address_detail'  => 'required|string|max:255',
            'full_address'    => 'required|string|max:500',

            'note'            => 'nullable|string|max:500',
            'payment'         => 'required|in:COD',
        ], [], [
            'city_id'       => 'Tỉnh/Thành phố',
            'district_id'   => 'Quận/Huyện',
            'ward_id'       => 'Phường/Xã',
            'address_detail' => 'Địa chỉ chi tiết',
            'full_address'  => 'Địa chỉ',
        ]);

        $cart  = $this->resolveCart($request)->load('items.product');
        $items = $cart->items;
        if ($items->isEmpty()) {
            return back()->with('cart_toast', [
                'type' => 'error',
                'title' => 'Giỏ hàng trống',
                'message' => 'Vui lòng thêm sản phẩm trước khi đặt.'
            ]);
        }

        $subtotal = $items->sum(fn($i) => $i->price * $i->quantity);
        $shipping = 0;
        $discount = 0;
        $total = $subtotal + $shipping - $discount;

        DB::transaction(function () use ($items, $data, $subtotal, $shipping, $discount, $total) {
            $order = Order::create([
                'user_id'        => Auth::id(),
                'code'           => 'OD' . now()->format('ymdHis') . Str::upper(Str::random(4)),

                'full_name'      => $data['name'],
                'phone'          => $data['phone'],
                'email'          => $data['email'] ?? null,
                'address'        => $data['full_address'], // "Số nhà, Phường, Quận, Tỉnh"

                'payment_method' => $data['payment'], // COD
                'note'           => $data['note'] ?? null,

                'subtotal'       => $subtotal,
                'shipping'       => $shipping,
                'discount'       => $discount,
                'total'          => $total,
                'status'         => 'Pending',
            ]);

            foreach ($items as $ci) {
                $p = $ci->product;
                $order->items()->create([
                    'product_id'    => $ci->product_id,
                    'product_name'  => $p?->NameProduct ?? ('Sản phẩm #' . $ci->product_id),
                    'product_image' => $p?->MainImage,
                    'size'          => $ci->size,
                    'unit_price'    => $ci->price,
                    'quantity'      => $ci->quantity,
                    'line_total'    => $ci->price * $ci->quantity,
                ]);
            }

            // clear cart
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
            $cart->items()->delete();
        });

        return redirect()->route('orders.index')->with('cart_toast', [
            'type' => 'success',
            'title' => 'Đặt hàng thành công',
            'message' => 'Bạn có thể xem chi tiết trong lịch sử đơn hàng.'
        ]);
    }
}
