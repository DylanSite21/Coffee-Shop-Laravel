@extends('layouts.app')

@section('title', 'Detail Menu')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $menu->name }}</h5>
        <p><strong>Kategori:</strong> {{ $menu->category->name ?? '-' }}</p>
        <p><strong>Harga:</strong> Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
        <p><strong>Deskripsi:</strong> {{ $menu->description }}</p>
        <p><strong>Status:</strong> {{ ucfirst($menu->status) }}</p>
        <a href="{{ route('manager.menus.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
