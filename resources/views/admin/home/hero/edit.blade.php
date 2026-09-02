@extends('admin.layouts.app')
@section('title', 'Edit Hero')
@section('page-title', 'Hero Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Hero</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Hero Settings</h2>
        <p>Edit the homepage hero tagline and description</p>
    </div>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.hero.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Tagline <span style="color:var(--red-600)">*</span></label>
                <input type="text" name="tagline" class="form-control @error('tagline') is-invalid @enderror" id="taglineInput" value="{{ old('tagline', $settings['tagline']) }}" required placeholder="e.g. 65+ brands trusted us">
                @error('tagline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Short headline displayed at the top</div>
            </div>

            <div class="form-group">
                <label class="form-label">Description <span style="color:var(--red-600)">*</span></label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="descInput" rows="3" required>{{ old('description', $settings['description']) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Subtitle text below the main title</div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.5rem;background:var(--gray-900);color:white;text-align:center">
            <div style="font-size:.72rem;font-weight:600;color:var(--green-400);letter-spacing:.05em;margin-bottom:.75rem;text-transform:uppercase" id="previewTagline">{{ $settings['tagline'] }}</div>
            <div style="font-size:1.3rem;font-weight:700;margin-bottom:.5rem;line-height:1.2">Create to<br><span style="color:var(--green-400)">Elevate</span></div>
            <div style="font-size:.8rem;color:rgba(255,255,255,.6);margin-bottom:1rem" id="previewDesc">{{ $settings['description'] }}</div>
            <div style="display:flex;gap:.5rem;justify-content:center">
                <span style="background:var(--green-500);color:white;padding:.4rem .8rem;border-radius:6px;font-size:.7rem;font-weight:600">See selected work ↗</span>
                <span style="border:1px solid rgba(255,255,255,.2);color:white;padding:.4rem .8rem;border-radius:6px;font-size:.7rem">What we do</span>
            </div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">Hero section on the homepage</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const taglineInput = document.getElementById('taglineInput');
    const descInput = document.getElementById('descInput');
    const previewTagline = document.getElementById('previewTagline');
    const previewDesc = document.getElementById('previewDesc');

    taglineInput.addEventListener('input', () => { previewTagline.textContent = taglineInput.value || 'Tagline'; });
    descInput.addEventListener('input', () => { previewDesc.textContent = descInput.value || 'Description...'; });
});
</script>
@endpush
