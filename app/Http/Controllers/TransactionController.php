<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['item', 'user', 'warehouse']);

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->filled('bulan')) {
            $parts = explode('-', $request->bulan);
            if (count($parts) === 2) {
                $query->whereYear('created_at', $parts[0])
                      ->whereMonth('created_at', $parts[1]);
            }
        }

        $transactions = $query->latest()->get();
        $items = Item::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();

        return view('transactions.index', compact('transactions', 'items', 'warehouses'));
    }

    public function print(Request $request)
    {
        $query = Transaction::with(['item', 'user', 'warehouse']);

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->filled('bulan')) {
            $parts = explode('-', $request->bulan);
            if (count($parts) === 2) {
                $query->whereYear('created_at', $parts[0])
                      ->whereMonth('created_at', $parts[1]);
            }
        }

        $transactions = $query->orderBy('created_at', 'asc')->get();
        $warehouse = $request->warehouse_id ? Warehouse::find($request->warehouse_id) : null;
        $bulan = $request->bulan;

        return view('transactions.print', compact('transactions', 'warehouse', 'bulan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $item = Item::findOrFail($data['item_id']);

            // Restriction: User can only transact items in their assigned warehouse
            if (Auth::user()->warehouse_id && Auth::user()->warehouse_id != $item->warehouse_id) {
                return back()->with('error', 'Anda hanya diperbolehkan melakukan transaksi untuk barang di gudang Anda sendiri.');
            }

            if ($data['type'] === 'out' && $item->stock < $data['quantity']) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }

            Transaction::create([
                'item_id' => $data['item_id'],
                'user_id' => Auth::id(),
                'warehouse_id' => $item->warehouse_id,
                'type' => $data['type'],
                'quantity' => $data['quantity'],
                'note' => $data['note']
            ]);

            if ($data['type'] === 'in') {
                $item->increment('stock', $data['quantity']);
            } else {
                $item->decrement('stock', $data['quantity']);
            }

            DB::commit();
            return back()->with('success', 'Transaksi berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
