<?php $__env->startSection('title', 'Statistics'); ?>
<?php $__env->startSection('page-title', 'Statistics'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.home')); ?>">Home</a></li>
    <li class="breadcrumb-item active">Statistics</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Statistics</h2>
        <p>Manage the counter statistics displayed on the homepage</p>
    </div>
    <a href="<?php echo e(route('admin.home.stats.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Stat</a>
</div>

<?php if($stats->count() > 0): ?>
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem">
    <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="stat-card" style="position:relative">
        <div class="stat-value" style="color:<?php echo e($stat->is_active ? 'var(--gray-900)' : 'var(--gray-400)'); ?>">
            <?php echo e($stat->value); ?><span style="font-size:.9rem;color:var(--green-500)"><?php echo e($stat->suffix); ?></span>
        </div>
        <div class="stat-label"><?php echo e($stat->label); ?></div>
        <div style="position:absolute;top:.75rem;right:.75rem;display:flex;gap:.25rem">
            <a href="<?php echo e(route('admin.home.stats.edit', $stat->id)); ?>" class="btn btn-secondary btn-sm" style="padding:.2rem .4rem;font-size:.65rem"><i class="bi bi-pencil"></i></a>
            <form action="<?php echo e(route('admin.home.stats.destroy', $stat->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this stat?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger btn-sm" style="padding:.2rem .4rem;font-size:.65rem"><i class="bi bi-trash"></i></button>
            </form>
        </div>
        <?php if(!$stat->is_active): ?>
        <div style="position:absolute;top:.75rem;left:.75rem">
            <span class="badge-inactive" style="font-size:.6rem">Inactive</span>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th style="width:60px">Order</th>
                    <th>Value</th>
                    <th>Suffix</th>
                    <th>Label</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="color:var(--gray-500)"><?php echo e($stat->sort_order); ?></td>
                    <td><span class="fw-600" style="font-size:1rem;color:var(--green-600)"><?php echo e($stat->value); ?></span></td>
                    <td style="color:var(--gray-500)"><?php echo e($stat->suffix ?: '—'); ?></td>
                    <td><span class="fw-600"><?php echo e($stat->label); ?></span></td>
                    <td>
                        <?php if($stat->is_active): ?>
                            <span class="badge-active">Active</span>
                        <?php else: ?>
                            <span class="badge-inactive">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end">
                        <a href="<?php echo e(route('admin.home.stats.edit', $stat->id)); ?>" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('admin.home.stats.destroy', $stat->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this stat?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<div class="card-white">
    <div class="empty-state">
        <i class="bi bi-bar-chart"></i>
        <p>No statistics yet</p>
        <a href="<?php echo e(route('admin.home.stats.create')); ?>" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Add Stat</a>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/home/stats/index.blade.php ENDPATH**/ ?>