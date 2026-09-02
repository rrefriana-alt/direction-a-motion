@extends('admin.layouts.app')
@section('title', 'Edit: ' . $marqueeItem->text)
@section('page-title', 'Edit Marquee Item')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.marquee.index') }}">Marquee</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit Marquee Item</h2>
        <p>{{ $marqueeItem->text }}</p>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.home.marquee.destroy', $marqueeItem->id) }}" method="POST" onsubmit="return confirm('Delete this item permanently?');">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
        </form>
        <a href="{{ route('admin.home.marquee.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.marquee.update', $marqueeItem->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Text <span style="color:var(--red-600)">*</span></label>
                <input type="text" name="text" class="form-control @error('text') is-invalid @enderror" id="textInput" value="{{ old('text', $marqueeItem->text) }}" required>
                @error('text') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" id="sortInput" value="{{ old('sort_order', $marqueeItem->sort_order) }}" min="0">
            </div>

            <div class="form-group">
                <div style="display:flex;align-items:center;gap:.5rem">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="activeCheck" {{ old('is_active', $marqueeItem->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="activeCheck" style="font-size:.85rem;color:var(--gray-700)">Active</label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home.marquee.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.5rem;overflow:hidden">
            <div style="font-size:1rem;font-weight:700;color:var(--gray-900);white-space:nowrap" id="previewText">{{ $marqueeItem->text }}</div>
            <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem" id="previewSort">Order: {{ $marqueeItem->sort_order }}</div>
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
