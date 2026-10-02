<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Daftar menu + filter kategori + pencarian
    // URL: /menu?kategori=1&cari=katsu
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Menu::with('category');

        if ($request->filled('kategori')) {
            $query->where('category_id', $request->kategori);
        }

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        $menus = $query->orderBy('name')->get();

        return view('customer.menu', compact('menus', 'categories'));
    }

    // Detail satu menu
    // URL: /menu/5
    public function show($id)
    {
        $menu = Menu::with('category')->findOrFail($id);

        return view('customer.detail-menu', compact('menu'));
    }
}
