@extends('admin.layouts.app')
@section('title', 'Edit Statistic')
@section('page-title', 'Edit Statistic')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.statistics.index') }}">Statistics</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit Statistic</h2>
        <p>Update this statistic entry.</p>
    </div>
    <a href="{{ route('admin.about.statistics.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:640px">
    <form action="{{ route('admin.about.statistics.update', $stat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-section-title">Statistic Details</div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Value <span class="required">*</span></label>
                    <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $stat->value) }}" required>
                    @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Suffix</label>
                    <input type="text" name="suffix" class="form-control" value="{{ old('suffix', $stat->suffix ?? '') }}">
                    <div class="form-text">Optional suffix after the value</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Label <span class="required">*</span></label>
            <input type="text" name="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label', $stat->label) }}" required>
            @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $stat->sort_order) }}" min="0">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div style="display:flex;align-items:center;gap:.5rem;padding-top:.35rem">
                        <div class="svc-toggle {{ $stat->is_active ? 'on' : '' }}" id="toggleStatus"></div>
                        <span style="font-size:.78rem;color:var(--gray-600)" id="statusText">{{ $stat->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <input type="hidden" name="is_active" value="{{ $stat->is_active ? '1' : '0' }}" id="statusInput">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.about.statistics.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
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
    document.getElementById('statusText').textContent = isActive ? 'Active' : 'Inactive';
});
</script>
@endpush
