<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Coffee Shop')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f4f0;
            padding-top: 76px;
        }
        
        .navbar-custom {
            background: #1a0f0a;
        }
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.7);
            transition: color 0.3s;
        }
        .navbar-custom .nav-link:hover {
            color: #d4a24e;
        }
        .navbar-custom .brand {
            color: #d4a24e;
            font-weight: 800;
            font-size: 1.5rem;
        }
        .navbar-custom .brand span {
            color: white;
        }
        
        .text-gold {
            color: #d4a24e;
        }
        .bg-gold {
            background: #d4a24e;
        }
        .btn-gold {
            background: #d4a24e;
            color: white;
            border: none;
        }
        .btn-gold:hover {
            background: #b8860b;
            color: white;
        }
        .btn-outline-gold {
            border: 2px solid #d4a24e;
            color: #d4a24e;
        }
        .btn-outline-gold:hover {
            background: #d4a24e;
            color: white;
        }
        
        .hover-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.04);
        }
        .hover-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }
        
        .min-vh-75 {
            min-height: 75vh;
        }
        
        .coffee-display {
            font-size: 200px;
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        
        .hero-section {
            background: linear-gradient(135deg, #f8f4f0 0%, #e8ddd6 100%);
        }
        
        @media (max-width: 768px) {
            body { padding-top: 66px; }
            .coffee-display { font-size: 120px; }
            .display-1 { font-size: 3rem; }
            .display-4 { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand brand" href="{{ route('home') }}">
                ☕ Coffee<span>Shop</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    
                    @if(Auth::check())
                        @if(Auth::user()->role === 'user')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.menus.index') }}">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.cart.index') }}">🛒 Cart</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.orders.index') }}">📋 Orders</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.profile.edit') }}">👤 Profile</a>
                            </li>
                        @endif
                        
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
                            </li>
                        @endif
                        
                        @if(Auth::user()->role === 'manager')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('manager.dashboard') }}">📦 Kelola</a>
                            </li>
                        @endif
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                👋 {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" style="background: rgba(26,15,10,0.95); border: 1px solid rgba(255,255,255,0.05);">
                                @if(Auth::user()->role === 'user')
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.profile.edit') }}">
                                            <i class="bi bi-person"></i> Profile
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-gold" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-gold" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Daftar
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===== MAIN CONTENT ===== -->
    <main>
        @yield('content')
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="bg-dark text-white-50 py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-white fw-bold">☕ Coffee<span class="text-gold">Shop</span></h5>
                    <p class="small opacity-75">Experience the art of specialty coffee.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="small opacity-50 mb-0">
                        &copy; {{ date('Y') }} Coffee Shop. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @stack('scripts')
</body>
</html>