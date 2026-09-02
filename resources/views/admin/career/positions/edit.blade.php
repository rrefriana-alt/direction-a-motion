@extends('admin.layouts.app')
@section('title', 'Edit Position')
@section('page-title', 'Edit Position')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.index') }}">Career</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.positions.index') }}">Positions</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit Position</h2>
        <p>Update job position details</p>
    </div>
    <a href="{{ route('admin.career.positions.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:640px;">
    <form action="{{ route('admin.career.positions.update', $position->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="margin-bottom:1rem;">
            <label class="form-label">Job Title <span style="color:#dc2626;">*</span></label>
            <input type="text" class="form-control" name="job_title" value="{{ old('job_title', $position->job_title) }}" required>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
            <div>
                <label class="form-label">Department <span style="color:#dc2626;">*</span></label>
                <input type="text" class="form-control" name="job_department" value="{{ old('job_department', $position->job_department) }}" required>
            </div>
            <div>
                <label class="form-label">Location</label>
                <input type="text" class="form-control" name="location" value="{{ old('location', $position->location) }}">
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
            <div>
                <label class="form-label">Employment Type</label>
                <select name="employment_type" class="form-select">
                    @foreach(['full_time','part_time','contract','internship','freelance'] as $type)
                    <option value="{{ $type }}" {{ old('employment_type', $position->employment_type) === $type ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Experience Level</label>
                <select name="experience_level" class="form-select">
                    @foreach(['entry','mid','senior','lead','executive'] as $level)
                    <option value="{{ $level }}" {{ old('experience_level', $position->experience_level) === $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-bottom:1rem;">
            <label class="form-label">Job Description <span style="color:#dc2626;">*</span></label>
            <textarea class="form-control" name="job_description" rows="8" required>{{ old('job_description', $position->job_description) }}</textarea>
        </div>

        <div style="margin-bottom:1rem;">
            <label class="form-label">Sort Order</label>
            <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $position->sort_order) }}" min="0" style="max-width:120px;">
        </div>

        <div style="display:flex;gap:2rem;margin-bottom:1.5rem;">
            <label style="display:flex;align-items:center;gap:.5rem;font-size:.8125rem;color:#374151;cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $position->is_active) ? 'checked' : '' }}> Active
            </label>
            <label style="display:flex;align-items:center;gap:.5rem;font-size:.8125rem;color:#374151;cursor:pointer;">
                <input type="checkbox" name="is_open" value="1" {{ old('is_open', $position->is_open) ? 'checked' : '' }}> Open for Applications
            </label>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:.5rem;">
            <a href="{{ route('admin.career.positions.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2"></i> Update Position</button>
        </div>
    </form>
</div>
@endsection
