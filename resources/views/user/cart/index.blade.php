@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="cart-page fade-in-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">Keranjang Belanja</h2>
        @if(!$cart->cartItems->isEmpty())
            <span class="text-muted-custom" id="cart-item-count">{{ $cart->cartItems->count() }} item</span>
        @endif
    </div>

    @if($cart->cartItems->isEmpty())
        <div class="empty-cart-card text-center py-5">
            <div class="empty-cart-icon">
                <i class="bi bi-bag-x"></i>
            </div>
            <h5 class="text-coffee mb-2">Keranjang Anda kosong</h5>
            <p class="text-muted-custom mb-4">Sepertinya Anda belum menambahkan menu apapun.</p>
            <a href="{{ route('user.menus.index') }}" class="btn btn-coffee">
                <i class="bi bi-cup-hot me-2"></i>Lihat Menu
            </a>
        </div>
    @else
        <div class="cart-items">
            @foreach($cart->cartItems as $item)
                <div class="cart-item-card mb-3" id="cart-item-card-{{ $item->id }}">
                    <div class="cart-item-row">
                        <div class="cart-item-info">
                            <h6 class="cart-item-name mb-1">{{ $item->menu->name ?? '-' }}</h6>
                            <p class="cart-item-price mb-0">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>

                        <form action="{{ route('user.cart.update', $item) }}" method="POST" id="updateCart-{{ $item->id }}" class="cart-quantity-form">
                            @csrf @method('PUT')
                            <div class="quantity-stepper">
                                <button type="button" class="qty-btn" onclick="decrementQuantity(this.closest('.quantity-stepper').querySelector('input'))">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" name="quantity" class="form-control cart-quantity-input" value="{{ $item->quantity }}" min="1" data-cart-item-id="{{ $item->id }}">
                                <button type="button" class="qty-btn" onclick="incrementQuantity(this.closest('.quantity-stepper').querySelector('input'))">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </form>

                        <div class="cart-item-subtotal">
                            <span class="subtotal-label">Subtotal</span>
                            <span class="subtotal-value" id="subtotal-{{ $item->id }}">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>

                        <form action="{{ route('user.cart.destroy', $item) }}" method="POST" id="removeCart-{{ $item->id }}" onsubmit="return confirmDelete(event, 'Yakin hapus item ini dari keranjang?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-remove">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="cart-summary mt-4">
            <div class="summary-card">
                <div class="summary-row total-row">
                    <span class="fw-semibold">Total</span>
                    <span class="total-value" id="cart-total">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('user.checkout.index') }}" class="btn btn-coffee btn-checkout w-100 mt-3">
                    <i class="bi bi-bag-check me-2"></i>Checkout
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
