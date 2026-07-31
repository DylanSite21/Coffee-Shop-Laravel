@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- Welcome Banner --}}
<div class="mb-4 p-4 fade-in"
    style="background:linear-gradient(135deg,#3E1F0D 0%,#6B3A2A 100%);border-radius:1rem;color:#FDF6ED;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-30px;right:-20px;font-size:8rem;opacity:0.08;line-height:1;">☕</div>
    <div style="position:relative;z-index:1;">
        <div style="font-size:0.8rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;color:#C08B5C;margin-bottom:0.25rem;">
            Selamat datang kembali
        </div>
        <h2 style="font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:800;color:#FDF6ED;margin-bottom:0.5rem;">
            Halo, {{ auth()->user()->name }}! 👋
        </h2>
        <p style="color:#C8A882;margin-bottom:1.25rem;font-size:0.9rem;">
            Apa yang ingin Anda nikmati hari ini? Kami siap menyajikan yang terbaik untuk Anda.
        </p>
        <a href="{{ route('user.menus.index') }}" class="btn btn-gold">
            <i class="bi bi-cup-hot me-2"></i>Pesan Sekarang
        </a>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-4 mb-4">
    <div class="col-6 col-md-4">
        <div class="card stat-card stat-gradient-brown shadow fade-in-up">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-receipt-cutoff"></i></div>
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">{{ number_format($totalOrders) }}</div>
                <div class="stat-sub">Semua waktu</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card stat-card stat-gradient-amber shadow fade-in-up delay-1">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-bag2"></i></div>
                <div class="stat-label">Keranjang</div>
                <div class="stat-value">{{ $cartCount }}</div>
                <div class="stat-sub">Item menunggu</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card stat-card stat-gradient-teal shadow fade-in-up delay-2">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-star-fill"></i></div>
                <div class="stat-label">Status Akun</div>
                <div class="stat-value" style="font-size:1.25rem;">Member ✓</div>
                <div class="stat-sub">Pelanggan aktif</div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card fade-in-up delay-1">
            <div class="card-header"><i class="bi bi-lightning-charge me-2"></i>Aksi Cepat</div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('user.menus.index') }}" class="btn btn-coffee">
                        <i class="bi bi-cup-hot me-2"></i>Lihat Menu
                    </a>
                    <a href="{{ route('user.cart.index') }}" class="btn btn-outline-coffee">
                        <i class="bi bi-bag2 me-2"></i>Keranjang
                        @if($cartCount > 0)
                            <span class="badge ms-1" style="background:#D4A855;color:#3E1F0D;">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('user.orders.index') }}" class="btn btn-outline-coffee">
                        <i class="bi bi-receipt me-2"></i>Pesanan Saya
                    </a>
                    <a href="{{ route('user.profile') }}" class="btn btn-outline-coffee">
                        <i class="bi bi-person me-2"></i>Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="card fade-in-up delay-2">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-clock-history me-2"></i>Pesanan Terbaru</span>
        <a href="{{ route('user.orders.index') }}" class="btn btn-sm btn-outline-coffee">
            Semua Pesanan
        </a>
    </div>
    <div class="card-body p-0">
        @forelse($recentOrders as $order)
            <div class="d-flex justify-content-between align-items-center px-4 py-3"
                 style="border-bottom:1px solid #EDD9BC;transition:background 0.2s;"
                 onmouseover="this.style.background='#F5E8D4'" onmouseout="this.style.background=''">
                <div>
                    <div style="font-weight:700;font-size:0.9rem;color:#3E1F0D;">
                        {{ $order->order_number }}
                    </div>
                    <div style="font-size:0.78rem;color:#6B4C3B;">
                        <i class="bi bi-calendar3 me-1"></i>{{ $order->created_at->format('d M Y, H:i') }} WIB
                    </div>
                </div>
                <div class="text-end">
                    @php
                        $statusClasses = [
                            'completed' => 'status-approved',
                            'cancelled' => 'status-rejected',
                            'pending'   => 'status-pending',
                            'processing'=> 'status-processing',
                        ];
                    @endphp
                    <span class="status-badge {{ $statusClasses[$order->status] ?? 'status-pending' }}">
                        {{ match($order->status) {
                            'completed'  => '✓ Selesai',
                            'cancelled'  => '✕ Dibatalkan',
                            'processing' => '⚡ Diproses',
                            default      => '⏳ Menunggu',
                        } }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <div style="font-size:3rem;margin-bottom:0.75rem;">🛍️</div>
                <p class="text-muted-custom mb-3">Belum ada pesanan</p>
                <a href="{{ route('user.menus.index') }}" class="btn btn-coffee btn-sm">
                    Pesan Sekarang
                </a>
            </div>
        @endforelse
    </div>
</div>

@endsection
