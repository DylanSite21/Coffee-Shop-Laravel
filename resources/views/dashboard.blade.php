@extends('layouts.app')

@section('title', 'User Dashboard - Coffee Shop')

@section('content')
<section class="dashboard-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="fw-bold">👋 Welcome, {{ Auth::user()->name }}</h1>
                    <span class="badge bg-warning text-dark px-3 py-2">
                        {{ Auth::user()->role_label }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistik -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center">
                    <h3 class="text-warning">{{ $cartCount }}</h3>
                    <p class="text-muted mb-0">🛒 Items in Cart</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center">
                    <h3 class="text-warning">{{ $orderCount }}</h3>
                    <p class="text-muted mb-0">📋 Total Orders</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center">
                    <h3 class="text-warning">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">💰 Total Spent</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm p-3 text-center">
                    <h3 class="text-warning">
                        {{ $orders->where('status', 'pending')->count() }}
                    </h3>
                    <p class="text-muted mb-0">⏳ Pending Orders</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <a href="{{ route('user.menus.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm p-4 text-center hover-card">
                        <div class="display-4 mb-2">☕</div>
                        <h5 class="fw-bold">Explore Menu</h5>
                        <p class="text-muted small">Find your favorite coffee</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('user.cart.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm p-4 text-center hover-card">
                        <div class="display-4 mb-2">🛒</div>
                        <h5 class="fw-bold">My Cart</h5>
                        <p class="text-muted small">{{ $cartCount }} items in cart</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('user.orders.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm p-4 text-center hover-card">
                        <div class="display-4 mb-2">📋</div>
                        <h5 class="fw-bold">My Orders</h5>
                        <p class="text-muted small">{{ $orderCount }} total orders</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-transparent">
                        <h5 class="fw-bold mb-0">📋 Recent Orders</h5>
                    </div>
                    <div class="card-body">
                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td>#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                                <td>
                                                    @if($order->status === 'pending')
                                                        <span class="badge bg-warning text-dark">⏳ Pending</span>
                                                    @elseif($order->status === 'processing')
                                                        <span class="badge bg-info">🔄 Processing</span>
                                                    @elseif($order->status === 'completed')
                                                        <span class="badge bg-success">✅ Completed</span>
                                                    @else
                                                        <span class="badge bg-danger">❌ Cancelled</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('user.orders.show', $order) }}" 
                                                       class="btn btn-sm btn-outline-warning">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted">No orders yet. Start ordering!</p>
                                <a href="{{ route('user.menus.index') }}" class="btn btn-warning">
                                    Explore Menu →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .hover-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04);
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-color: #d4a24e;
    }
</style>
@endpush