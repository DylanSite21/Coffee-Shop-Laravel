<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $recentOrders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        $cartCount = 0;

        $cart = $user->carts()->where('status', 'active')->first();
        if ($cart) {
            $cartCount = $cart->cartItems()->sum('quantity');
        }

        $totalOrders = Order::where('user_id', $user->id)->count();

        return view('user.dashboard', compact('recentOrders', 'cartCount', 'totalOrders'));
    }
}
