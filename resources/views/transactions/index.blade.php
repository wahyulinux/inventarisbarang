@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Transaksi</h3>
    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
        <i class="bi bi-plus-lg"></i> Tambah Transaksi
    </button>
    @endif
</div>

<div class="card">
    <div class="card-body p-0 table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Barang</th>
                    <th>Gudang</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Oleh</th>
                    <th>Catatan</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $t)
                <tr>
                    <td>{{ $t->created_at }}</td>
                    <td>{{ $t->item->name }}</td>
                    <td>{{ $t->warehouse->name ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $t->type === 'in' ? 'success' : 'danger' }}">
                            {{ strtoupper($t->type) }}
                        </span>
                    </td>
                    <td>{{ $t->quantity }}</td>
                    <td>{{ $t->user->username }}</td>
                    <td><small>{{ $t->note }}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Barang</label>
                        <select name="item_id" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} (SKU: {{ $item->sku }}) - Stok: {{ $item->stock }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Transaksi</label>
                        <select name="type" class="form-select" required>
                            <option value="in">Barang Masuk (IN)</option>
                            <option value="out">Barang Keluar (OUT)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="note" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
