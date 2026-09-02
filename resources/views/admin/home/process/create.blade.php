@extends('admin.layouts.app')
@section('title', 'Add Process Step')
@section('page-title', 'Add Process Step')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.process.index') }}">Process Steps</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Add Process Step</h2>
        <p>Add a new step to the "How we work" section</p>
    </div>
    <a href="{{ route('admin.home.process.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.process.store') }}" method="POST">
            @csrf

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Step Number <span style="color:var(--red-600)">*</span></label>
                    <input type="number" class="form-control @error('step_number') is-invalid @enderror" name="step_number" id="stepNumberInput" value="{{ old('step_number', 1) }}" min="1" max="10" required>
                    @error('step_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Title (EN) <span style="color:var(--red-600)">*</span></label>
                    <input type="text" class="form-control @error('title_en') is-invalid @enderror" name="title_en" id="titleEnInput" value="{{ old('title_en') }}" required placeholder="e.g. Listen & frame">
                    @error('title_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Title (ID)</label>
                    <input type="text" class="form-control @error('title_id') is-invalid @enderror" name="title_id" id="titleIdInput" value="{{ old('title_id') }}" placeholder="e.g. Dengar — rumuskan">
                    @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description (EN) <span style="color:var(--red-600)">*</span></label>
                <textarea class="form-control @error('description_en') is-invalid @enderror" name="description_en" id="descEnInput" rows="3" required placeholder="Step description in English...">{{ old('description_en') }}</textarea>
                @error('description_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description (ID)</label>
                <textarea class="form-control @error('description_id') is-invalid @enderror" name="description_id" id="descIdInput" rows="3" placeholder="Deskripsi langkah dalam Bahasa Indonesia...">{{ old('description_id') }}</textarea>
                @error('description_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home.process.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Step</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.25rem">
            <div style="display:flex;align-items:flex-start;gap:1rem">
                <div style="font-size:1.5rem;font-weight:800;color:var(--green-600);line-height:1;flex-shrink:0" id="previewStepNumber">01</div>
                <div style="flex:1">
                    <div style="font-size:.95rem;font-weight:600;color:var(--gray-900);margin-bottom:.15rem" id="previewTitle">Step Title</div>
                    <div style="font-size:.73rem;color:var(--gray-400);margin-bottom:.5rem;font-style:italic;display:none" id="previewTitleId"></div>
                    <div style="font-size:.73rem;color:var(--gray-500);display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden" id="previewDesc">Description will appear here...</div>
                </div>
            </div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">This is how it will appear on the homepage</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stepNumberInput = document.getElementById('stepNumberInput');
    const titleEnInput = document.getElementById('titleEnInput');
    const titleIdInput = document.getElementById('titleIdInput');
    const descEnInput = document.getElementById('descEnInput');
    const descIdInput = document.getElementById('descIdInput');
    const previewStepNumber = document.getElementById('previewStepNumber');
    const previewTitle = document.getElementById('previewTitle');
    const previewTitleId = document.getElementById('previewTitleId');
    const previewDesc = document.getElementById('previewDesc');

    stepNumberInput.addEventListener('input', () => {
        previewStepNumber.textContent = String(stepNumberInput.value || 1).padStart(2, '0');
    });
    titleEnInput.addEventListener('input', () => {
        previewTitle.textContent = titleEnInput.value || 'Step Title';
    });
    titleIdInput.addEventListener('input', () => {
        const val = titleIdInput.value;
        previewTitleId.textContent = val;
        previewTitleId.style.display = val ? 'block' : 'none';
    });
    descEnInput.addEventListener('input', () => {
        previewDesc.textContent = descEnInput.value || 'Description will appear here...';
    });
});
</script>
@endpush
