<?php $__env->startSection('title', 'Projects'); ?>
<?php $__env->startSection('page-title', 'Portfolio / Projects'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Projects</h2>
        <a href="<?php echo e(route('admin.projects.create')); ?>" class="btn btn-accent">
            <i class="bi bi-plus-lg me-2"></i>Add Project
        </a>
    </div>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        <?php if($projects->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Category</th>
                            <th>Year</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($project->hero_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $project->hero_image)); ?>" alt="<?php echo e($project->title); ?>" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px; border-radius: 4px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle fw-semibold"><?php echo e($project->title); ?></td>
                            <td class="align-middle"><?php echo e($project->client); ?></td>
                            <td class="align-middle"><?php echo e($project->category); ?></td>
                            <td class="align-middle"><?php echo e($project->year); ?></td>
                            <td class="align-middle text-end">
                                <a href="<?php echo e(route('admin.projects.edit', $project->id)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.projects.destroy', $project->id)); ?>" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state text-center p-5">
                <i class="bi bi-folder2-open display-4 text-muted mb-3 d-block"></i>
                <h4 class="text-muted mb-3">No projects found</h4>
                <a href="<?php echo e(route('admin.projects.create')); ?>" class="btn btn-accent">
                    <i class="bi bi-plus-lg me-2"></i>Add Your First Project
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/projects/index.blade.php ENDPATH**/ ?>