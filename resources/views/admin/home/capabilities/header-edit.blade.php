@extends('admin.layouts.app')
@section('title', 'Capabilities Header')
@section('page-title', 'Capabilities Header')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale]) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home', ['locale'=>$locale]) }}">Home</a></li>
    <li class="breadcrumb-item active">Capabilities Header — {{ strtoupper($locale) }}</li>
@endsection
@section('content')
@php $isEn = ($locale ?? 'en') === 'en'; @endphp
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><h2 style="display:flex;align-items:center;gap:.5rem">Capabilities Header <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }}</span></h2><p>Hanya {{ $isEn ? 'EN' : 'ID' }} tampil</p></div>
    <a href="{{ route('admin.home', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div class="card-white saas-card" style="max-width:640px">
    <form action="{{ route('admin.home.capabilities-header.update', ['locale'=>$locale]) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Title — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <input type="text" name="{{ $isEn ? 'title_en' : 'title_id' }}" class="form-control @error($isEn ? 'title_en' : 'title_id') is-invalid @enderror" value="{{ old($isEn ? 'title_en' : 'title_id', $isEn ? $settings['title_en'] : $settings['title_id']) }}" maxlength="80" data-max="80" required>
            @error($isEn ? 'title_en' : 'title_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Description — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <textarea name="{{ $isEn ? 'description_en' : 'description_id' }}" class="form-control @error($isEn ? 'description_en' : 'description_id') is-invalid @enderror" rows="3" maxlength="260" data-max="260" required>{{ old($isEn ? 'description_en' : 'description_id', $isEn ? $settings['description_en'] : $settings['description_id']) }}</textarea>
            @error($isEn ? 'description_en' : 'description_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
