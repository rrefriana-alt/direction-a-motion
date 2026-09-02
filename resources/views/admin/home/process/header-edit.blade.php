@extends('admin.layouts.app')
@section('title', 'Edit Process Header')
@section('page-title', 'Process Header')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Process Header</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Process Header</h2>
        <p>Edit the section eyebrow and title for "05 — How we work"</p>
    </div>
    <a href="{{ route('admin.home.process.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.process-header.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Eyebrow (EN) <span style="color:var(--red-600)">*</span></label>
                    <input type="text" class="form-control @error('eyebrow_en') is-invalid @enderror" name="eyebrow_en" id="eyebrowEnInput" value="{{ old('eyebrow_en', $settings['eyebrow_en']) }}" required placeholder="e.g. 05 — How we work">
                    @error('eyebrow_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Eyebrow (ID)</label>
                    <input type="text" class="form-control @error('eyebrow_id') is-invalid @enderror" name="eyebrow_id" id="eyebrowIdInput" value="{{ old('eyebrow_id', $settings['eyebrow_id']) }}" placeholder="e.g. 05 — Cara kami bekerja">
                    @error('eyebrow_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Title (EN) <span style="color:var(--red-600)">*</span></label>
                <textarea class="form-control @error('title_en') is-invalid @enderror" name="title_en" id="titleEnInput" rows="2" required placeholder="e.g. A short line<br>to remarkable">{{ old('title_en', $settings['title_en']) }}</textarea>
                @error('title_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Use <code>&lt;br&gt;</code> for line break</div>
            </div>

            <div class="form-group">
                <label class="form-label">Title (ID)</label>
                <textarea class="form-control @error('title_id') is-invalid @enderror" name="title_id" id="titleIdInput" rows="2" placeholder="e.g. Garis pendek<br>menuju luar biasa">{{ old('title_id', $settings['title_id']) }}</textarea>
                @error('title_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
            <div style="font-size:.72rem;font-weight:600;color:var(--green-600);letter-spacing:.05em;margin-bottom:.5rem;text-transform:uppercase" id="previewEyebrow">{{ $settings['eyebrow_en'] }}</div>
            <div style="font-size:1.1rem;font-weight:700;color:var(--gray-900);line-height:1.3" id="previewTitle">{!! $settings['title_en'] !!}</div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">Section header on the homepage</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const eyebrowEnInput = document.getElementById('eyebrowEnInput');
    const titleEnInput = document.getElementById('titleEnInput');
    const previewEyebrow = document.getElementById('previewEyebrow');
    const previewTitle = document.getElementById('previewTitle');

    eyebrowEnInput.addEventListener('input', () => {
        previewEyebrow.textContent = eyebrowEnInput.value || 'Eyebrow';
    });
    titleEnInput.addEventListener('input', () => {
        previewTitle.innerHTML = titleEnInput.value || 'Title';
    });
});
</script>
@endpush
