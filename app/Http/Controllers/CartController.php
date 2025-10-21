<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    protected function resolveCart(Request $request): Cart
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        // Khách (guest) dùng cart_token
        $token = $request->cookie('cart_token') ?? Str::uuid()->toString();
        $cart  = Cart::firstOrCreate(['cart_token' => $token]);

        if (!$request->cookie('cart_token')) {
            Cookie::queue(cookie('cart_token', $token, 60 * 24 * 30)); // 30 ngày
        }

        return $cart;
    }

    public function index(Request $request)
    {
        $cart  = $this->resolveCart($request);
        $items = $cart->items()->with('product')->get();
        $total = $items->sum(fn($it) => $it->price * $it->quantity);

        return view('customer.cart', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'size'       => 'nullable|string|in:S,M,L',
            'quantity'   => 'nullable|integer|min:1'
        ]);
        $qty = $data['quantity'] ?? 1;

        // Lấy sp + size/price
        $product = Product::with(['sizes' => function ($q) {
            $q->select('idProductSize', 'Size', 'Price', 'ProductId');
        }])
            ->where('idProduct', $data['product_id'])
            ->where('Status', '!=', 'Stopped')
            ->firstOrFail();

        $size = $data['size'] ?? null;
        $priceRow = $size
            ? $product->sizes->firstWhere('Size', $size)
            : ($product->sizes->whereNotNull('Size')->sortBy('Price')->first()
                ?? $product->sizes->firstWhere('Size', null));

        abort_if(!$priceRow, 422, 'Không tìm thấy giá cho sản phẩm');

        $cart = $this->resolveCart($request);

        $item = $cart->items()
            ->where('product_id', $product->idProduct)
            ->where('size', $priceRow->Size)
            ->first();

        if ($item) {
            $item->increment('quantity', $qty);
        } else {
            $cart->items()->create([
                'product_id' => $product->idProduct,
                'size'       => $priceRow->Size, // có thể null
                'price'      => (int)$priceRow->Price,
                'quantity'   => $qty,
            ]);
        }

        return back()->with('ok', 'Đã thêm vào giỏ');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'idCartItem' => 'required|integer',
            'action'     => 'required|in:increase,decrease,set',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $cart = $this->resolveCart($request);
        $item = $cart->items()->with('product')->where('idCartItem', $data['idCartItem'])->firstOrFail();

        if ($data['action'] === 'increase') {
            $item->increment('quantity');
        } elseif ($data['action'] === 'decrease') {
            if ($item->quantity > 1) $item->decrement('quantity');
        } else { // set
            $item->update(['quantity' => $data['quantity'] ?? $item->quantity]);
        }

        $item->refresh();
        $cartItems = $cart->items()->get();
        $cartTotal = $cartItems->sum(fn($i) => $i->price * $i->quantity);
        $cartCount = $cartItems->sum('quantity');

        return response()->json([
            'ok'          => true,
            'idCartItem'  => $item->idCartItem,
            'quantity'    => $item->quantity,
            'itemSubtotal' => $item->price * $item->quantity,
            'cartTotal'   => $cartTotal,
            'cartCount'   => $cartCount,
        ]);
    }

    public function remove(Request $request)
    {
        $data = $request->validate(['idCartItem' => 'required|integer']);
        $cart = $this->resolveCart($request);
        $cart->items()->where('idCartItem', $data['idCartItem'])->delete();

        $cartItems = $cart->items()->get();
        $cartTotal = $cartItems->sum(fn($i) => $i->price * $i->quantity);
        $cartCount = $cartItems->sum('quantity');

        return response()->json([
            'ok'        => true,
            'cartTotal' => $cartTotal,
            'cartCount' => $cartCount,
            'empty'     => $cartItems->isEmpty(),
        ]);
    }
}
