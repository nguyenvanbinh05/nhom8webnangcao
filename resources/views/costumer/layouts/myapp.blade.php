<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/svg" href="{{ asset('images/logo/logo-web.svg') }}">
    @stack('styles')

    <title>@yield('title', 'Coffee Shop')</title>
</head>

<body>
    @include('costumer.partials.header')
    <div class="container">
        @yield('content')
    </div>
    @include('costumer.partials.footer')
    <script src="{{ asset('js/home.js') }}"></script>

</body>


</html>