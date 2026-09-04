@extends('admin.layouts.app')
@section('title', 'Edit Manifesto')
@section('page-title', 'Manifesto Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Manifesto</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Manifesto Settings</h2>
        <p>Edit the homepage manifesto subtitle and title</p>
    </div>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.manifesto.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Subtitle — EN <span style="color:var(--red-600)">*</span></label>
                    <input type="text" name="subtitle_en" class="form-control @error('subtitle_en') is-invalid @enderror" value="{{ old('subtitle_en', $settings['subtitle_en']) }}" required>
                    @error('subtitle_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Subtitle — ID <span style="color:var(--red-600)">*</span></label>
                    <input type="text" name="subtitle_id" class="form-control @error('subtitle_id') is-invalid @enderror" value="{{ old('subtitle_id', $settings['subtitle_id']) }}" required>
                    @error('subtitle_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Title — EN <span style="color:var(--red-600)">*</span></label>
                    <textarea name="title_en" class="form-control @error('title_en') is-invalid @enderror" rows="4" required>{{ old('title_en', $settings['title_en']) }}</textarea>
                    @error('title_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Title — ID <span style="color:var(--red-600)">*</span></label>
                    <textarea name="title_id" class="form-control @error('title_id') is-invalid @enderror" rows="4" required>{{ old('title_id', $settings['title_id']) }}</textarea>
                    @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Use *word* to mark bold words</div>

            <div class="form-actions">
                <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.5rem">
            <div style="font-size:.72rem;font-weight:600;color:var(--green-600);letter-spacing:.05em;margin-bottom:.5rem;text-transform:uppercase" id="previewSubtitle">01 — {{ $settings['subtitle'] }}</div>
            <div style="font-size:.95rem;font-weight:600;color:var(--gray-900);line-height:1.5" id="previewTitle">{{ $settings['title'] }}</div>
            <div style="margin-top:1rem;display:flex;gap:.5rem">
                <span style="color:var(--green-600);font-size:.8rem;font-weight:600;text-decoration:underline">Read our story</span>
                <span style="color:var(--gray-300)">·</span>
                <span style="color:var(--gray-600);font-size:.8rem">Work with us</span>
            </div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">Manifesto section on the homepage</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subtitleInput = document.getElementById('subtitleInput');
    const titleInput = document.getElementById('titleInput');
    const previewSubtitle = document.getElementById('previewSubtitle');
    const previewTitle = document.getElementById('previewTitle');

    subtitleInput.addEventListener('input', () => { previewSubtitle.textContent = '01 — ' + (subtitleInput.value || 'SUBTITLE'); });
    titleInput.addEventListener('input', () => { previewTitle.textContent = titleInput.value || 'Title text...'; });
});
</script>
@endpush
