@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Daftar Pesanan</h5>

        <div class="mb-3">
            <form method="GET" action="{{ route('user.orders.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari pesanan..." value="{{ $search }}">
                <select name="status" class="form-select me-2">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="btn btn-coffee">Filter</button>
            </form>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No Pesanan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            <a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Tidak ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $orders->links() }}
    </div>
</div>
@endsection
