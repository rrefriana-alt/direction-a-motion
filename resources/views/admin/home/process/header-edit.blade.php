@extends('admin.layouts.app')
@section('title', 'Process Header')
@section('page-title', 'Process Header')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale]) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home', ['locale'=>$locale]) }}">Home</a></li>
    <li class="breadcrumb-item active">Process Header — {{ strtoupper($locale) }}</li>
@endsection
@section('content')
@php $isEn = ($locale ?? 'en') === 'en'; @endphp
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><h2 style="display:flex;align-items:center;gap:.5rem">Process Header <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }}</span></h2><p>Hanya {{ $isEn ? 'EN' : 'ID' }} tampil</p></div>
    <a href="{{ route('admin.home', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div class="card-white saas-card" style="max-width:640px">
    <form action="{{ route('admin.home.process-header.update', ['locale'=>$locale]) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Eyebrow — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <input type="text" name="{{ $isEn ? 'eyebrow_en' : 'eyebrow_id' }}" class="form-control @error($isEn ? 'eyebrow_en' : 'eyebrow_id') is-invalid @enderror" value="{{ old($isEn ? 'eyebrow_en' : 'eyebrow_id', $isEn ? $settings['eyebrow_en'] : $settings['eyebrow_id']) }}" maxlength="60" data-max="60" required>
            @error($isEn ? 'eyebrow_en' : 'eyebrow_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Title — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <textarea name="{{ $isEn ? 'title_en' : 'title_id' }}" class="form-control @error($isEn ? 'title_en' : 'title_id') is-invalid @enderror" rows="3" maxlength="120" data-max="120" required>{{ old($isEn ? 'title_en' : 'title_id', $isEn ? $settings['title_en'] : $settings['title_id']) }}</textarea>
            @error($isEn ? 'title_en' : 'title_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions"><a href="{{ route('admin.home', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm">Cancel</a><button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save {{ strtoupper($locale) }}</button></div>
    </form>
</div>
@push('scripts')
<script>
document.querySelectorAll('textarea.form-control').forEach(ta=>{const g=()=>{ta.style.height='auto';ta.style.height=ta.scrollHeight+'px'};ta.addEventListener('input',g);g();});
document.querySelectorAll('[data-max]').forEach(el=>{let m=el.nextElementSibling;if(!m||!m.classList.contains('char-meta')){m=document.createElement('div');m.className='char-meta';el.insertAdjacentElement('afterend',m);}const u=()=>{const l=el.value.length, max=parseInt(el.dataset.max);m.textContent=l+' / '+max;m.classList.toggle('over',l>max*0.9)};el.addEventListener('input',u);u();});
</script>
@endpush
@endsection
