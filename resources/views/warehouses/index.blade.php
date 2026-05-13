@extends('layouts.app')

@section('title', 'Kelola Gudang')

@section('content')
<div x-data="{ 
    openModal: false, 
    editMode: false,
    warehouse: { id: '', code: '', name: '', address: '', description: '' },
    openEdit(data) {
        this.warehouse = { ...data };
        this.editMode = true;
        this.openModal = true;
    },
    openAdd() {
        this.warehouse = { id: '', code: '', name: '', address: '', description: '' };
        this.editMode = false;
        this.openModal = true;
    }
}">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h3 class="text-xl font-bold text-gray-800">Daftar Gudang</h3>
        @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
        <button @click="openAdd()" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition shadow-sm w-full md:w-auto">
            <i class="bi bi-plus-lg mr-2"></i> Tambah Gudang
        </button>
        @endif
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Gudang</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($warehouses as $w)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                            {{ $w->code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $w->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $w->address ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 italic max-w-xs truncate">
                            {{ $w->description ?: '-' }}
                        </td>
                        @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <button @click='openEdit(@json($w))' class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 p-2 rounded-lg transition">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('warehouses.destroy', $w->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus gudang ini?')">
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
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                            Belum ada data gudang.
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
                <form :action="editMode ? '/warehouses/' + warehouse.id : '{{ route('warehouses.store') }}'" method="POST">
                    @csrf
                    <template x-if="editMode">
                        @method('PUT')
                    </template>
                    
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-900" x-text="editMode ? 'Edit Gudang' : 'Tambah Gudang'"></h3>
                            <button type="button" @click="openModal = false" class="text-gray-400 hover:text-gray-500">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kode Gudang</label>
                                <input type="text" name="code" x-model="warehouse.code" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Gudang</label>
                                <input type="text" name="name" x-model="warehouse.name" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                                <input type="text" name="address" x-model="warehouse.address" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                                <textarea name="description" x-model="warehouse.description" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
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
