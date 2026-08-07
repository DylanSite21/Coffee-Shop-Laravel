@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="dashboard-page fade-in-up">

    {{-- Welcome Banner --}}
    <div class="welcome-banner mb-4">
        <div class="welcome-label">Selamat datang kembali</div>
        <h1 class="welcome-title">Halo, {{ auth()->user()->name }}!</h1>
        <p class="welcome-subtitle">
            Apa yang ingin Anda nikmati hari ini? Kami siap menyajikan yang terbaik untuk Anda.
        </p>
        <a href="{{ route('user.menus.index') }}" class="welcome-btn">
            <i class="bi bi-cup-hot"></i>
            Pesan Sekarang
        </a>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-4">
            <div class="dash-stat-card fade-in-up">
                <div class="dash-stat-icon orders">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <div class="dash-stat-label">Total Pesanan</div>
                <div class="dash-stat-value">{{ number_format($totalOrders) }}</div>
                <div class="dash-stat-sub">Semua waktu</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="dash-stat-card fade-in-up delay-1">
                <div class="dash-stat-icon cart">
                    <i class="bi bi-bag2"></i>
                </div>
                <div class="dash-stat-label">Keranjang</div>
                <div class="dash-stat-value">{{ $cartCount }}</div>
                <div class="dash-stat-sub">Item menunggu</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="dash-stat-card fade-in-up delay-2">
                <div class="dash-stat-icon member">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="dash-stat-label">Status Akun</div>
                <div class="dash-stat-value" style="font-size: 1.35rem;">Member</div>
                <div class="dash-stat-sub">Pelanggan aktif</div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="card mb-4 fade-in-up delay-1" style="border:none;box-shadow:none;background:transparent;">
        <div class="card-body p-0">
            <div class="quick-actions-grid">
                <a href="{{ route('user.menus.index') }}" class="quick-action-card">
                    <div class="quick-action-icon">
                        <i class="bi bi-cup-hot"></i>
                    </div>
                    <span class="quick-action-label">Lihat Menu</span>
                </a>
                <a href="{{ route('user.cart.index') }}" class="quick-action-card">
                    <div class="quick-action-icon">
                        <i class="bi bi-bag2"></i>
                    </div>
                    <span class="quick-action-label">Keranjang</span>
                    @if($cartCount > 0)
                        <span class="quick-action-badge">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ route('user.orders.index') }}" class="quick-action-card">
                    <div class="quick-action-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <span class="quick-action-label">Pesanan Saya</span>
                </a>
                <a href="{{ route('user.profile') }}" class="quick-action-card">
                    <div class="quick-action-icon">
                        <i class="bi bi-person"></i>
                    </div>
                    <span class="quick-action-label">Profil</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="recent-orders-card fade-in-up delay-2">
        <div class="recent-orders-header">
            <div class="recent-orders-header-title">
                <i class="bi bi-clock-history"></i>
                Pesanan Terbaru
            </div>
            <a href="{{ route('user.orders.index') }}" class="btn btn-outline-coffee btn-sm">
                Semua Pesanan
            </a>
        </div>
        <div class="card-body p-0">
            @forelse($recentOrders as $order)
                <a href="{{ route('user.orders.show', $order) }}" class="order-item">
                    <div class="order-info">
                        <div class="order-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div>
                            <div class="order-id">{{ $order->order_number }}</div>
                            <div class="order-date">
                                <i class="bi bi-calendar3 me-1"></i>{{ $order->created_at->format('d M Y, H:i') }} WIB
                            </div>
                        </div>
                    </div>
                    <div class="order-status status-{{ $order->status }}">
                        {{ match($order->status) {
                            'completed'  => 'Selesai',
                            'cancelled'  => 'Dibatalkan',
                            'processing' => 'Diproses',
                            default      => 'Menunggu',
                        } }}
                    </div>
                </a>
            @empty
                <div class="order-empty">
                    <div class="order-empty-icon">
                        <i class="bi bi-bag-check"></i>
                    </div>
                    <h5 class="text-coffee mb-2">Belum ada pesanan</h5>
                    <p class="text-muted-custom mb-3">Mulai berbelanja dan pesan menu favorit Anda sekarang.</p>
                    <a href="{{ route('user.menus.index') }}" class="btn btn-coffee btn-sm">
                        <i class="bi bi-cup-hot me-2"></i>Pesan Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
