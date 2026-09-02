@extends('admin.layouts.app')
@section('title', 'Create Timeline Entry')
@section('page-title', 'Create Timeline')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.timeline.index') }}">Timeline</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Create Timeline Entry</h2>
        <p>Add a new company history milestone</p>
    </div>
    <a href="{{ route('admin.about.timeline.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:560px">
    <form action="{{ route('admin.about.timeline.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Year <span style="color:var(--red-600)">*</span></label>
            <input type="text" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year') }}" placeholder="e.g. 2024" maxlength="4" required>
            @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Description <span style="color:var(--red-600)">*</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4" placeholder="Describe the milestone..." required>{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Icon</label>
            <input type="text" class="form-control" name="icon" value="{{ old('icon') }}" placeholder="e.g. bi-trophy">
        </div>

        <div class="form-group">
            <label class="form-label">Sort Order</label>
            <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.about.timeline.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Entry</button>
        </div>
    </form>
</div>
@endsection
