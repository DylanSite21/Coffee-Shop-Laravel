@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Pesanan {{ $order->order_number }}</h5>
        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
        <p><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Pembayaran:</strong> {{ ucfirst($order->payment_status) }}</p>
        <p><strong>Metode:</strong> {{ ucfirst($order->payment_method) }}</p>
        <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
        <p><strong>Telepon:</strong> {{ $order->phone }}</p>

        <h6 class="mt-3">Detail Item</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->menu->name ?? '-' }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Tidak ada item.</td></tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('user.orders.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
