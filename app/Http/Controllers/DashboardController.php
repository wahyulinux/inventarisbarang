<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'itemCount' => Item::count(),
            'categoryCount' => Category::count(),
            'transactionCount' => Transaction::count(),
            'lowStockCount' => Item::where('stock', '<', 10)->count(),
            'recentTransactions' => Transaction::with(['item', 'user'])->latest()->limit(5)->get()
        ];
        return view('dashboard', $data);
    }
}
