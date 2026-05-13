@extends('layouts.app')

@section('title', 'Kelola Barang')

@section('content')
<div x-data="{ 
    openModal: false, 
    editMode: false,
    item: { id: '', name: '', sku: '', category_id: '', warehouse_id: '{{ auth()->user()->warehouse_id }}', description: '' },
    openEdit(data) {
        this.item = { ...data };
        this.editMode = true;
        this.openModal = true;
    },
    openAdd() {
        this.item = { id: '', name: '', sku: '', category_id: '', warehouse_id: '{{ auth()->user()->warehouse_id }}', description: '' };
        this.editMode = false;
        this.openModal = true;
    }
}">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h3 class="text-xl font-bold text-gray-800">Daftar Barang</h3>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <a href="{{ route('items.print', request()->query()) }}" target="_blank" class="flex-1 md:flex-none inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <i class="bi bi-printer mr-2"></i> Cetak
            </a>
            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
            <button @click="openAdd()" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition shadow-sm w-full md:w-auto">
                <i class="bi bi-plus-lg mr-2"></i> Tambah Barang
            </button>
            @endif
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <form action="{{ route('items.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Filter Gudang</label>
                <select name="warehouse_id" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Gudang</option>
                    @foreach($warehouses as $w)
                    <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>
                        {{ $w->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Filter Kategori</label>
                <select name="category_id" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2 md:col-span-2">
                <button type="submit" class="inline-flex justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition w-full md:w-auto">
                    Filter
                </button>
                <a href="{{ route('items.index') }}" class="inline-flex justify-center px-4 py-2 bg-gray-100 border border-transparent rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-200 transition w-full md:w-auto">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Gudang</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                        @if((auth()->user()->isAdmin() || auth()->user()->isStaff()) && !auth()->user()->warehouse_id)
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($items as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                            {{ $item->sku }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $item->category->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $item->warehouse->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->stock <= 0)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-2.5 h-2.5 mr-2 bg-red-600 rounded-full animate-pulse"></span>
                                    <span class="text-lg font-black mr-2">0</span>
                                    <span class="text-xs font-bold uppercase tracking-wider opacity-70">Habis</span>
                                </span>
                            @elseif($item->stock < 5)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-orange-50 text-orange-700 border border-orange-200">
                                    <span class="w-2.5 h-2.5 mr-2 bg-orange-500 rounded-full"></span>
                                    <span class="text-lg font-black mr-2">{{ $item->stock }}</span>
                                    <span class="text-xs font-bold uppercase tracking-wider opacity-70">Kritis</span>
                                </span>
                            @elseif($item->stock < 10)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-200">
                                    <span class="w-2.5 h-2.5 mr-2 bg-yellow-500 rounded-full"></span>
                                    <span class="text-lg font-black mr-2">{{ $item->stock }}</span>
                                    <span class="text-xs font-bold uppercase tracking-wider opacity-70">Menipis</span>
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-2.5 h-2.5 mr-2 bg-emerald-500 rounded-full"></span>
                                    <span class="text-lg font-black mr-2">{{ $item->stock }}</span>
                                    <span class="text-xs font-bold uppercase tracking-wider opacity-70">Banyak</span>
                                </span>
                            @endif
                        </td>
                        @if((auth()->user()->isAdmin() || auth()->user()->isStaff()) && !auth()->user()->warehouse_id)
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <button @click='openEdit(@json($item))' class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 p-2 rounded-lg transition">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 p-2 rounded-lg transition">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">
                            Belum ada data barang.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form (Add/Edit) -->
    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="openModal" @click="openModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="openModal" 
                 class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form :action="editMode ? '/items/' + item.id : '{{ route('items.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        @method('PUT')
                    </template>
                    
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-900" x-text="editMode ? 'Edit Barang' : 'Tambah Barang'"></h3>
                            <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-500">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                                <input type="text" name="name" x-model="item.name" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">SKU</label>
                                <input type="text" name="sku" x-model="item.sku" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Biarkan kosong untuk generate otomatis">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                                    <select name="category_id" x-model="item.category_id" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Gudang</label>
                                    <select name="warehouse_id" x-model="item.warehouse_id" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 {{ auth()->user()->warehouse_id ? 'bg-gray-100 cursor-not-allowed' : '' }}" {{ auth()->user()->warehouse_id ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Gudang --</option>
                                        @foreach($warehouses as $w)
                                        <option value="{{ $w->id }}" {{ auth()->user()->warehouse_id == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                                        @endforeach
                                    </select>
                                    @if(auth()->user()->warehouse_id)
                                        <input type="hidden" name="warehouse_id" value="{{ auth()->user()->warehouse_id }}">
                                        <p class="text-xs text-gray-500 mt-1">* Otomatis ke gudang Anda</p>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                                <textarea name="description" x-model="item.description" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit" class="inline-flex justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition shadow-sm">
                            Simpan
                        </button>
                        <button type="button" @click="openModal = false" class="inline-flex justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
