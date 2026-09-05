@extends('admin.layouts.app')
@section('title', 'Projects')
@section('page-title', 'Projects')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">Portfolio</a></li>
    <li class="breadcrumb-item active">Projects</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Projects</h2>
        <p>Manage all work portfolio projects and their modal content</p>
    </div>
    <a href="{{ route('admin.portfolio.projects.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Project</a>
</div>

<div class="card-white" style="padding:.75rem 1rem;margin-bottom:1.5rem">
    <form method="GET" style="display:flex;gap:.75rem;align-items:center;flex-wrap:wrap">
        <input type="text" name="search" class="form-control form-control-sm" style="max-width:240px" placeholder="Search projects..." value="{{ $search }}">
        <select name="category" class="form-select form-select-sm" style="max-width:160px">
            @foreach($categories as $key => $label)
                <option value="{{ $key }}" {{ $category === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary btn-sm"><i class="bi bi-search"></i> Filter</button>
        @if($search || $category !== 'all')
            <a href="{{ route('admin.portfolio.projects.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-x"></i> Clear</a>
        @endif
    </form>
</div>

@if($projects->count())
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem">
    @foreach($projects as $project)
    <div class="card-white" style="padding:0;overflow:hidden;transition:all .2s;cursor:default">
        <div style="height:160px;background:{{ $project->bg_color ?: 'var(--gray-900)' }};overflow:hidden;position:relative;display:flex;align-items:center;justify-content:center">
            @if($project->image)
                <img src="{{ asset('img/' . $project->image) }}" alt="{{ $project->title }}" style="width:100%;height:100%;object-fit:cover">
            @elseif($project->hero_image)
                <img src="{{ asset('img/' . $project->hero_image) }}" alt="{{ $project->title }}" style="width:100%;height:100%;object-fit:cover">
            @else
                <div style="color:{{ $project->accent_color ?: 'var(--green-400)' }};font-size:2rem;font-weight:800;opacity:.6">{{ strtoupper(substr($project->client_name ?? 'F', 0, 2)) }}</div>
            @endif
            <div style="position:absolute;top:.5rem;right:.5rem;display:flex;gap:.25rem">
                @if($project->is_featured)
                    <span style="background:var(--green-500);color:#fff;padding:.15rem .4rem;border-radius:4px;font-size:.6rem;font-weight:600">Featured</span>
                @endif
                @if(! $project->is_active)
                    <span style="background:var(--danger);color:#fff;padding:.15rem .4rem;border-radius:4px;font-size:.6rem;font-weight:600">Draft</span>
                @endif
            </div>
        </div>
        <div style="padding:1rem">
            <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:.35rem">
                <div>
                    <div style="font-size:.9rem;font-weight:700;color:var(--gray-900)">{{ $project->title }}</div>
                    <div style="font-size:.73rem;color:var(--gray-500)">{{ $project->client_name ?: '—' }}</div>
                </div>
                <span style="font-size:.65rem;font-weight:600;color:var(--green-600);background:var(--green-50);padding:.15rem .4rem;border-radius:4px">{{ ucfirst($project->category) }}</span>
            </div>
            <div style="display:flex;gap:.5rem;margin-top:.75rem">
                <a href="{{ route('admin.portfolio.projects.edit', ['locale' => request()->route('locale') ?? 'en', 'project' => $project->id]) }}" class="btn btn-secondary btn-sm" style="flex:1"><i class="bi bi-pencil"></i> Edit</a>
                <form action="{{ route('admin.portfolio.projects.destroy', ['locale' => request()->route('locale') ?? 'en', 'project' => $project->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this project?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($projects->hasPages())
<div style="margin-top:1.5rem">{{ $projects->links() }}</div>
@endif
@else
<div class="card-white" style="padding:3rem;text-align:center">
    <i class="bi bi-folder2-open" style="font-size:2.5rem;color:var(--gray-300)"></i>
    <p style="color:var(--gray-500);margin-top:.5rem">No projects found</p>
    <a href="{{ route('admin.portfolio.projects.create') }}" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Create First Project</a>
</div>
@endif
@endsection
