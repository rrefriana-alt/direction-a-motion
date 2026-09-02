@extends('admin.layouts.app')
@section('title', 'Add Marquee Item')
@section('page-title', 'Add Marquee Item')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.marquee.index') }}">Marquee</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Add Marquee Item</h2>
        <p>Add a new text item to the scrolling marquee</p>
    </div>
    <a href="{{ route('admin.home.marquee.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.marquee.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Text <span style="color:var(--red-600)">*</span></label>
                <input type="text" name="text" class="form-control @error('text') is-invalid @enderror" id="textInput" value="{{ old('text') }}" required placeholder="e.g. Create to Elevate">
                @error('text') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" id="sortInput" value="{{ old('sort_order', 0) }}" min="0">
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Display order. Lower = earlier in marquee.</div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home.marquee.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Item</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.5rem;overflow:hidden">
            <div style="font-size:1rem;font-weight:700;color:var(--gray-900);white-space:nowrap" id="previewText">{{ old('text', 'Your marquee text') }}</div>
            <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem" id="previewSort">Order: 0</div>
            <div style="margin-top:1rem;font-size:.65rem;color:var(--gray-300);letter-spacing:.1em;text-transform:uppercase">↓ This text scrolls across the homepage</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const textInput = document.getElementById('textInput');
    const sortInput = document.getElementById('sortInput');
    const previewText = document.getElementById('previewText');
    const previewSort = document.getElementById('previewSort');

    textInput.addEventListener('input', () => { previewText.textContent = textInput.value || 'Your marquee text'; });
    sortInput.addEventListener('input', () => { previewSort.textContent = 'Order: ' + (sortInput.value || '0'); });
});
</script>
@endpush
