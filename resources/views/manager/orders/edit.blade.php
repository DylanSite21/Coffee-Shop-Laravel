@extends('layouts.app')

@section('title', 'Edit Status Pesanan')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Edit Status Pesanan</h5>

        <div class="mb-3">
            <p><strong>No Pesanan:</strong> {{ $order->order_number }}</p>
            <p><strong>User:</strong> {{ $order->user->name ?? '-' }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        </div>

        <form method="POST" action="{{ route('manager.orders.process', $order) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Ubah Status</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-coffee">Update Status</button>
            <a href="{{ route('manager.orders.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
