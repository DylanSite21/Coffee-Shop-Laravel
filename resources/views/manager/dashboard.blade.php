@extends('layouts.app')

@section('title', 'Dashboard Manager')

@section('content')

    {{-- Stat Cards --}}
    <div class="row mb-4">
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
                    <div class="stat-label">Pengajuan Menu</div>
                    <div class="stat-value">{{ number_format($pendingMenus) }}</div>
                    <div class="stat-sub">Menunggu persetujuan</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card stat-gradient-green shadow fade-in-up delay-2">
                <div class="card-body">
                    <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
                    <div class="stat-label">Menu Disetujui</div>
                    <div class="stat-value">{{ number_format($approvedMenus) }}</div>
                    <div class="stat-sub">Siap dijual di katalog</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card stat-gradient-teal shadow fade-in-up delay-3" style="background: linear-gradient(135deg, #E65100, #F57C00);">
                <div class="card-body text-white">
                    <div class="stat-icon" style="color: #fff;"><i class="bi bi-arrow-counterclockwise"></i></div>
                    <div class="stat-label" style="color: rgba(255,255,255,0.85);">Permohonan Refund</div>
                    <div class="stat-value" style="color: #fff;">{{ number_format($pendingRefunds) }}</div>
                    <div class="stat-sub" style="color: rgba(255,255,255,0.75);">Menunggu verifikasi QRIS</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Incoming Orders Summary --}}
        <div class="col-md-6">
            <div class="card h-100 fade-in-up delay-1">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-receipt me-2"></i>Status Pesanan & Refund</span>
                    <a href="{{ route('manager.orders.index') }}" class="btn btn-sm btn-outline-coffee">
                        Kelola Pesanan
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-3 text-center">
                        <div class="col-6 col-sm-3">
                            <div class="p-3" style="background:#FFF3E0;border-radius:0.75rem;border:1px solid #FFCC80;">
                                <div style="font-size:1.6rem;font-weight:800;color:#E65100;font-family:'Playfair Display',serif;">
                                    {{ $incomingOrders }}
                                </div>
                                <div style="font-size:0.7rem;font-weight:700;color:#E65100;text-transform:uppercase;">
                                    Pesanan Masuk
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="p-3" style="background:#E3F2FD;border-radius:0.75rem;border:1px solid #90CAF9;">
                                <div style="font-size:1.6rem;font-weight:800;color:#01579B;font-family:'Playfair Display',serif;">
                                    {{ $processingOrders }}
                                </div>
                                <div style="font-size:0.7rem;font-weight:700;color:#01579B;text-transform:uppercase;">
                                    Diproses
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="p-3" style="background:#E8F5E9;border-radius:0.75rem;border:1px solid #A5D6A7;">
                                <div style="font-size:1.6rem;font-weight:800;color:#2E7D32;font-family:'Playfair Display',serif;">
                                    {{ $completedOrders }}
                                </div>
                                <div style="font-size:0.7rem;font-weight:700;color:#2E7D32;text-transform:uppercase;">
                                    Selesai
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="p-3" style="background:#EDE7F6;border-radius:0.75rem;border:1px solid #D1C4E9;">
                                <div style="font-size:1.6rem;font-weight:800;color:#512DA8;font-family:'Playfair Display',serif;">
                                    {{ $totalRefunded }}
                                </div>
                                <div style="font-size:0.7rem;font-weight:700;color:#512DA8;text-transform:uppercase;">
                                    Direfund
                                </div>
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
                        <a href="{{ route('manager.orders.index') }}" class="btn btn-coffee py-2 d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-receipt me-2"></i>Daftar Semua Pesanan</span>
                            <span class="badge bg-white text-dark">{{ $incomingOrders }} Baru</span>
                        </a>
                        <a href="{{ route('manager.refunds.index') }}" class="btn btn-outline-coffee py-2 d-flex justify-content-between align-items-center" style="border-color: #E65100; color: #E65100;">
                            <span><i class="bi bi-arrow-counterclockwise me-2"></i>Kelola Pengajuan Refund (QRIS)</span>
                            @if($pendingRefunds > 0)
                                <span class="badge bg-warning text-dark">{{ $pendingRefunds }} Perlu Ditinjau</span>
                            @else
                                <span class="badge bg-secondary-subtle text-muted">0</span>
                            @endif
                        </a>
                        <a href="{{ route('manager.menus.index') }}" class="btn btn-outline-coffee py-2">
                            <i class="bi bi-cup-hot me-2"></i>Daftar Pengajuan Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
