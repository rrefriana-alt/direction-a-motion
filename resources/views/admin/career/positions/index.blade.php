@extends('admin.layouts.app')
@section('title', 'Positions')
@section('page-title', 'Job Positions')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.index') }}">Career</a></li>
    <li class="breadcrumb-item active">Positions</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Positions</h2>
        <p>Manage open job positions</p>
    </div>
    <a href="{{ route('admin.career.positions.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Create</a>
</div>

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem;margin-bottom:1.5rem">
    <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;color:#16a34a"><i class="bi bi-briefcase"></i></div>
        <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        <div class="stat-label">Total</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#dcfce7;color:#16a34a"><i class="bi bi-check-circle"></i></div>
        <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
        <div class="stat-label">Active</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-door-open"></i></div>
        <div class="stat-value">{{ $stats['open'] ?? 0 }}</div>
        <div class="stat-label">Open</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef2f2;color:#dc2626"><i class="bi bi-lock"></i></div>
        <div class="stat-value">{{ $stats['closed'] ?? 0 }}</div>
        <div class="stat-label">Closed</div>
    </div>
</div>

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Department</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Active</th>
                    <th>Open</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($positions as $pos)
                <tr>
                    <td><span class="fw-600">{{ $pos->job_title }}</span></td>
                    <td style="color:var(--gray-500)">{{ $pos->job_department }}</td>
                    <td style="color:var(--gray-500)">{{ $pos->location }}</td>
                    <td style="color:var(--gray-500)">{{ ucfirst(str_replace('_', ' ', $pos->employment_type)) }}</td>
                    <td>
                        @if($pos->is_active)
                            <span class="badge-active">Active</span>
                        @else
                            <span class="badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        @if($pos->is_open)
                            <span class="badge-active">Open</span>
                        @else
                            <span class="badge-inactive">Closed</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.career.positions.edit', $pos->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.career.positions.destroy', $pos->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this position?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-briefcase"></i>
                            <p>No positions found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($positions, 'links'))
    <div style="padding:.75rem 1.25rem;border-top:1px solid var(--gray-100)">
        {{ $positions->links() }}
    </div>
    @endif
</div>
@endsection
