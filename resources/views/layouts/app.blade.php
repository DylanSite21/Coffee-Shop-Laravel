<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coffee Shop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manager.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @include('partials.styles')
    @stack('styles')
</head>
<body class="@yield('body-class', 'bg-customer')">
    @hasSection('auth')
        @yield('auth')
    @else
        @include('partials.navbar')

        <div class="container-fluid">
            <div class="row">
                @auth
                    @include('partials.sidebar')
                @endauth

                <main class="@auth col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 @else col-12 py-4 @endauth">
                    @if(auth()->check())
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2 text-brown">@yield('title')</h1>
                        </div>
                    @endif

                    @include('partials.alert')

                    @yield('content')
                </main>
            </div>
        </div>

        @auth
            @include('partials.footer')
        @endauth
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/manager.js') }}"></script>
    <script src="{{ asset('js/user.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    @stack('scripts')
</body>
</html>
