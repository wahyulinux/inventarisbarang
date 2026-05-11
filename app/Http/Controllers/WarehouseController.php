<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        return view('warehouses.index', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:warehouses',
            'address' => 'nullable',
            'description' => 'nullable'
        ]);
        Warehouse::create($data);
        return back()->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $data = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:warehouses,code,'.$warehouse->id,
            'address' => 'nullable',
            'description' => 'nullable'
        ]);
        $warehouse->update($data);
        return back()->with('success', 'Gudang berhasil diperbarui.');
    }

    public function destroy(Warehouse $warehouse)
    {
        if ($warehouse->items()->count() > 0) {
            return back()->with('error', 'Gagal menghapus gudang. Masih ada barang di gudang ini.');
        }
        $warehouse->delete();
        return back()->with('success', 'Gudang berhasil dihapus.');
    }
}
