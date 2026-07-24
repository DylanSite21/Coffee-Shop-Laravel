<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $orders = Order::with('user')
            ->when($search, fn($q) => $q->where('order_number', 'like', "%{$search}%")->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%")))
            ->when($status, fn($q) => $q->where('status', $status))
            ->paginate(10);

        return view('manager.orders.index', compact('orders', 'search', 'status'));
    }

    public function accept(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan ini tidak dapat diterima.');
        }

        $order->update(['status' => 'processing']);

        return back()->with('success', 'Pesanan berhasil diterima dan sedang diproses.');
    }

    public function reject(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan ini tidak dapat ditolak.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil ditolak.');
    }

    public function process(Order $order)
    {
        if ($order->status !== 'processing') {
            return back()->with('error', 'Pesanan ini tidak dapat diproses.');
        }

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Pesanan berhasil diselesaikan.');
    }

    public function complete(Order $order)
    {
        if ($order->status !== 'processing') {
            return back()->with('error', 'Pesanan ini tidak dapat diselesaikan.');
        }

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Pesanan berhasil diselesaikan.');
    }
}
