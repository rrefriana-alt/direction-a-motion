@extends('admin.layouts.app')
@section('title', 'Carousel Management')
@section('page-title', 'Carousel Management')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.clients.index') }}">Client Logos</a></li>
    <li class="breadcrumb-item active">Carousel</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Carousel Management</h2>
        <p>Toggle which logos appear in the homepage client ticker carousel</p>
    </div>
    <a href="{{ route('admin.home.clients.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white">
    <form action="{{ route('admin.home.clients.carousel') }}" method="GET" class="d-flex gap-2 mb-3" style="flex-wrap:wrap">
        <input type="text" name="search" class="form-control" placeholder="Search logos..." value="{{ $search ?? '' }}" style="flex:1;min-width:200px;max-width:400px">
        <select name="category" class="form-select" style="max-width:200px">
            <option value="">All Categories</option>
            @foreach($categories as $slug => $label)
                <option value="{{ $slug }}" {{ ($category ?? '') === $slug ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary btn-sm"><i class="bi bi-search"></i> Filter</button>
    </form>

    <form action="{{ route('admin.home.clients.carousel.update') }}" method="POST">
        @csrf

        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleAll()">Toggle All</button>
        </div>

        @forelse($clientLogos as $logo)
        <div class="d-flex align-items-center gap-3" style="padding:.65rem 0;{{ !$loop->last ? 'border-bottom:1px solid var(--gray-100)' : '' }}">
            <input type="checkbox" name="logo_ids[]" value="{{ $logo->id }}" id="logo_{{ $logo->id }}" {{ $logo->is_active ? 'checked' : '' }} style="width:16px;height:16px;accent-color:#10b981;cursor:pointer;flex-shrink:0">
            <img src="{{ asset('assets/img/clients/' . $logo->image) }}" alt="{{ $logo->name }}" style="height:26px;width:auto;object-fit:contain;flex-shrink:0">
            <label for="logo_{{ $logo->id }}" style="flex:1;cursor:pointer;margin:0">
                <div class="fw-600" style="font-size:.82rem;color:var(--gray-900)">{{ $logo->name }}</div>
                @if($logo->category && isset($categories[$logo->category]))
                <div style="font-size:.7rem;color:var(--gray-400);margin-top:.1rem">{{ $categories[$logo->category] }}</div>
                @endif
            </label>
            @if($logo->is_active)
                <span class="badge-active">Active</span>
            @else
                <span class="badge-inactive">Inactive</span>
            @endif
        </div>
        @empty
        <div class="empty-state">
            <i class="bi bi-image"></i>
            <p>No client logos found</p>
        </div>
        @endforelse

        @if($clientLogos->count() > 0)
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check-lg"></i> Update Carousel</button>
        </div>
        @endif
    </form>
</div>

<script>
function toggleAll() {
    const checkboxes = document.querySelectorAll('input[name="logo_ids[]"]');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
}
</script>
@endsection
