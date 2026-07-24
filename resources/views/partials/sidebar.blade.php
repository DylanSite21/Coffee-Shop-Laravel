@php
    $role = auth()->user()->role ?? null;
@endphp

<div class="sidebar col-md-3 col-lg-2 p-3" style="min-height: calc(100vh - 56px);">
    <ul class="nav flex-column">
        @if($role === 'admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tags"></i> Kategori
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}" href="{{ route('admin.menus.index') }}">
                    <i class="bi bi-cup-hot"></i> Menu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.approvals.*') ? 'active' : '' }}" href="{{ route('admin.approvals.index') }}">
                    <i class="bi bi-check-circle"></i> Approvals
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                    <i class="bi bi-bar-chart"></i> Reports
                </a>
            </li>
        @elseif($role === 'manager')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}" href="{{ route('manager.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('manager.menus.*') ? 'active' : '' }}" href="{{ route('manager.menus.index') }}">
                    <i class="bi bi-cup-hot"></i> Pengajuan Menu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('manager.orders.*') ? 'active' : '' }}" href="{{ route('manager.orders.index') }}">
                    <i class="bi bi-receipt"></i> Pesanan
                </a>
            </li>
        @elseif($role === 'user')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                    <i class="bi bi-house"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.menus.*') ? 'active' : '' }}" href="{{ route('user.menus.index') }}">
                    <i class="bi bi-cup-hot"></i> Menu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.cart.*') ? 'active' : '' }}" href="{{ route('user.cart.index') }}">
                    <i class="bi bi-cart"></i> Cart
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.orders.*') ? 'active' : '' }}" href="{{ route('user.orders.index') }}">
                    <i class="bi bi-receipt"></i> Pesanan
                </a>
            </li>
        @endif
    </ul>
</div>
