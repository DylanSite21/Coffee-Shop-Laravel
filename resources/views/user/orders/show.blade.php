@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="order-detail-page fade-in-up">
    {{-- Top Action Bar --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('user.orders.index') }}" class="btn btn-outline-coffee btn-sm mb-2">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Pesanan
            </a>
            <h2 class="section-title mb-0">Detail Pesanan</h2>
        </div>
        <span class="order-number-badge fs-6 px-3 py-2">
            <i class="bi bi-receipt me-1"></i>{{ $order->order_number }}
        </span>
    </div>

    <div class="row g-4 mb-4">
        {{-- Order Information Card --}}
        <div class="col-lg-6">
            <div class="order-table-card h-100">
                <div class="order-card-header">
                    <h5><i class="bi bi-info-circle me-2"></i>Informasi Status & Pembayaran</h5>
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
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between py-2 border-bottom border-border">
                        <span class="text-muted-custom">Tanggal Pesanan</span>
                        <span class="fw-semibold text-brown">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom border-border">
                        <span class="text-muted-custom">Status Pembayaran</span>
                        <span class="fw-semibold text-coffee">{{ ucfirst($order->payment_status ?? 'Pending') }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom border-border">
                        <span class="text-muted-custom">Metode Pembayaran</span>
                        <span class="fw-semibold text-brown">
                            {{ strtoupper($order->payment_method ?? '-') }}
                            @if($order->payment_method === 'qris')
                                <span class="refund-badge-yes ms-1">Bisa Refund</span>
                            @else
                                <span class="refund-badge-no ms-1">Tidak Bisa Refund</span>
                            @endif
                        </span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted-custom">Total Tagihan</span>
                        <span class="fw-bold text-coffee fs-5">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipping Information Card --}}
        <div class="col-lg-6">
            <div class="order-table-card h-100">
                <div class="order-card-header">
                    <h5><i class="bi bi-truck me-2"></i>Tujuan Pengiriman</h5>
                </div>
                <div class="p-4">
                    <div class="mb-3">
                        <label class="text-muted-custom small text-uppercase fw-bold mb-1">Nomor Telepon / WhatsApp</label>
                        <div class="fw-semibold text-brown"><i class="bi bi-telephone me-2 text-coffee"></i>{{ $order->phone ?? '-' }}</div>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted-custom small text-uppercase fw-bold mb-1">Alamat Pengiriman</label>
                        <div class="fw-medium text-brown p-3 rounded" style="background-color: var(--color-background); border: 1px solid var(--color-border);">
                            <i class="bi bi-geo-alt me-2 text-coffee"></i>{{ $order->shipping_address ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Refund Section --}}
    @if($order->refund)
        <div class="refund-section mb-4">
            <div class="refund-section-header">
                <i class="bi bi-arrow-counterclockwise"></i> Status Pengajuan Refund
            </div>
            <div class="refund-status-card">
                <div class="refund-status-info">
                    <div><strong>Alasan Refund:</strong> {{ $order->refund->reason }}</div>
                    <div class="text-muted-custom small mt-1">
                        Diajukan pada: {{ $order->refund->created_at->format('d M Y, H:i') }} WIB
                    </div>
                    @if($order->refund->status === 'rejected' && $order->refund->rejected_reason)
                        <div class="text-danger small mt-1">
                            <strong>Alasan Penolakan:</strong> {{ $order->refund->rejected_reason }}
                        </div>
                    @endif
                </div>
                <div>
                    @if($order->refund->status === 'pending')
                        <span class="status-badge status-pending">
                            <i class="bi bi-hourglass-split me-1"></i>Menunggu Persetujuan Manager
                        </span>
                    @elseif($order->refund->status === 'approved')
                        <span class="status-badge status-approved">
                            <i class="bi bi-check-circle-fill me-1"></i>Refund Disetujui (Dana Dikembalikan)
                        </span>
                    @elseif($order->refund->status === 'rejected')
                        <span class="status-badge status-rejected">
                            <i class="bi bi-x-circle-fill me-1"></i>Refund Ditolak
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @elseif($order->payment_method === 'qris' && $order->status === 'pending')
        <div class="refund-section mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                <div>
                    <div class="refund-section-header mb-1">
                        <i class="bi bi-shield-check"></i> Pengajuan Refund (QRIS)
                    </div>
                    <small class="text-muted-custom">
                        Pesanan ini belum dikonfirmasi oleh manager. Anda dapat mengajukan refund jika ingin membatalkan pesanan.
                    </small>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm px-3 py-2 fw-semibold" id="toggleRefundBtn" onclick="toggleRefundForm()">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Ajukan Refund
                </button>
            </div>

            {{-- Inline Refund Form --}}
            <div id="inlineRefundContainer" style="display: none;" class="mt-3 pt-3 border-top border-border">
                <form action="{{ route('user.orders.refund', $order) }}" method="POST" class="p-3 rounded" style="background-color: #fdf6ed; border: 1.5px solid #dec9aa;">
                    @csrf
                    <div class="alert alert-warning mb-3 py-2 small">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        Pengajuan refund sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong> akan dikirimkan ke manager untuk ditinjau.
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-brown small">
                            Alasan Pengajuan Refund <span class="text-danger">*</span>
                        </label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Tuliskan alasan pengajuan refund pesanan Anda di sini..." required style="background-color: #fff;"></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleRefundForm()">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-danger btn-sm px-3 fw-semibold">
                            <i class="bi bi-send me-1"></i>Kirim Pengajuan Refund
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Order Items Table --}}
    <div class="order-table-card">
        <div class="order-card-header">
            <h5><i class="bi bi-cup-hot me-2"></i>Rincian Menu Yang Dipesan</h5>
            <span class="badge bg-gold text-brown px-2 py-1">{{ $order->orderDetails->count() }} Menu</span>
        </div>
        <div class="table-responsive">
            <table class="table order-table align-middle">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Harga Satuan</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->orderDetails as $detail)
                        <tr>
                            <td>
                                <div class="fw-bold text-brown">{{ $detail->menu->name ?? '-' }}</div>
                                @if(isset($detail->menu->category))
                                    <small class="text-muted-custom">{{ $detail->menu->category->name }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-coffee-light text-white px-2 py-1 fs-6">{{ $detail->quantity }}</span>
                            </td>
                            <td class="text-end text-muted-custom">
                                Rp {{ number_format($detail->price, 0, ',', '.') }}
                            </td>
                            <td class="text-end fw-bold text-coffee">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted-custom">Tidak ada rincian item pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-top border-border d-flex justify-content-between align-items-center flex-wrap gap-2" style="background-color: var(--color-surface-alt);">
            <div class="text-muted-custom fs-6">
                Terima kasih telah memesan di <strong class="text-brown">Kopi Nusantara</strong>!
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="fw-bold text-brown">Total Akhir:</span>
                <span class="checkout-total-price">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<script>
function toggleRefundForm() {
    const container = document.getElementById('inlineRefundContainer');
    const btn = document.getElementById('toggleRefundBtn');
    if (!container) return;

    if (container.style.display === 'none' || container.style.display === '') {
        container.style.display = 'block';
        if (btn) btn.style.display = 'none';
        const textarea = container.querySelector('textarea[name="reason"]');
        if (textarea) textarea.focus();
    } else {
        container.style.display = 'none';
        if (btn) btn.style.display = 'inline-flex';
    }
}
</script>
@endsection
