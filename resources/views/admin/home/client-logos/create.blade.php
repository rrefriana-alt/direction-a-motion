@extends('admin.layouts.app')
@section('title', 'Add Client Logo')
@section('page-title', 'Add Client Logo')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.clients.index') }}">Client Logos</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Add Client Logo</h2>
        <p>Add a new client logo to the ticker carousel</p>
    </div>
    <a href="{{ route('admin.home.clients.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:720px;">
    <form action="{{ route('admin.home.clients.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Client Name <span style="color:#dc2626;">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div style="font-size:.75rem;color:#dc2626;margin-top:.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select class="form-select" name="category">
                <option value="">Select category</option>
                @foreach($categories as $slug => $label)
                    <option value="{{ $slug }}" {{ old('category') === $slug ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Logo Image <span style="color:#dc2626;">*</span></label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*" required>
            @error('image')
                <div style="font-size:.75rem;color:#dc2626;margin-top:.25rem;">{{ $message }}</div>
            @enderror
            <small style="color:#6b7280">Format: JPG, PNG, SVG, WebP. Maks 4MB.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
            <small style="color:#6b7280">Urutan logo di carousel. Semakin kecil, semakin awal.</small>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:.5rem;margin-top:1.25rem;">
            <a href="{{ route('admin.home.clients.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Logo</button>
        </div>
    </form>
</div>
@endsection
