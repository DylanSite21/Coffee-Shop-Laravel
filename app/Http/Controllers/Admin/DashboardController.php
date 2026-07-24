<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalMenus' => Menu::count(),
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::where('payment_status', 'paid')->sum('total'),
            'approvedMenus' => Menu::approved()->count(),
            'pendingMenus' => Menu::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', $data);
    }
}
