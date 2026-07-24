@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-3">Keranjang Belanja</h5>

        @if($cart->cartItems->isEmpty())
            <div class="alert alert-info">Keranjang Anda kosong.</div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart->cartItems as $item)
                        <tr>
                            <td>{{ $item->menu->name ?? '-' }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('user.cart.update', $item) }}" method="POST" class="d-flex">
                                    @csrf @method('PUT')
                                    <input type="number" name="quantity" class="form-control me-2" value="{{ $item->quantity }}" min="1" style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-warning">Update</button>
                                </form>
                            </td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('user.cart.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center">
                <h5>Total: Rp {{ number_format($cart->total, 0, ',', '.') }}</h5>
                <a href="{{ route('user.checkout.index') }}" class="btn btn-coffee">Checkout</a>
            </div>
        @endif
    </div>
</div>
@endsection
