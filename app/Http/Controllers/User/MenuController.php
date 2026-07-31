<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Tampilkan halaman explore menu
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk filter
        $categories = Category::where('is_active', true)->get();

        // 2. Query menu
        $query = Menu::with('category')
                    ->where('status', 'approved')
                    ->where('is_available', true);

        // 3. Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // 4. Search berdasarkan nama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 5. Sort
        $sort = $request->sort ?? 'terbaru';
        switch ($sort) {
            case 'termurah':
                $query->orderBy('price', 'asc');
                break;
            case 'termahal':
                $query->orderBy('price', 'desc');
                break;
            case 'terpopuler':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // 6. Pagination (9 per halaman)
        $menus = $query->paginate(9);

        // 7. Kirim ke view
        return view('user.menus.index', compact('menus', 'categories'));
    }

    /**
     * Tampilkan detail menu
     */
    public function show(Menu $menu)
    {
        // Cek apakah menu approved dan available
        if ($menu->status !== 'approved' || !$menu->is_available) {
            abort(404);
        }

        // Ambil menu lain yang related (same category)
        $relatedMenus = Menu::where('category_id', $menu->category_id)
                          ->where('id', '!=', $menu->id)
                          ->where('status', 'approved')
                          ->where('is_available', true)
                          ->limit(4)
                          ->get();

        return view('user.menus.show', compact('menu', 'relatedMenus'));
    }
}