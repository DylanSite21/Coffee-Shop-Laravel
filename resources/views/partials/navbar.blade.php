<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ url('/') }}">
            <span class="brand-icon">☕</span>
            Kopi Nusantara
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#menu-section') }}">
                            <i class="bi bi-cup-hot me-1"></i>Menu
                        </a>
                    </li>
                @endguest

                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'manager')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}" href="{{ route('manager.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                                <i class="bi bi-house-door me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.menus.*') ? 'active' : '' }}" href="{{ route('user.menus.index') }}">
                                <i class="bi bi-cup-hot me-1"></i>Menu
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav align-items-center gap-1">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item ms-1">
                        <a class="btn btn-gold btn-sm px-3" href="{{ route('register') }}">Daftar</a>
                    </li>
                @else
                    @if(auth()->user()->role === 'user')
                        <li class="nav-item me-1">
                            <a href="{{ route('user.cart.index') }}" class="nav-link position-relative" title="Keranjang">
                                <i class="bi bi-bag2 fs-5"></i>
                                @php
                                    $cartCount = auth()->user()->carts()->withCount('cartItems')->first()?->cart_items_count ?? 0;
                                @endphp
                                @if($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#C08B5C,#D4A855);display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;color:#3E1F0D;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <div class="px-3 py-2 border-bottom" style="border-color:#DEC9AA!important;">
                                    <div style="font-weight:600;font-size:0.875rem;color:#3E1F0D;">{{ auth()->user()->name }}</div>
                                    <div style="font-size:0.75rem;color:#6B4C3B;">{{ ucfirst(auth()->user()->role) }}</div>
                                </div>
                            </li>
                            @if(auth()->user()->role === 'user')
                                <li><a class="dropdown-item" href="{{ route('user.orders.index') }}"><i class="bi bi-receipt me-2"></i>Pesanan Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                                <li><hr class="dropdown-divider" style="border-color:#DEC9AA;"></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
