@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Checkout</h5>

        <div class="mb-4">
            <h6>Ringkasan Pesanan</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->cartItems as $item)
                        <tr>
                            <td>{{ $item->menu->name ?? '-' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><strong>Total</strong></td>
                        <td><strong>Rp {{ number_format($cart->total, 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <form method="POST" action="{{ route('user.checkout.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Alamat Pengiriman</label>
                <textarea name="shipping_address" class="form-control" required>{{ old('shipping_address') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <select name="payment_method" class="form-control" required>
                    <option value="">Pilih Metode</option>
                    <option value="cash">Cash</option>
                    <option value="qris">QRIS</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
            </div>
            <button type="submit" class="btn btn-coffee">Buat Pesanan</button>
            <a href="{{ route('user.cart.index') }}" class="btn btn-secondary">Kembali ke Keranjang</a>
        </form>
    </div>
</div>
@endsection
