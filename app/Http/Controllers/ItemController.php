<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['category', 'warehouse'])->latest()->get();
        $categories = Category::orderBy('name')->get();
        $warehouses = \App\Models\Warehouse::orderBy('name')->get();
        return view('items.index', compact('items', 'categories', 'warehouses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'nullable|unique:items',
            'category_id' => 'nullable|exists:categories,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'price' => 'numeric',
            'description' => 'nullable'
        ]);

        if (empty($data['sku'])) {
            $category = \App\Models\Category::find($data['category_id']);
            $warehouse = \App\Models\Warehouse::find($data['warehouse_id']);
            
            $prefix = ($warehouse ? $warehouse->code : 'XXX') . '-' . ($category ? $category->code : 'YYY');
            
            // Get last item count with this prefix
            $count = Item::where('sku', 'like', $prefix . '-%')->count();
            $data['sku'] = $prefix . '-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        }

        Item::create($data);
        return back()->with('success', 'Barang berhasil ditambahkan dengan SKU: ' . $data['sku']);
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:items,sku,'.$item->id,
            'category_id' => 'nullable|exists:categories,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
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
