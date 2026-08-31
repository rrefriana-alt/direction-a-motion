@extends('admin.layout')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('content')

{{-- Greeting --}}
<div class="d-flex align-center justify-between mb-4">
    <div>
        <h1 style="font-size:1.4rem;font-weight:800;color:var(--tx-primary);letter-spacing:-.02em;">
            Welcome back, {{ explode(' ', Auth::user()->name ?? 'Admin')[0] }} 👋
        </h1>
        <p style="font-size:.82rem;color:var(--tx-secondary);margin-top:.25rem;">
            Here's what's happening with your website today.
        </p>
    </div>
    <a href="{{ route('home') }}" target="_blank" class="btn btn-ghost btn-sm" style="display:flex;">
        <i class="bi bi-arrow-up-right-circle"></i> View Website
    </a>
</div>

{{-- Stats --}}
<div class="grid cols-5 g-3 mb-4">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(59,130,246,.12);color:#3b82f6;">
            <i class="bi bi-collection-fill"></i>
        </div>
        <div>
            <div class="stat-value">{{ $projects_count ?? 0 }}</div>
            <div class="stat-label">Projects</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(61,220,151,.12);color:var(--accent);">
            <i class="bi bi-layers-fill"></i>
        </div>
        <div>
            <div class="stat-value">{{ $services_count ?? 0 }}</div>
            <div class="stat-label">Services</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(245,158,11,.12);color:#f59e0b;">
            <i class="bi bi-chat-dots-fill"></i>
        </div>
        <div>
            <div class="stat-value">{{ $messages_count ?? 0 }}</div>
            <div class="stat-label">New Messages</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(139,92,246,.12);color:#8b5cf6;">
            <i class="bi bi-person-badge-fill"></i>
        </div>
        <div>
            <div class="stat-value">{{ $careers_count ?? 0 }}</div>
            <div class="stat-label">Open Positions</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(239,68,68,.12);color:#ef4444;">
            <i class="bi bi-newspaper"></i>
        </div>
        <div>
            <div class="stat-value">{{ $news_count ?? 0 }}</div>
            <div class="stat-label">Articles</div>
        </div>
    </div>
</div>

{{-- Main area --}}
<div class="grid g-4" style="grid-template-columns:1fr 360px;">

    {{-- Page Manager Card --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="bi bi-layout-text-sidebar-reverse"></i> Page Section Manager</div>
            <span style="font-size:.72rem;color:var(--tx-muted);">Click a page to manage its content</span>
        </div>
        <div style="padding:1rem;">
            @php
            $pages = [
                ['key'=>'home',     'icon'=>'bi-house-fill',       'label'=>'Home Page',     'desc'=>'Hero, Manifesto, Services overview, CTA sections', 'color'=>'rgba(61,220,151,.12)', 'tcolor'=>'#3ddc97'],
                ['key'=>'work',     'icon'=>'bi-folder2-open',     'label'=>'Work Page',     'desc'=>'Page header and filter labels',                      'color'=>'rgba(59,130,246,.12)', 'tcolor'=>'#3b82f6'],
                ['key'=>'services', 'icon'=>'bi-layers-fill',      'label'=>'Services Page', 'desc'=>'Page header and service category descriptions',      'color'=>'rgba(139,92,246,.12)', 'tcolor'=>'#8b5cf6'],
                ['key'=>'about',    'icon'=>'bi-people-fill',      'label'=>'About / Studio','desc'=>'Hero, founder quote, values, stats',                  'color'=>'rgba(245,158,11,.12)', 'tcolor'=>'#f59e0b'],
                ['key'=>'contact',  'icon'=>'bi-envelope-fill',    'label'=>'Contact Page',  'desc'=>'Header, email, phone, address info',                 'color'=>'rgba(239,68,68,.12)',  'tcolor'=>'#ef4444'],
            ];
            @endphp
            @foreach($pages as $p)
            <a href="{{ route('admin.content') }}?page={{ $p['key'] }}" style="display:flex;align-items:center;gap:1rem;padding:.9rem 1rem;border-radius:10px;border:1px solid var(--border);background:var(--bg-card);margin-bottom:.6rem;transition:all .2s;text-decoration:none;"
               onmouseover="this.style.background='var(--bg-card-hover)';this.style.borderColor='var(--border-hover)'"
               onmouseout="this.style.background='var(--bg-card)';this.style.borderColor='var(--border)'">
                <div style="width:40px;height:40px;border-radius:10px;background:{{ $p['color'] }};color:{{ $p['tcolor'] }};display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">
                    <i class="bi {{ $p['icon'] }}"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:.85rem;font-weight:700;color:var(--tx-primary);">{{ $p['label'] }}</div>
                    <div style="font-size:.73rem;color:var(--tx-muted);margin-top:.1rem;">{{ $p['desc'] }}</div>
                </div>
                <i class="bi bi-chevron-right" style="color:var(--tx-muted);font-size:.8rem;"></i>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Right column --}}
    <div style="display:flex;flex-direction:column;gap:1rem;">

        {{-- Quick Actions --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="bi bi-lightning-fill"></i> Quick Actions</div>
            </div>
            <div style="padding:1rem;display:grid;grid-template-columns:1fr 1fr;gap:.6rem;">
                <a href="{{ route('admin.projects.create') }}" style="display:flex;flex-direction:column;align-items:center;gap:.5rem;padding:.85rem .5rem;border-radius:10px;background:var(--bg-card);border:1px solid var(--border);color:var(--tx-secondary);font-size:.75rem;font-weight:600;text-decoration:none;transition:all .2s;text-align:center;"
                   onmouseover="this.style.background='var(--bg-card-hover)';this.style.color='var(--tx-primary)'"
                   onmouseout="this.style.background='var(--bg-card)';this.style.color='var(--tx-secondary)'">
                    <i class="bi bi-folder-plus" style="font-size:1.3rem;color:#3b82f6;"></i>New Project
                </a>
                <a href="{{ route('admin.news.create') }}" style="display:flex;flex-direction:column;align-items:center;gap:.5rem;padding:.85rem .5rem;border-radius:10px;background:var(--bg-card);border:1px solid var(--border);color:var(--tx-secondary);font-size:.75rem;font-weight:600;text-decoration:none;transition:all .2s;text-align:center;"
                   onmouseover="this.style.background='var(--bg-card-hover)';this.style.color='var(--tx-primary)'"
                   onmouseout="this.style.background='var(--bg-card)';this.style.color='var(--tx-secondary)'">
                    <i class="bi bi-journal-plus" style="font-size:1.3rem;color:#8b5cf6;"></i>New Article
                </a>
                <a href="{{ route('admin.services.create') }}" style="display:flex;flex-direction:column;align-items:center;gap:.5rem;padding:.85rem .5rem;border-radius:10px;background:var(--bg-card);border:1px solid var(--border);color:var(--tx-secondary);font-size:.75rem;font-weight:600;text-decoration:none;transition:all .2s;text-align:center;"
                   onmouseover="this.style.background='var(--bg-card-hover)';this.style.color='var(--tx-primary)'"
                   onmouseout="this.style.background='var(--bg-card)';this.style.color='var(--tx-secondary)'">
                    <i class="bi bi-plus-circle" style="font-size:1.3rem;color:var(--accent);"></i>Add Service
                </a>
                <a href="{{ route('admin.messages.index') }}" style="display:flex;flex-direction:column;align-items:center;gap:.5rem;padding:.85rem .5rem;border-radius:10px;background:var(--bg-card);border:1px solid var(--border);color:var(--tx-secondary);font-size:.75rem;font-weight:600;text-decoration:none;transition:all .2s;text-align:center;"
                   onmouseover="this.style.background='var(--bg-card-hover)';this.style.color='var(--tx-primary)'"
                   onmouseout="this.style.background='var(--bg-card)';this.style.color='var(--tx-secondary)'">
                    <i class="bi bi-inbox" style="font-size:1.3rem;color:#f59e0b;"></i>Messages
                </a>
            </div>
        </div>

        {{-- System Info --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="bi bi-cpu"></i> System</div>
            </div>
            <div style="padding:1rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;padding:.55rem 0;border-bottom:1px solid var(--border);">
                    <span style="font-size:.76rem;color:var(--tx-muted);">PHP Version</span>
                    <span class="badge badge-muted">{{ phpversion() }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:.55rem 0;border-bottom:1px solid var(--border);">
                    <span style="font-size:.76rem;color:var(--tx-muted);">Laravel Version</span>
                    <span class="badge badge-muted">{{ app()->version() }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;padding:.55rem 0;">
                    <span style="font-size:.76rem;color:var(--tx-muted);">Environment</span>
                    <span class="badge badge-success">{{ app()->environment() }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
