<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categorySlug = $request->input('category');

        $menus = Menu::with('category')
            ->where('status', 'approved')
            ->where('is_available', true)
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($categorySlug, fn($q) => $q->whereHas('category', fn($q2) => $q2->where('slug', $categorySlug)))
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();

        return view('user.menus.index', compact('menus', 'categories', 'search', 'categorySlug'));
    }

    public function show(Menu $menu)
    {
        if ($menu->status !== 'approved' || !$menu->is_available) {
            abort(404);
        }

        $menu->load('category');
        return view('user.menus.show', compact('menu'));
    }
}
