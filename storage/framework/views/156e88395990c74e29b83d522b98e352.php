<?php $__env->startSection('title', 'News'); ?>
<?php $__env->startSection('page-title', 'News & Blog'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">News & Blog</h4>
        <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-accent">
            <i class="bi bi-pencil-square me-1"></i> Write Article
        </a>
    </div>

    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($item->title); ?></td>
                                <td><?php echo e($item->category); ?></td>
                                <td><?php echo e($item->author); ?></td>
                                <td>
                                    <?php if($item->status === 'Published'): ?>
                                        <span class="badge badge-status bg-success">Published</span>
                                    <?php elseif($item->status === 'Draft'): ?>
                                        <span class="badge badge-status bg-warning text-dark">Draft</span>
                                    <?php else: ?>
                                        <span class="badge badge-status bg-secondary"><?php echo e($item->status); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($item->created_at->format('M d, Y')); ?></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="<?php echo e(route('admin.news.edit', $item->id)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.news.destroy', $item->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state text-center py-5">
                                        <i class="bi bi-journal-text fs-1 text-muted mb-3 d-block"></i>
                                        <h5 class="text-muted mb-0">No articles found</h5>
                                        <p class="text-muted mb-3">Get started by creating your first article.</p>
                                        <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-accent btn-sm">Write Article</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/news/index.blade.php ENDPATH**/ ?>