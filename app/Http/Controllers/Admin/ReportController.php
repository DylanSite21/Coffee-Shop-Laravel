<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ? \Carbon\Carbon::parse($request->input('start_date')) : \Carbon\Carbon::now()->subDays(30);
        $endDate = $request->input('end_date') ? \Carbon\Carbon::parse($request->input('end_date')) : \Carbon\Carbon::now();

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();
        $totalRevenue = $orders->where('payment_status', 'paid')->sum('total');
        $totalOrders = $orders->count();
        $completedOrders = $orders->where('status', 'completed')->count();
        $cancelledOrders = $orders->where('status', 'cancelled')->count();

        $topMenus = Menu::withCount('orderDetails')
            ->orderByDesc('order_details_count')
            ->take(10)
            ->get();

        return view('admin.reports.index', compact('orders', 'totalRevenue', 'totalOrders', 'completedOrders', 'cancelledOrders', 'topMenus', 'startDate', 'endDate'));
    }
}
