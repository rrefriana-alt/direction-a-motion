@extends('admin.layouts.app')
@section('title', 'Edit Footer')
@section('page-title', 'Footer Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale]) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home', ['locale'=>$locale]) }}">Home</a></li>
    <li class="breadcrumb-item active">Footer — {{ strtoupper($locale) }}</li>
@endsection
@section('content')
@php $isEn = ($locale ?? 'en') === 'en'; @endphp
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><h2 style="display:flex;align-items:center;gap:.5rem">Footer <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }}</span></h2><p>{{ $isEn ? 'EN' : 'ID' }} description saja — social & alamat shared</p></div>
    <a href="{{ route('admin.home', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white saas-card" style="max-width:640px">
        <form action="{{ route('admin.home.footer.update', ['locale'=>$locale]) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Description — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
                <textarea name="{{ $isEn ? 'description_en' : 'description_id' }}" class="form-control @error($isEn ? 'description_en' : 'description_id') is-invalid @enderror" rows="3" maxlength="260" data-max="260" required>{{ old($isEn ? 'description_en' : 'description_id', $isEn ? $settings['description_en'] : $settings['description_id']) }}</textarea>
                @error($isEn ? 'description_en' : 'description_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group"><label class="form-label">Phone Number <span style="font-weight:400;color:var(--gray-400)">shared</span></label><input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $settings['phone']) }}" placeholder="+62 821 2100 0680">@error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label class="form-label">Email <span style="font-weight:400;color:var(--gray-400)">shared</span></label><input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $settings['email']) }}" placeholder="hello@fugocreativegroup.com">@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label class="form-label">Address (Bandung — HQ) <span style="font-weight:400;color:var(--gray-400)">shared</span></label><textarea name="address_bandung" class="form-control @error('address_bandung') is-invalid @enderror" rows="2">{{ old('address_bandung', $settings['address_bandung']) }}</textarea>@error('address_bandung')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label class="form-label">Address (Jakarta) <span style="font-weight:400;color:var(--gray-400)">shared</span></label><textarea name="address_jakarta" class="form-control @error('address_jakarta') is-invalid @enderror" rows="2">{{ old('address_jakarta', $settings['address_jakarta']) }}</textarea>@error('address_jakarta')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label class="form-label">Address (Bali) <span style="font-weight:400;color:var(--gray-400)">shared</span></label><textarea name="address_bali" class="form-control @error('address_bali') is-invalid @enderror" rows="2">{{ old('address_bali', $settings['address_bali']) }}</textarea>@error('address_bali')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <hr style="margin:1.2rem 0;border:none;border-top:1px solid #f1f5f9">
            <div style="font-size:.82rem;font-weight:700;color:var(--gray-700);margin-bottom:.8rem">Social Media Links <span style="font-weight:400;color:var(--gray-400)">shared</span></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group"><label class="form-label"><i class="bi bi-instagram"></i> Instagram</label><input type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram', $settings['instagram']) }}" placeholder="https://instagram.com/fugocreative">@error('instagram')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label"><i class="bi bi-linkedin"></i> LinkedIn</label><input type="url" name="linkedin" class="form-control @error('linkedin') is-invalid @enderror" value="{{ old('linkedin', $settings['linkedin']) }}" placeholder="https://linkedin.com/company/...">@error('linkedin')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label"><i class="bi bi-tiktok"></i> TikTok</label><input type="url" name="tiktok" class="form-control @error('tiktok') is-invalid @enderror" value="{{ old('tiktok', $settings['tiktok']) }}" placeholder="https://tiktok.com/@fugo.creative">@error('tiktok')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="form-group"><label class="form-label"><i class="bi bi-youtube"></i> YouTube</label><input type="url" name="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ old('youtube', $settings['youtube']) }}" placeholder="https://youtube.com/@fugocreative">@error('youtube')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            </div>
            <div class="form-actions"><a href="{{ route('admin.home', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm">Cancel</a><button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save {{ strtoupper($locale) }}</button></div>
        </form>
    </div>
    <div>
        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.5rem">Live Preview — {{ strtoupper($locale) }}</div>
        <div class="card-white saas-card" style="padding:1.2rem;background:var(--gray-900);color:white"><div style="font-size:.8rem;font-weight:700;color:white;margin-bottom:.4rem">Fugo<span style="color:var(--green-400)">Creative</span></div><p style="font-size:.72rem;color:rgba(255,255,255,.6);margin-bottom:.8rem;line-height:1.5;max-width:30ch">{{ $isEn ? $settings['description_en'] : $settings['description_id'] }}</p><div style="font-size:.62rem;color:rgba(255,255,255,.4);border-top:1px solid rgba(255,255,255,.1);padding-top:.6rem;display:flex;justify-content:space-between"><span>© 2026 PT Fugo Creative Group</span><span>{{ $settings['phone'] }}</span></div></div>
    </div>
</div>
@push('scripts')
<script>
document.querySelectorAll('textarea.form-control').forEach(ta=>{const g=()=>{ta.style.height='auto';ta.style.height=ta.scrollHeight+'px'};ta.addEventListener('input',g);g();});
document.querySelectorAll('[data-max]').forEach(el=>{let m=el.nextElementSibling;if(!m||!m.classList.contains('char-meta')){m=document.createElement('div');m.className='char-meta';el.insertAdjacentElement('afterend',m);}const u=()=>{const l=el.value.length, max=parseInt(el.dataset.max);m.textContent=l+' / '+max;m.classList.toggle('over',l>max*0.9)};el.addEventListener('input',u);u();});
</script>
@endpush
@endsection
