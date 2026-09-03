<?php $__env->startSection('title', 'About'); ?>
<?php $__env->startSection('page-title', 'About'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">About</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h2>About</h2>
    <p>Manage your company profile, CEO bio, timeline, and page settings.</p>
</div>

<div class="row g-3">
    <div class="col-md-3">
        <a href="<?php echo e(route('admin.about.settings.edit')); ?>" class="dashboard-card h-100">
            <div class="dashboard-card-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-type"></i></div>
            <div class="dashboard-card-title">Page Settings</div>
            <p class="dashboard-card-desc">Edit page header, headline, and belief section text.</p>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?php echo e(route('admin.about.ceo-profile')); ?>" class="dashboard-card h-100">
            <div class="dashboard-card-icon"><i class="bi bi-person-badge"></i></div>
            <div class="dashboard-card-title">CEO Profile</div>
            <p class="dashboard-card-desc">Edit the CEO profile, photo, quote, and greeting message.</p>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?php echo e(route('admin.about.timeline.index')); ?>" class="dashboard-card h-100">
            <div class="dashboard-card-icon" style="background:#e0f2fe;color:#0ea5e9"><i class="bi bi-clock-history"></i></div>
            <div class="dashboard-card-title">Timeline</div>
            <p class="dashboard-card-desc">Manage the company history and milestone timeline entries.</p>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?php echo e(route('admin.about.statistics.index')); ?>" class="dashboard-card h-100">
            <div class="dashboard-card-icon" style="background:#dcfce7;color:#166534"><i class="bi bi-bar-chart-steps"></i></div>
            <div class="dashboard-card-title">Statistics</div>
            <p class="dashboard-card-desc">Manage statistics displayed on the About page (value, label, suffix).</p>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?php echo e(route('admin.about.sectors.index')); ?>" class="dashboard-card h-100">
            <div class="dashboard-card-icon" style="background:#ede9fe;color:#7c3aed"><i class="bi bi-tag"></i></div>
            <div class="dashboard-card-title">Sectors</div>
            <p class="dashboard-card-desc">Manage sectors (heading) and their sub-items for the About page.</p>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/about/index.blade.php ENDPATH**/ ?>