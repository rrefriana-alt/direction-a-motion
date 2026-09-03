<?php $__env->startSection('title', 'Projects'); ?>
<?php $__env->startSection('page-title', 'Projects'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.portfolio.index')); ?>">Portfolio</a></li>
    <li class="breadcrumb-item active">Projects</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Projects</h2>
        <p>Manage all work portfolio projects and their modal content</p>
    </div>
    <a href="<?php echo e(route('admin.portfolio.projects.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Project</a>
</div>

<div class="card-white" style="padding:.75rem 1rem;margin-bottom:1.5rem">
    <form method="GET" style="display:flex;gap:.75rem;align-items:center;flex-wrap:wrap">
        <input type="text" name="search" class="form-control form-control-sm" style="max-width:240px" placeholder="Search projects..." value="<?php echo e($search); ?>">
        <select name="category" class="form-select form-select-sm" style="max-width:160px">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>" <?php echo e($category === $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button type="submit" class="btn btn-secondary btn-sm"><i class="bi bi-search"></i> Filter</button>
        <?php if($search || $category !== 'all'): ?>
            <a href="<?php echo e(route('admin.portfolio.projects.index')); ?>" class="btn btn-secondary btn-sm"><i class="bi bi-x"></i> Clear</a>
        <?php endif; ?>
    </form>
</div>

<?php if($projects->count()): ?>
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem">
    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card-white" style="padding:0;overflow:hidden;transition:all .2s;cursor:default">
        <div style="height:160px;background:<?php echo e($project->bg_color ?: 'var(--gray-900)'); ?>;overflow:hidden;position:relative;display:flex;align-items:center;justify-content:center">
            <?php if($project->image): ?>
                <img src="<?php echo e(asset('img/' . $project->image)); ?>" alt="<?php echo e($project->title); ?>" style="width:100%;height:100%;object-fit:cover">
            <?php elseif($project->hero_image): ?>
                <img src="<?php echo e(asset('img/' . $project->hero_image)); ?>" alt="<?php echo e($project->title); ?>" style="width:100%;height:100%;object-fit:cover">
            <?php else: ?>
                <div style="color:<?php echo e($project->accent_color ?: 'var(--green-400)'); ?>;font-size:2rem;font-weight:800;opacity:.6"><?php echo e(strtoupper(substr($project->client_name ?? 'F', 0, 2))); ?></div>
            <?php endif; ?>
            <div style="position:absolute;top:.5rem;right:.5rem;display:flex;gap:.25rem">
                <?php if($project->is_featured): ?>
                    <span style="background:var(--green-500);color:#fff;padding:.15rem .4rem;border-radius:4px;font-size:.6rem;font-weight:600">Featured</span>
                <?php endif; ?>
                <?php if(! $project->is_active): ?>
                    <span style="background:var(--danger);color:#fff;padding:.15rem .4rem;border-radius:4px;font-size:.6rem;font-weight:600">Draft</span>
                <?php endif; ?>
            </div>
        </div>
        <div style="padding:1rem">
            <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:.35rem">
                <div>
                    <div style="font-size:.9rem;font-weight:700;color:var(--gray-900)"><?php echo e($project->title); ?></div>
                    <div style="font-size:.73rem;color:var(--gray-500)"><?php echo e($project->client_name ?: '—'); ?></div>
                </div>
                <span style="font-size:.65rem;font-weight:600;color:var(--green-600);background:var(--green-50);padding:.15rem .4rem;border-radius:4px"><?php echo e(ucfirst($project->category)); ?></span>
            </div>
            <div style="display:flex;gap:.5rem;margin-top:.75rem">
                <a href="<?php echo e(route('admin.portfolio.projects.edit', $project->id)); ?>" class="btn btn-secondary btn-sm" style="flex:1"><i class="bi bi-pencil"></i> Edit</a>
                <form action="<?php echo e(route('admin.portfolio.projects.destroy', $project->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this project?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php if($projects->hasPages()): ?>
<div style="margin-top:1.5rem"><?php echo e($projects->links()); ?></div>
<?php endif; ?>
<?php else: ?>
<div class="card-white" style="padding:3rem;text-align:center">
    <i class="bi bi-folder2-open" style="font-size:2.5rem;color:var(--gray-300)"></i>
    <p style="color:var(--gray-500);margin-top:.5rem">No projects found</p>
    <a href="<?php echo e(route('admin.portfolio.projects.create')); ?>" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Create First Project</a>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/portfolio/projects/index.blade.php ENDPATH**/ ?>