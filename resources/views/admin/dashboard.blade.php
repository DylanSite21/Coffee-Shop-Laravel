@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-coffee">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text display-4">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-coffee-light">
            <div class="card-body">
                <h5 class="card-title">Total Menus</h5>
                <p class="card-text display-4">{{ $totalMenus }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background-color: #A3B18A;">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <p class="card-text display-4">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background-color: #6F4E37;">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <p class="card-text display-4">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Status Menu</h5>
                <p class="card-text">Approved: <strong>{{ $approvedMenus }}</strong></p>
                <p class="card-text">Pending: <strong>{{ $pendingMenus }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
