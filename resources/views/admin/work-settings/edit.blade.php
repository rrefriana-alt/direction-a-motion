@extends('admin.layouts.app')
@section('title', 'Work Page Settings')
@section('page-title', 'Work Page Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale]) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index', ['locale'=>$locale]) }}">Portfolio</a></li>
    <li class="breadcrumb-item active">Work Page — {{ strtoupper($locale) }}</li>
@endsection
@section('content')
@php $isEn = ($locale ?? 'en') === 'en'; @endphp
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><h2 style="display:flex;align-items:center;gap:.5rem">Work Page <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }}</span></h2><p>Hanya {{ $isEn ? 'EN' : 'ID' }} tampil</p></div>
    <a href="{{ route('admin.portfolio.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white saas-card" style="max-width:640px">
        <form action="{{ route('admin.work-settings.update', ['locale'=>$locale]) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Page Title — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
                <input type="text" name="{{ $isEn ? 'title_en' : 'title_id' }}" class="form-control @error($isEn ? 'title_en' : 'title_id') is-invalid @enderror" value="{{ old($isEn ? 'title_en' : 'title_id', $isEn ? $settings['title_en'] : $settings['title_id']) }}" maxlength="80" data-max="80" required>
                @error($isEn ? 'title_en' : 'title_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Page Lede — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
                <textarea name="{{ $isEn ? 'lede_en' : 'lede_id' }}" class="form-control @error($isEn ? 'lede_en' : 'lede_id') is-invalid @enderror" rows="3" maxlength="260" data-max="260" required>{{ old($isEn ? 'lede_en' : 'lede_id', $isEn ? $settings['lede_en'] : $settings['lede_id']) }}</textarea>
                @error($isEn ? 'lede_en' : 'lede_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-actions"><a href="{{ route('admin.portfolio.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm">Cancel</a><button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save {{ strtoupper($locale) }}</button></div>
        </form>
    </div>
    <div>
        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.5rem">Preview — {{ strtoupper($locale) }}</div>
        <div class="card-white saas-card" style="padding:1.2rem"><div style="font-size:.7rem;color:var(--gray-400);margin-bottom:.4rem">Fugo / Work</div><h1 style="font-size:1.25rem;font-weight:800;color:var(--gray-900);line-height:1.1;margin-bottom:.6rem">{{ $isEn ? $settings['title_en'] : $settings['title_id'] }}</h1><p style="font-size:.78rem;color:var(--gray-500);line-height:1.5">{{ $isEn ? $settings['lede_en'] : $settings['lede_id'] }}</p></div>
    </div>
</div>
@push('scripts')
<script>
document.querySelectorAll('textarea.form-control').forEach(ta=>{const g=()=>{ta.style.height='auto';ta.style.height=ta.scrollHeight+'px'};ta.addEventListener('input',g);g();});
document.querySelectorAll('[data-max]').forEach(el=>{let m=el.nextElementSibling;if(!m||!m.classList.contains('char-meta')){m=document.createElement('div');m.className='char-meta';el.insertAdjacentElement('afterend',m);}const u=()=>{const l=el.value.length, max=parseInt(el.dataset.max);m.textContent=l+' / '+max;m.classList.toggle('over',l>max*0.9)};el.addEventListener('input',u);u();});
</script>
@endpush
@endsection
