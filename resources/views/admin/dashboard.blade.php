@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Stat Cards --}}
<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card stat-card stat-gradient-brown shadow fade-in-up">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-value">{{ number_format($totalUsers) }}</div>
                <div class="stat-sub">Pelanggan terdaftar</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card stat-gradient-amber shadow fade-in-up delay-1">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-cup-hot-fill"></i></div>
                <div class="stat-label">Total Menu</div>
                <div class="stat-value">{{ number_format($totalMenus) }}</div>
                <div class="stat-sub">Item aktif di katalog</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card stat-gradient-green shadow fade-in-up delay-2">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-receipt-cutoff"></i></div>
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">{{ number_format($totalOrders) }}</div>
                <div class="stat-sub">Semua waktu</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card stat-gradient-teal shadow fade-in-up delay-3">
            <div class="card-body">
                <div class="stat-icon"><i class="bi bi-cash-coin"></i></div>
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value" style="font-size:1.35rem;">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>
                <div class="stat-sub">Keseluruhan transaksi</div>
            </div>
        </div>
    </div>
</div>

{{-- Status Menu & Quick Info --}}
<div class="row g-4">
    {{-- Menu Status --}}
    <div class="col-md-6">
        <div class="card h-100 fade-in-up delay-1">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-cup-hot me-2"></i>Status Menu</span>
                <a href="{{ route('admin.approvals.index') }}" class="btn btn-sm btn-outline-coffee">
                    Kelola
                </a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div style="background:linear-gradient(135deg,#E8F5E9,#C8E6C9);border-radius:0.75rem;padding:1.25rem;text-align:center;border:1px solid #A5D6A7;">
                            <div style="font-size:2rem;font-weight:800;color:#2E7D32;font-family:'Playfair Display',serif;">{{ $approvedMenus }}</div>
                            <div style="font-size:0.75rem;font-weight:600;color:#2E7D32;text-transform:uppercase;letter-spacing:0.5px;">Disetujui</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:linear-gradient(135deg,#FFF3E0,#FFE0B2);border-radius:0.75rem;padding:1.25rem;text-align:center;border:1px solid #FFCC80;">
                            <div style="font-size:2rem;font-weight:800;color:#E65100;font-family:'Playfair Display',serif;">{{ $pendingMenus }}</div>
                            <div style="font-size:0.75rem;font-weight:600;color:#E65100;text-transform:uppercase;letter-spacing:0.5px;">Menunggu</div>
                        </div>
                    </div>
                </div>

                @if($pendingMenus > 0)
                    <div class="alert alert-warning mt-3 mb-0 py-2 px-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Ada <strong>{{ $pendingMenus }} menu</strong> yang menunggu persetujuan Anda.
                        <a href="{{ route('admin.approvals.index') }}" class="alert-link">Tinjau sekarang →</a>
                    </div>
                @else
                    <div class="alert alert-success mt-3 mb-0 py-2 px-3">
                        <i class="bi bi-check-circle me-2"></i>Semua menu sudah diproses. Tidak ada antrian.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="col-md-6">
        <div class="card h-100 fade-in-up delay-2">
            <div class="card-header">
                <i class="bi bi-lightning-charge me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ route('admin.menus.index') }}" class="btn btn-coffee w-100 py-3" style="flex-direction:column;display:flex;align-items:center;gap:0.4rem;">
                            <i class="bi bi-cup-hot fs-4"></i>
                            <span style="font-size:0.8rem;">Kelola Menu</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-coffee w-100 py-3" style="flex-direction:column;display:flex;align-items:center;gap:0.4rem;">
                            <i class="bi bi-tags fs-4"></i>
                            <span style="font-size:0.8rem;">Kategori</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-coffee w-100 py-3" style="flex-direction:column;display:flex;align-items:center;gap:0.4rem;">
                            <i class="bi bi-people fs-4"></i>
                            <span style="font-size:0.8rem;">Pengguna</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-coffee w-100 py-3" style="flex-direction:column;display:flex;align-items:center;gap:0.4rem;">
                            <i class="bi bi-bar-chart-line fs-4"></i>
                            <span style="font-size:0.8rem;">Laporan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
