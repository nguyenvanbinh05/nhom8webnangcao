<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cookie;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }
    protected function mergeGuestCart(Request $request, $user): void
    {
        $token = $request->cookie('cart_token');
        if (!$token) return;

        $guest = Cart::with('items')->where('cart_token', $token)->first();
        if (!$guest || $guest->items->isEmpty()) {
            Cookie::queue(Cookie::forget('cart_token'));
            return;
        }

        // lấy/ tạo giỏ của user
        $userCart = Cart::with('items')->firstOrCreate(['user_id' => $user->id]);

        DB::transaction(function () use ($guest, $userCart) {
            $toId = $userCart->getKey(); // idCart
            foreach ($guest->items as $g) {
                $target = $userCart->items()
                    ->where('product_id', $g->product_id)
                    ->where('size', $g->size)
                    ->first();

                if ($target) {
                    $target->increment('quantity', $g->quantity);
                    $g->delete();
                } else {
                    $g->cart_id = $toId; // CHỦ MỚI = carts.idCart
                    $g->save();
                }
            }
            $guest->refresh();
            if ($guest->items()->count() === 0) {
                $guest->delete();
            }
        });

        Cookie::queue(Cookie::forget('cart_token'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();


        if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            return redirect()
                ->route('verification.notice')
                ->with('status', 'verification-link-sent');
        }


        $this->mergeGuestCart($request, $user);


        return redirect()->intended(match ($user->role) {
            'admin', 'staff' => '/admin',
            default          => '/',
        });
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
