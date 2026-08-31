@extends('layouts.app')

@section('title', 'Detail Menu')

@section('content')
<div class="menu-detail-page fade-in-up" style="max-width: 720px;">
    {{-- Back Button --}}
    <a href="{{ route('user.menus.index') }}" class="btn btn-outline-coffee btn-sm mb-3">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Menu
    </a>

    <div class="menu-detail-card">
        {{-- Image --}}
        @if($menu->image)
            <div class="menu-detail-image">
                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
            </div>
        @endif

        <div class="menu-detail-body">
            {{-- Category Badge --}}
            @if($menu->category)
                <span class="menu-detail-category">{{ $menu->category->name }}</span>
            @endif

            {{-- Name --}}
            <h3 class="menu-detail-name">{{ $menu->name }}</h3>

            {{-- Price --}}
            <div class="menu-detail-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>

            {{-- Description --}}
            @if($menu->description)
                <div class="menu-detail-desc">
                    <p>{{ $menu->description }}</p>
                </div>
            @endif

            {{-- Add to Cart Form or Out of Stock Alert --}}
            @if($menu->stock <= 0)
                <div class="alert alert-danger d-flex align-items-center gap-2 mt-4 mb-2" role="alert">
                    <i class="bi bi-slash-circle-fill fs-5"></i>
                    <div>
                        <strong>Stok Habis:</strong> Menu ini saat ini sedang tidak tersedia untuk dipesan.
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-secondary w-100 py-2" disabled>
                        <i class="bi bi-slash-circle me-1"></i>Stok Habis — Tidak Dapat Dipesan
                    </button>
                </div>
            @else
                <form action="{{ route('user.cart.store') }}" method="POST" class="menu-detail-form mt-3">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <label class="form-label mb-1 small fw-semibold text-brown">Jumlah</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required style="max-width: 100px;">
                        </div>
                        <div class="flex-grow-0 align-self-end">
                            <button type="submit" class="btn btn-coffee">
                                <i class="bi bi-cart-plus me-1"></i>Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
