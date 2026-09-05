@extends('admin.layouts.app')
@section('title', 'Contact Page Settings')
@section('page-title', 'Contact Page Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale]) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.contact.index', ['locale'=>$locale]) }}">Contact</a></li>
    <li class="breadcrumb-item active">Page Settings — {{ strtoupper($locale) }}</li>
@endsection
@section('content')
@php $isEn = ($locale ?? 'en') === 'en'; @endphp
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><h2 style="display:flex;align-items:center;gap:.5rem">Contact Page <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }}</span></h2><p>Headline & subtitle per bahasa — alamat & kontak shared</p></div>
    <a href="{{ route('admin.contact.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div class="card-white saas-card" style="max-width:640px">
    <form action="{{ route('admin.contact.settings.update', ['locale'=>$locale]) }}" method="POST">
        @csrf @method('PUT')
        <h6 style="font-weight:700;color:var(--gray-900);margin-bottom:.8rem">Page Header — {{ $isEn ? 'EN' : 'ID' }}</h6>
        <div class="form-group">
            <label class="form-label">Headline — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <input type="text" name="{{ $isEn ? 'headline_en' : 'headline_id' }}" class="form-control @error($isEn ? 'headline_en' : 'headline_id') is-invalid @enderror" value="{{ old($isEn ? 'headline_en' : 'headline_id', $isEn ? $settings['headline_en'] : $settings['headline_id']) }}" maxlength="80" data-max="80" required>
            @error($isEn ? 'headline_en' : 'headline_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Subtitle — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
            <textarea name="{{ $isEn ? 'subtitle_en' : 'subtitle_id' }}" class="form-control @error($isEn ? 'subtitle_en' : 'subtitle_id') is-invalid @enderror" rows="2" maxlength="260" data-max="260" required>{{ old($isEn ? 'subtitle_en' : 'subtitle_id', $isEn ? $settings['subtitle_en'] : $settings['subtitle_id']) }}</textarea>
            @error($isEn ? 'subtitle_en' : 'subtitle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <hr style="margin:1rem 0;border:none;border-top:1px solid #f1f5f9">
        <h6 style="font-weight:700;color:var(--gray-900);margin-bottom:.8rem">Contact Information <span style="font-weight:400;color:var(--gray-400)">shared</span></h6>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $settings['phone']) }}" required>@error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $settings['email']) }}" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <hr style="margin:1rem 0;border:none;border-top:1px solid #f1f5f9">
        <h6 style="font-weight:700;color:var(--gray-900);margin-bottom:.8rem">Studio Addresses <span style="font-weight:400;color:var(--gray-400)">shared</span></h6>
        <div class="form-group"><label class="form-label">Bandung Office</label><textarea name="address_bdg" class="form-control @error('address_bdg') is-invalid @enderror" rows="2" required>{{ old('address_bdg', $settings['address_bdg']) }}</textarea>@error('address_bdg')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="form-group"><label class="form-label">Jakarta Office</label><textarea name="address_jkt" class="form-control @error('address_jkt') is-invalid @enderror" rows="2" required>{{ old('address_jkt', $settings['address_jkt']) }}</textarea>@error('address_jkt')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="form-group"><label class="form-label">Bali Office</label><textarea name="address_bali" class="form-control @error('address_bali') is-invalid @enderror" rows="2" required>{{ old('address_bali', $settings['address_bali']) }}</textarea>@error('address_bali')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="form-actions"><a href="{{ route('admin.contact.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm">Cancel</a><button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save {{ strtoupper($locale) }}</button></div>
    </form>
</div>
@push('scripts')
<script>
document.querySelectorAll('textarea.form-control').forEach(ta=>{const g=()=>{ta.style.height='auto';ta.style.height=ta.scrollHeight+'px'};ta.addEventListener('input',g);g();});
document.querySelectorAll('[data-max]').forEach(el=>{let m=el.nextElementSibling;if(!m||!m.classList.contains('char-meta')){m=document.createElement('div');m.className='char-meta';el.insertAdjacentElement('afterend',m);}const u=()=>{const l=el.value.length, max=parseInt(el.dataset.max);m.textContent=l+' / '+max;m.classList.toggle('over',l>max*0.9)};el.addEventListener('input',u);u();});
</script>
@endpush
@endsection
