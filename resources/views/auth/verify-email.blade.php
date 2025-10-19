{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the
        link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
    </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout> --}}

<x-guest-layout>
    @php
        $email = auth()->user()->email ?? null;
    @endphp

    {{-- Thông báo chung nếu có (vd: "Chúng tôi đã gửi liên kết xác minh...") --}}
    @if (session('status') && session('status') !== 'verification-link-sent')
        <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700 border border-green-200">
            {{ session('status') }}
        </div>
    @endif

    {{-- Thông báo mặc định của Laravel khi vừa gửi lại mail xác minh --}}
    @if (session('status') === 'verification-link-sent')
        <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700 border border-green-200">
            {{ __('Một liên kết xác minh mới đã được gửi tới địa chỉ email bạn đăng ký.') }}
        </div>
    @endif

    <div class="mb-4 text-sm text-gray-600">
        <p class="mb-1">
            {{ __('Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, vui lòng xác minh địa chỉ email của bạn bằng cách nhấp vào liên kết chúng tôi vừa gửi.') }}
        </p>
        @if ($email)
            <p class="mb-1">
                {{ __('Chúng tôi gửi email tới:') }} <span class="font-medium text-gray-800">{{ $email }}</span>
            </p>
        @endif
        <p class="mt-2">
            {{ __('Nếu bạn không nhận được email, bạn có thể yêu cầu gửi lại.') }}
        </p>
    </div>

    <div class="mt-4 flex items-center justify-between">
        {{-- Gửi lại email xác minh --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                {{ __('Gửi lại email xác minh') }}
            </x-primary-button>
        </form>

        {{-- Đăng xuất --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Đăng xuất') }}
            </button>
        </form>
    </div>

    {{-- Gợi ý nhỏ --}}
    <div class="mt-6 text-xs text-gray-500">
        {{ __('Mẹo: Kiểm tra thư mục Spam/Quảng cáo. Nếu nhập sai email, hãy đăng xuất và đăng ký lại với địa chỉ đúng.') }}
    </div>
</x-guest-layout>