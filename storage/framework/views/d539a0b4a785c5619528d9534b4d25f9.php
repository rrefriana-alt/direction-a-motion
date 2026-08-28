<?php $__env->startSection('title', 'Services'); ?>
<?php $__env->startSection('page-title', 'Services'); ?>

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

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="mb-0 fs-4 fw-bold">Service Categories</h2>
    </div>
    <div class="col-auto d-md-none">
        <button class="btn btn-accent" data-bs-toggle="collapse" data-bs-target="#addCategoryForm" aria-expanded="false" aria-controls="addCategoryForm">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </button>
    </div>
</div>

<div class="row">
    <!-- LEFT: List of existing categories -->
    <div class="col-md-8">
        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="card card-modern mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h4 class="fw-bold mb-1"><?php echo e($category->name); ?></h4>
                        
                        <form action="<?php echo e(route('admin.services.destroy', $category->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                    
                    <?php if($category->description): ?>
                        <p class="text-secondary mb-3"><?php echo e($category->description); ?></p>
                    <?php endif; ?>
                    
                    <hr class="text-muted opacity-25 my-3">
                    
                    <h6 class="fw-semibold mb-3 text-dark">Sub-Services</h6>
                    
                    <?php if($category->items->count() > 0): ?>
                        <div class="list-group list-group-flush border-0">
                            <?php $__currentLoopData = $category->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item px-0 py-2 border-0 d-flex flex-column">
                                    <div class="fw-medium text-dark d-flex align-items-center mb-1">
                                        <i class="bi bi-check-circle-fill text-success me-2 small"></i>
                                        <?php echo e($item->title); ?>

                                    </div>
                                    <?php if($item->description): ?>
                                        <div class="text-secondary small ms-4"><?php echo e($item->description); ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small fst-italic mb-0">No sub-services found.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state text-center py-5 bg-white rounded-3 border">
                <i class="bi bi-grid-3x3-gap text-muted fs-1 mb-3 d-block"></i>
                <h5 class="fw-semibold">No categories yet</h5>
                <p class="text-secondary mb-0">Create your first service category to get started.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- RIGHT: Add New Category Form -->
    <div class="col-md-4">
        <div class="collapse d-md-block" id="addCategoryForm">
            <div class="card card-modern sticky-top" style="top: 20px; z-index: 10;">
                <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
                    <h5 class="fw-bold mb-0">Add New Category</h5>
                </div>
                <div class="card-body p-4 pt-3">
                    <form action="<?php echo e(route('admin.services.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label form-label-modern fw-medium">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-modern" id="name" name="name" required placeholder="e.g. Video Production">
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label form-label-modern fw-medium">Description</label>
                            <textarea class="form-control form-control-modern" id="description" name="description" rows="3" placeholder="Brief overview of this category"></textarea>
                        </div>
                        
                        <hr class="text-muted opacity-25 my-4">
                        
                        <h6 class="fw-bold mb-3">Sub-Services</h6>
                        <p class="text-secondary small mb-3">Add up to 4 sub-services for this category.</p>
                        
                        <?php for($i = 0; $i < 4; $i++): ?>
                            <div class="bg-light p-3 rounded-3 mb-3 border">
                                <div class="mb-2">
                                    <label for="items_title_<?php echo e($i); ?>" class="form-label form-label-modern fw-medium small mb-1">Service <?php echo e($i + 1); ?> Title</label>
                                    <input type="text" class="form-control form-control-modern form-control-sm" id="items_title_<?php echo e($i); ?>" name="items_title[]" placeholder="Title">
                                </div>
                                <div>
                                    <label for="items_desc_<?php echo e($i); ?>" class="form-label form-label-modern fw-medium small mb-1">Service <?php echo e($i + 1); ?> Description</label>
                                    <input type="text" class="form-control form-control-modern form-control-sm" id="items_desc_<?php echo e($i); ?>" name="items_desc[]" placeholder="Description">
                                </div>
                            </div>
                        <?php endfor; ?>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-accent py-2 fw-semibold">
                                <i class="bi bi-check-lg me-1"></i> Save Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/services/index.blade.php ENDPATH**/ ?>