<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function store(Request $request, Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only QRIS orders can be refunded
        if ($order->payment_method !== 'qris') {
            return back()->with('error', 'Refund hanya tersedia untuk metode pembayaran QRIS.');
        }

        // Refund can only be requested when the order is still pending (baru dipesan dan belum dikonfirmasi manager)
        if ($order->status !== 'pending') {
            return back()->with('error', 'Refund hanya bisa diajukan ketika pesanan masih berstatus pending (belum dikonfirmasi oleh manager).');
        }

        // Check if refund already exists
        if ($order->refund) {
            return back()->with('error', 'Anda sudah mengajukan refund untuk pesanan ini.');
        }

        $request->validate([
            'reason' => ['required', 'string', 'max:1000'],
        ], [
            'reason.required' => 'Alasan refund wajib diisi.',
        ]);

        Refund::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'amount' => $order->total,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan refund berhasil dikirim. Menunggu persetujuan dari manager.');
    }
}
