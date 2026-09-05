@extends('admin.layouts.app')
@section('title', 'Edit Hero')
@section('page-title', 'Hero Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale]) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home', ['locale'=>$locale]) }}">Home</a></li>
    <li class="breadcrumb-item active">Hero — {{ strtoupper($locale) }}</li>
@endsection

@section('content')
@php $isEn = ($locale ?? 'en') === 'en'; @endphp
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h2 style="display:flex;align-items:center;gap:.5rem">Hero <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }} — {{ $isEn ? 'English' : 'Bahasa' }}</span></h2>
        <p>Hanya field {{ $isEn ? 'EN' : 'ID' }} tampil. Sisi lawan dipertahankan. Ganti bahasa via switcher header.</p>
    </div>
    <a href="{{ route('admin.home', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white saas-card" style="max-width:640px">
        <form action="{{ route('admin.home.hero.update', ['locale'=>$locale]) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Tagline — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
                <input type="text" name="{{ $isEn ? 'tagline_en' : 'tagline_id' }}" class="form-control @error($isEn ? 'tagline_en' : 'tagline_id') is-invalid @enderror" value="{{ old($isEn ? 'tagline_en' : 'tagline_id', $isEn ? $settings['tagline_en'] : $settings['tagline_id']) }}" maxlength="80" data-max="80" required>
                @error($isEn ? 'tagline_en' : 'tagline_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Description — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
                <textarea name="{{ $isEn ? 'description_en' : 'description_id' }}" class="form-control @error($isEn ? 'description_en' : 'description_id') is-invalid @enderror" rows="3" maxlength="260" data-max="260" required>{{ old($isEn ? 'description_en' : 'description_id', $isEn ? $settings['description_en'] : $settings['description_id']) }}</textarea>
                @error($isEn ? 'description_en' : 'description_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="form-actions">
                <a href="{{ route('admin.home', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save {{ strtoupper($locale) }}</button>
            </div>
        </form>
    </div>
    <div>
        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.5rem">Preview ({{ strtoupper($locale) }})</div>
        <div class="card-white saas-card" style="padding:1.2rem;background:var(--gray-900);color:white;text-align:center">
            <div style="font-size:.72rem;color:var(--gray-400)">{{ $isEn ? $settings['tagline_en'] : $settings['tagline_id'] }}</div>
            <div style="font-size:.78rem;color:#fff;margin-top:.35rem;line-height:1.5">{{ $isEn ? $settings['description_en'] : $settings['description_id'] }}</div>
        </div>
        <div class="card-white saas-card" style="padding:.8rem;margin-top:.75rem;background:#f8fafc">
            <div style="font-size:.68rem;font-weight:600;color:var(--gray-500)">Sisi {{ $isEn ? 'ID' : 'EN' }} tersimpan: {{ $isEn ? $settings['tagline_id'] : $settings['tagline_en'] }}</div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.querySelectorAll('textarea.form-control').forEach(ta=>{const g=()=>{ta.style.height='auto';ta.style.height=ta.scrollHeight+'px'};ta.addEventListener('input',g);g();});
document.querySelectorAll('[data-max]').forEach(el=>{let m=el.nextElementSibling;if(!m||!m.classList.contains('char-meta')){m=document.createElement('div');m.className='char-meta';el.insertAdjacentElement('afterend',m);}const u=()=>{const l=el.value.length, max=parseInt(el.dataset.max);m.textContent=l+' / '+max;m.classList.toggle('over',l>max*0.9)};el.addEventListener('input',u);u();});
</script>
@endpush
@endsection
