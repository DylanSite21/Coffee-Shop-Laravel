<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $menus = Menu::with('category')
            ->where('status', 'approved')
            ->where('is_available', true)
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        return view('home', compact('categories', 'menus'));
    }
}
