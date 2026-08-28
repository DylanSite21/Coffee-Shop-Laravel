<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $menus = Menu::with('category')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->paginate(10);

        return view('manager.menus.index', compact('menus', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('manager.menus.create', compact('categories'));
    }

    public function store(MenuRequest $request)
    {
        $menu = Menu::create(array_merge($request->validated(), ['user_id' => auth()->id()]));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $menu->update(['image' => $path]);
        }

        return redirect()->route('manager.menus.index')->with('success', 'Menu berhasil diajukan.');
    }

    public function show(Menu $menu)
    {
        $menu->load('category');
        return view('manager.menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('manager.menus.edit', compact('menu', 'categories'));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menus', 'public');
            $menu->update(['image' => $path]);
        }

        return redirect()->route('manager.menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('manager.menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}
