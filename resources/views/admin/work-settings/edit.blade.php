@extends('admin.layouts.app')
@section('title', 'Work Page Settings')
@section('page-title', 'Work Page Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">Portfolio</a></li>
    <li class="breadcrumb-item active">Work Page</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Work Page Settings</h2>
        <p>Configure the header section of the /work page</p>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.work-settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field-group">
                <label class="field-label">Page Title <span style="color:var(--danger)">*</span></label>
                <input type="text" name="title" class="form-control" id="titleInput" value="{{ old('title', $settings['title']) }}" required placeholder="Selected work">
                <div class="field-hint">Main heading on the work page</div>
            </div>

            <div class="field-group">
                <label class="field-label">Page Lede <span style="color:var(--danger)">*</span></label>
                <textarea name="lede" class="form-control" id="ledeInput" rows="3" required>{{ old('lede', $settings['lede']) }}</textarea>
                <div class="field-hint">Subtitle text below the title</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.5rem">
            <div style="font-size:.72rem;color:var(--gray-400);margin-bottom:.5rem">Fugo / Work</div>
            <h1 style="font-size:1.5rem;font-weight:800;color:var(--gray-900);line-height:1.1;margin-bottom:.75rem" id="previewTitle">{!! $settings['title'] !!}</h1>
            <p style="font-size:.8rem;color:var(--gray-500);line-height:1.5" id="previewLede">{{ $settings['lede'] }}</p>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">Preview of the work page header</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('titleInput');
    const ledeInput = document.getElementById('ledeInput');
    const previewTitle = document.getElementById('previewTitle');
    const previewLede = document.getElementById('previewLede');

    titleInput.addEventListener('input', () => { previewTitle.innerHTML = titleInput.value || 'Selected work'; });
    ledeInput.addEventListener('input', () => { previewLede.textContent = ledeInput.value || 'Page description...'; });
});
</script>
@endpush
