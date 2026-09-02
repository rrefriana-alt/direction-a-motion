@extends('admin.layouts.app')
@section('title', 'Services Page Header')
@section('page-title', 'Services Page Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Services Page</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Services Page Header</h2>
        <p>Edit the services page headline and subtitle</p>
    </div>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.services-page.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Headline <span style="color:var(--red-600)">*</span></label>
                <input type="text" name="headline" class="form-control @error('headline') is-invalid @enderror" id="headlineInput" value="{{ old('headline', $settings['headline']) }}" required placeholder="e.g. Five studios, one invoice">
                @error('headline') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Subtitle <span style="color:var(--red-600)">*</span></label>
                <textarea name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" id="subtitleInput" rows="2" required>{{ old('subtitle', $settings['subtitle']) }}</textarea>
                @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
            <div style="font-size:1.1rem;font-weight:700;color:var(--gray-900);line-height:1.3;margin-bottom:.5rem" id="previewHeadline">{!! $settings['headline'] !!}</div>
            <div style="font-size:.78rem;color:var(--gray-500);line-height:1.5" id="previewSubtitle">{{ $settings['subtitle'] }}</div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">Services page header section</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const headlineInput = document.getElementById('headlineInput');
    const subtitleInput = document.getElementById('subtitleInput');
    const previewHeadline = document.getElementById('previewHeadline');
    const previewSubtitle = document.getElementById('previewSubtitle');

    headlineInput.addEventListener('input', () => { previewHeadline.textContent = headlineInput.value || 'Headline'; });
    subtitleInput.addEventListener('input', () => { previewSubtitle.textContent = subtitleInput.value || 'Subtitle...'; });
});
</script>
@endpush
