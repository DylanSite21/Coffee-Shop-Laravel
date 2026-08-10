@extends('layouts.app')

@section('title', 'Checkout Pesanan')

@section('content')
<div class="checkout-page fade-in-up">
    {{-- Header --}}
    <div class="mb-4">
        <h2 class="section-title mb-1">Checkout Pesanan</h2>
        <p class="text-muted-custom mb-0">Lengkapi informasi pengiriman dan tentukan metode pembayaran Anda.</p>
    </div>

    <form method="POST" action="{{ route('user.checkout.store') }}">
        @csrf
        <div class="row g-4">
            {{-- Left Column: Shipping & Payment Form --}}
            <div class="col-lg-7">
                <div class="checkout-card mb-4">
                    <div class="checkout-card-header">
                        <h5><i class="bi bi-geo-alt-fill me-2"></i>Informasi Pengiriman & Pembayaran</h5>
                    </div>
                    <div class="p-4">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-house-door me-1 text-coffee"></i>Alamat Pengiriman
                            </label>
                            <textarea name="shipping_address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap pengiriman pesanan..." required>{{ old('shipping_address') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-telephone me-1 text-coffee"></i>Nomor Telepon / WhatsApp
                            </label>
                            <input type="text" name="phone" class="form-control" placeholder="Contoh: 081234567890" value="{{ old('phone') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-credit-card-2-front me-1 text-coffee"></i>Metode Pembayaran
                            </label>
                            <select name="payment_method" class="form-select" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>💵 Cash / Tunai</option>
                                <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>📱 QRIS (Instant Scan)</option>
                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>🏦 Bank Transfer</option>
                            </select>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">
                                <i class="bi bi-pencil-square me-1 text-coffee"></i>Catatan Pesanan (Opsional)
                            </label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Catatan khusus, misal: Es sedikit, gula terpisah...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Order Summary --}}
            <div class="col-lg-5">
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <h5><i class="bi bi-receipt me-2"></i>Ringkasan Item</h5>
                        <span class="badge bg-gold text-brown px-2 py-1">{{ $cart->cartItems->count() }} Item</span>
                    </div>
                    <div class="p-4">
                        <div class="checkout-items-list mb-3">
                            @foreach($cart->cartItems as $item)
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-border">
                                    <div>
                                        <div class="fw-semibold text-brown">{{ $item->menu->name ?? '-' }}</div>
                                        <small class="text-muted-custom">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</small>
                                    </div>
                                    <span class="fw-bold text-coffee">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="checkout-summary-box">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted-custom">Subtotal Item</span>
                                <span class="fw-semibold text-brown">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted-custom">Biaya Layanan</span>
                                <span class="text-success fw-semibold">GRATIS</span>
                            </div>
                            <div class="checkout-total-row">
                                <span class="fw-bold text-brown fs-5">Total Pembayaran</span>
                                <span class="checkout-total-price">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-coffee w-100 py-3 mb-2 fw-bold">
                                <i class="bi bi-bag-check-fill me-2"></i>Konfirmasi & Buat Pesanan
                            </button>
                            <a href="{{ route('user.cart.index') }}" class="btn btn-outline-coffee w-100">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
