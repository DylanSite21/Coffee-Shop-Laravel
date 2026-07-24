@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-coffee">
            <div class="card-body">
                <h5 class="card-title">Total Menu Saya</h5>
                <p class="card-text display-4">{{ $totalMenus }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-coffee-light">
            <div class="card-body">
                <h5 class="card-title">Pending</h5>
                <p class="card-text display-4">{{ $pendingMenus }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background-color: #A3B18A;">
            <div class="card-body">
                <h5 class="card-title">Approved</h5>
                <p class="card-text display-4">{{ $approvedMenus }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background-color: #6F4E37;">
            <div class="card-body">
                <h5 class="card-title">Rejected</h5>
                <p class="card-text display-4">{{ $rejectedMenus }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pesanan Masuk</h5>
                <p class="card-text">Pending: <strong>{{ $incomingOrders }}</strong></p>
                <p class="card-text">Processing: <strong>{{ $processingOrders }}</strong></p>
                <p class="card-text">Completed: <strong>{{ $completedOrders }}</strong></p>
            </div>
        </div>
    </div>
</div>
@endsection
