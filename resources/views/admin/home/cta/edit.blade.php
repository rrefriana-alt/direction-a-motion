@extends('admin.layouts.app')
@section('title', 'Edit CTA')
@section('page-title', 'Call to Action')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">CTA</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Call to Action</h2>
        <p>Edit the CTA eyebrow and title text on the homepage</p>
    </div>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.cta.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Eyebrow <span style="color:var(--red-600)">*</span></label>
                <input type="text" name="eyebrow" class="form-control @error('eyebrow') is-invalid @enderror" id="eyebrowInput" value="{{ old('eyebrow', $settings['eyebrow']) }}" required placeholder="e.g. Available for Q4 2026 projects">
                @error('eyebrow') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Small text above the title</div>
            </div>

            <div class="form-group">
                <label class="form-label">Title <span style="color:var(--red-600)">*</span></label>
                <textarea name="title" class="form-control @error('title') is-invalid @enderror" id="titleInput" rows="2" required>{{ old('title', $settings['title']) }}</textarea>
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Main CTA text. Use &lt;br&gt; for line breaks.</div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:2rem;text-align:center;background:linear-gradient(135deg,var(--green-50),white)">
            <div style="font-size:.72rem;font-weight:600;color:var(--green-600);letter-spacing:.05em;margin-bottom:.5rem;text-transform:uppercase" id="previewEyebrow">{{ $settings['eyebrow'] }}</div>
            <div style="font-size:1.2rem;font-weight:700;color:var(--gray-900);line-height:1.3;margin-bottom:1rem" id="previewTitle">{!! $settings['title'] !!}</div>
            <div style="display:flex;gap:.5rem;justify-content:center">
                <span style="background:var(--green-500);color:white;padding:.5rem 1rem;border-radius:6px;font-size:.75rem;font-weight:600">Start a project ↗</span>
                <span style="border:1px solid var(--gray-200);color:var(--gray-600);padding:.5rem 1rem;border-radius:6px;font-size:.75rem">hello@fugocreativegroup.com</span>
            </div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">CTA section on the homepage</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const eyebrowInput = document.getElementById('eyebrowInput');
    const titleInput = document.getElementById('titleInput');
    const previewEyebrow = document.getElementById('previewEyebrow');
    const previewTitle = document.getElementById('previewTitle');

    eyebrowInput.addEventListener('input', () => { previewEyebrow.textContent = eyebrowInput.value || 'Eyebrow'; });
    titleInput.addEventListener('input', () => { previewTitle.innerHTML = titleInput.value || 'Title'; });
});
</script>
@endpush
