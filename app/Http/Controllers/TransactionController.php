<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['item', 'user', 'warehouse'])->latest()->get();
        $items = Item::orderBy('name')->get();
        return view('transactions.index', compact('transactions', 'items'));
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
