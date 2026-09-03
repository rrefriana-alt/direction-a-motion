<?php $__env->startSection('title', 'Timeline'); ?>
<?php $__env->startSection('page-title', 'Timeline'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.about.index')); ?>">About</a></li>
    <li class="breadcrumb-item active">Timeline</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Timeline</h2>
        <p>Manage your company history milestones</p>
    </div>
    <a href="<?php echo e(route('admin.about.timeline.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Create</a>
</div>

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Description</th>
                    <th>Icon</th>
                    <th>Order</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $timelines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timeline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><span class="fw-600" style="color:var(--green-600)"><?php echo e($timeline->year); ?></span></td>
                    <td style="max-width:400px;color:var(--gray-500)"><?php echo e(Str::limit($timeline->description, 80)); ?></td>
                    <td style="color:var(--gray-500)"><?php echo e($timeline->icon ?? '—'); ?></td>
                    <td style="color:var(--gray-500)"><?php echo e($timeline->sort_order ?? 0); ?></td>
                    <td class="text-end">
                        <a href="<?php echo e(route('admin.about.timeline.edit', $timeline->id)); ?>" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('admin.about.timeline.destroy', $timeline->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this entry?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="bi bi-clock-history"></i>
                            <p>No timeline entries yet</p>
                            <a href="<?php echo e(route('admin.about.timeline.create')); ?>" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Add Entry</a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/about/timeline/index.blade.php ENDPATH**/ ?>