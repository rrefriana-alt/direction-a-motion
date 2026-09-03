<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item active">Dashboard</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h2>Welcome back, <?php echo e(auth('admin')->user()->name ?? 'Admin'); ?> 👋</h2>
    <p>Here's what's happening with your website today</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--green-50);color:var(--green-600)"><i class="bi bi-briefcase"></i></div>
            <div class="stat-value"><?php echo e($totalProjects); ?></div>
            <div class="stat-label">Total Projects</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;color:#2563eb"><i class="bi bi-newspaper"></i></div>
            <div class="stat-value"><?php echo e($totalNews); ?></div>
            <div class="stat-label">News Articles</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-mortarboard"></i></div>
            <div class="stat-value"><?php echo e($totalApplications); ?></div>
            <div class="stat-label">Applications</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce7f3;color:#db2777"><i class="bi bi-envelope"></i></div>
            <div class="stat-value"><?php echo e($unreadMessages); ?></div>
            <div class="stat-label">Unread Messages</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card-white">
            <div class="d-flex align-items-center justify-content-between" style="margin-bottom:1rem">
                <h6 style="font-weight:700;font-size:.9rem;margin:0;color:var(--gray-900)"><i class="bi bi-briefcase text-green"></i> Recent Projects</h6>
                <a href="<?php echo e(route('admin.portfolio.projects.index')); ?>" style="font-size:.73rem;color:var(--green-600);text-decoration:none;font-weight:600">View All →</a>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $recentProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="d-flex align-items-center justify-content-between" style="padding:.55rem 0;border-bottom:1px solid var(--gray-100)">
                <div>
                    <div style="font-weight:600;font-size:.82rem;color:var(--gray-900)"><?php echo e($p->title); ?></div>
                    <div style="font-size:.7rem;color:var(--gray-400)"><?php echo e(ucfirst($p->category)); ?></div>
                </div>
                <span class="<?php echo e($p->is_active ? 'badge-active' : 'badge-inactive'); ?>"><?php echo e($p->is_active ? 'Active' : 'Draft'); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state" style="padding:2rem 1rem">
                <i class="bi bi-briefcase"></i>
                <p>No projects yet</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-white">
            <div class="d-flex align-items-center justify-content-between" style="margin-bottom:1rem">
                <h6 style="font-weight:700;font-size:.9rem;margin:0;color:var(--gray-900)"><i class="bi bi-mortarboard" style="color:#d97706"></i> Recent Applications</h6>
                <a href="<?php echo e(route('admin.career.applications.index')); ?>" style="font-size:.73rem;color:var(--green-600);text-decoration:none;font-weight:600">View All →</a>
            </div>
            <?php $__empty_1 = true; $__currentLoopData = $recentApplications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="d-flex align-items-center justify-content-between" style="padding:.55rem 0;border-bottom:1px solid var(--gray-100)">
                <div>
                    <div style="font-weight:600;font-size:.82rem;color:var(--gray-900)"><?php echo e($a->full_name); ?></div>
                    <div style="font-size:.7rem;color:var(--gray-400)"><?php echo e($a->position); ?></div>
                </div>
                <?php if($a->status === 'pending'): ?>
                    <span class="badge-pending">Pending</span>
                <?php elseif($a->status === 'accepted'): ?>
                    <span class="badge-active">Accepted</span>
                <?php else: ?>
                    <span class="badge-inactive"><?php echo e(ucfirst($a->status)); ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state" style="padding:2rem 1rem">
                <i class="bi bi-mortarboard"></i>
                <p>No applications yet</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card-white mt-3">
    <div class="d-flex align-items-center justify-content-between" style="margin-bottom:1rem">
        <h6 style="font-weight:700;font-size:.9rem;margin:0;color:var(--gray-900)"><i class="bi bi-lightning-charge-fill" style="color:#d97706"></i> Quick Actions</h6>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="<?php echo e(route('admin.portfolio.projects.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Project</a>
        <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Create Article</a>
        <a href="<?php echo e(route('admin.career.positions.create')); ?>" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Position</a>
        <a href="<?php echo e(route('admin.services.crud')); ?>" class="btn btn-secondary btn-sm"><i class="bi bi-gear"></i> Manage Services</a>
        <a href="<?php echo e(route('admin.about.ceo-profile')); ?>" class="btn btn-secondary btn-sm"><i class="bi bi-person"></i> CEO Profile</a>
        <a href="<?php echo e(route('admin.account.index')); ?>" class="btn btn-secondary btn-sm"><i class="bi bi-people"></i> Admin Users</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>