<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $menus = Menu::with('category')
            ->where('status', 'pending')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->paginate(10);

        return view('admin.approvals.index', compact('menus', 'search'));
    }

    public function approve(Menu $menu)
    {
        $menu->update(['status' => 'approved']);

        return back()->with('success', 'Menu berhasil disetujui.');
    }

    public function reject(Menu $menu)
    {
        $menu->update(['status' => 'rejected']);

        return back()->with('success', 'Menu berhasil ditolak.');
    }
}
