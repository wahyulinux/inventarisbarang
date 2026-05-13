@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card Total Barang -->
    <div class="bg-blue-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <h5 class="text-lg font-semibold opacity-80">Total Barang</h5>
            <i class="bi bi-box text-2xl"></i>
        </div>
        <p class="text-4xl font-bold">{{ $itemCount }}</p>
    </div>

    <!-- Card Total Kategori -->
    <div class="bg-green-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <h5 class="text-lg font-semibold opacity-80">Total Kategori</h5>
            <i class="bi bi-tags text-2xl"></i>
        </div>
        <p class="text-4xl font-bold">{{ $categoryCount }}</p>
    </div>

    <!-- Card Total Transaksi -->
    <div class="bg-sky-500 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <h5 class="text-lg font-semibold opacity-80">Total Transaksi</h5>
            <i class="bi bi-arrow-left-right text-2xl"></i>
        </div>
        <p class="text-4xl font-bold">{{ $transactionCount }}</p>
    </div>

    <!-- Card Stok Rendah -->
    <a href="{{ route('items.index', ['warehouse_id' => '', 'stock_status' => 'low']) }}" class="block transform hover:scale-105 transition duration-300">
        <div class="bg-red-600 rounded-xl shadow-sm p-6 text-white relative overflow-hidden">
            <div class="flex items-center justify-between mb-4 relative z-10">
                <h5 class="text-lg font-semibold opacity-80">Stok Rendah</h5>
                <i class="bi bi-exclamation-triangle text-2xl"></i>
            </div>
            <p class="text-4xl font-bold relative z-10">{{ $lowStockCount }}</p>
            <div class="absolute -right-4 -bottom-4 opacity-10">
                <i class="bi bi-exclamation-triangle-fill text-8xl"></i>
            </div>
        </div>
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h4 class="text-lg font-bold text-gray-800">Transaksi Terakhir</h4>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Oleh</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentTransactions as $row)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $row->created_at->format('d M Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $row->item->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $row->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ strtoupper($row->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                        {{ $row->quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $row->user->username }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                        Belum ada transaksi terbaru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
