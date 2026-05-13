<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['category', 'warehouse']);

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->latest()->get();
        $categories = Category::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        return view('items.index', compact('items', 'categories', 'warehouses'));
    }

    public function print(Request $request)
    {
        $query = Item::with(['category', 'warehouse']);

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->orderBy('name', 'asc')->get();
        $warehouse = $request->warehouse_id ? Warehouse::find($request->warehouse_id) : null;
        $category = $request->category_id ? Category::find($request->category_id) : null;

        return view('items.print', compact('items', 'warehouse', 'category'));
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

        // Jika staff gudang, paksa warehouse_id ke gudang mereka
        if (Auth::user()->warehouse_id) {
            $data['warehouse_id'] = Auth::user()->warehouse_id;
        }

        if (empty($data['sku'])) {
            $category = Category::find($data['category_id']);
            $warehouse = Warehouse::find($data['warehouse_id']);
            
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
        if (Auth::user()->warehouse_id) {
            return back()->with('error', 'Staff gudang hanya diperbolehkan melihat daftar barang.');
        }

        $data = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:items,sku,'.$item->id,
            'category_id' => 'nullable|exists:categories,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'description' => 'nullable'
        ]);
        $item->update($data);
        return back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        if (Auth::user()->warehouse_id) {
            return back()->with('error', 'Staff gudang tidak diperbolehkan menghapus barang.');
        }

        $item->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }
}
