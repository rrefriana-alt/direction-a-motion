<?php $__env->startSection('title', 'CEO Profile'); ?>
<?php $__env->startSection('page-title', 'CEO Profile'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.about.index')); ?>">About</a></li>
    <li class="breadcrumb-item active">CEO Profile</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>CEO Profile</h2>
        <p>Edit the CEO profile photo, quote, and bio</p>
    </div>
    <a href="<?php echo e(route('admin.about.index')); ?>" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:720px">
    <form action="<?php echo e(route('admin.about.ceo-profile.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="form-group">
            <label class="form-label">Photo</label>
            <?php if(isset($ceo->photo) && $ceo->photo): ?>
            <div style="margin-bottom:.75rem">
                <img src="<?php echo e($ceo->photo); ?>" alt="CEO Photo" style="width:100px;height:100px;object-fit:cover;border-radius:50%;border:2px solid var(--gray-200)">
            </div>
            <?php endif; ?>
            <input type="file" class="form-control" name="photo" accept="image/*">
        </div>

        <div class="form-group">
            <label class="form-label">Quote</label>
            <input type="text" class="form-control" name="quote" value="<?php echo e(old('quote', $ceo->quote ?? '')); ?>" placeholder="Inspirational quote...">
        </div>

        <div class="form-group">
            <label class="form-label">Description 1</label>
            <textarea class="form-control" name="description1" rows="4" placeholder="First paragraph..."><?php echo e(old('description1', $ceo->description1 ?? '')); ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Description 2</label>
            <textarea class="form-control" name="description2" rows="4" placeholder="Second paragraph..."><?php echo e(old('description2', $ceo->description2 ?? '')); ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Signature</label>
            <?php if(isset($ceo->signature) && $ceo->signature): ?>
            <div style="margin-bottom:.75rem">
                <img src="<?php echo e($ceo->signature); ?>" alt="Signature" style="max-height:60px;border:1px solid var(--gray-200);border-radius:var(--radius-sm);padding:.5rem;background:#fff">
            </div>
            <?php endif; ?>
            <input type="file" class="form-control" name="signature" accept="image/*">
        </div>

        <div class="form-group">
            <label class="form-label">Greeting</label>
            <input type="text" class="form-control" name="greeting" value="<?php echo e(old('greeting', $ceo->greeting ?? '')); ?>" placeholder="e.g. Welcome to our company...">
        </div>

        <div class="row g-3">
            <div class="col-md-6 form-group">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo e(old('name', $ceo->name ?? '')); ?>" placeholder="Full name">
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label">Position</label>
                <input type="text" class="form-control" name="position" value="<?php echo e(old('position', $ceo->position ?? '')); ?>" placeholder="e.g. CEO & Founder">
            </div>
        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('admin.about.index')); ?>" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Profile</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/about/ceo-profile.blade.php ENDPATH**/ ?>