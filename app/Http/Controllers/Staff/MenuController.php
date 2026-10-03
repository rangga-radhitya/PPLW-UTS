<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->latest()->get();
        return view('staff.menu.index', compact('menus'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('staff.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect('/staff/menu')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $categories = Category::orderBy('name')->get();
        return view('staff.menu.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect('/staff/menu')->with('success', 'Menu berhasil diubah.');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }
        $menu->delete();

        return redirect('/staff/menu')->with('success', 'Menu berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|integer|min:0',
            'image'        => 'nullable|image|max:2048',
            'is_available' => 'required|in:0,1',
        ]);
    }

    // Ubah ketersediaan menu
    // URL: PATCH /staff/menu/{id}/ketersediaan  (field: is_available)
    public function ketersediaan(\Illuminate\Http\Request $request, $id)
    {
        $data = $request->validate([
            'is_available' => ['required', 'boolean'],
        ]);

        $menu = \App\Models\Menu::findOrFail($id);
        $menu->update(['is_available' => $data['is_available']]);

        return back()->with('success', $menu->name . ($menu->is_available ? ' tersedia lagi.' : ' ditandai habis.'));
    }
}
