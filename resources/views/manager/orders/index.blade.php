@extends('layouts.app')

@section('title', 'Pesanan')

@section('content')
<div class="manager-orders-page fade-in-up">
    <div class="page-header-bar">
        <div class="page-title-bar">
            <div class="page-title-icon">
                <i class="bi bi-receipt"></i>
            </div>
            <h2>Daftar Pesanan</h2>
        </div>
    </div>

    <div class="orders-toolbar">
        <div class="orders-filter-group">
            <div>
                <div class="orders-filter-label">Status</div>
                <select class="orders-filter-select" onchange="location = this.value;">
                    <option value="">Semua Status</option>
                    <option value="?status=pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="?status=processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="?status=completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="?status=cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <form method="GET" action="{{ route('manager.orders.index') }}" class="orders-search-form">
                <input type="text" name="search" class="form-control" placeholder="Cari pesanan..." value="{{ $search }}">
                <button type="submit" class="btn-primary-solid">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="orders-table-card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Pesanan</th>
                        <th>Customer</th>
                        <th>Menu</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="order-number">#{{ $order->order_number }}</span>
                            </td>
                            <td>
                                <div class="order-customer">
                                    <div class="order-customer-avatar">
                                        {{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="order-customer-name">{{ $order->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="order-menu-text">
                                    {{ $order->orderDetails->map(fn($d) => $d->menu->name ?? '-')->join(', ') }}
                                </span>
                            </td>
                            <td>
                                <span class="order-total">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="order-actions">
                                    @if($order->status == 'pending')
                                        <form action="{{ route('manager.orders.accept', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Terima pesanan ini?')">
                                            @csrf
                                            <button type="submit" class="btn-action btn-action-accept">
                                                <i class="bi bi-check-lg"></i>
                                                Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('manager.orders.reject', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin tolak pesanan ini?')">
                                            @csrf
                                            <button type="submit" class="btn-action btn-action-reject">
                                                <i class="bi bi-x-lg"></i>
                                                Tolak
                                            </button>
                                        </form>
                                    @endif
                                    @if($order->status == 'processing')
                                        <form action="{{ route('manager.orders.complete', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai pesanan sebagai selesai?')">
                                            @csrf
                                            <button type="submit" class="btn-action btn-action-complete">
                                                <i class="bi bi-check2-all"></i>
                                                Selesai
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="order-empty-state">
                                    <div class="order-empty-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h5 class="text-coffee mb-2">Tidak ada pesanan</h5>
                                    <p class="text-muted-custom">Belum ada pesanan masuk untuk saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="pagination-wrapper">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
