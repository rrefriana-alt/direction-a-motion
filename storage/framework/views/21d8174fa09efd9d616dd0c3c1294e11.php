
<?php $__env->startSection('title', 'Messages'); ?>
<?php $__env->startSection('page-title', 'Contact Messages'); ?>

<?php $__env->startSection('content'); ?>
<div class="card card-modern">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-modern align-middle">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e(!$m->is_read ? 'fw-bold bg-light' : ''); ?>">
                        <td><?php echo e($m->name); ?></td>
                        <td><?php echo e($m->email); ?></td>
                        <td><?php echo e(\Illuminate\Support\Str::limit($m->subject, 30)); ?></td>
                        <td><?php echo e($m->created_at->format('M d, Y H:i')); ?></td>
                        <td>
                            <span class="badge <?php echo e($m->is_read ? 'bg-secondary' : 'bg-primary'); ?>">
                                <?php echo e($m->is_read ? 'Read' : 'Unread'); ?>

                            </span>
                        </td>
                        <td class="text-end">
                            <a href="<?php echo e(route('admin.messages.show', $m->id)); ?>" class="btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="<?php echo e(route('admin.messages.destroy', $m->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?');">
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
                        <td colspan="6" class="text-center py-4 empty-state">No messages received yet.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/messages/index.blade.php ENDPATH**/ ?>