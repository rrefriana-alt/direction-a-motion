@extends('admin.layouts.app')
@section('title', 'Add Statistic')
@section('page-title', 'Add Statistic')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.stats.index') }}">Statistics</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Add Statistic</h2>
        <p>Add a new counter stat to the homepage</p>
    </div>
    <a href="{{ route('admin.home.stats.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:480px">
        <form action="{{ route('admin.home.stats.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Value <span style="color:var(--red-600)">*</span></label>
                <input type="text" class="form-control @error('value') is-invalid @enderror" name="value" value="{{ old('value') }}" required placeholder="e.g. 9, 65, 300">
                @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Suffix</label>
                <input type="text" class="form-control" name="suffix" value="{{ old('suffix') }}" placeholder="e.g. +, K, %" maxlength="10">
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Appended after the value (e.g. "9" + "+" = "9+")</div>
            </div>

            <div class="form-group">
                <label class="form-label">Label — EN <span style="color:var(--red-600)">*</span></label>
                <input type="text" class="form-control @error('label') is-invalid @enderror" name="label" value="{{ old('label') }}" required placeholder="e.g. Years in the industry">
                @error('label') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Label — ID</label>
                <input type="text" class="form-control @error('label_id') is-invalid @enderror" name="label_id" value="{{ old('label_id') }}" placeholder="e.g. Tahun di industri">
                @error('label_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Kosongkan untuk pakai label EN</div>
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Lower numbers appear first</div>
            </div>

            <div class="form-group">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home.stats.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Stat</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Preview</div>
        <div class="card-white" style="padding:1.5rem;text-align:center">
            <div style="font-size:2.5rem;font-weight:800;color:var(--gray-900);line-height:1">
                <span id="previewValue">{{ old('value', '0') }}</span><span id="previewSuffix" style="font-size:1.2rem;color:var(--green-500)">{{ old('suffix') }}</span>
            </div>
            <div style="font-size:.85rem;color:var(--gray-500);margin-top:.5rem" id="previewLabel">{{ old('label', 'Label') }}</div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">This is how it will appear on the homepage</div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const valueInput = document.querySelector('input[name="value"]');
    const suffixInput = document.querySelector('input[name="suffix"]');
    const labelInput = document.querySelector('input[name="label"]');
    const previewValue = document.getElementById('previewValue');
    const previewSuffix = document.getElementById('previewSuffix');
    const previewLabel = document.getElementById('previewLabel');

    valueInput.addEventListener('input', () => { previewValue.textContent = valueInput.value || '0'; });
    suffixInput.addEventListener('input', () => { previewSuffix.textContent = suffixInput.value; });
    labelInput.addEventListener('input', () => { previewLabel.textContent = labelInput.value || 'Label'; });
});
</script>
@endpush
