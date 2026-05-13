<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Daftar Barang</title>
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
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>Laporan Inventaris Barang</h2>
        <p>Sistem Inventaris Barang</p>
    </div>

    <div class="info">
        <table style="width: auto;">
            <tr>
                <td style="border: none; width: 100px;">Gudang</td>
                <td style="border: none;">: {{ $warehouse->name ?? 'Semua Gudang' }}</td>
            </tr>
            <tr>
                <td style="border: none;">Kategori</td>
                <td style="border: none;">: {{ $category->name ?? 'Semua Kategori' }}</td>
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
                <th>SKU</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Gudang</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->sku }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category->name ?? '-' }}</td>
                <td>{{ $item->warehouse->name ?? '-' }}</td>
                <td>{{ $item->stock }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data barang.</td>
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
