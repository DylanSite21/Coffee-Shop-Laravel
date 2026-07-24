@extends('layouts.app')

@section('title', 'Detail Menu')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $menu->name }}</h5>
        <p><strong>Kategori:</strong> {{ $menu->category->name ?? '-' }}</p>
        <p><strong>Harga:</strong> Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
        <p><strong>Deskripsi:</strong> {{ $menu->description }}</p>

        <form action="{{ route('user.cart.store') }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
            <div class="mb-3">
                <label class="form-label">Jumlah</label>
                <input type="number" name="quantity" class="form-control" value="1" min="1" required>
            </div>
            <button type="submit" class="btn btn-coffee">Tambah ke Keranjang</button>
        </form>

        <a href="{{ route('user.menus.index') }}" class="btn btn-secondary mt-2">Kembali ke Menu</a>
    </div>
</div>
@endsection
