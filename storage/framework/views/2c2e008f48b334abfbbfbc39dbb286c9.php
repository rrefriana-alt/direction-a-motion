<?php $__env->startSection('title', 'Edit Statistic'); ?>
<?php $__env->startSection('page-title', 'Edit Statistic'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.about.index')); ?>">About</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.about.statistics.index')); ?>">Statistics</a></li>
    <li class="breadcrumb-item active">Edit</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit Statistic</h2>
        <p>Update this statistic entry.</p>
    </div>
    <a href="<?php echo e(route('admin.about.statistics.index')); ?>" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:640px">
    <form action="<?php echo e(route('admin.about.statistics.update', $stat->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-section-title">Statistic Details</div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Value <span class="required">*</span></label>
                    <input type="text" name="value" class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('value', $stat->value)); ?>" required>
                    <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Suffix</label>
                    <input type="text" name="suffix" class="form-control" value="<?php echo e(old('suffix', $stat->suffix ?? '')); ?>">
                    <div class="form-text">Optional suffix after the value</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Label <span class="required">*</span></label>
            <input type="text" name="label" class="form-control <?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('label', $stat->label)); ?>" required>
            <?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo e(old('sort_order', $stat->sort_order)); ?>" min="0">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div style="display:flex;align-items:center;gap:.5rem;padding-top:.35rem">
                        <div class="svc-toggle <?php echo e($stat->is_active ? 'on' : ''); ?>" id="toggleStatus"></div>
                        <span style="font-size:.78rem;color:var(--gray-600)" id="statusText"><?php echo e($stat->is_active ? 'Active' : 'Inactive'); ?></span>
                    </div>
                    <input type="hidden" name="is_active" value="<?php echo e($stat->is_active ? '1' : '0'); ?>" id="statusInput">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('admin.about.statistics.index')); ?>" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('toggleStatus').addEventListener('click', function() {
    this.classList.toggle('on');
    var isActive = this.classList.contains('on');
    document.getElementById('statusInput').value = isActive ? '1' : '0';
    document.getElementById('statusText').textContent = isActive ? 'Active' : 'Inactive';
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/about/statistics/edit.blade.php ENDPATH**/ ?>