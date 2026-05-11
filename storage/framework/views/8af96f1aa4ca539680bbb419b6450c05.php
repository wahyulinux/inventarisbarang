<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'Inventaris Barang')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar { background-color: #212529; color: white; }
        @media (min-width: 768px) {
            .sidebar { min-height: 100vh; }
        }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 10px 20px; display: block; }
        .sidebar a:hover { background-color: #343a40; color: white; }
        .sidebar a.active { background-color: #0d6efd; color: white; }
        .main-content { padding: 20px; }
    </style>
</head>
<body>
    <!-- Mobile Navbar -->
    <nav class="navbar navbar-dark bg-dark d-md-none">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Inventaris Barang</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (Offcanvas on Mobile, Sidebar on Desktop) -->
            <div class="col-md-2 bg-dark sidebar offcanvas-md offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-header text-white d-md-none">
                    <h5 class="offcanvas-title" id="sidebarMenuLabel">Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                </div>
                <div class="sidebar-sticky pt-3 offcanvas-body d-md-block">
                    <h5 class="px-3 mb-4 d-none d-md-block">Inventaris Barang</h5>
                    <ul class="nav flex-column w-100">
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('items*') ? 'active' : ''); ?>" href="<?php echo e(route('items.index')); ?>"><i class="bi bi-box me-2"></i> Barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('warehouses*') ? 'active' : ''); ?>" href="<?php echo e(route('warehouses.index')); ?>"><i class="bi bi-house me-2"></i> Gudang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('categories*') ? 'active' : ''); ?>" href="<?php echo e(route('categories.index')); ?>"><i class="bi bi-tags me-2"></i> Kategori</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('transactions*') ? 'active' : ''); ?>" href="<?php echo e(route('transactions.index')); ?>"><i class="bi bi-arrow-left-right me-2"></i> Transaksi</a>
                        </li>
                        <?php if(auth()->user()->isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('users*') ? 'active' : ''); ?>" href="<?php echo e(route('users.index')); ?>"><i class="bi bi-people me-2"></i> Kelola User</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item mt-5">
                            <form action="<?php echo e(route('logout')); ?>" method="POST" id="logout-form">
                                <?php echo csrf_field(); ?>
                                <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Main Content -->
            <main class="col-md-10 ms-md-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <span class="badge bg-secondary p-2">Logged in as: <?php echo e(auth()->user()->username); ?> (<?php echo e(ucfirst(auth()->user()->role)); ?>)</span>
                    </div>
                </div>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/app.blade.php ENDPATH**/ ?>