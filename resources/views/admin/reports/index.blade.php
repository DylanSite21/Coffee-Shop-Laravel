@extends('layouts.app')

@section('title', 'Laporan Pendapatan')

@section('content')
<div class="report-page fade-in-up">
    <div class="page-header-bar">
        <div class="page-title-bar">
            <div class="page-title-icon">
                <i class="bi bi-bar-chart-line"></i>
            </div>
            <h2>Laporan Pendapatan</h2>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.reports.index') }}" class="report-filter-bar">
        <div>
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
        </div>
        <div>
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
        </div>
        <div class="ms-auto">
            <button type="submit" class="btn-primary-solid">
                <i class="bi bi-funnel"></i>
                Filter
            </button>
        </div>
    </form>

    <div class="report-stat-grid">
        <div class="report-stat-card revenue">
            <div class="report-stat-label">Total Pendapatan</div>
            <div class="report-stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="report-stat-card orders">
            <div class="report-stat-label">Total Pesanan</div>
            <div class="report-stat-value">{{ number_format($totalOrders) }}</div>
        </div>
        <div class="report-stat-card completed">
            <div class="report-stat-label">Selesai</div>
            <div class="report-stat-value">{{ number_format($completedOrders) }}</div>
        </div>
        <div class="report-stat-card cancelled">
            <div class="report-stat-label">Dibatalkan</div>
            <div class="report-stat-value">{{ number_format($cancelledOrders) }}</div>
        </div>
    </div>

    <div class="top-menu-card">
        <div class="card-header" style="background-color:#FDF6ED;border-bottom:1px solid #D7CCC8;padding:1rem 1.5rem;">
            <i class="bi bi-trophy me-2" style="color:#C08B5C;"></i>
            <span style="font-family:'Playfair Display',serif;font-weight:700;color:#3E1F0D;">Top Menu</span>
        </div>
        <div class="card-body p-0">
            @forelse($topMenus as $topMenu)
                <div class="top-menu-item">
                    <div style="display:flex;align-items:center;">
                        <span class="top-menu-rank">{{ $loop->iteration }}</span>
                        <div class="top-menu-info">
                            <div class="top-menu-name">{{ $topMenu->name }}</div>
                        </div>
                    </div>
                    <div class="top-menu-count">{{ $topMenu->order_details_count }}x terjual</div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-graph-down"></i>
                    </div>
                    <h5 class="text-coffee mb-2">Tidak ada data</h5>
                    <p class="text-muted-custom">Belum ada penjualan pada periode ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
