@extends('admin.layouts.app')
@section('title', 'Statistics')
@section('page-title', 'Statistics')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Statistics</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Statistics</h2>
        <p>Manage the counter statistics displayed on the homepage</p>
    </div>
    <a href="{{ route('admin.home.stats.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Stat</a>
</div>

@if($stats->count() > 0)
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem">
    @foreach($stats as $stat)
    <div class="stat-card" style="position:relative">
        <div class="stat-value" style="color:{{ $stat->is_active ? 'var(--gray-900)' : 'var(--gray-400)' }}">
            {{ $stat->value }}<span style="font-size:.9rem;color:var(--green-500)">{{ $stat->suffix }}</span>
        </div>
        <div class="stat-label">{{ $stat->label }}</div>
        <div style="position:absolute;top:.75rem;right:.75rem;display:flex;gap:.25rem">
            <a href="{{ route('admin.home.stats.edit', $stat->id) }}" class="btn btn-secondary btn-sm" style="padding:.2rem .4rem;font-size:.65rem"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.home.stats.destroy', $stat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this stat?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" style="padding:.2rem .4rem;font-size:.65rem"><i class="bi bi-trash"></i></button>
            </form>
        </div>
        @if(!$stat->is_active)
        <div style="position:absolute;top:.75rem;left:.75rem">
            <span class="badge-inactive" style="font-size:.6rem">Inactive</span>
        </div>
        @endif
    </div>
    @endforeach
</div>

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th style="width:60px">Order</th>
                    <th>Value</th>
                    <th>Suffix</th>
                    <th>Label</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stats as $stat)
                <tr>
                    <td style="color:var(--gray-500)">{{ $stat->sort_order }}</td>
                    <td><span class="fw-600" style="font-size:1rem;color:var(--green-600)">{{ $stat->value }}</span></td>
                    <td style="color:var(--gray-500)">{{ $stat->suffix ?: '—' }}</td>
                    <td><span class="fw-600">{{ $stat->label }}</span></td>
                    <td>
                        @if($stat->is_active)
                            <span class="badge-active">Active</span>
                        @else
                            <span class="badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.home.stats.edit', $stat->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.home.stats.destroy', $stat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this stat?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="card-white">
    <div class="empty-state">
        <i class="bi bi-bar-chart"></i>
        <p>No statistics yet</p>
        <a href="{{ route('admin.home.stats.create') }}" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Add Stat</a>
    </div>
</div>
@endif
@endsection
