<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('menus')->orderBy('name')->get();
        return view('staff.kategori.index', compact('categories'));
    }

    public function create()
    {
        return view('staff.kategori.create');
    }

    public function store(Request $request)
    {
        Category::create($request->validate(['name' => 'required|string|max:255']));
        return redirect('/staff/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('staff.kategori.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->validate(['name' => 'required|string|max:255']));
        return redirect('/staff/kategori')->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(Category $category)
    {
        if ($category->menus()->exists()) {
            return back()->with('error', 'Kategori masih dipakai menu, tidak bisa dihapus.');
        }

        $category->delete();
        return redirect('/staff/kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
