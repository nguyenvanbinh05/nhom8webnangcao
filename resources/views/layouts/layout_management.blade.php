<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <title>@yield('titlepage')</title>
</head>

<body>
    <div class="layout">
        <!-- Sidebar -->
        @include('common.sidebar')
        <div class="container_mainContent">
            <!-- Header -->
            @include('common.header')

            <main class="content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>