<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            text-transform: uppercase;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
        }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>Laporan Transaksi Barang</h2>
        <p>Sistem Inventaris Barang</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td style="border: none; width: 150px;">Gudang</td>
                <td style="border: none;">: {{ $warehouse->name ?? 'Semua Gudang' }}</td>
            </tr>
            <tr>
                <td style="border: none;">Periode</td>
                <td style="border: none;">: 
                    {{ $bulan ? date('F Y', strtotime($bulan)) : 'Semua Waktu' }}
                </td>
            </tr>
            <tr>
                <td style="border: none;">Dicetak pada</td>
                <td style="border: none;">: {{ date('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>Barang</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Oleh</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $t->item->name }}</td>
                <td>{{ strtoupper($t->type) }}</td>
                <td>{{ $t->quantity }}</td>
                <td>{{ $t->user->username }}</td>
                <td>{{ $t->note }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Dicetak secara otomatis oleh sistem.</p>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()">Cetak Lagi</button>
        <button onclick="window.close()">Tutup</button>
    </div>
</body>
</html>
