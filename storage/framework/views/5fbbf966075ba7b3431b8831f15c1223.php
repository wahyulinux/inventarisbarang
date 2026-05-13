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
                <td style="border: none;">: <?php echo e($warehouse->name ?? 'Semua Gudang'); ?></td>
            </tr>
            <tr>
                <td style="border: none;">Kategori</td>
                <td style="border: none;">: <?php echo e($category->name ?? 'Semua Kategori'); ?></td>
            </tr>
            <tr>
                <td style="border: none;">Dicetak pada</td>
                <td style="border: none;">: <?php echo e(date('d/m/Y H:i')); ?></td>
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
            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->sku); ?></td>
                <td><?php echo e($item->name); ?></td>
                <td><?php echo e($item->category->name ?? '-'); ?></td>
                <td><?php echo e($item->warehouse->name ?? '-'); ?></td>
                <td><?php echo e($item->stock); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data barang.</td>
            </tr>
            <?php endif; ?>
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
<?php /**PATH /var/www/html/resources/views/items/print.blade.php ENDPATH**/ ?>