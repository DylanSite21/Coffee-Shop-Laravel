@extends('layouts.app')

@section('title', 'Pesanan')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Daftar Pesanan</h5>
            <div class="d-flex gap-2">
                <select class="form-select" onchange="location = this.value;">
                    <option value="">Semua Status</option>
                    <option value="?status=pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="?status=processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="?status=completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="?status=cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <form method="GET" action="{{ route('manager.orders.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari pesanan..." value="{{ $search }}">
                <button type="submit" class="btn btn-coffee">Cari</button>
            </form>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Pesanan</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            <a href="{{ route('manager.orders.show', $order) }}" class="btn btn-sm btn-info">Detail</a>
                            @if($order->status == 'pending')
                                <form action="{{ route('manager.orders.accept', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Terima</button>
                                </form>
                                <form action="{{ route('manager.orders.reject', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin tolak?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                </form>
                            @endif
                            @if($order->status == 'processing')
                                <form action="{{ route('manager.orders.complete', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">Selesai</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $orders->links() }}
    </div>
</div>
@endsection
