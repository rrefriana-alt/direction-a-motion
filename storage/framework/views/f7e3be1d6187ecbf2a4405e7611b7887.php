<?php $__env->startSection('title', 'Work Page Settings'); ?>
<?php $__env->startSection('page-title', 'Work Page Settings'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.portfolio.index')); ?>">Portfolio</a></li>
    <li class="breadcrumb-item active">Work Page</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Work Page Settings</h2>
        <p>Configure the header section of the /work page</p>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="<?php echo e(route('admin.work-settings.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="field-group">
                <label class="field-label">Page Title <span style="color:var(--danger)">*</span></label>
                <input type="text" name="title" class="form-control" id="titleInput" value="<?php echo e(old('title', $settings['title'])); ?>" required placeholder="Selected work">
                <div class="field-hint">Main heading on the work page</div>
            </div>

            <div class="field-group">
                <label class="field-label">Page Lede <span style="color:var(--danger)">*</span></label>
                <textarea name="lede" class="form-control" id="ledeInput" rows="3" required><?php echo e(old('lede', $settings['lede'])); ?></textarea>
                <div class="field-hint">Subtitle text below the title</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.5rem">
            <div style="font-size:.72rem;color:var(--gray-400);margin-bottom:.5rem">Fugo / Work</div>
            <h1 style="font-size:1.5rem;font-weight:800;color:var(--gray-900);line-height:1.1;margin-bottom:.75rem" id="previewTitle"><?php echo $settings['title']; ?></h1>
            <p style="font-size:.8rem;color:var(--gray-500);line-height:1.5" id="previewLede"><?php echo e($settings['lede']); ?></p>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">Preview of the work page header</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('titleInput');
    const ledeInput = document.getElementById('ledeInput');
    const previewTitle = document.getElementById('previewTitle');
    const previewLede = document.getElementById('previewLede');

    titleInput.addEventListener('input', () => { previewTitle.innerHTML = titleInput.value || 'Selected work'; });
    ledeInput.addEventListener('input', () => { previewLede.textContent = ledeInput.value || 'Page description...'; });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/work-settings/edit.blade.php ENDPATH**/ ?>