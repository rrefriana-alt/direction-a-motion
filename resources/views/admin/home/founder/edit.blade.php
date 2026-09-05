@extends('admin.layouts.app')
@section('title', 'Founder Quote')
@section('page-title', 'Founder Quote')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale]) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home', ['locale'=>$locale]) }}">Home</a></li>
    <li class="breadcrumb-item active">Founder — {{ strtoupper($locale) }}</li>
@endsection
@section('content')
@php $isEn = ($locale ?? 'en') === 'en'; @endphp
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><h2 style="display:flex;align-items:center;gap:.5rem">Founder Quote <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }}</span></h2><p>Hanya {{ $isEn ? 'EN' : 'ID' }} tampil. Name & photo shared.</p></div>
    <a href="{{ route('admin.home', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>
<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white saas-card" style="max-width:640px">
        <form action="{{ route('admin.home.founder.update', ['locale'=>$locale]) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Quote — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
                <textarea name="{{ $isEn ? 'quote_en' : 'quote_id' }}" class="form-control @error($isEn ? 'quote_en' : 'quote_id') is-invalid @enderror" rows="3" maxlength="360" data-max="360" required>{{ old($isEn ? 'quote_en' : 'quote_id', $isEn ? $settings['quote_en'] : $settings['quote_id']) }}</textarea>
                @error($isEn ? 'quote_en' : 'quote_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Name <span class="required">*</span> <span style="font-weight:400;color:var(--gray-400)">shared</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $settings['name']) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Title — {{ $isEn ? 'EN' : 'ID' }} <span class="required">*</span></label>
                    <input type="text" name="{{ $isEn ? 'title_en' : 'title_id' }}" class="form-control @error($isEn ? 'title_en' : 'title_id') is-invalid @enderror" value="{{ old($isEn ? 'title_en' : 'title_id', $isEn ? $settings['title_en'] : $settings['title_id']) }}" maxlength="60" data-max="60" required>
                    @error($isEn ? 'title_en' : 'title_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Photo <span style="font-weight:400;color:var(--gray-400)">shared</span></label>
                <div id="dropZone" style="border:2px dashed #e2e8f0;border-radius:12px;padding:1.5rem;text-align:center;cursor:pointer;transition:all .2s;background:#f8fafc" onclick="document.getElementById('imageInput').click()">
                    <i class="bi bi-cloud-arrow-up" style="font-size:1.5rem;color:var(--gray-400)"></i>
                    <div style="font-size:.8rem;color:var(--gray-500);margin-top:.25rem">{{ $settings['image'] ? 'Click to replace photo' : 'Click to upload photo' }}</div>
                    <div style="font-size:.7rem;color:var(--gray-400)">JPG, PNG (max 2MB)</div>
                </div>
                <input type="file" name="image" class="form-control d-none" id="imageInput" accept="image/*">
                @if($settings['image'])
                <div id="currentImage" style="margin-top:.5rem"><img src="{{ asset('img/' . $settings['image']) }}" alt="Founder" style="height:64px;width:64px;object-fit:cover;border-radius:50%;border:2px solid #e2e8f0"></div>
                @endif
                <div id="imagePreview" style="margin-top:.5rem;display:none"><img id="previewImg" style="height:64px;width:64px;object-fit:cover;border-radius:50%;border:2px solid #e2e8f0"></div>
                @error('image')<div style="font-size:.75rem;color:var(--danger);margin-top:.25rem">{{ $message }}</div>@enderror
            </div>
            <div class="form-actions"><a href="{{ route('admin.home', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm">Cancel</a><button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save {{ strtoupper($locale) }}</button></div>
        </form>
    </div>
    <div>
        <div style="font-size:.72rem;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.5rem">Preview</div>
        <div class="card-white saas-card" style="padding:1.2rem">
            <blockquote style="font-size:.9rem;color:var(--gray-900);line-height:1.5;margin:0 0 1rem 0;font-style:italic;border-left:3px solid var(--green-500);padding-left:1rem">{{ $isEn ? $settings['quote_en'] : $settings['quote_id'] }}</blockquote>
            <div style="display:flex;align-items:center;gap:.75rem"><div style="width:40px;height:40px;border-radius:50%;background:var(--gray-100);display:flex;align-items:center;justify-content:center;color:var(--gray-400)"><i class="bi bi-person"></i></div><div><div style="font-size:.8rem;font-weight:600;color:var(--gray-900)">{{ $settings['name'] }}</div><div style="font-size:.72rem;color:var(--gray-500)">{{ $isEn ? $settings['title_en'] : $settings['title_id'] }}</div></div></div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.querySelectorAll('textarea.form-control').forEach(ta=>{const g=()=>{ta.style.height='auto';ta.style.height=ta.scrollHeight+'px'};ta.addEventListener('input',g);g();});
document.querySelectorAll('[data-max]').forEach(el=>{let m=el.nextElementSibling;if(!m||!m.classList.contains('char-meta')){m=document.createElement('div');m.className='char-meta';el.insertAdjacentElement('afterend',m);}const u=()=>{const l=el.value.length, max=parseInt(el.dataset.max);m.textContent=l+' / '+max;m.classList.toggle('over',l>max*0.9)};el.addEventListener('input',u);u();});
const imageInput=document.getElementById('imageInput');const dropZone=document.getElementById('dropZone');const imagePreview=document.getElementById('imagePreview');const previewImg=document.getElementById('previewImg');
if(imageInput) imageInput.addEventListener('change', function(){ if(this.files&&this.files[0]){ const url=URL.createObjectURL(this.files[0]); previewImg.src=url; imagePreview.style.display='block'; dropZone.style.display='none'; const cur=document.getElementById('currentImage'); if(cur) cur.style.display='none'; }});
if(dropZone){ dropZone.addEventListener('dragover', e=>{e.preventDefault(); dropZone.style.borderColor='var(--green-500)'}); dropZone.addEventListener('dragleave', ()=>dropZone.style.borderColor='#e2e8f0'); dropZone.addEventListener('drop', e=>{e.preventDefault(); dropZone.style.borderColor='#e2e8f0'; if(e.dataTransfer.files.length){ imageInput.files=e.dataTransfer.files; imageInput.dispatchEvent(new Event('change')); }}); }
</script>
@endpush
@endsection
