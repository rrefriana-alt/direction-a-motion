@extends('admin.layouts.app')
@section('title', 'About Page Settings')
@section('page-title', 'About Page Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale]) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index', ['locale'=>$locale]) }}">About</a></li>
    <li class="breadcrumb-item active">Page Settings — {{ strtoupper($locale) }}</li>
@endsection
@section('content')
@php $isEn = ($locale ?? 'en') === 'en'; @endphp
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><h2 style="display:flex;align-items:center;gap:.5rem">About Page <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }}</span></h2><p>Hanya {{ $isEn ? 'EN' : 'ID' }} tampil</p></div>
    <a href="{{ route('admin.about.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div class="card-white saas-card" style="max-width:640px">
    <form action="{{ route('admin.about.settings.update', ['locale'=>$locale]) }}" method="POST">
        @csrf @method('PUT')
        <div style="font-weight:700;color:var(--gray-900);margin-bottom:.6rem">Page Header — {{ $isEn ? 'EN' : 'ID' }}</div>
        <div class="form-group">
            <label class="form-label">Headline — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <input type="text" name="{{ $isEn ? 'headline_en' : 'headline_id' }}" class="form-control @error($isEn ? 'headline_en' : 'headline_id') is-invalid @enderror" value="{{ old($isEn ? 'headline_en' : 'headline_id', $isEn ? $settings['headline_en'] : $settings['headline_id']) }}" maxlength="120" data-max="120" required>
            @error($isEn ? 'headline_en' : 'headline_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Subtitle — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <textarea name="{{ $isEn ? 'subtitle_en' : 'subtitle_id' }}" class="form-control @error($isEn ? 'subtitle_en' : 'subtitle_id') is-invalid @enderror" rows="2" maxlength="260" data-max="260" required>{{ old($isEn ? 'subtitle_en' : 'subtitle_id', $isEn ? $settings['subtitle_en'] : $settings['subtitle_id']) }}</textarea>
            @error($isEn ? 'subtitle_en' : 'subtitle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <hr style="border:none;border-top:1px solid #f1f5f9;margin:1rem 0">
        <div style="font-weight:700;color:var(--gray-900);margin-bottom:.6rem">Our Belief — {{ $isEn ? 'EN' : 'ID' }}</div>
        <div class="form-group">
            <label class="form-label">Belief Title — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <input type="text" name="{{ $isEn ? 'belief_title_en' : 'belief_title_id' }}" class="form-control @error($isEn ? 'belief_title_en' : 'belief_title_id') is-invalid @enderror" value="{{ old($isEn ? 'belief_title_en' : 'belief_title_id', $isEn ? $settings['belief_title_en'] : $settings['belief_title_id']) }}" maxlength="80" data-max="80" required>
            @error($isEn ? 'belief_title_en' : 'belief_title_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Belief Text — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <textarea name="{{ $isEn ? 'belief_text_en' : 'belief_text_id' }}" class="form-control @error($isEn ? 'belief_text_en' : 'belief_text_id') is-invalid @enderror" rows="3" maxlength="260" data-max="260" required>{{ old($isEn ? 'belief_text_en' : 'belief_text_id', $isEn ? $settings['belief_text_en'] : $settings['belief_text_id']) }}</textarea>
            @error($isEn ? 'belief_text_en' : 'belief_text_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Belief Elaboration — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <textarea name="{{ $isEn ? 'belief_elaboration_en' : 'belief_elaboration_id' }}" class="form-control @error($isEn ? 'belief_elaboration_en' : 'belief_elaboration_id') is-invalid @enderror" rows="3" maxlength="360" data-max="360" required>{{ old($isEn ? 'belief_elaboration_en' : 'belief_elaboration_id', $isEn ? $settings['belief_elaboration_en'] : $settings['belief_elaboration_id']) }}</textarea>
            @error($isEn ? 'belief_elaboration_en' : 'belief_elaboration_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions"><a href="{{ route('admin.about.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm">Cancel</a><button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save {{ strtoupper($locale) }}</button></div>
    </form>
</div>
@push('scripts')
<script>
document.querySelectorAll('textarea.form-control').forEach(ta=>{const g=()=>{ta.style.height='auto';ta.style.height=ta.scrollHeight+'px'};ta.addEventListener('input',g);g();});
document.querySelectorAll('[data-max]').forEach(el=>{let m=el.nextElementSibling;if(!m||!m.classList.contains('char-meta')){m=document.createElement('div');m.className='char-meta';el.insertAdjacentElement('afterend',m);}const u=()=>{const l=el.value.length, max=parseInt(el.dataset.max);m.textContent=l+' / '+max;m.classList.toggle('over',l>max*0.9)};el.addEventListener('input',u);u();});
</script>
@endpush
@endsection
