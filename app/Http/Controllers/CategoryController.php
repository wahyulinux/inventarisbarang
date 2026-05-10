<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:categories'
        ]);
        Category::create($request->only('name', 'code'));
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:categories,code,'.$category->id
        ]);
        $category->update($request->only('name', 'code'));
        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->items()->count() > 0) {
            return back()->with('error', 'Gagal menghapus kategori. Masih digunakan oleh barang.');
        }
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
