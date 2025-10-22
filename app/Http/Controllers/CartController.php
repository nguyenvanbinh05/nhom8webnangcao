<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected function resolveCart(Request $request): Cart
    {
        if (Auth::check()) {
            // giỏ theo user
            $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

            // nếu còn cookie giỏ của khách -> gộp
            if ($token = $request->cookie('cart_token')) {
                $guest = Cart::with('items')->where('cart_token', $token)->first();
                if ($guest) {
                    $this->mergeCarts($guest, $cart);
                }
            }

            return $cart->load('items.product');
        }

        // khách: dùng cookie cart_token
        $token = $request->cookie('cart_token');
        if (!$token) {
            $token = (string) Str::uuid();
            Cookie::queue('cart_token', $token, 60 * 24 * 30); // 30 ngày
        }

        $cart = Cart::firstOrCreate(['cart_token' => $token], ['user_id' => null]);
        return $cart->load('items.product');
    }
    protected function mergeCarts(Cart $from, Cart $to): void
    {
        DB::transaction(function () use ($from, $to) {
            $toId = $to->getKey(); // idCart
            foreach ($from->items as $g) {
                $target = $to->items()
                    ->where('product_id', $g->product_id)
                    ->where('size', $g->size)
                    ->first();

                if ($target) {
                    $target->increment('quantity', $g->quantity);
                    $g->delete();
                } else {
                    $g->cart_id = $toId;
                    $g->save();
                }
            }
            $from->refresh();
            if ($from->items()->count() === 0) {
                $from->delete();
            }
        });

        Cookie::queue(Cookie::forget('cart_token'));
    }

    public function index(Request $request)
    {
        $cart  = $this->resolveCart($request);
        $items = $cart->items; // đã load product

        return view('customer.cart', [
            'items' => $items,
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'size'       => 'nullable|string|in:S,M,L',
            'quantity'   => 'nullable|integer|min:1',
        ]);
        $qty = $data['quantity'] ?? 1;

        $product = Product::with(['sizes:idProductSize,Size,Price,ProductId'])
            ->where('idProduct', $data['product_id'])
            ->where('Status', '!=', 'Stopped')
            ->firstOrFail();

        $hasLabeled = $product->sizes->whereNotNull('Size')->isNotEmpty();
        $size       = $data['size'] ?? null;

        // Nếu có size bắt buộc mà client không gửi → yêu cầu sang chi tiết
        if ($hasLabeled && !$size) {
            $detail = route('product.show', $product->idProduct);
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['ok' => false, 'redirect' => $detail, 'message' => 'Sản phẩm cần chọn size.'], 409);
            }
            return redirect()->to($detail);
        }

        // CHỌN GIÁ
        $priceRow = null;
        if ($size) {
            $priceRow = $product->sizes->firstWhere('Size', $size);
        } else {
            $priceRow = $product->sizes->firstWhere('Size', null)
                ?? $product->sizes->sortBy('Price')->first();
        }
        if (!$priceRow && !is_null($product->Price)) {
            $priceRow = (object)['Size' => null, 'Price' => $product->Price];
        }
        if (!$priceRow) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['ok' => false, 'message' => 'Sản phẩm này chưa có giá.'], 422);
            }
            return back()->with('cart_toast', [
                'type'    => 'error',
                'title'   => 'Không thể thêm vào giỏ',
                'message' => 'Sản phẩm này chưa có giá.',
            ]);
        }

        // LƯU
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
                'size'       => $priceRow->Size,                 // có thể null
                'price'      => (int) round($priceRow->Price),
                'quantity'   => $qty,
            ]);
        }

        // Tính lại tổng
        $items     = $cart->items()->get();
        $cartTotal = $items->sum(fn($i) => $i->price * $i->quantity);
        $cartCount = $items->sum('quantity');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'ok' => true,
                'product' => [
                    'name'  => $product->NameProduct,
                    'size'  => $priceRow->Size,
                    'image' => $product->MainImage ? asset('storage/' . $product->MainImage) : null,
                ],
                'cart_total' => $cartTotal,
                'cart_count' => $cartCount,
            ]);
        }

        return back()->with('cart_toast', [
            'type'       => 'success',
            'title'      => 'Thêm vào giỏ hàng thành công',
            'product'    => [
                'name'  => $product->NameProduct,
                'size'  => $priceRow->Size,
                'image' => $product->MainImage ? 'storage/' . $product->MainImage : null,
            ],
            'cart_total' => $cartTotal,
            'cart_count' => $cartCount,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'idCartItem' => 'required|integer',
            'action'     => 'required|in:increase,decrease',
        ]);

        $cart = $this->resolveCart($request);
        $item = $cart->items()->where('idCartItem', $data['idCartItem'])->firstOrFail();

        if ($data['action'] === 'increase') {
            $item->increment('quantity');
        } else {
            if ($item->quantity > 1) $item->decrement('quantity');
        }

        $cart->refresh();
        $items     = $cart->items()->get();
        $cartTotal = $items->sum(fn($i) => $i->price * $i->quantity);
        $cartCount = $items->sum('quantity');

        return response()->json([
            'ok'        => true,
            'quantity'  => $item->fresh()->quantity,
            'cartTotal' => $cartTotal,
            'cartCount' => $cartCount,
        ]);
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'idCartItem' => 'required|integer',
        ]);

        $cart = $this->resolveCart($request);
        $item = $cart->items()->where('idCartItem', $data['idCartItem'])->firstOrFail();
        $item->delete();

        $cart->refresh();
        $items     = $cart->items()->get();
        $cartTotal = $items->sum(fn($i) => $i->price * $i->quantity);
        $cartCount = $items->sum('quantity');

        return response()->json([
            'ok'        => true,
            'cartTotal' => $cartTotal,
            'cartCount' => $cartCount,
            'empty'     => $items->isEmpty(),
        ]);
    }
}
