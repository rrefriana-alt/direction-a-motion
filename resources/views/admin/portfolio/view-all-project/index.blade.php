@extends('admin.layouts.app')
@section('title', 'View All Projects')
@section('page-title', 'View All Projects')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">Portfolio</a></li>
    <li class="breadcrumb-item active">View All Projects</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>View All Projects</h2>
        <p>Toggle which projects appear on the public portfolio page</p>
    </div>
    <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white">
    <form action="{{ route('admin.portfolio.view-all.update') }}" method="POST">
        @csrf
        @forelse($projects as $project)
        <div class="d-flex align-items-center gap-3" style="padding:.65rem 0;{{ !$loop->last ? 'border-bottom:1px solid var(--gray-100)' : '' }}">
            <input type="checkbox" name="project_ids[]" value="{{ $project->id }}" id="project_{{ $project->id }}" {{ $project->is_active ? 'checked' : '' }} style="width:16px;height:16px;accent-color:#10b981;cursor:pointer;flex-shrink:0">
            <label for="project_{{ $project->id }}" style="flex:1;cursor:pointer;margin:0">
                <div class="fw-600" style="font-size:.82rem;color:var(--gray-900)">{{ $project->title }}</div>
                @if($project->category)
                <div style="font-size:.7rem;color:var(--gray-400);margin-top:.1rem">{{ ucfirst($project->category) }}</div>
                @endif
            </label>
            @if($project->is_active)
                <span class="badge-active">Active</span>
            @else
                <span class="badge-inactive">Inactive</span>
            @endif
        </div>
        @empty
        <div class="empty-state">
            <i class="bi bi-folder2-open"></i>
            <p>No projects available</p>
        </div>
        @endforelse

        @if($projects->count() > 0)
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Update Visibility</button>
        </div>
        @endif
    </form>
</div>
@endsection
