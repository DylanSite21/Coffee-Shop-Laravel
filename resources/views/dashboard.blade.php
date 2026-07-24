@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-coffee">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text display-4">0</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-coffee-light">
            <div class="card-body">
                <h5 class="card-title">Total Menus</h5>
                <p class="card-text display-4">0</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background-color: #A3B18A;">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <p class="card-text display-4">0</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background-color: #6F4E37;">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <p class="card-text display-4">Rp 0</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Selamat Datang di Coffee Shop Management System</h5>
        <p class="card-text">Gunakan sidebar untuk navigasi.</p>
    </div>
</div>
@endsection
