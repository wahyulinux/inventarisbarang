<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Barang</h5>
                <p class="card-text fs-2"><?php echo e($itemCount); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Kategori</h5>
                <p class="card-text fs-2"><?php echo e($categoryCount); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Transaksi</h5>
                <p class="card-text fs-2"><?php echo e($transactionCount); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Stok Rendah</h5>
                <p class="card-text fs-2"><?php echo e($lowStockCount); ?></p>
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
                <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($row->created_at); ?></td>
                    <td><?php echo e($row->item->name); ?></td>
                    <td>
                        <span class="badge bg-<?php echo e($row->type === 'in' ? 'success' : 'danger'); ?>">
                            <?php echo e(strtoupper($row->type)); ?>

                        </span>
                    </td>
                    <td><?php echo e($row->quantity); ?></td>
                    <td><?php echo e($row->user->username); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($recentTransactions->isEmpty()): ?>
                    <tr><td colspan="5" class="text-center">Belum ada transaksi.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/dashboard.blade.php ENDPATH**/ ?>