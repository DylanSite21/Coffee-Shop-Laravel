<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cart = $user->carts()->where('status', 'active')->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id, 'total' => 0, 'status' => 'active']);
        }

        $cart->load('cartItems.menu');

        return view('user.cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user();
        $menu = Menu::findOrFail($request->menu_id);
        $cart = $user->carts()->where('status', 'active')->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id, 'total' => 0, 'status' => 'active']);
        }

        $cartItem = $cart->cartItems()->where('menu_id', $menu->id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            $cartItem->update([
                'quantity' => $newQuantity,
                'subtotal' => $newQuantity * $menu->price,
            ]);
        } else {
            $cart->cartItems()->create([
                'menu_id' => $menu->id,
                'quantity' => $request->quantity,
                'price' => $menu->price,
                'subtotal' => $request->quantity * $menu->price,
            ]);
        }

        $this->updateCartTotal($cart);

        return redirect()->route('user.cart.index')->with('success', 'Menu berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->update([
            'quantity' => $request->quantity,
            'subtotal' => $request->quantity * $cartItem->price,
        ]);

        $this->updateCartTotal($cartItem->cart);

        return redirect()->route('user.cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart = $cartItem->cart;
        $cartItem->delete();
        $this->updateCartTotal($cart);

        return redirect()->route('user.cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    private function updateCartTotal(Cart $cart)
    {
        $total = $cart->cartItems()->sum('subtotal');
        $cart->update(['total' => $total]);
    }
}
