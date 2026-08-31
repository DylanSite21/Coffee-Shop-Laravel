<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $orders = Order::with(['user', 'orderDetails.menu', 'refund'])
            ->when($search, fn($q) => $q->where('order_number', 'like', "%{$search}%")->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%")))
            ->when($status, function($q, $status) {
                if ($status === 'refund_pending') {
                    $q->whereHas('refund', fn($rq) => $rq->where('status', 'pending'));
                } elseif ($status === 'normal') {
                    $q->whereDoesntHave('refund', fn($rq) => $rq->where('status', 'pending'))->where('status', '!=', 'refunded');
                } else {
                    $q->where('status', $status);
                }
            })
            ->latest()
            ->paginate(10);

        return view('manager.orders.index', compact('orders', 'search', 'status'));
    }

    public function accept(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan ini tidak dapat diterima.');
        }

        // If order has pending refund, alert manager
        if ($order->refund && $order->refund->status === 'pending') {
            return back()->with('error', 'Pesanan ini memiliki pengajuan refund aktif. Silakan setujui/tolak refund terlebih dahulu.');
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
        return $this->complete($order);
    }

    public function complete(Order $order)
    {
        if ($order->status !== 'processing') {
            return back()->with('error', 'Pesanan ini tidak dapat diselesaikan.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'completed']);

            // Deduct stock for each menu in this order
            $order->loadMissing('orderDetails.menu');
            foreach ($order->orderDetails as $detail) {
                if ($detail->menu) {
                    $newStock = max(0, (int) $detail->menu->stock - (int) $detail->quantity);
                    $detail->menu->update(['stock' => $newStock]);
                }
            }
        });

        return back()->with('success', 'Pesanan berhasil diselesaikan dan stok menu telah otomatis dikurangi.');
    }
}
