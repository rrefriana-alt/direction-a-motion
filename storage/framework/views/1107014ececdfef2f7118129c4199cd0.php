<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-folder2-open fs-5"></i>
                    </div>
                    <div>
                        <div class="stat-value fs-4 fw-bold"><?php echo e($projects_count ?? 0); ?></div>
                        <div class="stat-label text-muted">Projects</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="background-color: rgba(111, 66, 193, 0.1); color: #6f42c1; width: 44px; height: 44px;">
                        <i class="bi bi-layers fs-5"></i>
                    </div>
                    <div>
                        <div class="stat-value fs-4 fw-bold"><?php echo e($services_count ?? 0); ?></div>
                        <div class="stat-label text-muted">Services</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-chat-dots fs-5"></i>
                    </div>
                    <div>
                        <div class="stat-value fs-4 fw-bold"><?php echo e($messages_count ?? 0); ?></div>
                        <div class="stat-label text-muted">Messages</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-6 col-xl">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-briefcase fs-5"></i>
                    </div>
                    <div>
                        <div class="stat-value fs-4 fw-bold"><?php echo e($careers_count ?? 0); ?></div>
                        <div class="stat-label text-muted">Careers</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-6 col-xl">
            <div class="stat-card">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-newspaper fs-5"></i>
                    </div>
                    <div>
                        <div class="stat-value fs-4 fw-bold"><?php echo e($news_count ?? 0); ?></div>
                        <div class="stat-label text-muted">News</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card card-modern h-100 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold">Quick Actions</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <a href="<?php echo e(route('admin.projects.create')); ?>" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3 gap-2 border-1 rounded-3 text-decoration-none">
                                <i class="bi bi-folder-plus fs-3 text-primary"></i>
                                <span>Add Project</span>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3 gap-2 border-1 rounded-3 text-decoration-none">
                                <i class="bi bi-journal-plus fs-3 text-danger"></i>
                                <span>Write Article</span>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a href="<?php echo e(route('admin.content')); ?>" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3 gap-2 border-1 rounded-3 text-decoration-none">
                                <i class="bi bi-pencil-square fs-3" style="color: #6f42c1;"></i>
                                <span>Edit Content</span>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <a href="<?php echo e(route('admin.messages.index')); ?>" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3 gap-2 border-1 rounded-3 text-decoration-none">
                                <i class="bi bi-envelope-open fs-3 text-warning"></i>
                                <span>View Messages</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            
            <div class="card card-modern border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="mb-0 fw-bold">Admin Navigation</h5>
                </div>
                <div class="card-body p-4">
                    <div class="list-group list-group-flush border-0">
                        <a href="<?php echo e(route('admin.services.index')); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 border-bottom py-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-layers text-secondary"></i> Services
                            </div>
                            <i class="bi bi-chevron-right text-muted small"></i>
                        </a>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 border-bottom py-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-people text-secondary"></i> Users
                            </div>
                            <i class="bi bi-chevron-right text-muted small"></i>
                        </a>
                        <a href="<?php echo e(route('admin.careers.index')); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 border-bottom py-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-briefcase text-secondary"></i> Careers
                            </div>
                            <i class="bi bi-chevron-right text-muted small"></i>
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="card card-modern border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">PHP Version</span>
                        <span class="fw-semibold small"><?php echo e(phpversion()); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-muted small">Laravel Version</span>
                        <span class="fw-semibold small"><?php echo e(app()->version()); ?></span>
                    </div>
                    <a href="<?php echo e(url('/')); ?>" target="_blank" class="btn btn-light w-100 text-primary bg-primary bg-opacity-10 border-0 shadow-none d-flex justify-content-center align-items-center gap-2">
                        <i class="bi bi-box-arrow-up-right"></i> Back to Website
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>