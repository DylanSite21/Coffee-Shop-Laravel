<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil orders
        $orders = $user->orders()->orderBy('created_at', 'desc')->limit(5)->get();
        $orderCount = $user->orders()->count();
        
        // HAPUS total_spent - pake 0 aja
        $totalSpent = 0;
        
        // Cart count pake dummy
        $cartCount = 0;
        
        return view('user.dashboard', compact(
            'user',
            'orders',
            'orderCount',
            'totalSpent',
            'cartCount'
        ));
    }
}