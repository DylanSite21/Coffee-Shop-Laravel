@extends('layouts.app')

@section('title', 'Kelola Refund')

@section('content')
<div class="manager-orders-page fade-in-up">
    <div class="page-header-bar">
        <div class="page-title-bar">
            <div class="page-title-icon">
                <i class="bi bi-arrow-counterclockwise"></i>
            </div>
            <h2>Kelola Pengajuan Refund (QRIS)</h2>
        </div>
    </div>

    <div class="orders-toolbar">
        <div class="orders-filter-group">
            <div>
                <div class="orders-filter-label">Status</div>
                <select class="orders-filter-select" onchange="location = this.value;">
                    <option value="{{ route('manager.refunds.index') }}">Semua Status</option>
                    <option value="{{ route('manager.refunds.index', ['status' => 'pending']) }}" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                    <option value="{{ route('manager.refunds.index', ['status' => 'approved']) }}" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="{{ route('manager.refunds.index', ['status' => 'rejected']) }}" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <form method="GET" action="{{ route('manager.refunds.index') }}" class="orders-search-form">
                <input type="text" name="search" class="form-control" placeholder="Cari nomor pesanan / customer..." value="{{ $search }}">
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
                        <th>Jumlah Refund</th>
                        <th>Alasan Refund</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($refunds as $refund)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="order-number">#{{ $refund->order->order_number ?? '-' }}</span>
                            </td>
                            <td>
                                <div class="order-customer">
                                    <div class="order-customer-avatar">
                                        {{ strtoupper(substr($refund->user->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="order-customer-name">{{ $refund->user->name ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="order-total">Rp {{ number_format($refund->amount, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="text-brown" style="max-width: 200px; display: inline-block;">
                                    {{ $refund->reason }}
                                </span>
                                @if($refund->status === 'rejected' && $refund->rejected_reason)
                                    <br><small class="text-danger">Alasan ditolak: {{ $refund->rejected_reason }}</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $refundBadgeClass = match($refund->status) {
                                        'pending' => 'status-pending',
                                        'approved' => 'status-approved',
                                        'rejected' => 'status-rejected',
                                        default => 'status-pending'
                                    };
                                @endphp
                                <span class="status-badge {{ $refundBadgeClass }}">
                                    {{ ucfirst($refund->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="order-actions">
                                    @if($refund->status === 'pending')
                                        <form action="{{ route('manager.refunds.approve', $refund) }}" method="POST" class="d-inline" onsubmit="return confirm('Setujui pengajuan refund sebesar Rp {{ number_format($refund->amount, 0, ',', '.') }} ini?')">
                                            @csrf
                                            <button type="submit" class="btn-action btn-action-accept" title="Setujui Refund">
                                                <i class="bi bi-check-lg"></i>
                                                Setujui
                                            </button>
                                        </form>
                                        
                                        <button type="button" class="btn-action btn-action-reject" data-bs-toggle="modal" data-bs-target="#rejectRefundModal-{{ $refund->id }}" title="Tolak Refund">
                                            <i class="bi bi-x-lg"></i>
                                            Tolak
                                        </button>

                                        {{-- Reject Modal --}}
                                        <div class="modal fade text-start" id="rejectRefundModal-{{ $refund->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content" style="background-color: #fdf6ed; border: 1px solid #d7ccc8;">
                                                    <form action="{{ route('manager.refunds.reject', $refund) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header" style="background: linear-gradient(135deg, #3e1f0d, #6b3a2a); color: #fdf6ed;">
                                                            <h5 class="modal-title">Tolak Pengajuan Refund</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <p class="mb-3 text-brown">Tolak refund untuk pesanan <strong>#{{ $refund->order->order_number ?? '' }}</strong>?</p>
                                                            <div class="mb-0">
                                                                <label class="form-label fw-semibold text-brown small">Alasan Penolakan</label>
                                                                <textarea name="rejected_reason" class="form-control" rows="3" placeholder="Masukkan alasan penolakan..." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer" style="border-top: 1px solid #dec9aa;">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger btn-sm">Tolak Refund</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted small">Selesai</span>
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
                                    <h5 class="text-coffee mb-2">Tidak ada pengajuan refund</h5>
                                    <p class="text-muted-custom">Belum ada permohonan refund dari pelanggan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($refunds->hasPages())
            <div class="pagination-wrapper d-flex justify-content-center mt-4">
                {{ $refunds->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
