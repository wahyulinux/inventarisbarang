@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Barang</h5>
                <p class="card-text fs-2">{{ $itemCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Kategori</h5>
                <p class="card-text fs-2">{{ $categoryCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi</h5>
                <p class="card-text fs-2">{{ $transactionCount }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Stok Rendah</h5>
                <p class="card-text fs-2">{{ $lowStockCount }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <h4>Transaksi Terakhir</h4>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Barang</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Oleh</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentTransactions as $row)
                <tr>
                    <td>{{ $row->created_at }}</td>
                    <td>{{ $row->item->name }}</td>
                    <td>
                        <span class="badge bg-{{ $row->type === 'in' ? 'success' : 'danger' }}">
                            {{ strtoupper($row->type) }}
                        </span>
                    </td>
                    <td>{{ $row->quantity }}</td>
                    <td>{{ $row->user->username }}</td>
                </tr>
                @endforeach
                @if($recentTransactions->isEmpty())
                    <tr><td colspan="5" class="text-center">Belum ada transaksi.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
