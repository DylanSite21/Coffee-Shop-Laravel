<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Kopi Nusantara — Kedai kopi premium Indonesia dengan biji pilihan petani lokal, diracik oleh barista profesional.">
    <title>@yield('title', 'Kopi Nusantara — Kedai Kopi Premium Indonesia')</title>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- App CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.styles')
    @stack('styles')

</head>

<body class="@yield('body-class', 'bg-customer')">
    @hasSection('auth')
        @yield('auth')
    @else
        @include('partials.navbar')

        <div class="container-fluid px-3 px-lg-4">
            <div class="row">
                @auth
                    @include('partials.sidebar')
                @endauth

                <main class="@auth col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 @else col-12 py-4 @endauth">
                    @if (auth()->check())
                        <div
                            class="page-header d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                            <h1>@yield('title')</h1>
                        </div>
                    @endif

                    @include('partials.alert')

                    @yield('content')
                </main>
            </div>
        </div>

        @include('partials.footer')
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/manager.js') }}"></script>
    <script src="{{ asset('js/user.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    @stack('scripts')
</body>

</html>
