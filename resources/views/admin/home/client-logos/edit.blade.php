@extends('admin.layouts.app')
@section('title', 'Edit: ' . $clientLogo->name)
@section('page-title', 'Edit Client Logo')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.clients.index') }}">Client Logos</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit Client Logo</h2>
        <p>{{ $clientLogo->name }}</p>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.home.clients.destroy', $clientLogo->id) }}" method="POST" onsubmit="return confirm('Delete this logo permanently?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
        </form>
        <a href="{{ route('admin.home.clients.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card-white" style="max-width:640px;">
    <form action="{{ route('admin.home.clients.update', $clientLogo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Client Name <span style="color:#dc2626;">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $clientLogo->name) }}" required>
            @error('name')
                <div style="font-size:.75rem;color:#dc2626;margin-top:.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select class="form-select" name="category">
                <option value="">Select category</option>
                @foreach($categories as $slug => $label)
                    <option value="{{ $slug }}" {{ old('category', $clientLogo->category) === $slug ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Logo</label>
            <div class="mb-2">
                <img src="{{ asset('assets/img/clients/' . $clientLogo->image) }}" alt="{{ $clientLogo->name }}" style="max-width:200px;max-height:80px;object-fit:contain;border:1px solid #e8ecf1;border-radius:8px;padding:8px;">
            </div>
            <label class="form-label">Replace Logo</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
            @error('image')
                <div style="font-size:.75rem;color:#dc2626;margin-top:.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $clientLogo->sort_order) }}" min="0">
        </div>

        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $clientLogo->is_active) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:.5rem;margin-top:1.25rem;">
            <a href="{{ route('admin.home.clients.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </form>
</div>
@endsection
