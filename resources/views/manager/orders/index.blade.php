@extends('layouts.app')

@section('title', 'Pesanan')

@section('content')
<div class="manager-orders-page fade-in-up">
    <div class="page-header-bar">
        <div class="page-title-bar">
            <div class="page-title-icon">
                <i class="bi bi-receipt"></i>
            </div>
            <div>
                <h2>Daftar Pesanan</h2>
                <p class="text-muted-custom small mb-0">Pantau pesanan pelanggan & verifikasi status refund</p>
            </div>
        </div>
        <a href="{{ route('manager.refunds.index') }}" class="btn-outline-coffee">
            <i class="bi bi-arrow-counterclockwise me-1"></i>Halaman Khusus Refund
        </a>
    </div>

    <div class="orders-toolbar">
        <div class="orders-filter-group">
            <div>
                <div class="orders-filter-label">Filter Kategori / Status</div>
                <select class="orders-filter-select" onchange="location = this.value;">
                    <option value="{{ route('manager.orders.index') }}">Semua Pesanan</option>
                    <option value="{{ route('manager.orders.index', ['status' => 'normal']) }}" {{ request('status') == 'normal' ? 'selected' : '' }}>✅ Pesanan Normal (Tanpa Refund)</option>
                    <option value="{{ route('manager.orders.index', ['status' => 'refund_pending']) }}" {{ request('status') == 'refund_pending' ? 'selected' : '' }}>⚠️ Ada Pengajuan Refund (QRIS)</option>
                    <option value="{{ route('manager.orders.index', ['status' => 'refunded']) }}" {{ request('status') == 'refunded' ? 'selected' : '' }}>🛑 Sudah Direfund</option>
                    <option disabled>──────────</option>
                    <option value="{{ route('manager.orders.index', ['status' => 'pending']) }}" {{ request('status') == 'pending' ? 'selected' : '' }}>Status: Pending</option>
                    <option value="{{ route('manager.orders.index', ['status' => 'processing']) }}" {{ request('status') == 'processing' ? 'selected' : '' }}>Status: Processing</option>
                    <option value="{{ route('manager.orders.index', ['status' => 'completed']) }}" {{ request('status') == 'completed' ? 'selected' : '' }}>Status: Completed</option>
                    <option value="{{ route('manager.orders.index', ['status' => 'cancelled']) }}" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Status: Cancelled</option>
                </select>
            </div>
            <form method="GET" action="{{ route('manager.orders.index') }}" class="orders-search-form">
                <input type="text" name="search" class="form-control" placeholder="Cari nomor pesanan / nama..." value="{{ $search }}">
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
                        <th>Metode Bayar</th>
                        <th>Total</th>
                        <th>Tipe / Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr style="{{ $order->refund && $order->refund->status === 'pending' ? 'background-color: #FFF8E1;' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="order-number">#{{ $order->order_number }}</span>
                            </td>
                            <td>
                                <div class="order-customer">
                                    <div class="order-customer-avatar">
                                        {{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="order-customer-name d-block">{{ $order->user->name ?? '-' }}</span>
                                        <small class="text-muted-custom">{{ $order->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="order-menu-text">
                                    {{ $order->orderDetails->map(fn($d) => ($d->quantity > 1 ? $d->quantity . 'x ' : '') . ($d->menu->name ?? '-'))->join(', ') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-dark border">
                                    {{ strtoupper($order->payment_method ?? '-') }}
                                </span>
                            </td>
                            <td>
                                <span class="order-total">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @if($order->refund && $order->refund->status === 'pending')
                                    <div>
                                        <span class="badge bg-warning text-dark px-2 py-1 fw-bold">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i>Pengajuan Refund
                                        </span>
                                        <small class="text-danger d-block mt-1" style="font-size: 0.75rem; max-width: 160px;">
                                            "{{ Str::limit($order->refund->reason, 45) }}"
                                        </small>
                                    </div>
                                @elseif($order->status === 'refunded')
                                    <span class="status-badge status-refunded">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i>Direfund
                                    </span>
                                @else
                                    <div>
                                        @php
                                            $statusClass = match(strtolower($order->status)) {
                                                'pending' => 'status-pending',
                                                'processing' => 'status-processing',
                                                'completed' => 'status-completed',
                                                'cancelled' => 'status-cancelled',
                                                default => 'status-pending'
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <div class="mt-1">
                                            <span class="badge bg-success text-white" style="font-size: 0.65rem;">
                                                <i class="bi bi-check-circle me-1"></i>Pesanan Valid
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="order-actions">
                                    @if($order->refund && $order->refund->status === 'pending')
                                        <a href="{{ route('manager.refunds.index') }}" class="btn-action" style="background: linear-gradient(135deg, #E65100, #EF6C00); color: #fff;" title="Kelola permohonan refund">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                            Tinjau Refund
                                        </a>
                                    @elseif($order->status == 'pending')
                                        <form action="{{ route('manager.orders.accept', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Terima pesanan ini?')">
                                            @csrf
                                            <button type="submit" class="btn-action btn-action-accept" title="Terima Pesanan">
                                                <i class="bi bi-check-lg"></i>
                                                Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('manager.orders.reject', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin tolak pesanan ini?')">
                                            @csrf
                                            <button type="submit" class="btn-action btn-action-reject" title="Tolak Pesanan">
                                                <i class="bi bi-x-lg"></i>
                                                Tolak
                                            </button>
                                        </form>
                                    @elseif($order->status == 'processing')
                                        <form action="{{ route('manager.orders.complete', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai pesanan sebagai selesai?')">
                                            @csrf
                                            <button type="submit" class="btn-action btn-action-complete" title="Selesaikan Pesanan">
                                                <i class="bi bi-check2-all"></i>
                                                Selesai
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="order-empty-state">
                                    <div class="order-empty-icon">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <h5 class="text-coffee mb-2">Tidak ada pesanan</h5>
                                    <p class="text-muted-custom">Belum ada pesanan yang sesuai dengan filter.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="pagination-wrapper d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
