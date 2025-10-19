<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // $user = Auth::user();
        // if ($user->role === 'admin') {
        //     return redirect('/admin');
        // } elseif ($user->role === 'staff') {
        //     return redirect('/admin');
        // } else {
        //     return redirect('/');
        // }
        $user = $request->user();
        if (! $user->hasVerifiedEmail()) {
            // (Tuỳ chọn) gửi lại email xác minh mỗi lần user cố đăng nhập
            $user->sendEmailVerificationNotification();

            return redirect()
                ->route('verification.notice')
                ->with('status', 'Tài khoản của bạn chưa được xác minh. Chúng tôi vừa gửi lại email xác minh — vui lòng kiểm tra hộp thư và nhấp vào liên kết.');
        }

        // Redirect theo vai trò của bạn
        $user = $request->user();
        return redirect()->intended(match ($user->role) {
            'admin' => '/admin',
            'staff' => '/admin',
            default => '/',
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
