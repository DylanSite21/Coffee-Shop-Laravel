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

        if ($menu->stock <= 0 || !$menu->is_available) {
            return back()->with('error', 'Maaf, stok ' . $menu->name . ' sedang habis dan tidak dapat dipesan.');
        }

        $cart = $user->carts()->where('status', 'active')->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id, 'total' => 0, 'status' => 'active']);
        }

        $cartItem = $cart->cartItems()->where('menu_id', $menu->id)->first();
        $targetQuantity = $cartItem ? ($cartItem->quantity + $request->quantity) : $request->quantity;

        if ($targetQuantity > $menu->stock) {
            return back()->with('error', 'Maaf, jumlah pesanan untuk ' . $menu->name . ' melebihi stok yang tersedia.');
        }

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $targetQuantity,
                'subtotal' => $targetQuantity * $menu->price,
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
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $cartItem->loadMissing('menu');
        if ($cartItem->menu && $request->quantity > $cartItem->menu->stock) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['error' => 'Jumlah melebihi stok yang tersedia.'], 422);
            }
            return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $cartItem->update([
            'quantity' => $request->quantity,
            'subtotal' => $request->quantity * $cartItem->price,
        ]);

        $this->updateCartTotal($cartItem->cart);

        $cart = $cartItem->cart->fresh(['cartItems']);
        $cartCount = $cart->cartItems->sum('quantity');

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil diperbarui.',
                'item_id' => $cartItem->id,
                'item_quantity' => $cartItem->quantity,
                'item_subtotal' => 'Rp ' . number_format($cartItem->subtotal, 0, ',', '.'),
                'cart_total' => 'Rp ' . number_format($cart->total, 0, ',', '.'),
                'cart_count' => $cartCount,
            ]);
        }

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
