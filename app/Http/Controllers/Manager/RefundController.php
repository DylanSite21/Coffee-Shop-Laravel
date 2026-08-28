<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $refunds = Refund::with(['order.user', 'user'])
            ->when($search, fn($q) => $q->whereHas('order', fn($q2) => $q2->where('order_number', 'like', "%{$search}%"))
                ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%")))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

        return view('manager.refunds.index', compact('refunds', 'search', 'status'));
    }

    public function approve(Refund $refund)
    {
        if ($refund->status !== 'pending') {
            return back()->with('error', 'Refund ini sudah diproses sebelumnya.');
        }

        $refund->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Update order status to refunded
        $refund->order->update([
            'status' => 'refunded',
            'payment_status' => 'failed',
        ]);

        return back()->with('success', 'Refund berhasil disetujui. Dana akan dikembalikan ke customer.');
    }

    public function reject(Request $request, Refund $refund)
    {
        if ($refund->status !== 'pending') {
            return back()->with('error', 'Refund ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'rejected_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $refund->update([
            'status' => 'rejected',
            'rejected_reason' => $request->rejected_reason ?? 'Ditolak oleh manager.',
        ]);

        return back()->with('success', 'Refund berhasil ditolak.');
    }
}
