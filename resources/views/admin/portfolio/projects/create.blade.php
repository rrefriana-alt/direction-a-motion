@extends('admin.layouts.app')
@section('title', 'Create Project')
@section('page-title', 'Create Project')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale ?? 'en']) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index', ['locale'=>$locale ?? 'en']) }}">Portfolio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.projects.index', ['locale'=>$locale ?? 'en']) }}">Projects</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
@php $isEn = ($locale ?? 'en') === 'en'; @endphp
<style>
.proj-layout{display:grid;grid-template-columns:240px 1fr;gap:1.6rem;align-items:start}
.proj-nav{position:sticky;top:1rem;background:#fff;border:1px solid #eef2f7;border-radius:16px;padding:.6rem;display:flex;flex-direction:column;gap:.4rem;box-shadow:0 8px 24px rgba(15,23,42,.06)}
.proj-nav button{width:100%;text-align:left;padding:.7rem .85rem;background:#f8fafc;border:1px solid transparent;border-radius:12px;font-size:.78rem;font-weight:600;color:var(--gray-600);display:flex;align-items:center;justify-content:space-between;gap:.5rem;cursor:pointer;transition:all .18s}
.proj-nav button:hover{background:#fff;border-color:#e2e8f0;transform:translateY(-1px);box-shadow:0 4px 12px rgba(15,23,42,.06)}
.proj-nav button.active{background:var(--gray-900);border-color:var(--gray-900);color:#fff;box-shadow:0 8px 20px rgba(15,23,42,.18)}
.proj-nav button small{font-size:.62rem;font-weight:600;opacity:.6;background:#eef2f7;padding:.18rem .45rem;border-radius:100px}
.proj-nav button.active small{background:rgba(255,255,255,.14);color:#fff;opacity:1}
.tab-content{display:none;animation:fadeIn .22s ease}
.tab-content.active{display:block}
@keyframes fadeIn{from{opacity:0;transform:translateY(4px)}to{opacity:1;transform:none}}
.group-card{background:#fff;border:1px solid #eef2f7;border-radius:16px;padding:1.3rem;margin-bottom:1rem;box-shadow:0 2px 12px rgba(15,23,42,.04)}
.group-head{display:flex;align-items:center;gap:.7rem;margin-bottom:1.1rem;padding-bottom:.85rem;border-bottom:1px solid #f1f5f9}
.group-head i{width:32px;height:32px;border-radius:10px;background:linear-gradient(135deg,var(--green-500),#06b6d4);color:#fff;display:grid;place-items:center;font-size:.9rem;box-shadow:0 4px 10px rgba(16,185,129,.25)}
.group-head h3{font-size:.86rem;font-weight:700;color:var(--gray-800);margin:0;letter-spacing:-.01em}
.group-head p{font-size:.7rem;color:var(--gray-400);margin:.1rem 0 0}
.locale-badge{display:inline-flex;align-items:center;gap:.35rem;padding:.28rem .65rem;border-radius:100px;font-size:.66rem;font-weight:800;letter-spacing:.05em;text-transform:uppercase}
.locale-badge.en{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
.locale-badge.id{background:#fffbeb;color:#92400e;border:1px solid #fde68a}
.field-group{margin-bottom:1.05rem}
.field-label{font-size:.68rem;font-weight:700;color:var(--gray-500);margin-bottom:.35rem;display:flex;align-items:center;justify-content:space-between;letter-spacing:.04em;text-transform:uppercase}
.field-label span{font-weight:500;text-transform:none;letter-spacing:0}
.field-hint{font-size:.68rem;color:var(--gray-400);margin-top:.3rem;line-height:1.5}
.form-control,.form-select{background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:.65rem .85rem;font-size:.84rem;color:var(--gray-900);transition:all .18s;box-shadow:none}
.form-control::placeholder{color:#94a3b8;font-size:.82rem}
.form-control:hover{background:#fff;border-color:#cbd5e1}
.form-control:focus,.form-select:focus{background:#fff;border-color:var(--green-500);box-shadow:0 0 0 4px rgba(16,185,129,.12);outline:none}
.form-control-sm{padding:.5rem .7rem;font-size:.8rem;border-radius:10px}
textarea.form-control{resize:none !important;overflow:hidden;min-height:88px;line-height:1.6;field-sizing:content}
.char-meta{font-size:.62rem;font-weight:500;color:var(--gray-400);text-align:right;margin-top:.28rem;transition:color .2s}
.char-meta.over{color:var(--danger)}
.list-item{background:#f8fafc;border:1px solid #eef2f7;border-radius:14px;padding:1rem;margin-bottom:.7rem;position:relative;transition:all .18s}
.list-item:hover{background:#fff;border-color:#e2e8f0;box-shadow:0 4px 16px rgba(15,23,42,.06);transform:translateY(-1px)}
.list-item .remove-btn{position:absolute;top:.5rem;right:.5rem;width:26px;height:26px;border-radius:10px;background:#fff;border:1px solid #fee2e2;color:#ef4444;font-size:.72rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;box-shadow:0 1px 4px rgba(0,0,0,.06)}
.list-item .remove-btn:hover{background:#ef4444;border-color:#ef4444;color:#fff;transform:scale(1.05)}
.add-btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem .85rem;background:#fff;border:1px dashed #cbd5e1;border-radius:12px;color:var(--gray-600);font-size:.72rem;font-weight:700;cursor:pointer;transition:all .18s}
.add-btn:hover{border-color:var(--green-500);color:var(--green-600);background:#ecfdf5;transform:translateY(-1px);box-shadow:0 4px 12px rgba(16,185,129,.12)}
.color-input{width:100%;height:42px;border:1px solid #e2e8f0;border-radius:12px;cursor:pointer;padding:3px;background:#f8fafc}
@media(max-width:900px){.proj-layout{grid-template-columns:1fr}.proj-nav{position:static;flex-direction:row;overflow-x:auto;scrollbar-width:none;padding:.5rem}.proj-nav button{white-space:nowrap}}
</style>

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h2 style="display:flex;align-items:center;gap:.6rem">Create New Project <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }} — {{ $isEn ? 'English' : 'Bahasa' }}</span></h2>
        <p style="font-size:.78rem;color:var(--gray-500)">Form hanya <strong>{{ $isEn ? 'EN' : 'ID' }}</strong>. Buat dulu di satu bahasa, lalu edit di bahasa lain untuk menambah terjemahan. Website akan tampil sesuai locale.</p>
    </div>
    <a href="{{ route('admin.portfolio.projects.index', ['locale'=>$locale ?? 'en']) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<form action="{{ route('admin.portfolio.projects.store', ['locale'=>$locale ?? 'en']) }}" method="POST" enctype="multipart/form-data" id="projectForm" data-locale="{{ $locale ?? 'en' }}">
    @csrf

    <div class="proj-layout">
        <nav class="proj-nav" id="projNav">
            <button type="button" class="active" data-tab="overview"><span><i class="bi bi-grid"></i> Overview</span> <small>Umum</small></button>
            <button type="button" data-tab="narrative"><span><i class="bi bi-text-paragraph"></i> Narrative</span> <small>cerita</small></button>
            <button type="button" data-tab="outcome"><span><i class="bi bi-graph-up"></i> Outcome</span> <small>stats/result</small></button>
            <button type="button" data-tab="media"><span><i class="bi bi-images"></i> Media</span> <small>gallery/docs</small></button>
            <button type="button" data-tab="context"><span><i class="bi bi-collection"></i> Context</span> <small>use & credit</small></button>
        </nav>

        <div class="proj-main">
            <div class="tab-content active" id="tab-overview">
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-info-circle"></i><div><h3>Identitas</h3><p>Judul, client, kategori & urutan</p></div></div>
                    <div class="field-group"><label class="field-label">Title <span style="color:var(--danger)">*</span> <span style="font-weight:400;color:var(--gray-400)">shared</span></label><input type="text" name="title" maxlength="120" data-max="120" class="form-control" value="{{ old('title') }}" required placeholder="e.g. BRI Debit Virtual TVC"></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
                        <div class="field-group"><label class="field-label">Client Name <span style="font-weight:400;color:var(--gray-400)">shared</span></label><input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" placeholder="Bank Rakyat Indonesia"></div>
                        <div class="field-group"><label class="field-label">Category <span style="color:var(--danger)">*</span></label><select name="category" class="form-select" required><option value="">Select category</option>@foreach($categories as $key=>$label)<option value="{{ $key }}" {{ old('category')===$key?'selected':'' }}>{{ $label }}</option>@endforeach</select></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem">
                        <div class="field-group"><label class="field-label">Year</label><input type="text" name="year" class="form-control" value="{{ old('year', date('Y')) }}" placeholder="2025"></div>
                        <div class="field-group"><label class="field-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',0) }}" min="0"></div>
                        <div class="field-group"><label class="field-label">Homepage Order</label><input type="number" name="homepage_order" class="form-control" value="{{ old('homepage_order',0) }}" min="0"></div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Scope — {{ $isEn?'English':'Bahasa' }}</label>
                        @if($isEn)<input type="text" name="scope_en" maxlength="80" data-max="80" class="form-control" value="{{ old('scope_en') }}" placeholder="Concept — Script — Production">
                        @else<input type="text" name="scope_id" maxlength="80" data-max="80" class="form-control" value="{{ old('scope_id') }}" placeholder="Konsep — Naskah — Produksi">@endif
                    </div>
                    <div class="field-group">
                        <label class="field-label">Division — {{ $isEn?'English':'Bahasa' }}</label>
                        @if($isEn)<input type="text" name="division_en" maxlength="60" data-max="60" class="form-control" value="{{ old('division_en') }}" placeholder="Production House">
                        @else<input type="text" name="division_id" maxlength="60" data-max="60" class="form-control" value="{{ old('division_id') }}" placeholder="Rumah Produksi">@endif
                    </div>
                </div>
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-image"></i><div><h3>Media Utama</h3><p>Card, hero, logo & warna — shared</p></div></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem">
                        <div>
                            <div class="field-group"><label class="field-label">Card Image</label><input type="file" name="image" class="form-control" accept="image/*"><div class="field-hint">Work list</div></div>
                            <div class="field-group"><label class="field-label">Hero Image</label><input type="file" name="hero_image" class="form-control" accept="image/*"><div class="field-hint">Top modal</div></div>
                            <div class="field-group"><label class="field-label">Client Logo</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
                        </div>
                        <div>
                            <div class="field-group"><label class="field-label">Background Color</label><div style="display:flex;gap:.5rem;align-items:center"><input type="color" name="bg_color" class="color-input" value="{{ old('bg_color','#101722') }}"><input type="text" class="form-control form-control-sm" value="{{ old('bg_color','#101722') }}" style="max-width:100px" readonly></div></div>
                            <div class="field-group"><label class="field-label">Accent Color</label><div style="display:flex;gap:.5rem;align-items:center"><input type="color" name="accent_color" class="color-input" value="{{ old('accent_color','#3ddc97') }}"><input type="text" class="form-control form-control-sm" value="{{ old('accent_color','#3ddc97') }}" style="max-width:100px" readonly></div></div>
                        </div>
                    </div>
                </div>
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-gear"></i><div><h3>Publish</h3><p>URL, status & urutan</p></div></div>
                    <div class="field-group"><label class="field-label">Case Study URL</label><input type="text" name="case_study" class="form-control" value="{{ old('case_study') }}" placeholder="case-study or https://..."></div>
                    <div class="field-group"><label class="field-label">Description (legacy) <span style="font-weight:400;color:var(--gray-400)">shared</span></label><textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea></div>
                    <div style="display:flex;gap:1.2rem;flex-wrap:wrap"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" checked><label class="form-check-label" style="font-size:.78rem">Active</label></div><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_featured" value="1"><label class="form-check-label" style="font-size:.78rem">Featured homepage</label></div></div>
                    <div style="margin-top:.75rem;padding:.65rem;background:var(--gray-50);border:1px solid var(--gray-200);border-radius:var(--radius-md);font-size:.7rem;color:var(--gray-500)"><i class="bi bi-translate"></i> Anda membuat di <strong style="color:var(--green-600)">{{ strtoupper($locale) }}</strong> — nanti edit di bahasa lawan untuk menambah terjemahan tanpa menghapus yang sudah ada.</div>
                </div>
            </div>

            <div class="tab-content" id="tab-narrative">
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-text-paragraph"></i><div><h3>Narrative — {{ $isEn?'EN':'ID' }}</h3><p>Lede, result, about & tags — hanya bahasa aktif</p></div></div>
                    <div class="field-group"><label class="field-label">Lede — {{ $isEn?'English':'Bahasa' }}</label><textarea name="{{ $isEn?'lede_en':'lede_id' }}" class="form-control" rows="2" placeholder="{{ $isEn?'Short headline EN':'Headline singkat ID' }}">{{ old($isEn?'lede_en':'lede_id') }}</textarea></div>
                    <div class="field-group"><label class="field-label">Result — {{ $isEn?'English':'Bahasa' }}</label><textarea name="{{ $isEn?'result_en':'result_id' }}" class="form-control" rows="2" placeholder="{{ $isEn?'Outcome EN':'Hasil ID' }}">{{ old($isEn?'result_en':'result_id') }}</textarea></div>
                    <div class="field-group"><label class="field-label">About — What it is ({{ $isEn?'EN':'ID' }})</label><div id="aboutList"></div><button type="button" class="add-btn" onclick="addAbout()"><i class="bi bi-plus"></i> Add Paragraph ({{ strtoupper($isEn?'en':'id') }})</button></div>
                    <div class="field-group"><label class="field-label">Tags <span style="font-weight:400;color:var(--gray-400)">shared</span></label><div style="display:flex;flex-wrap:wrap;gap:.4rem;margin-bottom:.4rem" id="tagsDisplay"></div><div style="display:flex;gap:.45rem"><input type="text" id="tagInput" class="form-control form-control-sm" placeholder="Add tag + Enter" style="max-width:180px" onkeydown="if(event.key==='Enter'){event.preventDefault();addTag()}"><button type="button" class="btn btn-secondary btn-sm" onclick="addTag()"><i class="bi bi-plus"></i></button></div><input type="hidden" name="tags[]" id="tagsHidden" value=""></div>
                    <div style="margin-top:1rem;border-top:1px solid var(--gray-100);padding-top:1rem">
                        <label class="field-label">What We Did — Steps ({{ $isEn?'EN':'ID' }})</label><div id="stepsList"></div><button type="button" class="add-btn" onclick="addStep()"><i class="bi bi-plus"></i> Add Step ({{ strtoupper($isEn?'en':'id') }})</button>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="tab-outcome">
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-graph-up"></i><div><h3>Outcome</h3><p>Stats atau result — label ikut bahasa aktif</p></div></div>
                    <div class="field-group"><label class="field-label">Outcome Type</label><div style="display:flex;gap:1rem"><label class="form-check-sm" style="display:flex;align-items:center;gap:.3rem;cursor:pointer"><input type="radio" name="outcome_type" value="stats" checked onchange="toggleOutcome('stats')"> Stats Grid</label><label class="form-check-sm" style="display:flex;align-items:center;gap:.3rem;cursor:pointer"><input type="radio" name="outcome_type" value="result" onchange="toggleOutcome('result')"> Result Text</label></div></div>
                    <div id="outcomeStats"><div class="field-group"><label class="field-label">Stats — Label {{ $isEn?'EN':'ID' }} saja</label><div id="statsList"></div><button type="button" class="add-btn" onclick="addStat()"><i class="bi bi-plus"></i> Add Stat ({{ $isEn?'EN':'ID' }})</button></div></div>
                    <div id="outcomeResult" style="display:none"><div class="field-group"><label class="field-label">Result Text — {{ $isEn?'EN':'ID' }}</label><textarea name="{{ $isEn?'result_en':'result_id' }}" class="form-control" rows="3" placeholder="{{ $isEn?'Outcome EN':'Hasil ID' }}">{{ old('result_text') }}</textarea></div></div>
                </div>
            </div>

            <div class="tab-content" id="tab-media">
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-grid-3x3"></i><div><h3>Gallery — {{ $isEn?'EN':'ID' }}</h3><p>Kind & caption per bahasa, media shared</p></div></div>
                    <div id="galleryList"></div><button type="button" class="add-btn" onclick="addGalleryItem()"><i class="bi bi-plus"></i> Add Gallery Item ({{ $isEn?'EN':'ID' }})</button>
                </div>
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-file-earmark"></i><div><h3>Documentation — {{ $isEn?'EN':'ID' }}</h3><p>Label & meta per bahasa, href shared</p></div></div>
                    <div id="docsList"></div><button type="button" class="add-btn" onclick="addDoc()"><i class="bi bi-plus"></i> Add Document ({{ $isEn?'EN':'ID' }})</button>
                </div>
            </div>

            <div class="tab-content" id="tab-context">
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-diagram-3"></i><div><h3>Use Cases — {{ $isEn?'EN':'ID' }}</h3><p>Di mana dipakai</p></div></div>
                    <div id="usecasesList"></div><button type="button" class="add-btn" onclick="addUseCase()"><i class="bi bi-plus"></i> Add Use Case ({{ $isEn?'EN':'ID' }})</button>
                </div>
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-people"></i><div><h3>Credits — {{ $isEn?'EN':'ID' }}</h3><p>Role per bahasa, name shared</p></div></div>
                    <div id="creditsList"></div><button type="button" class="add-btn" onclick="addCredit()"><i class="bi bi-plus"></i> Add Credit ({{ $isEn?'EN':'ID' }})</button>
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:.5rem;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--gray-200)">
                <a href="{{ route('admin.portfolio.projects.index', ['locale'=>$locale ?? 'en']) }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Create Project ({{ strtoupper($locale ?? 'EN') }})</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
const LOCALE="{{ $locale ?? 'en' }}";
const IS_EN=LOCALE==='en';
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.proj-nav button').forEach(btn=>{
        btn.addEventListener('click', ()=>{
            document.querySelectorAll('.proj-nav button').forEach(b=>b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-'+btn.dataset.tab).classList.add('active');
        });
    });
        // auto-grow textareas (no manual resize)
    document.querySelectorAll('textarea.form-control').forEach(ta=>{
        const grow=()=>{ta.style.height='auto';ta.style.height=ta.scrollHeight+'px'};
        ta.addEventListener('input', grow); grow();
    });
    // char count
    function attachChar(el){
        const max=parseInt(el.dataset.max||0); if(!max) return;
        let meta=el.nextElementSibling; if(!meta||!meta.classList.contains('char-meta')){ meta=document.createElement('div'); meta.className='char-meta'; el.insertAdjacentElement('afterend', meta); }
        const upd=()=>{ const len=el.value.length; meta.textContent=len+' / '+max; meta.classList.toggle('over', len>max*0.9); };
        el.addEventListener('input', upd); upd();
    }
    document.querySelectorAll('[data-max]').forEach(attachChar);
    const obs=new MutationObserver(muts=>{
        muts.forEach(m=>{
            m.addedNodes.forEach(n=>{
                if(n.nodeType!==1) return;
                n.querySelectorAll&&n.querySelectorAll('[data-max]').forEach(attachChar);
                n.querySelectorAll&&n.querySelectorAll('textarea.form-control').forEach(ta=>{
                    const grow=()=>{ta.style.height='auto';ta.style.height=ta.scrollHeight+'px'};
                    ta.addEventListener('input', grow); grow();
                });
                if(n.matches&&n.matches('[data-max]')) attachChar(n);
                if(n.matches&&n.matches('textarea.form-control')){
                    const grow=()=>{n.style.height='auto';n.style.height=n.scrollHeight+'px'};
                    n.addEventListener('input', grow); grow();
                }
            });
        });
    });
    obs.observe(document.body,{childList:true, subtree:true});
    document.querySelectorAll('input[type="color"]').forEach(input=>{ input.addEventListener('input', ()=>{ input.nextElementSibling.value=input.value; }); });
    document.getElementById('projectForm').addEventListener('submit', function(e){
        const hidden=document.getElementById('tagsHidden');
        const tags=[...document.querySelectorAll('#tagsDisplay .tag-chip')].map(el=>el.textContent.replace(/\s*\×\s*$/,'').trim()).filter(Boolean);
        if(hidden) hidden.remove();
        tags.forEach(t=>{const inp=document.createElement('input');inp.type='hidden';inp.name='tags[]';inp.value=t;e.target.appendChild(inp);});
        if(tags.length===0){const inp=document.createElement('input');inp.type='hidden';inp.name='tags';inp.value='';e.target.appendChild(inp);}
    });
});
function addTag(){const input=document.getElementById('tagInput');const val=input.value.trim();if(!val) return;const chip=document.createElement('span');chip.className='tag-chip';chip.style.cssText='background:var(--gray-100);border:1px solid var(--gray-200);border-radius:4px;padding:.2rem .5rem;font-size:.72rem;display:flex;align-items:center;gap:.2rem';chip.innerHTML=val+'<button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:var(--gray-400);cursor:pointer;font-size:.65rem">&times;</button>';document.getElementById('tagsDisplay').appendChild(chip);input.value='';}
function addAbout(){const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><textarea name="about_${IS_EN?'en':'id'}[]" maxlength="600" data-max="600" class="form-control" rows="2" placeholder="${IS_EN?'English paragraph':'Paragraf Bahasa'}"></textarea></div>`;document.getElementById('aboutList').insertAdjacentHTML('beforeend', html);}
function addStep(){const hName=IS_EN?'steps[h_en][]':'steps[h_id][]';const pName=IS_EN?'steps[p_en][]':'steps[p_id][]';const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><label class="field-label" style="font-size:.66rem">Heading — ${IS_EN?'EN':'ID'}</label><input type="text" name="${hName}" maxlength="80" data-max="80" class="form-control form-control-sm" placeholder="${IS_EN?'Step heading EN':'Judul ID'}"><label class="field-label" style="font-size:.66rem;margin-top:.4rem">Paragraph — ${IS_EN?'EN':'ID'}</label><textarea name="${pName}" maxlength="360" data-max="360" class="form-control" rows="2" placeholder="${IS_EN?'Description EN':'Deskripsi ID'}"></textarea></div>`;document.getElementById('stepsList').insertAdjacentHTML('beforeend', html);}
function addStat(){const lName=IS_EN?'stats[l_en][]':'stats[l_id][]';const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:80px 60px 1fr;gap:.45rem"><input type="text" name="stats[n][]" class="form-control form-control-sm" placeholder="Number"><input type="text" name="stats[suffix][]" class="form-control form-control-sm" placeholder="Suffix"><input type="text" name="${lName}" maxlength="40" data-max="40" class="form-control form-control-sm" placeholder="Label ${IS_EN?'EN':'ID'}"></div></div>`;document.getElementById('statsList').insertAdjacentHTML('beforeend', html);}
function addGalleryItem(){const idx=document.querySelectorAll('#galleryList .list-item').length;const kindName=IS_EN?'gallery[kind_en][]':'gallery[kind_id][]';const capName=IS_EN?'gallery[cap_en][]':'gallery[cap_id][]';const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div class="field-group" style="margin-bottom:.4rem"><label class="field-label" style="font-size:.66rem">Kind — ${IS_EN?'EN':'ID'}</label><input type="text" name="${kindName}" maxlength="30" data-max="30" class="form-control form-control-sm" placeholder="Film"></div><div class="field-group" style="margin-bottom:.4rem"><label class="field-label" style="font-size:.66rem">Caption — ${IS_EN?'EN':'ID'}</label><input type="text" name="${capName}" maxlength="60" data-max="60" class="form-control form-control-sm" placeholder="${IS_EN?'Opening frame':'Frame pembuka'}"></div><div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem"><div><label class="field-label" style="font-size:.66rem">Media Type</label><select name="gallery[type][]" class="form-select form-select-sm" onchange="toggleGalleryMedia(this)"><option value="art">Generated Art</option><option value="image" selected>Image</option><option value="video_url">Video URL</option></select></div><div class="gallery-media-input" style="display:block"><label class="field-label" style="font-size:.66rem">Image File</label><input type="file" name="gallery_file[${idx}]" class="form-control form-control-sm" accept="image/*"><input type="hidden" name="gallery_existing_src[${idx}]" value=""></div><div class="gallery-media-input" style="display:none"><label class="field-label" style="font-size:.66rem">Video URL</label><input type="url" name="gallery[video_url][]" class="form-control form-control-sm" placeholder="https://..."></div></div></div>`;document.getElementById('galleryList').insertAdjacentHTML('beforeend', html);}
function addDoc(){const labelName=IS_EN?'docs[label_en][]':'docs[label_id][]';const metaName=IS_EN?'docs[meta_en][]':'docs[meta_id][]';const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr;gap:.45rem"><div><label class="field-label" style="font-size:.66rem">Label — ${IS_EN?'EN':'ID'}</label><input type="text" name="${labelName}" maxlength="60" data-max="60" class="form-control form-control-sm" placeholder="Label"></div><div><label class="field-label" style="font-size:.66rem">Meta — ${IS_EN?'EN':'ID'}</label><input type="text" name="${metaName}" maxlength="40" data-max="40" class="form-control form-control-sm" placeholder="PDF — 24 pages"></div></div><div class="field-group" style="margin-top:.4rem"><label class="field-label" style="font-size:.66rem">URL (shared)</label><input type="url" name="docs[href][]" class="form-control form-control-sm" placeholder="https://..."></div></div>`;document.getElementById('docsList').insertAdjacentHTML('beforeend', html);}
function addUseCase(){const hName=IS_EN?'usecases[h_en][]':'usecases[h_id][]';const pName=IS_EN?'usecases[p_en][]':'usecases[p_id][]';const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><label class="field-label" style="font-size:.66rem">Heading — ${IS_EN?'EN':'ID'}</label><input type="text" name="${hName}" maxlength="60" data-max="60" class="form-control form-control-sm" placeholder="Heading"><label class="field-label" style="font-size:.66rem;margin-top:.4rem">Paragraph — ${IS_EN?'EN':'ID'}</label><textarea name="${pName}" maxlength="360" data-max="360" class="form-control" rows="2" placeholder="Description"></textarea></div>`;document.getElementById('usecasesList').insertAdjacentHTML('beforeend', html);}
function addCredit(){const rName=IS_EN?'credits[role_en][]':'credits[role_id][]';const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr;gap:.45rem"><div><label class="field-label" style="font-size:.66rem">Role — ${IS_EN?'EN':'ID'}</label><input type="text" name="${rName}" maxlength="40" data-max="40" class="form-control form-control-sm" placeholder="Role"></div><div><label class="field-label" style="font-size:.66rem">Name (shared)</label><input type="text" name="credits[name][]" class="form-control form-control-sm" placeholder="Fugo Creative"></div></div></div>`;document.getElementById('creditsList').insertAdjacentHTML('beforeend', html);}
function toggleOutcome(type){document.getElementById('outcomeStats').style.display=type==='stats'?'block':'none';document.getElementById('outcomeResult').style.display=type==='result'?'block':'none';}
function toggleGalleryMedia(select){const container=select.closest('.list-item');const inputs=container.querySelectorAll('.gallery-media-input');const val=select.value;inputs.forEach(el=>el.style.display='none');if(val==='image') inputs[0].style.display='block';if(val==='video_url') inputs[1].style.display='block';}
</script>
@endpush
