<?php $__env->startSection('title', 'Riwayat Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Transaksi</h3>
    <?php if(auth()->user()->isAdmin() || auth()->user()->isStaff()): ?>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
        <i class="bi bi-plus-lg"></i> Tambah Transaksi
    </button>
    <?php endif; ?>
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
                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($t->created_at); ?></td>
                    <td><?php echo e($t->item->name); ?></td>
                    <td><?php echo e($t->warehouse->name ?? '-'); ?></td>
                    <td>
                        <span class="badge bg-<?php echo e($t->type === 'in' ? 'success' : 'danger'); ?>">
                            <?php echo e(strtoupper($t->type)); ?>

                        </span>
                    </td>
                    <td><?php echo e($t->quantity); ?></td>
                    <td><?php echo e($t->user->username); ?></td>
                    <td><small><?php echo e($t->note); ?></small></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Transaction Modal -->
<div class="modal fade" id="addTransactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('transactions.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Barang</label>
                        <select name="item_id" class="form-select" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?> (SKU: <?php echo e($item->sku); ?>) - Stok: <?php echo e($item->stock); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/transactions/index.blade.php ENDPATH**/ ?>