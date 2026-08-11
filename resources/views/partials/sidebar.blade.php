@php
    $role = auth()->user()->role ?? null;
@endphp

<div class="sidebar col-md-3 col-lg-2">
    {{-- Sidebar Brand --}}
    <div class="sidebar-brand">
        <span>☕</span>
        <span>Kopi Nusantara</span>
    </div>

    <ul class="nav flex-column">
        @if ($role === 'admin')
            <li><span class="sidebar-section-label">Manajemen</span></li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                    href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tags"></i> Kategori
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}"
                    href="{{ route('admin.menus.index') }}">
                    <i class="bi bi-cup-hot"></i> Menu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> Pengguna
                </a>
            </li>

            <li><span class="sidebar-section-label">Operasional</span></li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.approvals.*') ? 'active' : '' }}"
                    href="{{ route('admin.approvals.index') }}">
                    <i class="bi bi-patch-check"></i> Persetujuan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                    href="{{ route('admin.reports.index') }}">
                    <i class="bi bi-bar-chart-line"></i> Laporan
                </a>
            </li>
        @elseif($role === 'manager')
            <li><span class="sidebar-section-label">Menu</span></li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}"
                    href="{{ route('manager.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('manager.menus.*') ? 'active' : '' }}"
                    href="{{ route('manager.menus.index') }}">
                    <i class="bi bi-cup-hot"></i> Pengajuan Menu
                </a>
            </li>

            <li><span class="sidebar-section-label">Pesanan</span></li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('manager.orders.*') ? 'active' : '' }}"
                    href="{{ route('manager.orders.index') }}">
                    <i class="bi bi-receipt"></i> Kelola Pesanan
                </a>
            </li>
        @elseif($role === 'user')
            <li><span class="sidebar-section-label">Utama</span></li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"
                    href="{{ route('user.dashboard') }}">
                    <i class="bi bi-house-door"></i> Beranda
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.menus.*') ? 'active' : '' }}"
                    href="{{ route('user.menus.index') }}">
                    <i class="bi bi-cup-hot"></i> Menu
                </a>
            </li>

            <li><span class="sidebar-section-label">Transaksi</span></li>
            <li class="nav-item position-relative">
                @php
                    $activeCart = auth()->user()->carts()->where('status', 'active')->with('cartItems')->first();
                    $cartCount = $activeCart ? $activeCart->cartItems->sum('quantity') : 0;
                @endphp
                <a class="nav-link {{ request()->routeIs('user.cart.*') ? 'active' : '' }}"
                    href="{{ route('user.cart.index') }}">
                    <i class="bi bi-cart3 fs-5"></i> Keranjang
                </a>
                @if ($cartCount > 0)
                    <span class="cart-badge" style="position: absolute; right: -5px; top: -5px;">
                        {{ $cartCount > 99 ? '99+' : $cartCount }}
                    </span>
                @endif
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.orders.*') ? 'active' : '' }}"
                    href="{{ route('user.orders.index') }}">
                    <i class="bi bi-receipt"></i> Pesanan Saya
                </a>
            </li>

            <li><span class="sidebar-section-label">Akun</span></li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}"
                    href="{{ route('user.profile') }}">
                    <i class="bi bi-person-circle"></i> Profil
                </a>
            </li>
        @endif
    </ul>
</div>
