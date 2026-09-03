<?php $__env->startSection('title', 'Portfolio'); ?>
<?php $__env->startSection('page-title', 'Portfolio'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Portfolio</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h2>Portfolio</h2>
    <p>Manage your portfolio projects and showcase your work.</p>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <a href="<?php echo e(route('admin.portfolio.projects.index')); ?>" class="dashboard-card h-100">
            <div class="dashboard-card-icon"><i class="bi bi-folder2-open"></i></div>
            <div class="dashboard-card-title">Projects</div>
            <p class="dashboard-card-desc">Create, edit, and manage individual portfolio projects.</p>
        </a>
    </div>
    <div class="col-md-6">
        <a href="<?php echo e(route('admin.portfolio.view-all')); ?>" class="dashboard-card h-100">
            <div class="dashboard-card-icon" style="background:#e0f2fe;color:#0ea5e9"><i class="bi bi-grid-3x3-gap"></i></div>
            <div class="dashboard-card-title">View All Projects</div>
            <p class="dashboard-card-desc">Toggle which projects are displayed on the public portfolio page.</p>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/portfolio/index.blade.php ENDPATH**/ ?>