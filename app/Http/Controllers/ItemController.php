<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();
        return view('items.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:items',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'numeric',
            'description' => 'nullable'
        ]);
        Item::create($data);
        return back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:items,sku,'.$item->id,
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'numeric',
            'description' => 'nullable'
        ]);
        $item->update($data);
        return back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }
}
