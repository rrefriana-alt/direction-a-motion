<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> — Fugo Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style>
        :root {
            --sidebar-w: 260px;
            --accent: #3ddc97;
            --accent-dark: #2bc285;
            --dark-bg: #0c1222;
            --dark-card: #111a2e;
            --dark-border: #1c2a45;
            --dark-text: #8899b4;
            --dark-hover: #162038;
            --body-bg: #f0f2f5;
        }
        * { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--dark-bg);
            z-index: 1040;
            display: flex; flex-direction: column;
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--dark-border) transparent;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid var(--dark-border);
        }
        .sidebar-brand h4 {
            font-size: 1.25rem; font-weight: 800; letter-spacing: -.02em;
            color: #fff; margin: 0;
        }
        .sidebar-brand h4 span { color: var(--accent); }
        .sidebar-brand small { font-size: .7rem; color: var(--dark-text); text-transform: uppercase; letter-spacing: .1em; }

        .sidebar-section { padding: .75rem 1rem .25rem; }
        .sidebar-section-title {
            font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .12em;
            color: var(--dark-text); opacity: .5; margin-bottom: .25rem;
        }
        .sidebar-nav { list-style: none; padding: 0; margin: 0; }
        .sidebar-nav li a {
            display: flex; align-items: center; gap: .75rem;
            padding: .6rem 1.25rem;
            font-size: .84rem; font-weight: 500;
            color: var(--dark-text);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all .2s;
        }
        .sidebar-nav li a:hover {
            color: #fff;
            background: var(--dark-hover);
        }
        .sidebar-nav li a.active {
            color: #fff;
            background: var(--dark-hover);
            border-left-color: var(--accent);
        }
        .sidebar-nav li a.active i { color: var(--accent); }
        .sidebar-nav li a i { font-size: 1.1rem; width: 1.25rem; text-align: center; }
        .sidebar-nav li a .badge-count {
            margin-left: auto;
            background: var(--accent);
            color: var(--dark-bg);
            font-size: .65rem; font-weight: 700;
            padding: .15rem .45rem;
            border-radius: 50rem;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--dark-border);
        }
        .sidebar-user {
            display: flex; align-items: center; gap: .75rem;
        }
        .sidebar-user .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--accent);
            color: var(--dark-bg);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .8rem;
        }
        .sidebar-user .user-info { flex: 1; min-width: 0; }
        .sidebar-user .user-name { font-size: .82rem; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user .user-role { font-size: .68rem; color: var(--dark-text); }

        /* ── Main ── */
        .main-content {
            margin-left: var(--sidebar-w);
            background: var(--body-bg);
            min-height: 100vh;
            transition: margin-left .3s;
        }

        /* ── Top Bar ── */
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: .75rem 1.5rem;
            display: flex; align-items: center; gap: 1rem;
            position: sticky; top: 0; z-index: 1020;
        }
        .topbar-title {
            font-size: 1.1rem; font-weight: 700; color: #111827;
        }
        .topbar .breadcrumb { font-size: .78rem; margin: 0; }
        .topbar .breadcrumb-item a { color: #6b7280; text-decoration: none; }
        .topbar .breadcrumb-item.active { color: #111827; font-weight: 600; }
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: .5rem; }
        .topbar-btn {
            width: 36px; height: 36px; border-radius: 50%;
            background: #f3f4f6; border: none; color: #6b7280;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; transition: all .2s; cursor: pointer;
        }
        .topbar-btn:hover { background: #e5e7eb; color: #111827; }

        /* ── Cards & Content ── */
        .page-content { padding: 1.5rem; }
        .stat-card {
            background: #fff; border-radius: .75rem;
            padding: 1.25rem 1.5rem;
            border: 1px solid #e5e7eb;
            transition: all .2s;
        }
        .stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.06); transform: translateY(-1px); }
        .stat-card .stat-icon {
            width: 44px; height: 44px; border-radius: .5rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
        }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 800; color: #111827; line-height: 1; }
        .stat-card .stat-label { font-size: .78rem; color: #6b7280; font-weight: 500; }

        .card-modern {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: .75rem;
            overflow: hidden;
        }
        .card-modern .card-header {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.25rem;
            font-weight: 700;
            font-size: .9rem;
            color: #111827;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-modern .card-body { padding: 1.25rem; }

        /* ── Alert ── */
        .alert-modern {
            border-radius: .5rem; font-size: .85rem; font-weight: 500;
            border: none; padding: .75rem 1rem;
            display: flex; align-items: center; gap: .5rem;
        }

        /* ── Buttons ── */
        .btn-accent {
            background: var(--accent); color: var(--dark-bg);
            font-weight: 600; border: none;
        }
        .btn-accent:hover { background: var(--accent-dark); color: var(--dark-bg); }

        /* ── Table ── */
        .table-modern { font-size: .85rem; }
        .table-modern thead th {
            background: #f9fafb; font-weight: 600; text-transform: uppercase;
            font-size: .7rem; letter-spacing: .05em; color: #6b7280;
            border-bottom: 2px solid #e5e7eb; padding: .75rem 1rem;
        }
        .table-modern tbody td { padding: .75rem 1rem; vertical-align: middle; color: #374151; }
        .table-modern tbody tr { transition: background .15s; }
        .table-modern tbody tr:hover { background: #f9fafb; }

        /* ── Badge ── */
        .badge-status { font-size: .7rem; font-weight: 600; padding: .3rem .6rem; border-radius: 50rem; }

        /* ── Forms ── */
        .form-label-modern { font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: .35rem; }
        .form-control-modern {
            border: 1px solid #d1d5db; border-radius: .5rem; padding: .6rem .85rem;
            font-size: .85rem; transition: all .2s;
        }
        .form-control-modern:focus {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(61,220,151,.15);
        }

        /* ── Mobile ── */
        .sidebar-toggle { display: none; }
        .overlay { display: none; }
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-toggle { display: flex; }
            .overlay.show {
                display: block; position: fixed; inset: 0;
                background: rgba(0,0,0,.5); z-index: 1035;
            }
        }
        @media (max-width: 576px) {
            .page-content { padding: 1rem; }
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center; padding: 3rem 1rem; color: #9ca3af;
        }
        .empty-state i { font-size: 2.5rem; margin-bottom: .75rem; display: block; }
        .empty-state p { font-size: .9rem; }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <div class="overlay" id="overlay"></div>

    <!-- ══ SIDEBAR ══ -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h4>Fugo<span>Admin</span></h4>
            <small>Direction-A-Motion</small>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Main</div>
        </div>
        <ul class="sidebar-nav">
            <li><a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"><i class="bi bi-grid-1x2-fill"></i>Dashboard</a></li>
        </ul>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Content</div>
        </div>
        <ul class="sidebar-nav">
            <li><a href="<?php echo e(route('admin.content')); ?>" class="<?php echo e(request()->routeIs('admin.content') ? 'active' : ''); ?>"><i class="bi bi-sliders"></i>Website Settings</a></li>
            <li><a href="<?php echo e(route('admin.projects.index')); ?>" class="<?php echo e(request()->routeIs('admin.projects.*') ? 'active' : ''); ?>"><i class="bi bi-folder2-open"></i>Projects</a></li>
            <li><a href="<?php echo e(route('admin.services.index')); ?>" class="<?php echo e(request()->routeIs('admin.services.*') ? 'active' : ''); ?>"><i class="bi bi-layers"></i>Services</a></li>
            <li><a href="<?php echo e(route('admin.news.index')); ?>" class="<?php echo e(request()->routeIs('admin.news.*') ? 'active' : ''); ?>"><i class="bi bi-newspaper"></i>News / Blog</a></li>
        </ul>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Engagement</div>
        </div>
        <ul class="sidebar-nav">
            <li><a href="<?php echo e(route('admin.careers.index')); ?>" class="<?php echo e(request()->routeIs('admin.careers.*') ? 'active' : ''); ?>"><i class="bi bi-person-badge"></i>Careers</a></li>
            <li>
                <a href="<?php echo e(route('admin.messages.index')); ?>" class="<?php echo e(request()->routeIs('admin.messages.*') ? 'active' : ''); ?>">
                    <i class="bi bi-chat-dots"></i>Messages
                    <?php $unread = \App\Models\Message::where('is_read', false)->count(); ?>
                    <?php if($unread > 0): ?><span class="badge-count"><?php echo e($unread); ?></span><?php endif; ?>
                </a>
            </li>
        </ul>

        <div class="sidebar-section">
            <div class="sidebar-section-title">System</div>
        </div>
        <ul class="sidebar-nav">
            <li><a href="<?php echo e(route('admin.users.index')); ?>" class="<?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>"><i class="bi bi-people"></i>Admin Users</a></li>
        </ul>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="avatar"><?php echo e(strtoupper(substr(Auth::user()->name ?? 'A', 0, 1))); ?></div>
                <div class="user-info">
                    <div class="user-name"><?php echo e(Auth::user()->name ?? 'Admin'); ?></div>
                    <div class="user-role">Administrator</div>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="topbar-btn" title="Logout" style="background:var(--dark-hover);color:var(--dark-text);">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ══ MAIN ══ -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <button class="topbar-btn sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <div>
                <div class="topbar-title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></div>
                <nav aria-label="breadcrumb" class="d-none d-md-block">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Admin</a></li>
                        <li class="breadcrumb-item active"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></li>
                    </ol>
                </nav>
            </div>
            <div class="topbar-right">
                <a href="<?php echo e(route('home')); ?>" class="topbar-btn" title="View Website" target="_blank">
                    <i class="bi bi-globe2"></i>
                </a>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            <?php if(session('success')): ?>
                <div class="alert alert-modern alert-success alert-dismissible fade show mb-3">
                    <i class="bi bi-check-circle-fill"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:.65rem;"></button>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-modern alert-danger alert-dismissible fade show mb-3">
                    <i class="bi bi-x-circle-fill"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:.65rem;"></button>
                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-modern alert-danger mb-3">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($e); ?><br><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('overlay');

            if (toggle) toggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
            if (overlay) overlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        });
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/layout.blade.php ENDPATH**/ ?>