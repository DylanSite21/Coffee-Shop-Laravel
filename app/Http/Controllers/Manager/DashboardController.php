<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Refund;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalMenus' => Menu::count(),
            'pendingMenus' => Menu::where('status', 'pending')->count(),
            'approvedMenus' => Menu::where('status', 'approved')->count(),
            'rejectedMenus' => Menu::where('status', 'rejected')->count(),
            'incomingOrders' => Order::where('status', 'pending')->whereDoesntHave('refund', fn($q) => $q->where('status', 'pending'))->count(),
            'processingOrders' => Order::where('status', 'processing')->count(),
            'completedOrders' => Order::where('status', 'completed')->count(),
            'pendingRefunds' => Refund::where('status', 'pending')->count(),
            'totalRefunded' => Order::where('status', 'refunded')->count(),
        ];

        return view('manager.dashboard', $data);
    }
}
