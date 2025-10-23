{{-- resources/views/customer/account/password.blade.php --}}
@extends('customer.account.layout')

@section('account')
    <section class="change-password">
        <header class="title-page">
            <h2 class="title">
                {{ __('Đổi Mật Khẩu') }}
            </h2>
            <p class="title-desc">
                {{ __('Hãy đảm bảo tài khoản của bạn dùng một mật khẩu dài và ngẫu nhiên để đảm bảo an toàn.') }}
            </p>
        </header>

        <form method="POST" action="{{ route('account.password.update') }}" class="input-fields">
            @csrf
            @method('put')

            <div>
                <x-input-label for="update_password_current_password" :value="__('Mật khẩu hiện tại')" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="input"
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('current_password')" class="error" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('Mật khẩu mới')" />
                <x-text-input id="update_password_password" name="password" type="password" class="input"
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="error" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Xác nhận mật khẩu')" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="input" autocomplete="new-password" />
            </div>

            <div class="btn-change">
                <x-primary-button class="btn">{{ __('Lưu') }}</x-primary-button>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="status">{{ __('Đã lưu.') }}</p>
                @endif
            </div>
        </form>
    </section>
@endsection