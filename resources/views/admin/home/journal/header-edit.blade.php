@extends('admin.layouts.app')
@section('title', 'Edit Journal Header')
@section('page-title', 'Journal Header')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.journal.index', ['locale' => $locale]) }}">Journal</a></li>
    <li class="breadcrumb-item active">Header</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Journal Header</h2>
        <p>Edit teks header section Journal (07) di homepage — EN &amp; ID</p>
    </div>
    <a href="{{ route('admin.home.journal.index', ['locale' => $locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:720px">
        <form action="{{ route('admin.home.journal.header.update', ['locale' => $locale]) }}" method="POST">
            @csrf
            @method('PUT')

            @foreach([['en', 'English'], ['id', 'Indonesia']] as [$lang, $label])
            <h3 style="font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--gray-500);margin:{{ $loop->first ? '0' : '1.5rem' }} 0 .75rem">{{ $label }}</h3>
            <div class="form-group">
                <label class="form-label" for="eyebrow_{{ $lang }}">Eyebrow <span style="color:var(--red-600)">*</span></label>
                <input type="text" id="eyebrow_{{ $lang }}" name="eyebrow_{{ $lang }}" class="form-control @error('eyebrow_'.$lang) is-invalid @enderror" value="{{ old('eyebrow_'.$lang, $settings['eyebrow_'.$lang]) }}" required maxlength="255">
                @error('eyebrow_'.$lang) <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="title_{{ $lang }}">Title <span style="color:var(--red-600)">*</span></label>
                <textarea id="title_{{ $lang }}" name="title_{{ $lang }}" class="form-control @error('title_'.$lang) is-invalid @enderror" rows="2" required maxlength="500">{{ old('title_'.$lang, $settings['title_'.$lang]) }}</textarea>
                @error('title_'.$lang) <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="lede_{{ $lang }}">Lede <span style="color:var(--red-600)">*</span></label>
                <textarea id="lede_{{ $lang }}" name="lede_{{ $lang }}" class="form-control @error('lede_'.$lang) is-invalid @enderror" rows="3" required maxlength="1000">{{ old('lede_'.$lang, $settings['lede_'.$lang]) }}</textarea>
                @error('lede_'.$lang) <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="cta_{{ $lang }}">CTA Label <span style="color:var(--red-600)">*</span></label>
                <input type="text" id="cta_{{ $lang }}" name="cta_{{ $lang }}" class="form-control @error('cta_'.$lang) is-invalid @enderror" value="{{ old('cta_'.$lang, $settings['cta_'.$lang]) }}" required maxlength="255">
                @error('cta_'.$lang) <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            @endforeach
            <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Title mendukung &lt;br&gt; untuk ganti baris. Tag HTML lain otomatis dibuang.</div>

            <div class="mt-3" style="border-top:1px solid var(--gray-100);padding-top:1rem">
                <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.5rem">Uji tampilan ({{ strtoupper($locale) }})</div>
                <button type="button" class="btn btn-secondary btn-sm" id="previewToggle">Preview {{ strtoupper($locale) }}</button>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home.journal.index', ['locale' => $locale]) }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div style="border-radius:var(--radius);padding:1.5rem;background:#07080a;color:#f4f5f2">
            <div style="font-family:monospace;font-size:.68rem;letter-spacing:.18em;text-transform:uppercase;color:#9ba1ab;margin-bottom:.8rem" id="pvEyebrow"></div>
            <div style="font-size:1.6rem;font-weight:800;line-height:1.05;letter-spacing:-.03em;margin-bottom:.8rem" id="pvTitle"></div>
            <p style="font-size:.85rem;color:#9ba1ab;line-height:1.6;margin-bottom:1rem" id="pvLede"></p>
            <span style="font-size:.85rem;color:#3ddc97" id="pvCta"></span>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">Journal header on the homepage</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const locale = @json($locale);
    const fields = ['eyebrow', 'title', 'lede', 'cta'];
    const paint = () => {
        fields.forEach(f => {
            const input = document.getElementById(f + '_' + locale);
            const out = document.getElementById('pv' + f.charAt(0).toUpperCase() + f.slice(1));
            if (!input || !out) return;
            const val = input.value || '';
            out[ f === 'title' ? 'innerHTML' : 'textContent' ] = val;
        });
    };
    fields.forEach(f => {
        ['en', 'id'].forEach(l => {
            const input = document.getElementById(f + '_' + l);
            if (input) input.addEventListener('input', paint);
        });
    });
    document.getElementById('previewToggle').addEventListener('click', paint);
    paint();
});
</script>
@endpush
