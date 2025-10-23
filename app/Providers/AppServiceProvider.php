<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('customer.partials.header', function ($view) {
            $count = 0;

            // Lấy giỏ theo user hoặc theo cookie cart_token
            $cart = null;
            if (Auth::check()) {
                $cart = Cart::with('items')->firstWhere('user_id', Auth::id());
            } else {
                $token = request()->cookie('cart_token'); // tên cookie bạn đang dùng trong resolveCart()
                if ($token) {
                    $cart = Cart::with('items')->firstWhere('cart_token', $token);
                }
            }

            if ($cart) {
                $count = $cart->items->sum('quantity');
            }

            $view->with('cartCount', $count);
        });
        VerifyEmail::toMailUsing(function ($notifiable, string $url) {
            return (new MailMessage)
                ->subject('Xác minh địa chỉ email')
                ->greeting('Xin chào ' . ($notifiable->name ?? 'bạn') . ' 👋')
                ->line('Cảm ơn bạn đã đăng ký Coffee Shop.')
                ->line('Nhấn nút bên dưới để xác minh địa chỉ email của bạn.')
                ->action('Xác minh email', $url)
                ->line('Nếu bạn không tạo tài khoản, vui lòng bỏ qua email này.');
        });
    }
}
