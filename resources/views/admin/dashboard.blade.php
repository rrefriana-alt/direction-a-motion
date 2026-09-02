@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="page-header">
    <h2>Welcome back, {{ auth('admin')->user()->name ?? 'Admin' }} 👋</h2>
    <p>Here's what's happening with your website today</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:var(--green-50);color:var(--green-600)"><i class="bi bi-briefcase"></i></div>
            <div class="stat-value">{{ $totalProjects }}</div>
            <div class="stat-label">Total Projects</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;color:#2563eb"><i class="bi bi-newspaper"></i></div>
            <div class="stat-value">{{ $totalNews }}</div>
            <div class="stat-label">News Articles</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-mortarboard"></i></div>
            <div class="stat-value">{{ $totalApplications }}</div>
            <div class="stat-label">Applications</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce7f3;color:#db2777"><i class="bi bi-envelope"></i></div>
            <div class="stat-value">{{ $unreadMessages }}</div>
            <div class="stat-label">Unread Messages</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card-white">
            <div class="d-flex align-items-center justify-content-between" style="margin-bottom:1rem">
                <h6 style="font-weight:700;font-size:.9rem;margin:0;color:var(--gray-900)"><i class="bi bi-briefcase text-green"></i> Recent Projects</h6>
                <a href="{{ route('admin.portfolio.projects.index') }}" style="font-size:.73rem;color:var(--green-600);text-decoration:none;font-weight:600">View All →</a>
            </div>
            @forelse($recentProjects as $p)
            <div class="d-flex align-items-center justify-content-between" style="padding:.55rem 0;border-bottom:1px solid var(--gray-100)">
                <div>
                    <div style="font-weight:600;font-size:.82rem;color:var(--gray-900)">{{ $p->title }}</div>
                    <div style="font-size:.7rem;color:var(--gray-400)">{{ ucfirst($p->category) }}</div>
                </div>
                <span class="{{ $p->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $p->is_active ? 'Active' : 'Draft' }}</span>
            </div>
            @empty
            <div class="empty-state" style="padding:2rem 1rem">
                <i class="bi bi-briefcase"></i>
                <p>No projects yet</p>
            </div>
            @endforelse
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-white">
            <div class="d-flex align-items-center justify-content-between" style="margin-bottom:1rem">
                <h6 style="font-weight:700;font-size:.9rem;margin:0;color:var(--gray-900)"><i class="bi bi-mortarboard" style="color:#d97706"></i> Recent Applications</h6>
                <a href="{{ route('admin.career.applications.index') }}" style="font-size:.73rem;color:var(--green-600);text-decoration:none;font-weight:600">View All →</a>
            </div>
            @forelse($recentApplications as $a)
            <div class="d-flex align-items-center justify-content-between" style="padding:.55rem 0;border-bottom:1px solid var(--gray-100)">
                <div>
                    <div style="font-weight:600;font-size:.82rem;color:var(--gray-900)">{{ $a->full_name }}</div>
                    <div style="font-size:.7rem;color:var(--gray-400)">{{ $a->position }}</div>
                </div>
                @if($a->status === 'pending')
                    <span class="badge-pending">Pending</span>
                @elseif($a->status === 'accepted')
                    <span class="badge-active">Accepted</span>
                @else
                    <span class="badge-inactive">{{ ucfirst($a->status) }}</span>
                @endif
            </div>
            @empty
            <div class="empty-state" style="padding:2rem 1rem">
                <i class="bi bi-mortarboard"></i>
                <p>No applications yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<div class="card-white mt-3">
    <div class="d-flex align-items-center justify-content-between" style="margin-bottom:1rem">
        <h6 style="font-weight:700;font-size:.9rem;margin:0;color:var(--gray-900)"><i class="bi bi-lightning-charge-fill" style="color:#d97706"></i> Quick Actions</h6>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.portfolio.projects.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Project</a>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Create Article</a>
        <a href="{{ route('admin.career.positions.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Position</a>
        <a href="{{ route('admin.services.crud') }}" class="btn btn-secondary btn-sm"><i class="bi bi-gear"></i> Manage Services</a>
        <a href="{{ route('admin.about.ceo-profile') }}" class="btn btn-secondary btn-sm"><i class="bi bi-person"></i> CEO Profile</a>
        <a href="{{ route('admin.account.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-people"></i> Admin Users</a>
    </div>
</div>
@endsection
