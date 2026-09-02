@extends('admin.layouts.app')
@section('title', 'Edit Engagement Model')
@section('page-title', 'Edit Engagement Model')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.services.engagement.index') }}">Engagement</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('styles')
<style>
    .eng-preview-card{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);padding:1.5rem;text-align:center;transition:all .2s;}
    .eng-preview-card:hover{box-shadow:var(--shadow-md);}
    .eng-preview-letter{width:48px;height:48px;border-radius:50%;background:var(--green-50);color:var(--green-600);display:flex;align-items:center;justify-content:center;font-size:1.25rem;font-weight:700;margin:0 auto .75rem;}
    .eng-preview-title{font-size:1rem;font-weight:600;color:var(--gray-900);margin-bottom:.5rem;}
    .eng-preview-desc{font-size:.8125rem;color:var(--gray-500);line-height:1.6;}
</style>
@endpush

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit Engagement Model</h2>
        <p>Update this engagement model for the services page</p>
    </div>
    <a href="{{ route('admin.services.engagement.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div x-data="engForm()" style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    {{-- Form --}}
    <div class="card-white">
        <div style="font-size:.875rem;font-weight:600;color:var(--gray-900);margin-bottom:1rem">Model Details</div>
        <form action="{{ route('admin.services.engagement.update', $engagement->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                <div>
                    <label class="form-label">Letter <span style="color:var(--green-500)">*</span></label>
                    <input type="text" name="letter" class="form-control @error('letter') is-invalid @enderror" value="{{ old('letter', $engagement->letter) }}" maxlength="10" required x-model="letter" @input="letter = letter.toUpperCase()">
                    @error('letter') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $engagement->sort_order) }}" x-model.number="sortOrder" min="0">
                </div>
            </div>
            <div style="margin-top:.75rem;">
                <label class="form-label">Title <span style="color:var(--green-500)">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $engagement->title) }}" required x-model="title">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div style="margin-top:.75rem;">
                <label class="form-label">Description <span style="color:var(--green-500)">*</span></label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required x-model="description"></textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">Supports HTML. Use &lt;br&gt; for line breaks, &lt;p&gt; for paragraphs.</div>
            </div>
            <div style="margin-top:.75rem;">
                <div style="display:flex;align-items:center;gap:.5rem;">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" style="width:20px;height:20px;" {{ old('is_active', $engagement->is_active) ? 'checked' : '' }} x-model="isActive">
                    <span style="font-size:.8125rem;color:var(--gray-600)" x-text="isActive ? 'Active' : 'Inactive'"></span>
                </div>
            </div>
            <div style="margin-top:1.25rem;">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Changes</button>
            </div>
        </form>
    </div>

    {{-- Live Preview --}}
    <div>
        <div style="font-size:.875rem;font-weight:600;color:var(--gray-900);margin-bottom:1rem">Live Preview</div>
        <div class="eng-preview-card">
            <div class="eng-preview-letter" x-text="letter || '?'"></div>
            <div class="eng-preview-title" x-text="title || 'Model Title'"></div>
            <div class="eng-preview-desc" x-html="description || 'Model description will appear here...'"></div>
        </div>
        <div style="margin-top:1rem;padding:.75rem;background:var(--gray-50);border-radius:var(--radius-md);font-size:.75rem;color:var(--gray-500);">
            <i class="bi bi-info-circle"></i> Preview shows how the model will appear on the services page.
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function engForm() {
    return {
        letter: @json(old('letter', $engagement->letter)),
        title: @json(old('title', $engagement->title)),
        description: @json(old('description', $engagement->description)),
        sortOrder: {{ old('sort_order', $engagement->sort_order) }},
        isActive: {{ old('is_active', $engagement->is_active) ? 'true' : 'false' }},
    };
}
</script>
@endpush
