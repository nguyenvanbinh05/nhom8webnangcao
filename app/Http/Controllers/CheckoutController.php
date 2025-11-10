<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ShippingArea;

class CheckoutController extends Controller
{
    protected function resolveCart(Request $request): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    /**
     * Tính phí ship dựa trên khu vực địa chỉ
     * Trả về -1 nếu khu vực không hỗ trợ
     * 
     * Logic:
     * - Nếu tổng >= 99k: miễn phí
     * - Nếu tổng < 99k: dùng phí của khu vực (hoặc 20k nếu phí = 0)
     */
    protected function calculateShipping($subtotal, $provinceId = null, $districtId = null, $wardId = null): int
    {
        // Nếu không có thông tin địa chỉ, trả về 0 (chưa chọn)
        if (!$provinceId) {
            return 0;
        }

        // Kiểm tra khu vực có được hỗ trợ không
        $shippingCost = ShippingArea::getShippingCost($provinceId, $districtId, $wardId);

        // Nếu khu vực không được hỗ trợ
        if ($shippingCost === null) {
            return -1;
        }

        // Nếu tổng >= 99k: miễn phí
        if ($subtotal >= 99000) {
            return 0;
        }

        // Nếu tổng < 99k: dùng phí khu vực
        if ($shippingCost > 0) {
            return (int)$shippingCost;
        }

        // Nếu phí khu vực = 0: dùng phí mặc định 20k
        return 20000;
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
        $shipping = $this->calculateShipping($subtotal);
        $discount = 0;
        $total    = $subtotal + $shipping - $discount;

        return view('customer.checkout', compact('items', 'subtotal', 'shipping', 'discount', 'total'));
    }

    /**
     * API: Tính toán phí ship real-time
     */
    public function calculateShippingCost(Request $request)
    {
        $validated = $request->validate([
            'subtotal' => 'required|integer|min:0',
            'province_id' => 'required|string',
            'district_id' => 'nullable|string',
            'ward_id' => 'nullable|string',
        ]);

        $shippingCost = $this->calculateShipping(
            $validated['subtotal'],
            $validated['province_id'],
            $validated['district_id'],
            $validated['ward_id']
        );

        // Nếu khu vực không hỗ trợ
        if ($shippingCost === -1) {
            return response()->json([
                'supported' => false,
                'message' => 'Khu vực này hiện không được hỗ trợ giao hàng',
                'shipping_cost' => 0,
            ]);
        }

        $total = $validated['subtotal'] + $shippingCost;

        return response()->json([
            'supported' => true,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'message' => $shippingCost === 0 ? 'Miễn phí giao hàng' : 'Phí giao hàng: ' . number_format($shippingCost, 0, ',', '.') . 'đ',
        ]);
    }

    public function place(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:120',
            'phone'           => ['required', 'regex:/^0(3[2-9]|5[2689]|7[06-9]|8[1-689]|9[0-46-9])\d{7}$/'],

            'city_id'         => 'required|string',
            'city_name'       => 'required|string|max:120',
            'district_id'     => 'required|string',
            'district_name'   => 'required|string|max:120',
            'ward_id'         => 'required|string',
            'ward_name'       => 'required|string|max:120',

            'address_detail'  => 'required|string|max:255',
            'full_address'    => 'required|string|max:500',

            'email'           => 'nullable|email|max:120',
            'note'            => 'nullable|string|max:500',
            'payment'         => 'required|in:COD',
        ], [], [
            'city_id'        => 'Tỉnh/Thành phố',
            'district_id'    => 'Quận/Huyện',
            'ward_id'        => 'Phường/Xã',
            'address_detail' => 'Địa chỉ chi tiết',
            'full_address'   => 'Địa chỉ',
            'phone'          => 'Số điện thoại',
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

        // Tính phí ship dựa trên địa chỉ chọn
        $shipping = $this->calculateShipping(
            $subtotal,
            $data['city_id'],
            $data['district_id'],
            $data['ward_id']
        );

        // Kiểm tra khu vực có được hỗ trợ không
        if ($shipping === -1) {
            return back()->withErrors([
                'address' => 'Khu vực bạn chọn (' . $data['city_name'] . ') hiện không được hỗ trợ giao hàng. Vui lòng liên hệ shop để biết thêm chi tiết.'
            ])->withInput();
        }

        $discount = 0;
        $total    = $subtotal + $shipping - $discount;

        $order = DB::transaction(function () use ($items, $data, $subtotal, $shipping, $discount, $total) {
            $order = Order::create([
                'user_id'        => Auth::id(),
                'code'           => 'OD' . now()->format('ymdHis') . Str::upper(Str::random(4)),

                'full_name'      => $data['name'],
                'phone'          => $data['phone'],
                'email'          => $data['email'] ?? null,
                'address'        => $data['full_address'],

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

            Cart::firstOrCreate(['user_id' => Auth::id()])->items()->delete();

            return $order;
        });

        return redirect()
            ->route('account.orders.show', $order->idOrder)
            ->with('alert', 'Đặt hàng thành công! Mã đơn #WEB-' . ($order->code ?? $order->idOrder));
    }
}
