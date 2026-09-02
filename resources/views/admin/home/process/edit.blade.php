@extends('admin.layouts.app')
@section('title', 'Edit Step: ' . $step->title_en)
@section('page-title', 'Edit Process Step')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.process.index') }}">Process Steps</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit Process Step</h2>
        <p>Update step {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}: {{ $step->title_en }}</p>
    </div>
    <a href="{{ route('admin.home.process.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.process.update', $step->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Step Number <span style="color:var(--red-600)">*</span></label>
                    <input type="number" class="form-control @error('step_number') is-invalid @enderror" name="step_number" id="stepNumberInput" value="{{ old('step_number', $step->step_number) }}" min="1" max="10" required>
                    @error('step_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $step->sort_order) }}" min="0">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Title (EN) <span style="color:var(--red-600)">*</span></label>
                    <input type="text" class="form-control @error('title_en') is-invalid @enderror" name="title_en" id="titleEnInput" value="{{ old('title_en', $step->title_en) }}" required>
                    @error('title_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Title (ID)</label>
                    <input type="text" class="form-control @error('title_id') is-invalid @enderror" name="title_id" id="titleIdInput" value="{{ old('title_id', $step->title_id) }}">
                    @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description (EN) <span style="color:var(--red-600)">*</span></label>
                <textarea class="form-control @error('description_en') is-invalid @enderror" name="description_en" id="descEnInput" rows="3" required>{{ old('description_en', $step->description_en) }}</textarea>
                @error('description_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description (ID)</label>
                <textarea class="form-control @error('description_id') is-invalid @enderror" name="description_id" id="descIdInput" rows="3">{{ old('description_id', $step->description_id) }}</textarea>
                @error('description_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $step->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home.process.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.25rem">
            <div style="display:flex;align-items:flex-start;gap:1rem">
                <div style="font-size:1.5rem;font-weight:800;color:var(--green-600);line-height:1;flex-shrink:0" id="previewStepNumber">{{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}</div>
                <div style="flex:1">
                    <div style="font-size:.95rem;font-weight:600;color:var(--gray-900);margin-bottom:.15rem" id="previewTitle">{{ $step->title_en }}</div>
                    <div style="font-size:.73rem;color:var(--gray-400);margin-bottom:.5rem;font-style:italic;{{ $step->title_id ? '' : 'display:none' }}" id="previewTitleId">{{ $step->title_id }}</div>
                    <div style="font-size:.73rem;color:var(--gray-500);display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden" id="previewDesc">{{ $step->description_en }}</div>
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
