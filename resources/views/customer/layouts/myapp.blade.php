<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/svg" href="{{ asset('images/logo/logo-web.svg') }}">
    @stack('styles')

    <title>@yield('title', 'Coffee Shop')</title>
</head>

<body>
    @include('customer.partials.header')
    <div class="container">
        @yield('content')
    </div>
    @include('customer.partials.footer')
    @include('customer.partials.cart-toast')

    <script src="{{ asset('js/home.js') }}"></script>
    <script>
        window.CART_ADD_URL = "{{ route('cart.add') }}";
        window.ASSET_BASE = "{{ asset('') }}";
    </script>
    <script src="{{ asset('js/cart-ajax.js') }}"></script>
    @stack('scripts')
</body>


</html>