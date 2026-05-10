@extends('layouts.app')

@section('title', 'Kelola Gudang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Gudang</h3>
    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
        <i class="bi bi-plus-lg"></i> Tambah Gudang
    </button>
    @endif
</div>

<div class="card">
    <div class="card-body p-0 table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Gudang</th>
                    <th>Alamat</th>
                    <th>Deskripsi</th>
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                    <th class="text-end">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($warehouses as $w)
                <tr>
                    <td><code>{{ $w->code }}</code></td>
                    <td>{{ $w->name }}</td>
                    <td>{{ $w->address ?: '-' }}</td>
                    <td><small>{{ $w->description ?: '-' }}</small></td>
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                    <td class="text-end">
                        <button class="btn btn-sm btn-warning" onclick='editWarehouse(@json($w))' data-bs-toggle="modal" data-bs-target="#editWarehouseModal">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('warehouses.destroy', $w->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus gudang ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
                @if($warehouses->isEmpty())
                    <tr><td colspan="5" class="text-center">Belum ada gudang.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="addWarehouseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('warehouses.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gudang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Gudang</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Gudang</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editWarehouseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editWarehouseForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gudang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Gudang</label>
                        <input type="text" name="code" id="edit_warehouse_code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Gudang</label>
                        <input type="text" name="name" id="edit_warehouse_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="address" id="edit_warehouse_address" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" id="edit_warehouse_description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editWarehouse(w) {
    document.getElementById('editWarehouseForm').action = '/warehouses/' + w.id;
    document.getElementById('edit_warehouse_code').value = w.code;
    document.getElementById('edit_warehouse_name').value = w.name;
    document.getElementById('edit_warehouse_address').value = w.address || '';
    document.getElementById('edit_warehouse_description').value = w.description || '';
}
</script>
@endpush
@endsection
