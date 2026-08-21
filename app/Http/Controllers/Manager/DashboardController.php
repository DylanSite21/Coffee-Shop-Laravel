<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
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
            'incomingOrders' => Order::where('status', 'pending')->count(),
            'processingOrders' => Order::where('status', 'processing')->count(),
            'completedOrders' => Order::where('status', 'completed')->count(),
        ];

        return view('manager.dashboard', $data);
    }
}
