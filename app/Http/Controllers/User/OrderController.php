<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $orders = Order::with('orderDetails.menu')
            ->where('user_id', auth()->id())
            ->when($search, fn($q) => $q->where('order_number', 'like', "%{$search}%"))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders', 'search', 'status'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('orderDetails.menu', 'payment');
        return view('user.orders.show', compact('order'));
    }
}
