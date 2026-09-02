@extends('admin.layouts.app')
@section('title', 'Applications')
@section('page-title', 'Job Applications')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.index') }}">Career</a></li>
    <li class="breadcrumb-item active">Applications</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Applications</h2>
        <p>Review and manage all candidate applications</p>
    </div>
    <a href="{{ route('admin.career.applications.export', request()->query()) }}" class="btn btn-secondary btn-sm"><i class="bi bi-download"></i> Export CSV</a>
</div>

<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:.75rem;margin-bottom:1.5rem">
    <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;color:#16a34a"><i class="bi bi-people"></i></div>
        <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        <div class="stat-label">Total</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-hourglass-split"></i></div>
        <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
        <div class="stat-label">Pending</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e0e7ff;color:#4f46e5"><i class="bi bi-eye"></i></div>
        <div class="stat-value">{{ $stats['reviewed'] ?? 0 }}</div>
        <div class="stat-label">Reviewed</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#dcfce7;color:#16a34a"><i class="bi bi-check-circle"></i></div>
        <div class="stat-value">{{ $stats['accepted'] ?? 0 }}</div>
        <div class="stat-label">Accepted</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef2f2;color:#dc2626"><i class="bi bi-x-circle"></i></div>
        <div class="stat-value">{{ $stats['rejected'] ?? 0 }}</div>
        <div class="stat-label">Rejected</div>
    </div>
</div>

<div class="card-white" style="margin-bottom:1rem">
    <form action="{{ route('admin.career.applications.index') }}" method="GET" class="d-flex gap-2" style="flex-wrap:wrap">
        <input type="text" name="search" class="form-control" placeholder="Name or email..." value="{{ request('search') }}" style="flex:1;min-width:200px;max-width:300px">
        <select name="status" class="form-select" style="max-width:140px">
            <option value="">All Status</option>
            @foreach(['pending','reviewed','accepted','rejected'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="position" class="form-select" style="max-width:160px">
            <option value="">All Positions</option>
            @foreach($positions as $p)
                <option value="{{ $p->id }}" {{ request('position') == $p->id ? 'selected' : '' }}>{{ $p->job_title }}</option>
            @endforeach
        </select>
        <select name="education" class="form-select" style="max-width:140px">
            <option value="">All Education</option>
            @foreach(['high_school','diploma','bachelor','master','phd'] as $e)
                <option value="{{ $e }}" {{ request('education') === $e ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$e)) }}</option>
            @endforeach
        </select>
        <select name="job_field" class="form-select" style="max-width:140px">
            <option value="">All Fields</option>
            @foreach($jobFields as $f)
                <option value="{{ $f }}" {{ request('job_field') === $f ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$f)) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary btn-sm"><i class="bi bi-search"></i> Filter</button>
        <a href="{{ route('admin.career.applications.index') }}" class="btn btn-secondary btn-sm">Clear</a>
    </form>
</div>

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr>
                    <td><span class="fw-600">{{ $app->full_name }}</span></td>
                    <td style="color:var(--gray-500)">{{ $app->email }}</td>
                    <td style="color:var(--gray-500)">{{ $app->position ?? '—' }}</td>
                    <td>
                        @switch($app->status)
                            @case('pending')
                                <span style="background:#fef3c7;color:#92400e;padding:.2rem .6rem;border-radius:6px;font-size:.7rem;font-weight:500">Pending</span>
                                @break
                            @case('reviewed')
                                <span style="background:#e0e7ff;color:#4338ca;padding:.2rem .6rem;border-radius:6px;font-size:.7rem;font-weight:500">Reviewed</span>
                                @break
                            @case('accepted')
                                <span class="badge-active">Accepted</span>
                                @break
                            @case('rejected')
                                <span class="badge-inactive">Rejected</span>
                                @break
                            @default
                                <span class="badge-inactive">{{ $app->status }}</span>
                        @endswitch
                    </td>
                    <td style="color:var(--gray-400);font-size:.73rem">{{ $app->created_at->format('M d, Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.career.applications.edit', $app->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>No applications found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($applications, 'links'))
    <div style="padding:.75rem 1.25rem;border-top:1px solid var(--gray-100)">
        {{ $applications->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
