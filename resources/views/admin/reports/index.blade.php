@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Laporan Pendapatan</h5>

        <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-coffee">Filter</button>
            </div>
        </form>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6>Total Pendapatan</h6>
                        <p class="h4">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6>Total Pesanan</h6>
                        <p class="h4">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6>Selesai</h6>
                        <p class="h4">{{ $completedOrders }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6>Dibatalkan</h6>
                        <p class="h4">{{ $cancelledOrders }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h6>Top Menu</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Jumlah Terjual</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topMenus as $topMenu)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $topMenu->name }}</td>
                        <td>{{ $topMenu->order_details_count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
