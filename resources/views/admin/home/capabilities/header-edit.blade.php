@extends('admin.layouts.app')
@section('title', 'Edit Capabilities Header')
@section('page-title', 'Capabilities Header')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Capabilities Header</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Capabilities Header</h2>
        <p>Edit the section title and description for 02-Capabilities</p>
    </div>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.capabilities-header.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Section Title <span style="color:var(--red-600)">*</span></label>
                <textarea name="title" class="form-control @error('title') is-invalid @enderror" id="titleInput" rows="2" required>{{ old('title', $settings['title']) }}</textarea>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Use <code>&lt;br&gt;</code> for line break. Default: <code>Five studios,&lt;br&gt;one standard</code></div>
            </div>

            <div class="form-group">
                <label class="form-label">Section Description <span style="color:var(--red-600)">*</span></label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="descInput" rows="3" required>{{ old('description', $settings['description']) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Description text below the section title</div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.5rem">
            <div style="font-size:.72rem;font-weight:600;color:var(--green-600);letter-spacing:.05em;margin-bottom:.5rem;text-transform:uppercase">02 — Capabilities</div>
            <div style="font-size:1.1rem;font-weight:700;color:var(--gray-900);line-height:1.3;margin-bottom:.75rem" id="previewTitle">{!! $settings['title'] !!}</div>
            <div style="font-size:.78rem;color:var(--gray-500);line-height:1.5;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden" id="previewDesc">{{ $settings['description'] }}</div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">Capabilities section header</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('titleInput');
    const descInput = document.getElementById('descInput');
    const previewTitle = document.getElementById('previewTitle');
    const previewDesc = document.getElementById('previewDesc');

    titleInput.addEventListener('input', () => { previewTitle.innerHTML = titleInput.value || 'Section Title'; });
    descInput.addEventListener('input', () => { previewDesc.textContent = descInput.value || 'Description...'; });
});
</script>
@endpush
