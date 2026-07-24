@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-coffee">
            <div class="card-body">
                <h5 class="card-title">Total Pesanan</h5>
                <p class="card-text display-4">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-coffee-light">
            <div class="card-body">
                <h5 class="card-title">Keranjang</h5>
                <p class="card-text display-4">{{ $cartCount }} item</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white" style="background-color: #A3B18A;">
            <div class="card-body">
                <h5 class="card-title">Menu Tersedia</h5>
                <p class="card-text">Nikmati menu kopi terbaik kami</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Pesanan Terbaru</h5>
        @forelse($recentOrders as $order)
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                <div>
                    <strong>{{ $order->order_number }}</strong><br>
                    <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                </div>
                <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        @empty
            <p class="text-muted">Belum ada pesanan.</p>
        @endforelse
    </div>
</div>
@endsection
