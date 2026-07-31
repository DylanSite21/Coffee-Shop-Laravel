<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman home
     */
    public function index()
    {
        // 1. Ambil semua kategori yang aktif
        $categories = Category::where('is_active', true)
                            ->withCount('menus')
                            ->get();

        // 2. Ambil menu yang sudah approved dan available (6 menu terbaru)
        $menus = Menu::with('category')
                    ->where('status', 'approved')
                    ->where('is_available', true)
                    ->orderBy('created_at', 'desc')
                    ->limit(6)
                    ->get();

        // 3. Hitung total menu untuk statistik
        $totalMenus = Menu::where('status', 'approved')
                        ->where('is_available', true)
                        ->count();

        // 4. Hitung total kategori
        $totalCategories = Category::where('is_active', true)->count();

        // 5. Kirim data ke view
        return view('home', compact(
            'categories', 
            'menus', 
            'totalMenus', 
            'totalCategories'
        ));
    }
}