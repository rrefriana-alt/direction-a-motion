
<?php $__env->startSection('title', 'Careers'); ?>
<?php $__env->startSection('page-title', 'Career Management'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{ tab: 'open' }">
    <!-- Tabs -->
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <button class="nav-link" :class="{ 'active': tab === 'open' }" @click="tab = 'open'">Open Positions</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" :class="{ 'active': tab === 'applications' }" @click="tab = 'applications'">Applications</button>
        </li>
    </ul>

    <!-- Tab 1: Open Positions -->
    <div x-show="tab === 'open'">
        <div class="card card-modern mb-4">
            <div class="card-body">
                <h5 class="card-title mb-4">Manage Positions</h5>
                <div class="table-responsive">
                    <table class="table table-modern align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $careers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $career): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($career->title); ?></td>
                                <td><?php echo e($career->type); ?></td>
                                <td><?php echo e($career->location); ?></td>
                                <td>
                                    <span class="badge <?php echo e($career->is_open ? 'bg-success' : 'bg-secondary'); ?>">
                                        <?php echo e($career->is_open ? 'Open' : 'Closed'); ?>

                                    </span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#editCareer<?php echo e($career->id); ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="<?php echo e(route('admin.careers.destroy', $career->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 empty-state">No open positions found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card card-modern">
            <div class="card-body">
                <h5 class="card-title mb-4">Add New Position</h5>
                <form action="<?php echo e(route('admin.careers.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="title" class="form-control form-control-modern" placeholder="Job Title" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="type" class="form-control form-control-modern" placeholder="Type (e.g. Full-time)" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="location" class="form-control form-control-modern" placeholder="Location" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="form-check form-switch w-100">
                                <input class="form-check-input" type="checkbox" name="is_open" id="isOpenAdd" value="1" checked>
                                <label class="form-check-label" for="isOpenAdd">Open</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-accent px-4">Add Position</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modals for Editing -->
        <?php $__currentLoopData = $careers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $career): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="editCareer<?php echo e($career->id); ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?php echo e(route('admin.careers.update', $career->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Position</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label form-label-modern">Title</label>
                                <input type="text" name="title" class="form-control form-control-modern" value="<?php echo e($career->title); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label form-label-modern">Type</label>
                                <input type="text" name="type" class="form-control form-control-modern" value="<?php echo e($career->type); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label form-label-modern">Location</label>
                                <input type="text" name="location" class="form-control form-control-modern" value="<?php echo e($career->location); ?>" required>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_open" value="1" <?php echo e($career->is_open ? 'checked' : ''); ?>>
                                <label class="form-check-label">Open</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-accent">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Tab 2: Applications -->
    <div x-show="tab === 'applications'" style="display: none;">
        <div class="card card-modern">
            <div class="card-body">
                <h5 class="card-title mb-4">Job Applications</h5>
                <div class="table-responsive">
                    <table class="table table-modern align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Resume</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($app->name); ?></td>
                                <td><?php echo e($app->position); ?></td>
                                <td>
                                    <?php
                                        $badgeClass = match(strtolower($app->status)) {
                                            'new' => 'bg-primary',
                                            'reviewed' => 'bg-warning text-dark',
                                            'accepted' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    ?>
                                    <span class="badge <?php echo e($badgeClass); ?> badge-status"><?php echo e(ucfirst($app->status)); ?></span>
                                </td>
                                <td><?php echo e($app->created_at->format('M d, Y')); ?></td>
                                <td>
                                    <?php if($app->resume_path): ?>
                                    <a href="<?php echo e(asset('storage/' . $app->resume_path)); ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-text"></i> View</a>
                                    <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <form action="<?php echo e(route('admin.careers.update-application', $app->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <select name="status" class="form-select form-select-sm d-inline-block w-auto me-2" onchange="this.form.submit()">
                                            <option value="new" <?php echo e($app->status === 'new' ? 'selected' : ''); ?>>New</option>
                                            <option value="reviewed" <?php echo e($app->status === 'reviewed' ? 'selected' : ''); ?>>Reviewed</option>
                                            <option value="accepted" <?php echo e($app->status === 'accepted' ? 'selected' : ''); ?>>Accepted</option>
                                            <option value="rejected" <?php echo e($app->status === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                                        </select>
                                    </form>
                                    <form action="<?php echo e(route('admin.careers.destroy-application', $app->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this application?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 empty-state">No applications found.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/careers/index.blade.php ENDPATH**/ ?>