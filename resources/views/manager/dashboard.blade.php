@extends('layouts.app')

@section('title', 'Dashboard Manager')

@section('content')

{{-- Stat Cards --}}
<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card stat-card stat-gradient-brown shadow fade-in-up">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-cup-hot-fill"></i></div>
                <div class="stat-label">Total Menu Saya</div>
                <div class="stat-value">{{ number_format($totalMenus) }}</div>
                <div class="stat-sub">Item yang saya buat</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card stat-gradient-amber shadow fade-in-up delay-1">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                <div class="stat-label">Menunggu Persetujuan</div>
                <div class="stat-value">{{ number_format($pendingMenus) }}</div>
                <div class="stat-sub">Status pending</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card stat-gradient-green shadow fade-in-up delay-2">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div class="stat-label">Disetujui</div>
                <div class="stat-value">{{ number_format($approvedMenus) }}</div>
                <div class="stat-sub">Siap dijual di katalog</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card stat-gradient-teal shadow fade-in-up delay-3">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-x-circle-fill"></i></div>
                <div class="stat-label">Ditolak</div>
                <div class="stat-value">{{ number_format($rejectedMenus) }}</div>
                <div class="stat-sub">Perlu revisi</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Incoming Orders Summary --}}
    <div class="col-md-6">
        <div class="card h-100 fade-in-up delay-1">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-receipt me-2"></i>Status Pesanan Masuk</span>
                <a href="{{ route('manager.orders.index') }}" class="btn btn-sm btn-outline-coffee">
                    Kelola Pesanan
                </a>
            </div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-4">
                        <div class="p-3" style="background:#FFF3E0;border-radius:0.75rem;border:1px solid #FFCC80;">
                            <div style="font-size:1.75rem;font-weight:800;color:#E65100;font-family:'Playfair Display',serif;">{{ $incomingOrders }}</div>
                            <div style="font-size:0.75rem;font-weight:600;color:#E65100;text-transform:uppercase;">Pending</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3" style="background:#E3F2FD;border-radius:0.75rem;border:1px solid #90CAF9;">
                            <div style="font-size:1.75rem;font-weight:800;color:#01579B;font-family:'Playfair Display',serif;">{{ $processingOrders }}</div>
                            <div style="font-size:0.75rem;font-weight:600;color:#01579B;text-transform:uppercase;">Diproses</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3" style="background:#E8F5E9;border-radius:0.75rem;border:1px solid #A5D6A7;">
                            <div style="font-size:1.75rem;font-weight:800;color:#2E7D32;font-family:'Playfair Display',serif;">{{ $completedOrders }}</div>
                            <div style="font-size:0.75rem;font-weight:600;color:#2E7D32;text-transform:uppercase;">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="col-md-6">
        <div class="card h-100 fade-in-up delay-2">
            <div class="card-header">
                <i class="bi bi-lightning-charge me-2"></i>Aksi Cepat Manager
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('manager.menus.create') }}" class="btn btn-coffee py-2">
                        <i class="bi bi-plus-circle me-2"></i>Ajukan Menu Baru
                    </a>
                    <a href="{{ route('manager.menus.index') }}" class="btn btn-outline-coffee py-2">
                        <i class="bi bi-cup-hot me-2"></i>Daftar Pengajuan Menu
                    </a>
                    <a href="{{ route('manager.orders.index') }}" class="btn btn-outline-coffee py-2">
                        <i class="bi bi-receipt me-2"></i>Kelola Pesanan Masuk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
