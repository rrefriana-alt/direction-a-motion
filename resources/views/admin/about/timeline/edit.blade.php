@extends('admin.layouts.app')
@section('title', 'Edit Timeline Entry')
@section('page-title', 'Edit Timeline')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>request()->route('locale') ?? 'en']) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index', ['locale'=>request()->route('locale') ?? 'en']) }}">About</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.timeline.index', ['locale'=>request()->route('locale') ?? 'en']) }}">Timeline</a></li>
    <li class="breadcrumb-item active">Edit — {{ strtoupper(request()->route('locale') ?? 'en') }}</li>
@endsection
@section('content')
@php $locale = request()->route('locale') ?? 'en'; $isEn = $locale === 'en'; @endphp
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><h2 style="display:flex;align-items:center;gap:.5rem">Edit Timeline <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }}</span></h2></div>
    <a href="{{ route('admin.about.timeline.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div class="card-white saas-card" style="max-width:560px">
    <form action="{{ route('admin.about.timeline.update', ['locale'=>$locale, 'timeline'=>$timeline->id]) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group"><label class="form-label">Year <span class="required">*</span></label><input type="text" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year', $timeline->year) }}" required>@error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="form-group"><label class="form-label">Description — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label><textarea class="form-control @error($isEn ? 'description_en' : 'description_id') is-invalid @enderror" name="{{ $isEn ? 'description_en' : 'description_id' }}" rows="4" maxlength="400" data-max="400" required>{{ old($isEn ? 'description_en' : 'description_id', $isEn ? $timeline->description : ($timeline->description_id ?? '')) }}</textarea>@error($isEn ? 'description_en' : 'description_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="form-group"><label class="form-label">Icon</label><input type="text" class="form-control" name="icon" value="{{ old('icon', $timeline->icon) }}"></div>
        <div class="form-group"><label class="form-label">Sort Order</label><input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $timeline->sort_order) }}" min="0"></div>
        <div class="form-actions"><a href="{{ route('admin.about.timeline.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm">Cancel</a><button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save {{ strtoupper($locale) }}</button></div>
    </form>
</div>
@push('scripts')
<script>
document.querySelectorAll('textarea.form-control').forEach(ta=>{const g=()=>{ta.style.height='auto';ta.style.height=ta.scrollHeight+'px'};ta.addEventListener('input',g);g();});
document.querySelectorAll('[data-max]').forEach(el=>{let m=el.nextElementSibling;if(!m||!m.classList.contains('char-meta')){m=document.createElement('div');m.className='char-meta';el.insertAdjacentElement('afterend',m);}const u=()=>{const l=el.value.length, max=parseInt(el.dataset.max);m.textContent=l+' / '+max;m.classList.toggle('over',l>max*0.9)};el.addEventListener('input',u);u();});
</script>
@endpush
@endsection
