@extends('admin.layouts.app')
@section('title', 'Add Statistic')
@section('page-title', 'Add Statistic')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.statistics.index') }}">Statistics</a></li>
    <li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Add Statistic</h2>
        <p>Create a new statistic for the About page.</p>
    </div>
    <a href="{{ route('admin.about.statistics.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:640px">
    <form action="{{ route('admin.about.statistics.store') }}" method="POST">
        @csrf

        <div class="form-section-title">Statistic Details</div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Value <span class="required">*</span></label>
                    <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" required placeholder="e.g. 9">
                    @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Suffix</label>
                    <input type="text" name="suffix" class="form-control" value="{{ old('suffix') }}" placeholder="e.g. +, years">
                    <div class="form-text">Optional suffix after the value (e.g. "+")</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Label <span class="required">*</span></label>
            <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label') }}" required placeholder="e.g. Years of experience">
            @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div style="display:flex;align-items:center;gap:.5rem;padding-top:.35rem">
                        <div class="svc-toggle on" id="toggleStatus"></div>
                        <span style="font-size:.78rem;color:var(--gray-600)">Active</span>
                    </div>
                    <input type="hidden" name="is_active" value="1" id="statusInput">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.about.statistics.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Statistic</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('toggleStatus').addEventListener('click', function() {
    this.classList.toggle('on');
    var isActive = this.classList.contains('on');
    document.getElementById('statusInput').value = isActive ? '1' : '0';
    this.nextElementSibling.textContent = isActive ? 'Active' : 'Inactive';
});
</script>
@endpush
