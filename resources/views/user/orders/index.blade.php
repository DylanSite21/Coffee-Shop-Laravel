@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="orders-page fade-in-up">
    {{-- Header Bar --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">Pesanan Saya</h2>
            <p class="text-muted-custom mb-0">Pantau dan lihat riwayat pesanan kopi Anda.</p>
        </div>
        <a href="{{ route('user.menus.index') }}" class="btn btn-outline-coffee">
            <i class="bi bi-plus-lg me-1"></i>Pesan Lagi
        </a>
    </div>

    {{-- Filter Card --}}
    <div class="order-filter-card">
        <form method="GET" action="{{ route('user.orders.index') }}" class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-muted-custom">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nomor pesanan..." value="{{ $search }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status Pesanan</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="refunded" {{ $status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-coffee w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Orders Table Card --}}
    <div class="order-table-card">
        <div class="table-responsive">
            <table class="table order-table align-middle">
                <thead>
                    <tr>
                        <th>No Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total Pembayaran</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <span class="order-number-badge">
                                    <i class="bi bi-receipt me-1"></i>{{ $order->order_number }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-medium text-brown">{{ $order->created_at->format('d M Y') }}</div>
                                <small class="text-muted-custom">{{ $order->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                <span class="fw-bold text-coffee fs-6">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @php
                                    $statusClass = match(strtolower($order->status)) {
                                        'pending' => 'status-pending',
                                        'processing' => 'status-processing',
                                        'completed' => 'status-completed',
                                        'cancelled' => 'status-cancelled',
                                        'refunded' => 'status-refunded',
                                        default => 'status-pending'
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                @if($order->refund && $order->refund->status === 'pending')
                                    <span class="badge bg-warning text-dark ms-1 small" style="font-size: 0.65rem;">Refund Diajukan</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('user.orders.show', $order) }}" class="btn-coffee-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state py-4">
                                    <div class="empty-cart-icon mb-3" style="font-size: 3rem; color: var(--color-accent);">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h5 class="text-coffee mb-2">Belum ada pesanan</h5>
                                    <p class="text-muted-custom mb-4">Anda belum memiliki riwayat pesanan yang sesuai.</p>
                                    <a href="{{ route('user.menus.index') }}" class="btn btn-coffee">
                                        <i class="bi bi-cup-hot me-2"></i>Mulai Pesan Kopi
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="p-3 border-top border-border d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
