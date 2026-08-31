<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Fugo Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <style>
        :root {
            --sidebar-w: 248px;
            --topbar-h: 60px;
            --accent: #3ddc97;
            --accent-dim: rgba(61,220,151,.12);
            --accent-glow: rgba(61,220,151,.25);
            --bg-base: #07101f;
            --bg-sidebar: #0c1828;
            --bg-card: rgba(255,255,255,.04);
            --bg-card-hover: rgba(255,255,255,.07);
            --bg-input: rgba(255,255,255,.05);
            --border: rgba(255,255,255,.08);
            --border-hover: rgba(255,255,255,.15);
            --border-accent: rgba(61,220,151,.35);
            --tx-primary: #e8f0fe;
            --tx-secondary: #7a94b8;
            --tx-muted: #465d7a;
            --success: #3ddc97;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --radius: 14px;
            --radius-sm: 8px;
            --shadow: 0 4px 32px rgba(0,0,0,.45);
            --shadow-sm: 0 2px 12px rgba(0,0,0,.3);
            --transition: .2s cubic-bezier(.4,0,.2,1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 15px; -webkit-font-smoothing: antialiased; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-base);
            color: var(--tx-primary);
            min-height: 100vh;
            display: flex;
        }
        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; cursor: pointer; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,.15); }
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            z-index: 1040;
            display: flex; flex-direction: column;
            transition: transform var(--transition);
            overflow: hidden;
        }
        .sb-brand {
            display: flex; align-items: center; gap: .75rem;
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }
        .sb-brand-mark { width: 34px; height: 34px; flex-shrink: 0; }
        .sb-brand-text { line-height: 1.1; }
        .sb-brand-name { font-size: .95rem; font-weight: 800; letter-spacing: -.02em; color: var(--tx-primary); }
        .sb-brand-name span { color: var(--accent); }
        .sb-brand-sub { font-size: .65rem; color: var(--tx-muted); text-transform: uppercase; letter-spacing: .1em; }
        .sb-scroll { flex: 1; overflow-y: auto; padding: .5rem 0; scrollbar-width: thin; scrollbar-color: var(--border) transparent; }
        .sb-section { padding: 1rem 1.25rem .25rem; }
        .sb-section-label { font-size: .6rem; font-weight: 700; text-transform: uppercase; letter-spacing: .14em; color: var(--tx-muted); }
        .sb-nav { list-style: none; }
        .sb-nav-item a {
            display: flex; align-items: center; gap: .75rem;
            padding: .58rem 1.25rem;
            font-size: .83rem; font-weight: 500;
            color: var(--tx-secondary);
            border-left: 2px solid transparent;
            transition: all var(--transition);
        }
        .sb-nav-item a:hover { color: var(--tx-primary); background: var(--bg-card); }
        .sb-nav-item a.active { color: var(--accent); background: var(--accent-dim); border-left-color: var(--accent); }
        .sb-nav-item a .sb-icon { width: 18px; text-align: center; font-size: 1rem; flex-shrink: 0; }
        .sb-badge { margin-left: auto; background: var(--danger); color: #fff; font-size: .6rem; font-weight: 700; padding: .1rem .42rem; border-radius: 50rem; min-width: 18px; text-align: center; }
        .sb-footer { border-top: 1px solid var(--border); padding: 1rem 1.25rem; flex-shrink: 0; }
        .sb-user { display: flex; align-items: center; gap: .75rem; }
        .sb-avatar { width: 34px; height: 34px; border-radius: 50%; background: var(--accent-dim); border: 1.5px solid var(--accent); display: flex; align-items: center; justify-content: center; font-size: .75rem; font-weight: 700; color: var(--accent); flex-shrink: 0; }
        .sb-user-info { flex: 1; min-width: 0; }
        .sb-user-name { font-size: .8rem; font-weight: 600; color: var(--tx-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sb-user-role { font-size: .65rem; color: var(--tx-muted); }
        .sb-logout { width: 30px; height: 30px; border-radius: 8px; background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.2); color: var(--danger); display: flex; align-items: center; justify-content: center; font-size: .9rem; transition: all var(--transition); }
        .sb-logout:hover { background: rgba(239,68,68,.2); }
        .main-wrapper { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; transition: margin-left var(--transition); }
        .topbar { height: var(--topbar-h); background: rgba(7,16,31,.9); backdrop-filter: blur(16px) saturate(180%); -webkit-backdrop-filter: blur(16px) saturate(180%); border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 1rem; padding: 0 1.5rem; position: sticky; top: 0; z-index: 1020; }
        .topbar-burger { width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--bg-card); border: 1px solid var(--border); color: var(--tx-secondary); font-size: 1.1rem; display: none; align-items: center; justify-content: center; transition: all var(--transition); }
        .topbar-burger:hover { color: var(--tx-primary); background: var(--bg-card-hover); }
        .topbar-breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: .78rem; flex: 1; min-width: 0; }
        .topbar-breadcrumb .bc-item { color: var(--tx-muted); }
        .topbar-breadcrumb .bc-sep { color: var(--tx-muted); font-size: .65rem; }
        .topbar-breadcrumb .bc-current { font-weight: 700; font-size: .9rem; color: var(--tx-primary); }
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: .5rem; }
        .topbar-action { width: 36px; height: 36px; border-radius: var(--radius-sm); background: var(--bg-card); border: 1px solid var(--border); color: var(--tx-secondary); font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: all var(--transition); position: relative; }
        .topbar-action:hover { color: var(--tx-primary); background: var(--bg-card-hover); border-color: var(--border-hover); }
        .topbar-action .dot { position: absolute; top: 6px; right: 6px; width: 7px; height: 7px; border-radius: 50%; background: var(--danger); border: 1.5px solid var(--bg-base); }
        .topbar-divider { width: 1px; height: 22px; background: var(--border); margin: 0 .25rem; }
        .topbar-view-site { display: flex; align-items: center; gap: .5rem; padding: .42rem .9rem; border-radius: var(--radius-sm); background: var(--accent-dim); border: 1px solid var(--border-accent); color: var(--accent); font-size: .78rem; font-weight: 600; transition: all var(--transition); }
        .topbar-view-site:hover { background: rgba(61,220,151,.2); }
        .page-body { flex: 1; padding: 1.75rem; }
        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
        .card-header { padding: 1.1rem 1.4rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-size: .9rem; font-weight: 700; color: var(--tx-primary); display: flex; align-items: center; gap: .5rem; }
        .card-title i { color: var(--accent); }
        .card-body { padding: 1.4rem; }
        .stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.25rem 1.4rem; display: flex; align-items: center; gap: 1rem; transition: all var(--transition); }
        .stat-card:hover { background: var(--bg-card-hover); border-color: var(--border-hover); transform: translateY(-2px); box-shadow: var(--shadow-sm); }
        .stat-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        .stat-value { font-size: 1.7rem; font-weight: 800; color: var(--tx-primary); line-height: 1; letter-spacing: -.03em; }
        .stat-label { font-size: .75rem; color: var(--tx-secondary); font-weight: 500; margin-top: .2rem; }
        .btn { display: inline-flex; align-items: center; gap: .45rem; padding: .52rem 1.1rem; border-radius: var(--radius-sm); font-size: .82rem; font-weight: 600; border: 1px solid transparent; transition: all var(--transition); cursor: pointer; }
        .btn-accent { background: var(--accent); color: #07101f; border-color: var(--accent); }
        .btn-accent:hover { background: #2bc285; box-shadow: 0 0 20px var(--accent-glow); }
        .btn-ghost { background: var(--bg-card); color: var(--tx-secondary); border-color: var(--border); }
        .btn-ghost:hover { background: var(--bg-card-hover); color: var(--tx-primary); border-color: var(--border-hover); }
        .btn-danger { background: rgba(239,68,68,.1); color: var(--danger); border-color: rgba(239,68,68,.2); }
        .btn-danger:hover { background: rgba(239,68,68,.2); }
        .btn-sm { padding: .38rem .8rem; font-size: .76rem; }
        .btn-xs { padding: .24rem .6rem; font-size: .7rem; }
        .badge { display: inline-flex; align-items: center; padding: .22rem .6rem; border-radius: 50rem; font-size: .68rem; font-weight: 700; letter-spacing: .03em; }
        .badge-success { background: rgba(61,220,151,.12); color: var(--success); }
        .badge-warning { background: rgba(245,158,11,.12); color: var(--warning); }
        .badge-danger { background: rgba(239,68,68,.12); color: var(--danger); }
        .badge-info { background: rgba(59,130,246,.12); color: var(--info); }
        .badge-muted { background: rgba(255,255,255,.06); color: var(--tx-secondary); }
        .table { width: 100%; border-collapse: collapse; font-size: .83rem; }
        .table thead tr { border-bottom: 1px solid var(--border); }
        .table thead th { padding: .75rem 1rem; font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; color: var(--tx-muted); text-align: left; }
        .table tbody td { padding: .85rem 1rem; color: var(--tx-secondary); border-bottom: 1px solid var(--border); vertical-align: middle; }
        .table tbody tr:hover td { background: var(--bg-card-hover); }
        .table tbody tr:last-child td { border-bottom: none; }
        .form-group { margin-bottom: 1.1rem; }
        .form-label { display: block; font-size: .78rem; font-weight: 600; color: var(--tx-secondary); margin-bottom: .4rem; }
        .form-control { width: 100%; background: var(--bg-input); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: .6rem .9rem; font-size: .84rem; color: var(--tx-primary); font-family: inherit; transition: all var(--transition); outline: none; }
        .form-control::placeholder { color: var(--tx-muted); }
        .form-control:focus { border-color: var(--border-accent); box-shadow: 0 0 0 3px var(--accent-dim); background: rgba(61,220,151,.04); }
        textarea.form-control { resize: vertical; min-height: 90px; }
        select.form-control { appearance: none; cursor: pointer; }
        .alert { padding: .8rem 1rem; border-radius: var(--radius-sm); font-size: .83rem; font-weight: 500; display: flex; align-items: flex-start; gap: .6rem; margin-bottom: 1rem; }
        .alert-success { background: rgba(61,220,151,.1); border: 1px solid rgba(61,220,151,.25); color: #4ade80; }
        .alert-danger { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.25); color: #f87171; }
        .alert-close { margin-left: auto; background: none; border: none; color: inherit; opacity: .5; font-size: 1rem; cursor: pointer; flex-shrink: 0; }
        .alert-close:hover { opacity: 1; }
        .empty-state { text-align: center; padding: 3rem 1rem; }
        .empty-icon { width: 60px; height: 60px; border-radius: 50%; background: var(--bg-card); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--tx-muted); margin: 0 auto 1rem; }
        .empty-state h6 { font-size: .9rem; font-weight: 700; color: var(--tx-secondary); margin-bottom: .35rem; }
        .empty-state p { font-size: .8rem; color: var(--tx-muted); }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.6); z-index: 1035; }
        .grid { display: grid; }
        .g-3 { gap: 1rem; }
        .g-4 { gap: 1.5rem; }
        .cols-5 { grid-template-columns: repeat(5,1fr); }
        .cols-4 { grid-template-columns: repeat(4,1fr); }
        .cols-3 { grid-template-columns: repeat(3,1fr); }
        .cols-2 { grid-template-columns: repeat(2,1fr); }
        @media(max-width:1100px) { .cols-5 { grid-template-columns: repeat(3,1fr); } }
        @media(max-width:900px) { .cols-4,.cols-5 { grid-template-columns: repeat(2,1fr); } }
        @media(max-width:1024px) { .sidebar { transform: translateX(-100%); } .sidebar.open { transform: translateX(0); box-shadow: var(--shadow); } .sidebar-overlay.open { display: block; } .main-wrapper { margin-left: 0; } .topbar-burger { display: flex; } }
        @media(max-width:640px) { .page-body { padding: 1rem; } .cols-2,.cols-3,.cols-4,.cols-5 { grid-template-columns: 1fr; } }
        .d-flex { display: flex; }
        .align-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-1 { gap: .4rem; }
        .gap-2 { gap: .75rem; }
        .gap-3 { gap: 1rem; }
        .mt-2 { margin-top: .75rem; }
        .mt-3 { margin-top: 1rem; }
        .mb-2 { margin-bottom: .75rem; }
        .mb-3 { margin-bottom: 1rem; }
        .mb-4 { margin-bottom: 1.5rem; }
        .w-full { width: 100%; }
        .text-accent { color: var(--accent); }
        .text-muted { color: var(--tx-muted); }
        .text-secondary { color: var(--tx-secondary); }
        .text-danger { color: var(--danger); }
        .text-warning { color: var(--warning); }
        .fw-700 { font-weight: 700; }
        .fw-800 { font-weight: 800; }
        .fs-sm { font-size: .8rem; }
        .fs-xs { font-size: .72rem; }
    </style>
    @yield('styles')
</head>
<body x-data="{ sidebarOpen: false }">
<div class="sidebar-overlay" :class="{ open: sidebarOpen }" @click="sidebarOpen = false"></div>

<aside class="sidebar" :class="{ open: sidebarOpen }" id="sidebar">
    <div class="sb-brand">
        <svg class="sb-brand-mark" viewBox="0 0 34 34" fill="none">
            <path d="M10 6h13l-3.2 5.3H6.8z" fill="#3ddc97"/>
            <path d="M6.8 14h11.4l-3.2 5.3H3.6z" fill="#3ddc97" opacity=".75"/>
            <path d="M3.6 22h9.8l-3.2 5.3H.4z" fill="#3ddc97" opacity=".5"/>
        </svg>
        <div class="sb-brand-text">
            <div class="sb-brand-name">Fugo<span>Admin</span></div>
            <div class="sb-brand-sub">Direction-A-Motion</div>
        </div>
    </div>
    <div class="sb-scroll">
        <div class="sb-section"><div class="sb-section-label">Main</div></div>
        <ul class="sb-nav">
            <li class="sb-nav-item"><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2-fill sb-icon"></i> Dashboard</a></li>
        </ul>
        <div class="sb-section"><div class="sb-section-label">Page Manager</div></div>
        <ul class="sb-nav">
            <li class="sb-nav-item"><a href="{{ route('admin.content') }}?page=home" class="{{ request()->routeIs('admin.content') && (request('page','home')==='home' || !request('page')) ? 'active' : '' }}"><i class="bi bi-house-fill sb-icon"></i> Home Page</a></li>
            <li class="sb-nav-item"><a href="{{ route('admin.content') }}?page=work" class="{{ request()->routeIs('admin.content') && request('page')==='work' ? 'active' : '' }}"><i class="bi bi-folder2-open sb-icon"></i> Work Page</a></li>
            <li class="sb-nav-item"><a href="{{ route('admin.content') }}?page=services" class="{{ request()->routeIs('admin.content') && request('page')==='services' ? 'active' : '' }}"><i class="bi bi-layers sb-icon"></i> Services Page</a></li>
            <li class="sb-nav-item"><a href="{{ route('admin.content') }}?page=about" class="{{ request()->routeIs('admin.content') && request('page')==='about' ? 'active' : '' }}"><i class="bi bi-people-fill sb-icon"></i> About / Studio</a></li>
            <li class="sb-nav-item"><a href="{{ route('admin.content') }}?page=contact" class="{{ request()->routeIs('admin.content') && request('page')==='contact' ? 'active' : '' }}"><i class="bi bi-envelope-fill sb-icon"></i> Contact Page</a></li>
        </ul>
        <div class="sb-section"><div class="sb-section-label">Content</div></div>
        <ul class="sb-nav">
            <li class="sb-nav-item"><a href="{{ route('admin.projects.index') }}" class="{{ request()->routeIs('admin.projects.*') ? 'active' : '' }}"><i class="bi bi-collection-fill sb-icon"></i> Projects</a></li>
            <li class="sb-nav-item"><a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}"><i class="bi bi-grid-3x3-gap-fill sb-icon"></i> Services</a></li>
            <li class="sb-nav-item"><a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}"><i class="bi bi-newspaper sb-icon"></i> News / Blog</a></li>
        </ul>
        <div class="sb-section"><div class="sb-section-label">Engagement</div></div>
        <ul class="sb-nav">
            <li class="sb-nav-item"><a href="{{ route('admin.careers.index') }}" class="{{ request()->routeIs('admin.careers.*') ? 'active' : '' }}"><i class="bi bi-person-badge-fill sb-icon"></i> Careers</a></li>
            <li class="sb-nav-item">
                @php $unread = \App\Models\Message::where('is_read', false)->count(); @endphp
                <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"><i class="bi bi-chat-dots-fill sb-icon"></i> Messages @if($unread > 0)<span class="sb-badge">{{ $unread }}</span>@endif</a>
            </li>
        </ul>
        <div class="sb-section"><div class="sb-section-label">System</div></div>
        <ul class="sb-nav">
            <li class="sb-nav-item"><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="bi bi-shield-person-fill sb-icon"></i> Admin Users</a></li>
        </ul>
    </div>
    <div class="sb-footer">
        <div class="sb-user">
            <div class="sb-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
            <div class="sb-user-info">
                <div class="sb-user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="sb-user-role">Administrator</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="sb-logout" title="Logout"><i class="bi bi-box-arrow-right"></i></button>
            </form>
        </div>
    </div>
</aside>

<div class="main-wrapper">
    <header class="topbar">
        <button class="topbar-burger" @click="sidebarOpen = !sidebarOpen"><i class="bi bi-list"></i></button>
        <div class="topbar-breadcrumb">
            <span class="bc-item">Admin</span>
            <i class="bi bi-chevron-right bc-sep"></i>
            <span class="bc-current">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
            @php $msgCount = \App\Models\Message::where('is_read',false)->count(); @endphp
            <a href="{{ route('admin.messages.index') }}" class="topbar-action" title="Messages">
                <i class="bi bi-chat-dots"></i>
                @if($msgCount > 0)<span class="dot"></span>@endif
            </a>
            <div class="topbar-divider"></div>
            <a href="{{ route('home') }}" target="_blank" class="topbar-view-site">
                <i class="bi bi-arrow-up-right-circle"></i> View Site
            </a>
        </div>
    </header>
    <main class="page-body">
        @if(session('success'))
        <div class="alert alert-success" x-data x-init="setTimeout(() => $el.remove(), 4000)">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
            <button class="alert-close" @click="$el.closest('.alert').remove()"><i class="bi bi-x"></i></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger" x-data x-init="setTimeout(() => $el.remove(), 5000)">
            <i class="bi bi-x-circle-fill"></i>
            <span>{{ session('error') }}</span>
            <button class="alert-close" @click="$el.closest('.alert').remove()"><i class="bi bi-x"></i></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
        @endif
        @yield('content')
    </main>
</div>
@yield('scripts')
</body>
</html>
