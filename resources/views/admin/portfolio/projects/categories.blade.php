@extends('admin.layouts.app')
@section('title', 'Work Categories')
@section('page-title', 'Work Categories')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale]) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index', ['locale'=>$locale]) }}">Portfolio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.projects.index', ['locale'=>$locale]) }}">Projects</a></li>
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
<style>
.cat-card{background:#fff;border:1px solid #eef2f7;border-radius:16px;padding:1.2rem;box-shadow:0 2px 12px rgba(15,23,42,.04)}
.cat-item{display:flex;align-items:center;gap:.75rem;padding:.75rem 1rem;background:#f8fafc;border:1px solid #eef2f7;border-radius:12px;margin-bottom:.5rem}
.cat-item:hover{background:#fff;border-color:#e2e8f0}
.cat-key{font-family:monospace;font-size:.72rem;color:var(--gray-500);background:#fff;border:1px solid #e2e8f0;padding:.2rem .45rem;border-radius:6px}
</style>

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div>
        <h2 style="font-size:1.1rem;font-weight:800;margin:0">Work Categories</h2>
        <p style="font-size:.78rem;color:var(--gray-500);margin:.2rem 0 0">Kelola kategori project. Slug auto dari label (contoh: "Motion Design" → motion-design). Semua project pakai kategori ini.</p>
    </div>
    <a href="{{ route('admin.portfolio.projects.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back to Projects</a>
</div>

@if(session('success'))<div class="alert alert-success py-2" style="font-size:.8rem">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-danger py-2" style="font-size:.8rem">{{ $errors->first() }}</div>@endif

<div class="cat-card mb-3">
    <form action="{{ route('admin.portfolio.projects.categories.store', ['locale'=>$locale]) }}" method="POST" class="d-flex gap-2 align-items-end flex-wrap">
        @csrf
        <div style="flex:1;min-width:200px">
            <label class="form-label" style="font-size:.72rem;font-weight:600;color:var(--gray-700)">New Category Label</label>
            <input type="text" name="label" class="form-control" placeholder="e.g. Motion, Interior, AI" required maxlength="60">
            <div style="font-size:.68rem;color:var(--gray-400);margin-top:.2rem">Slug otomatis dari label</div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="white-space:nowrap"><i class="bi bi-plus-lg"></i> Add Category</button>
    </form>
</div>

<div class="cat-card">
    <h3 style="font-size:.85rem;font-weight:700;margin-bottom:.8rem">Existing Categories <span style="font-weight:400;color:var(--gray-400)">— {{ count($categories) }} total</span></h3>
    @forelse($categories as $key => $label)
        <div class="cat-item">
            <span class="cat-key">{{ $key }}</span>
            <div style="flex:1">
                <form action="{{ route('admin.portfolio.projects.categories.update', ['locale'=>$locale,'key'=>$key]) }}" method="POST" class="d-flex gap-2 align-items-center flex-wrap">
                    @csrf @method('PUT')
                    <input type="text" name="label" value="{{ $label }}" class="form-control form-control-sm" style="max-width:220px" required maxlength="60">
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="bi bi-check"></i> Save</button>
                </form>
                @if(isset($counts[$key]))<div style="font-size:.68rem;color:var(--gray-500);margin-top:.25rem">{{ $counts[$key] }} project(s) pakai kategori ini</div>@endif
            </div>
            <form action="{{ route('admin.portfolio.projects.categories.destroy', ['locale'=>$locale,'key'=>$key]) }}" method="POST" onsubmit="return confirm('Delete category {{ $label }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
            </form>
        </div>
    @empty
        <p style="color:var(--gray-500);font-size:.8rem">No categories</p>
    @endforelse
</div>
@endsection
