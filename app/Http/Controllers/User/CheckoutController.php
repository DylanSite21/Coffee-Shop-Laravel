<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cart = $user->carts()->where('status', 'active')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $cart->load('cartItems.menu');

        return view('user.checkout', compact('cart'));
    }

    public function store(OrderRequest $request)
    {
        $user = auth()->user();
        $cart = $user->carts()->where('status', 'active')->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $cart->loadMissing('cartItems.menu');

        // Check stock availability for each item in cart
        foreach ($cart->cartItems as $item) {
            if (!$item->menu || $item->menu->stock <= 0 || !$item->menu->is_available) {
                return redirect()->route('user.cart.index')->with('error', 'Menu "' . ($item->menu->name ?? 'item') . '" saat ini sudah habis. Silakan hapus atau perbarui keranjang Anda.');
            }
            if ($item->quantity > $item->menu->stock) {
                return redirect()->route('user.cart.index')->with('error', 'Stok untuk menu "' . $item->menu->name . '" tidak mencukupi untuk jumlah yang dipesan.');
            }
        }

        $validated = $request->validated();
        $orderNumber = 'ORD-' . strtoupper(uniqid());

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => $user->id,
            'total' => $cart->total,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'] ?? null,
            'shipping_address' => $validated['shipping_address'],
            'phone' => $validated['phone'],
        ]);

        foreach ($cart->cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'menu_id' => $item->menu_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->subtotal,
            ]);
        }

        Payment::create([
            'order_id' => $order->id,
            'amount' => $cart->total,
            'method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        $cart->update(['status' => 'checkout']);

        return redirect()->route('user.orders.index')->with('success', 'Pesanan berhasil dibuat. Nomor pesanan: ' . $orderNumber);
    }
}
