<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Fugo Creative Group</title>
    <link rel="icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-50:#ecfdf5;--green-100:#d1fae5;--green-200:#a7f3d0;--green-400:#34d399;
            --green-500:#10b981;--green-600:#059669;--green-700:#047857;
            --gray-50:#f9fafb;--gray-100:#f3f4f6;--gray-200:#e5e7eb;--gray-300:#d1d5db;
            --gray-400:#9ca3af;--gray-500:#6b7280;--gray-600:#4b5563;--gray-700:#374151;
            --gray-800:#1f2937;--gray-900:#111827;
            --danger:#ef4444;--danger-bg:#fef2f2;--warning:#f59e0b;--warning-bg:#fffbeb;
            --sidebar-w:260px;--topbar-h:56px;
            --radius-sm:6px;--radius-md:8px;--radius-lg:12px;--radius-xl:16px;
            --shadow-xs:0 1px 2px rgba(0,0,0,.04);--shadow-sm:0 1px 3px rgba(0,0,0,.06);
            --shadow-md:0 4px 12px rgba(0,0,0,.08);--shadow-lg:0 8px 25px rgba(0,0,0,.1);
            --shadow-green:0 4px 14px rgba(16,185,129,.15);
        }
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;background:var(--gray-50);color:var(--gray-900);font-size:.8125rem;line-height:1.5;-webkit-font-smoothing:antialiased}

        /* ── Sidebar ── */
        .sidebar{position:fixed;top:0;left:0;width:var(--sidebar-w);height:100vh;background:#fff;border-right:1px solid var(--gray-200);z-index:1000;display:flex;flex-direction:column;transition:transform .3s cubic-bezier(.4,0,.2,1);overflow-y:auto;scrollbar-width:thin;scrollbar-color:var(--gray-200) transparent}
        .sidebar-brand{padding:1.5rem 1.25rem 1.25rem;border-bottom:1px solid var(--gray-100)}
        .sidebar-brand h4{font-size:1.1rem;font-weight:800;letter-spacing:-.02em;color:var(--gray-900);margin:0;line-height:1.2}
        .sidebar-brand h4 span{color:var(--green-500)}
        .sidebar-brand small{font-size:.65rem;color:var(--gray-400);text-transform:uppercase;letter-spacing:.1em;font-weight:600}
        .sidebar-section{padding:.75rem 1.25rem .35rem}
        .sidebar-section-title{font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:var(--gray-400);margin-bottom:.25rem}
        .sidebar-nav{list-style:none;padding:0;margin:0}
        .sidebar-nav li a{display:flex;align-items:center;gap:.65rem;padding:.5rem 1.25rem;font-size:.8rem;font-weight:500;color:var(--gray-500);text-decoration:none;border-left:3px solid transparent;transition:all .2s}
        .sidebar-nav li a:hover{color:var(--gray-800);background:var(--gray-50)}
        .sidebar-nav li a.active{color:var(--green-700);background:var(--green-50);border-left-color:var(--green-500);font-weight:600}
        .sidebar-nav li a.active i{color:var(--green-500)}
        .sidebar-nav li a i{font-size:1.05rem;width:1.15rem;text-align:center}
        .sidebar-submenu{list-style:none;padding:0 0 0 1.5rem;margin:0;border-left:1px dashed var(--gray-200)}
        .sidebar-submenu li{display:block}
        .sidebar-submenu li a{display:flex;align-items:center;gap:.65rem;padding:.4rem 1.25rem;font-size:.78rem;font-weight:400;color:var(--gray-500);text-decoration:none;border-left:3px solid transparent;transition:all .2s}
        .sidebar-submenu li a:hover{color:var(--gray-800);background:var(--gray-50)}
        .sidebar-submenu li a.active{color:var(--green-700);background:var(--green-50);border-left-color:var(--green-500)}
        .sidebar-footer{margin-top:auto;padding:1rem 1.25rem;border-top:1px solid var(--gray-100)}
        .sidebar-user{display:flex;align-items:center;gap:.65rem}
        .sidebar-user .avatar{width:34px;height:34px;border-radius:50%;background:var(--green-500);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;flex-shrink:0}
        .sidebar-user .user-info{flex:1;min-width:0}
        .sidebar-user .user-name{font-size:.78rem;font-weight:600;color:var(--gray-900);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .sidebar-user .user-role{font-size:.65rem;color:var(--gray-400)}
        .sidebar-user .btn-logout{width:30px;height:30px;border-radius:50%;background:transparent;border:none;color:var(--gray-400);display:flex;align-items:center;justify-content:center;transition:all .2s;cursor:pointer;flex-shrink:0}
        .sidebar-user .btn-logout:hover{background:var(--danger-bg);color:var(--danger)}

        /* ── Main Content ── */
        .main-content{margin-left:var(--sidebar-w);min-height:100vh;transition:margin-left .3s}

        /* ── Topbar ── */
        .topbar{position:sticky;top:0;background:#fff;border-bottom:1px solid var(--gray-200);padding:0 1.5rem;height:var(--topbar-h);display:flex;align-items:center;gap:1rem;z-index:100}
        .topbar-title{font-size:1rem;font-weight:700;color:var(--gray-900)}
        .topbar .breadcrumb{font-size:.75rem;margin:0;padding:0;background:none}
        .topbar .breadcrumb-item a{color:var(--gray-400);text-decoration:none;transition:color .15s}
        .topbar .breadcrumb-item a:hover{color:var(--green-500)}
        .topbar .breadcrumb-item.active{color:var(--gray-700);font-weight:600}
        .topbar .breadcrumb-item+.breadcrumb-item::before{color:var(--gray-300)}
        .topbar-right{margin-left:auto;display:flex;align-items:center;gap:.5rem}
        .topbar-btn{width:34px;height:34px;border-radius:50%;background:var(--gray-100);border:none;color:var(--gray-500);display:flex;align-items:center;justify-content:center;font-size:1rem;transition:all .2s;cursor:pointer;text-decoration:none}
        .topbar-btn:hover{background:var(--gray-200);color:var(--gray-900)}

        /* ── Content Area ── */
        .content-area{padding:1.5rem 1.75rem 3rem}

        /* ── Cards ── */
        .card-white{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);padding:var(--space-5,1.25rem);margin-bottom:1.25rem}
        .card-white--flush{padding:0;overflow:hidden}

        /* ── Stat Cards ── */
        .stat-card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);padding:1.25rem 1.5rem;transition:all .25s}
        .stat-card:hover{box-shadow:var(--shadow-sm);transform:translateY(-1px)}
        .stat-card .stat-icon{width:42px;height:42px;border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;font-size:1.1rem;margin-bottom:.75rem}
        .stat-card .stat-value{font-size:1.6rem;font-weight:800;color:var(--gray-900);line-height:1}
        .stat-card .stat-label{font-size:.75rem;color:var(--gray-500);font-weight:500;margin-top:.25rem}

        /* ── Buttons ── */
        .btn-primary{background:var(--green-500);border-color:var(--green-500);border-radius:var(--radius-md);font-weight:600;font-size:.8rem;padding:.4rem .9rem;transition:all .2s}
        .btn-primary:hover{background:var(--green-600);border-color:var(--green-600);box-shadow:var(--shadow-green)}
        .btn-secondary{background:#fff;border:1px solid var(--gray-300);color:var(--gray-700);border-radius:var(--radius-md);font-weight:500;font-size:.8rem;padding:.4rem .9rem;transition:all .15s}
        .btn-secondary:hover{background:var(--gray-50);border-color:var(--gray-400)}
        .btn-danger{background:var(--danger);border-color:var(--danger);border-radius:var(--radius-md);font-weight:600;font-size:.8rem;padding:.4rem .9rem;transition:all .15s}
        .btn-danger:hover{background:#dc2626;border-color:#dc2626}
        .btn-success{background:var(--green-500);border-color:var(--green-500);border-radius:var(--radius-md);font-weight:600;font-size:.8rem}
        .btn-sm{padding:.3rem .7rem;font-size:.73rem}
        .btn{transition:all .15s;cursor:pointer}

        /* ── Tables ── */
        .table-modern{width:100%;border-collapse:separate;border-spacing:0}
        .table-modern thead th{background:var(--gray-50);border-bottom:2px solid var(--gray-200);padding:.7rem 1rem;font-size:.68rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:var(--gray-500)}
        .table-modern tbody td{padding:.65rem 1rem;border-bottom:1px solid var(--gray-100);font-size:.8rem;vertical-align:middle;color:var(--gray-700)}
        .table-modern tbody tr{transition:background .15s}
        .table-modern tbody tr:hover{background:var(--gray-50)}

        /* ── Badges ── */
        .badge-active{background:var(--green-50);color:var(--green-700);padding:.2rem .55rem;border-radius:50rem;font-size:.68rem;font-weight:600}
        .badge-inactive{background:var(--danger-bg);color:#b91c1c;padding:.2rem .55rem;border-radius:50rem;font-size:.68rem;font-weight:600}
        .badge-pending{background:var(--warning-bg);color:#92400e;padding:.2rem .55rem;border-radius:50rem;font-size:.68rem;font-weight:600}
        .badge-category{background:#eff6ff;color:#1d4ed8;padding:.2rem .55rem;border-radius:50rem;font-size:.68rem;font-weight:600}
        .badge-reviewed{background:#e0e7ff;color:#4338ca;padding:.2rem .55rem;border-radius:50rem;font-size:.68rem;font-weight:600}
        .badge-featured{background:#fef3c7;color:#92400e;padding:.2rem .55rem;border-radius:50rem;font-size:.68rem;font-weight:600}

        /* ── Status Dots ── */
        .status-dot{width:7px;height:7px;border-radius:50%;display:inline-block;margin-right:.35rem;vertical-align:middle}
        .status-dot--active{background:var(--green-500)}
        .status-dot--inactive{background:var(--gray-300)}

        /* ── Forms ── */
        .form-section{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);padding:1.25rem 1.5rem;margin-bottom:1.25rem}
        .form-section-title{font-size:.95rem;font-weight:600;color:var(--gray-900);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--gray-100)}
        .form-group{margin-bottom:1rem}
        .form-label{font-size:.8rem;font-weight:600;color:var(--gray-700);margin-bottom:.3rem}
        .form-control{border:1px solid var(--gray-300);border-radius:var(--radius-md);padding:.5rem .75rem;font-size:.8rem;transition:all .2s;color:var(--gray-900)}
        .form-control:focus{border-color:var(--green-500);box-shadow:0 0 0 3px rgba(16,185,129,.1);outline:none}
        .form-control::placeholder{color:var(--gray-400)}
        .form-select{border:1px solid var(--gray-300);border-radius:var(--radius-md);padding:.5rem .75rem;font-size:.8rem;transition:all .2s;color:var(--gray-900)}
        .form-select:focus{border-color:var(--green-500);box-shadow:0 0 0 3px rgba(16,185,129,.1);outline:none}
        .form-text{font-size:.7rem;color:var(--gray-400);margin-top:.2rem}
        .invalid-feedback{font-size:.72rem;color:var(--danger);margin-top:.2rem}
        .form-check-input:checked{background-color:var(--green-500);border-color:var(--green-500)}
        .form-check-input:focus{box-shadow:0 0 0 3px rgba(16,185,129,.15)}
        .form-actions{display:flex;justify-content:flex-end;gap:.5rem;margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--gray-100)}
        .required{color:var(--danger)}

        /* ── Alerts ── */
        .alert{border-radius:var(--radius-md);font-size:.8rem;padding:.7rem 1rem;border:none;display:flex;align-items:center;gap:.5rem;animation:slideIn .3s ease}
        .alert-success{background:var(--green-50);color:var(--green-700)}
        .alert-danger{background:var(--danger-bg);color:#b91c1c}
        @keyframes slideIn{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}

        /* ── Breadcrumb ── */
        .breadcrumb-custom{display:flex;align-items:center;gap:.4rem;font-size:.78rem;margin-bottom:1.25rem}
        .breadcrumb-custom a{color:var(--gray-400);text-decoration:none;transition:color .15s}
        .breadcrumb-custom a:hover{color:var(--green-500)}
        .breadcrumb-custom .sep{color:var(--gray-300)}
        .breadcrumb-custom strong{color:var(--gray-700);font-weight:600}

        /* ── Page Header ── */
        .page-header{margin-bottom:1.5rem}
        .page-header h2{font-size:1.2rem;font-weight:700;color:var(--gray-900);margin:0}
        .page-header p{font-size:.78rem;color:var(--gray-500);margin:.15rem 0 0}

        /* ── Empty State ── */
        .empty-state{text-align:center;padding:2.5rem 1.5rem;color:var(--gray-400);background:var(--gray-50);border-radius:var(--radius-lg);border:1px dashed var(--gray-200)}
        .empty-state i{font-size:2.2rem;margin-bottom:.65rem;display:block;color:var(--gray-300)}
        .empty-state p{font-size:.85rem;margin:0}

        /* ── Dashboard Cards ── */
        .dashboard-card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);padding:1.75rem 1.25rem;text-align:center;cursor:pointer;transition:all .25s;display:block;text-decoration:none}
        .dashboard-card:hover{box-shadow:var(--shadow-green);border-color:var(--green-400);transform:translateY(-2px)}
        .dashboard-card-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto .85rem;font-size:1.4rem;background:var(--green-50);color:var(--green-600)}
        .dashboard-card-title{font-size:.95rem;font-weight:600;color:var(--gray-900);margin-bottom:.3rem}
        .dashboard-card-desc{font-size:.78rem;color:var(--gray-500);margin:0}

        /* ── List Cards ── */
        .list-card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);padding:1.15rem;text-decoration:none;display:flex;align-items:flex-start;gap:.85rem;transition:all .25s;cursor:pointer}
        .list-card:hover{box-shadow:var(--shadow-md);border-color:var(--gray-300)}
        .list-card-icon{width:44px;height:44px;border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.1rem}
        .list-card-title{font-size:.9rem;font-weight:600;color:var(--gray-900);margin-bottom:.2rem}
        .list-card-desc{font-size:.76rem;color:var(--gray-500);margin:0}
        .list-card-arrow{margin-left:auto;color:var(--gray-300);font-size:.85rem;margin-top:.45rem;transition:color .2s}
        .list-card:hover .list-card-arrow{color:var(--green-500)}

        /* ── Modal ── */
        .modal-content{border:1px solid var(--gray-200);border-radius:var(--radius-lg);overflow:hidden}
        .modal-header{border-bottom:1px solid var(--gray-100);padding:1rem 1.25rem}
        .modal-title{font-size:.9rem;font-weight:600}
        .modal-body{padding:1.25rem}
        .modal-footer{border-top:1px solid var(--gray-100);padding:.85rem 1.25rem}

        /* ── Mobile ── */
        .hamburger{display:none;background:none;border:none;font-size:1.15rem;color:var(--gray-600);cursor:pointer}
        .sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:999}
        @media(max-width:991.98px){
            .sidebar{transform:translateX(-100%);width:280px}
            .sidebar.show{transform:translateX(0)}
            .main-content{margin-left:0}
            .hamburger{display:block}
            .sidebar.show~.sidebar-overlay{display:block}
        }
        @media(max-width:576px){
            .content-area{padding:1rem}
        }

        /* ── Utilities ── */
        .text-green{color:var(--green-600)}
        .text-muted{color:var(--gray-500)}
        .text-danger{color:var(--danger)}
        .fw-600{font-weight:600}
        .gap-2{gap:.5rem}
        .d-inline{display:inline}
        .table-responsive{overflow-x:auto;-webkit-overflow-scrolling:touch}

        /* ── Toggle Switch ── */
        .svc-toggle{position:relative;width:36px;height:20px;background:var(--gray-200);border-radius:10px;cursor:pointer;transition:background .2s;flex-shrink:0}
        .svc-toggle.on{background:var(--green-500)}
        .svc-toggle::after{content:'';position:absolute;top:2px;left:2px;width:16px;height:16px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15)}
        .svc-toggle.on::after{transform:translateX(16px)}

        /* ── Transition Utilities ── */
        .opacity-0{opacity:0}
        .opacity-100{opacity:1}
        .transition{transition:all .2s ease}

    </style>
    @stack('styles')
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" style="text-decoration:none">
                <h4>FUGO<span>.</span></h4>
                <small>Admin Panel</small>
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Main</div>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2-fill"></i>Dashboard</a></li>
        </ul>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Page Manager</div>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('admin.translations.index') }}" class="{{ request()->routeIs('admin.translations*') ? 'active' : '' }}"><i class="bi bi-translate"></i>Translations <span style="margin-left:auto;font-size:.62rem;background:var(--green-50);color:var(--green-700);padding:.12rem .42rem;border-radius:999px;font-weight:800;border:1px solid var(--green-200)">EN | ID</span></a></li>
            <li><a href="{{ route('admin.home') }}" class="{{ request()->routeIs('admin.home') ? 'active' : '' }}"><i class="bi bi-house-door"></i>Home</a></li>
            <li><a href="{{ route('admin.portfolio.index') }}" class="{{ request()->routeIs('admin.portfolio*') ? 'active' : '' }}"><i class="bi bi-briefcase"></i>Work</a></li>
            <li><a href="{{ route('admin.work-settings.edit') }}" class="{{ request()->routeIs('admin.work-settings*') ? 'active' : '' }}"><i class="bi bi-gear"></i>Work Page</a></li>
            <li><a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services*') ? 'active' : '' }}"><i class="bi bi-gear"></i>Services</a></li>
            <li><a href="{{ route('admin.about.index') }}" class="{{ request()->routeIs('admin.about*') ? 'active' : '' }}"><i class="bi bi-building"></i>About</a></li>
            <li><a href="{{ route('admin.contact.index') }}" class="{{ request()->routeIs('admin.contact*') && !request()->routeIs('admin.career*') ? 'active' : '' }}"><i class="bi bi-envelope"></i>Contact</a></li>
        </ul>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Engagement</div>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('admin.career.index') }}" class="{{ request()->routeIs('admin.career*') ? 'active' : '' }}"><i class="bi bi-person-badge"></i>Career</a></li>
            <li><a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news*') ? 'active' : '' }}"><i class="bi bi-newspaper"></i>News</a></li>
        </ul>

        <div class="sidebar-section">
            <div class="sidebar-section-title">System</div>
        </div>
        <ul class="sidebar-nav">
            <li><a href="{{ route('admin.account.index') }}" class="{{ request()->routeIs('admin.account*') ? 'active' : '' }}"><i class="bi bi-people"></i>Admin Users</a></li>
        </ul>
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="avatar">{{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ auth('admin')->user()->name ?? 'Admin' }}</div>
                    <div class="user-role">Administrator</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin:0">
                    @csrf
                    <button type="submit" class="btn-logout" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="main-content">
        <div class="topbar">
            <button class="hamburger" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list"></i>
            </button>
            <div>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                @hasSection('breadcrumb')
                <nav aria-label="breadcrumb" class="d-none d-md-block">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
                @endif
            </div>
            <div class="topbar-right">
                @php $adminLocale = request()->route('locale') ?? 'en'; $adminOther = $adminLocale === 'en' ? 'id' : 'en'; @endphp
                <div class="lang" data-lang="{{ $adminLocale }}" role="group" aria-label="Language" style="margin-right:.5rem">
                    <span class="lang__pill" aria-hidden="true"></span>
                    <a class="lang__btn {{ $adminLocale==='en' ? 'is-on' : '' }}" href="{{ url('admin/en') }}" aria-label="English">EN</a>
                    <a class="lang__btn {{ $adminLocale==='id' ? 'is-on' : '' }}" href="{{ url('admin/id') }}" aria-label="Bahasa Indonesia">ID</a>
                </div>
                @if($adminLocale==='en')
                    <span style="font-size:.65rem;font-weight:700;letter-spacing:.08em;color:var(--green-600);background:var(--green-50);border:1px solid var(--green-200);padding:.25rem .5rem;border-radius:999px">EN</span>
                @else
                    <span style="font-size:.65rem;font-weight:700;letter-spacing:.08em;color:#b45309;background:#fffbeb;border:1px solid #fde68a;padding:.25rem .5rem;border-radius:999px">ID</span>
                @endif
                <a href="{{ url('/' . $adminLocale) }}" target="_blank" class="topbar-btn" title="View Website {{ strtoupper($adminLocale) }}">
                    <i class="bi bi-globe2"></i>
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="content-area" style="padding-bottom:0">
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="content-area" style="padding-bottom:0">
            <div class="alert alert-danger">
                <i class="bi bi-x-circle-fill"></i> {{ session('error') }}
            </div>
        </div>
        @endif
        @if($errors->any())
        <div class="content-area" style="padding-bottom:0">
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>@foreach($errors->all() as $e) {{ $e }}<br>@endforeach</div>
            </div>
        </div>
        @endif

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <div class="sidebar-overlay" onclick="document.getElementById('sidebar').classList.remove('show')"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script defer src="{{ asset('vendor/alpine/alpine.min.js') }}"></script>
</body>
</html>
