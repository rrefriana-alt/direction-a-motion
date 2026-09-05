@extends('admin.layouts.app')
@section('title', 'Edit: ' . $project->title)
@section('page-title', 'Edit Project')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard', ['locale'=>$locale]) }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index', ['locale'=>$locale]) }}">Portfolio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.projects.index', ['locale'=>$locale]) }}">Projects</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
@php
  $isEn = ($locale ?? 'en') === 'en';
  // helpers for split EN||ID with legacy support
  $splitEn = function($s){ $s = $s ?? ''; if($s==='' ) return ''; if(str_starts_with($s,'||')) return ''; return \Illuminate\Support\Str::before($s,'||'); };
  $splitId = function($s){ $s = $s ?? ''; if($s==='') return ''; if(str_starts_with($s,'||')) return \Illuminate\Support\Str::after($s,'||'); if(!str_contains($s,'||')) return ''; return \Illuminate\Support\Str::after($s,'||'); };
  // for single-value legacy where no delimiter, treat value as both sides fallback
  $getEn = function($s) use($splitEn,$splitId){ $s=$s??''; if($s==='' )return ''; if(!str_contains($s,'||') && !str_starts_with($s,'||')) return $s; return $splitEn($s); };
  $getId = function($s) use($splitEn,$splitId){ $s=$s??''; if($s==='' )return ''; if(!str_contains($s,'||') && !str_starts_with($s,'||')) return $s; return $splitId($s); };
@endphp
<style>
.proj-layout{display:grid;grid-template-columns:220px 1fr;gap:1.5rem;align-items:start}
.proj-nav{position:sticky;top:1rem;background:var(--gray-50);border:1px solid var(--gray-100);border-radius:var(--radius-md);padding:.6rem;display:flex;flex-direction:column;gap:.35rem}
.proj-nav button{width:100%;text-align:left;padding:.6rem .75rem;background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-md);font-size:.78rem;font-weight:600;color:var(--gray-600);display:flex;align-items:center;justify-content:space-between;gap:.5rem;cursor:pointer;transition:all .2s}
.proj-nav button:hover{border-color:var(--green-500);color:var(--green-600)}
.proj-nav button.active{background:var(--green-600);border-color:var(--green-600);color:#fff;box-shadow:0 2px 8px rgba(16,185,129,.25)}
.proj-nav button small{font-size:.62rem;font-weight:500;opacity:.7;background:rgba(0,0,0,.06);padding:.15rem .4rem;border-radius:100px}
.proj-nav button.active small{background:rgba(255,255,255,.22);color:#fff}
.tab-content{display:none}
.tab-content.active{display:block}
.group-card{background:#fff;border:1px solid var(--gray-100);border-radius:var(--radius-md);padding:1.25rem;margin-bottom:1rem}
.group-head{display:flex;align-items:center;gap:.6rem;margin-bottom:1rem;padding-bottom:.75rem;border-bottom:1px solid var(--gray-100)}
.group-head i{width:28px;height:28px;border-radius:8px;background:var(--green-50);color:var(--green-600);display:grid;place-items:center;font-size:.85rem}
.group-head h3{font-size:.85rem;font-weight:700;color:var(--gray-800);margin:0}
.group-head p{font-size:.7rem;color:var(--gray-400);margin:0}
.locale-badge{display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .6rem;border-radius:100px;font-size:.68rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase}
.locale-badge.en{background:var(--green-50);color:var(--green-700);border:1px solid var(--green-200)}
.locale-badge.id{background:#fef3c7;color:#92400e;border:1px solid #fcd34d}
.field-group{margin-bottom:1rem}
.field-label{font-size:.72rem;font-weight:600;color:var(--gray-700);margin-bottom:.3rem;display:block}
.field-hint{font-size:.68rem;color:var(--gray-400);margin-top:.2rem}
.bilingual{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
.bilingual-col{position:relative}
.bilingual-col::before{content:attr(data-lang);position:absolute;top:-.5rem;left:.5rem;font-size:.58rem;font-weight:700;color:var(--gray-400);background:white;padding:0 .25rem;z-index:1}
.list-item{background:var(--gray-50);border:1px solid var(--gray-100);border-radius:var(--radius-md);padding:1rem;margin-bottom:.65rem;position:relative}
.list-item .remove-btn{position:absolute;top:.45rem;right:.45rem;width:22px;height:22px;border-radius:50%;background:var(--danger-bg);border:none;color:var(--danger);font-size:.68rem;cursor:pointer;display:flex;align-items:center;justify-content:center}
.list-item .remove-btn:hover{background:var(--danger);color:#fff}
.add-btn{display:inline-flex;align-items:center;gap:.35rem;padding:.38rem .75rem;background:#fff;border:1px dashed var(--gray-300);border-radius:var(--radius-md);color:var(--gray-600);font-size:.72rem;font-weight:600;cursor:pointer;transition:all .2s}
.add-btn:hover{border-color:var(--green-500);color:var(--green-600);background:var(--green-50)}
.color-input{width:100%;height:38px;border:1px solid var(--gray-200);border-radius:var(--radius-md);cursor:pointer;padding:2px}
@media(max-width:900px){.proj-layout{grid-template-columns:1fr}.proj-nav{position:static;flex-direction:row;overflow-x:auto;scrollbar-width:none}}
</style>

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h2 style="display:flex;align-items:center;gap:.6rem">Edit: {{ $project->title }} <span class="locale-badge {{ $locale }}">{{ strtoupper($locale) }} — {{ $isEn ? 'English' : 'Bahasa' }}</span></h2>
        <p style="font-size:.78rem;color:var(--gray-500)">Hanya field <strong>{{ $isEn ? 'EN' : 'ID' }}</strong> yang tampil. Sisi bahasa lawan otomatis dipertahankan. Ganti bahasa via switcher di header.</p>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.portfolio.projects.destroy', ['locale'=>$locale,'project'=>$project->id]) }}" method="POST" onsubmit="return confirm('Delete this project permanently?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
        </form>
        <a href="{{ route('admin.portfolio.projects.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<form action="{{ route('admin.portfolio.projects.update', ['locale'=>$locale,'project'=>$project->id]) }}" method="POST" enctype="multipart/form-data" id="projectForm" data-locale="{{ $locale }}">
    @csrf @method('PUT')

    <div class="proj-layout">
        <nav class="proj-nav" id="projNav">
            <button type="button" class="active" data-tab="overview"><span><i class="bi bi-grid"></i> Overview</span> <small>Umum</small></button>
            <button type="button" data-tab="narrative"><span><i class="bi bi-text-paragraph"></i> Narrative</span> <small>{{ count($project->about ?? []) }} para</small></button>
            <button type="button" data-tab="outcome"><span><i class="bi bi-graph-up"></i> Outcome</span> <small>{{ !empty($project->stats) ? count($project->stats).' stats' : 'result' }}</small></button>
            <button type="button" data-tab="media"><span><i class="bi bi-images"></i> Media</span> <small>{{ count($project->gallery ?? []) }} items</small></button>
            <button type="button" data-tab="context"><span><i class="bi bi-collection"></i> Context</span> <small>use & credit</small></button>
        </nav>

        <div class="proj-main">
            {{-- OVERVIEW = Details + Images + Publish --}}
            <div class="tab-content active" id="tab-overview">
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-info-circle"></i><div><h3>Identitas</h3><p>Judul, client, kategori & urutan tampil</p></div></div>
                    <div class="field-group">
                        <label class="field-label">Title <span style="color:var(--danger)">*</span> <span style="font-weight:400;color:var(--gray-400)">— shared (EN & ID sama)</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
                        <div class="field-group">
                            <label class="field-label">Client Name <span style="font-weight:400;color:var(--gray-400)">shared</span></label>
                            <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $project->client_name) }}" placeholder="Bank Rakyat Indonesia">
                        </div>
                        <div class="field-group">
                            <label class="field-label">Category <span style="color:var(--danger)">*</span></label>
                            <select name="category" class="form-select" required>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category', $project->category) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem">
                        <div class="field-group"><label class="field-label">Year</label><input type="text" name="year" class="form-control" value="{{ old('year', $project->year) }}" placeholder="2025"></div>
                        <div class="field-group"><label class="field-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $project->sort_order) }}" min="0"></div>
                        <div class="field-group"><label class="field-label">Homepage Order</label><input type="number" name="homepage_order" class="form-control" value="{{ old('homepage_order', $project->homepage_order) }}" min="0"></div>
                    </div>
                    @php $scopeEnVal = old('scope_en', $getEn($project->scope)); $scopeIdVal = old('scope_id', $getId($project->scope)); @endphp
                    <div class="field-group">
                        <label class="field-label">Scope — {{ $isEn ? 'English' : 'Bahasa' }} @if($isEn)<span style="font-weight:400;color:var(--gray-400)">sisi ID dipertahankan otomatis</span>@else<span style="font-weight:400;color:var(--gray-400)">sisi EN dipertahankan otomatis</span>@endif</label>
                        @if($isEn)
                            <input type="text" name="scope_en" class="form-control" value="{{ $scopeEnVal }}" placeholder="Concept — Script — Production">
                        @else
                            <input type="text" name="scope_id" class="form-control" value="{{ $scopeIdVal }}" placeholder="Konsep — Naskah — Produksi">
                        @endif
                    </div>
                    @php $divEnVal = old('division_en', $getEn($project->division)); $divIdVal = old('division_id', $getId($project->division)); @endphp
                    <div class="field-group">
                        <label class="field-label">Division — {{ $isEn ? 'English' : 'Bahasa' }}</label>
                        @if($isEn)
                            <input type="text" name="division_en" class="form-control" value="{{ $divEnVal }}" placeholder="Production House">
                        @else
                            <input type="text" name="division_id" class="form-control" value="{{ $divIdVal }}" placeholder="Rumah Produksi">
                        @endif
                    </div>
                </div>

                <div class="group-card">
                    <div class="group-head"><i class="bi bi-image"></i><div><h3>Media Utama</h3><p>Card, hero, logo & warna SVG art — shared</p></div></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.2rem">
                        <div>
                            <div class="field-group"><label class="field-label">Card Image</label>@if($project->image)<div style="margin-bottom:.4rem"><img src="{{ asset('img/'.$project->image) }}" style="width:100%;max-height:140px;object-fit:cover;border-radius:var(--radius-md);border:1px solid var(--gray-200)"></div>@endif<input type="file" name="image" class="form-control" accept="image/*"><div class="field-hint">Work list</div></div>
                            <div class="field-group"><label class="field-label">Hero Image</label>@if($project->hero_image)<div style="margin-bottom:.4rem"><img src="{{ asset('img/'.$project->hero_image) }}" style="width:100%;max-height:140px;object-fit:cover;border-radius:var(--radius-md);border:1px solid var(--gray-200)"></div>@endif<input type="file" name="hero_image" class="form-control" accept="image/*"><div class="field-hint">Top modal</div></div>
                            <div class="field-group"><label class="field-label">Client Logo</label>@if($project->logo)<div style="margin-bottom:.4rem"><img src="{{ asset('img/'.$project->logo) }}" style="max-height:55px;object-fit:contain;border-radius:var(--radius-sm);border:1px solid var(--gray-200);padding:.4rem;background:white"></div>@endif<input type="file" name="logo" class="form-control" accept="image/*"></div>
                        </div>
                        <div>
                            <div class="field-group"><label class="field-label">Background Color</label><div style="display:flex;gap:.5rem;align-items:center"><input type="color" name="bg_color" class="color-input" value="{{ old('bg_color', $project->bg_color ?: '#101722') }}"><input type="text" class="form-control form-control-sm" value="{{ old('bg_color', $project->bg_color ?: '#101722') }}" style="max-width:100px" readonly></div></div>
                            <div class="field-group"><label class="field-label">Accent Color</label><div style="display:flex;gap:.5rem;align-items:center"><input type="color" name="accent_color" class="color-input" value="{{ old('accent_color', $project->accent_color ?: '#3ddc97') }}"><input type="text" class="form-control form-control-sm" value="{{ old('accent_color', $project->accent_color ?: '#3ddc97') }}" style="max-width:100px" readonly></div></div>
                            <div style="margin-top:.8rem;padding:1rem;background:{{ $project->bg_color ?: '#101722' }};border-radius:var(--radius-md);text-align:center"><div style="font-size:.62rem;color:rgba(255,255,255,.5);margin-bottom:.4rem">ART PREVIEW</div><div style="font-size:1.4rem;font-weight:800;color:{{ $project->accent_color ?: '#3ddc97' }};opacity:.8">{{ strtoupper(substr($project->client_name ?? 'F',0,2)) }}</div></div>
                        </div>
                    </div>
                </div>

                <div class="group-card">
                    <div class="group-head"><i class="bi bi-gear"></i><div><h3>Publish</h3><p>URL, status & urutan</p></div></div>
                    <div class="field-group"><label class="field-label">Case Study URL</label><input type="text" name="case_study" class="form-control" value="{{ old('case_study', $project->case_study) }}" placeholder="case-study or https://..."><div class="field-hint">Kosongkan untuk sembunyikan link</div></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
                        <div class="field-group"><label class="field-label">Slug</label><input type="text" class="form-control" value="{{ $project->slug }}" disabled style="background:var(--gray-50)"><div class="field-hint">Auto dari title</div></div>
                        <div class="field-group"><label class="field-label">Legacy Description <span style="font-weight:400;color:var(--gray-400)">shared</span></label><textarea name="description" class="form-control" rows="2">{{ old('description', $project->description) }}</textarea></div>
                    </div>
                    <div style="display:flex;gap:1.2rem;flex-wrap:wrap">
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $project->is_active) ? 'checked' : '' }}><label class="form-check-label" style="font-size:.78rem">Active (visible)</label></div>
                        <div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}><label class="form-check-label" style="font-size:.78rem">Featured homepage</label></div>
                    </div>
                </div>
            </div>

            {{-- NARRATIVE --}}
            <div class="tab-content" id="tab-narrative">
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-text-paragraph"></i><div><h3>Narrative — {{ $isEn ? 'EN' : 'ID' }}</h3><p>Lede, result, about & tags — hanya bahasa aktif</p></div></div>
                    @php $ledeVal = $isEn ? old('lede_en', $getEn($project->lede)) : old('lede_id', $getId($project->lede)); @endphp
                    <div class="field-group">
                        <label class="field-label">Lede — {{ $isEn ? 'English' : 'Bahasa' }}</label>
                        <textarea name="{{ $isEn ? 'lede_en' : 'lede_id' }}" class="form-control" rows="2" placeholder="{{ $isEn ? 'Short headline EN' : 'Headline singkat ID' }}">{{ $ledeVal }}</textarea>
                    </div>
                    @php $resultVal = $isEn ? old('result_en', $getEn($project->result)) : old('result_id', $getId($project->result)); @endphp
                    <div class="field-group">
                        <label class="field-label">Result — {{ $isEn ? 'English' : 'Bahasa' }} <span style="font-weight:400;color:var(--gray-400)">muncul jika tanpa stats</span></label>
                        <textarea name="{{ $isEn ? 'result_en' : 'result_id' }}" class="form-control" rows="2" placeholder="{{ $isEn ? 'Outcome EN' : 'Hasil ID' }}">{{ $resultVal }}</textarea>
                    </div>
                    <div class="field-group">
                        <label class="field-label">About — What it is ({{ $isEn ? 'EN' : 'ID' }})</label>
                        <div id="aboutList">
                            @php
                              $oldAbout = old('about_'.($isEn?'en':'id'));
                              $aboutSource = $oldAbout !== null ? array_map(fn($v)=>['raw'=>$v], $oldAbout) : ($project->about ?? []);
                            @endphp
                            @foreach($aboutSource as $i => $para)
                                @php
                                  if(isset($para['raw'])){ $val=$para['raw']; }
                                  else {
                                    $raw = is_array($para) ? ($para['en'] ?? $para[0] ?? '') : ($para ?? '');
                                    if(is_string($para) && str_contains($para,'||')){ $val = $isEn ? $getEn($para) : $getId($para); }
                                    else if(is_string($para) && $para!=='' && !str_contains($para,'||')){ $val=$para; }
                                    else { $val = is_string($para) ? ($isEn ? $getEn($para) : $getId($para)) : ''; }
                                    if($val==='' && is_string($para) && !str_contains($para,'||') && $para!=='') $val=$para;
                                  }
                                @endphp
                                <div class="list-item">
                                    <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                                    <textarea name="about_{{ $isEn?'en':'id' }}[]" class="form-control" rows="2" placeholder="{{ $isEn?'English paragraph':'Paragraf Bahasa' }}">{{ $val }}</textarea>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="add-btn" onclick="addAbout()"><i class="bi bi-plus"></i> Add Paragraph ({{ strtoupper($isEn?'en':'id') }})</button>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Tags <span style="font-weight:400;color:var(--gray-400)">shared — tidak per bahasa</span></label>
                        <div style="display:flex;flex-wrap:wrap;gap:.4rem;margin-bottom:.4rem" id="tagsDisplay">
                            @foreach(old('tags', $project->tags ?? []) as $tag)
                                <span class="tag-chip" style="background:var(--gray-100);border:1px solid var(--gray-200);border-radius:4px;padding:.2rem .5rem;font-size:.72rem;display:flex;align-items:center;gap:.2rem">{{ $tag }}<button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:var(--gray-400);cursor:pointer;font-size:.65rem">&times;</button></span>
                            @endforeach
                        </div>
                        <div style="display:flex;gap:.45rem"><input type="text" id="tagInput" class="form-control form-control-sm" placeholder="Add tag + Enter" style="max-width:180px"><button type="button" class="btn btn-secondary btn-sm" onclick="addTag()"><i class="bi bi-plus"></i></button></div>
                        <input type="hidden" name="tags[]" id="tagsHidden" value="">
                    </div>
                    <div style="margin-top:1rem;border-top:1px solid var(--gray-100);padding-top:1rem">
                        <label class="field-label">What We Did — Steps ({{ $isEn ? 'EN' : 'ID' }})</label>
                        <div id="stepsList">
                            @php
                              $oldStepsH = old('steps.h_'.($isEn?'en':'id'));
                              $oldStepsP = old('steps.p_'.($isEn?'en':'id'));
                              $hasOldSteps = $oldStepsH !== null || $oldStepsP !== null;
                            @endphp
                            @if($hasOldSteps)
                                @php $cnt = max(count($oldStepsH ?? []), count($oldStepsP ?? [])); @endphp
                                @for($i=0;$i<$cnt;$i++)
                                <div class="list-item">
                                    <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                                    <label class="field-label" style="font-size:.66rem">Heading — {{ $isEn?'EN':'ID' }}</label><input type="text" name="steps[{{ $isEn?'h_en':'h_id' }}][]" class="form-control form-control-sm" value="{{ $oldStepsH[$i] ?? '' }}" placeholder="{{ $isEn?'Step heading EN':'Judul ID' }}">
                                    <label class="field-label" style="font-size:.66rem;margin-top:.4rem">Paragraph — {{ $isEn?'EN':'ID' }}</label><textarea name="steps[{{ $isEn?'p_en':'p_id' }}][]" class="form-control" rows="2" placeholder="{{ $isEn?'Description EN':'Deskripsi ID' }}">{{ $oldStepsP[$i] ?? '' }}</textarea>
                                </div>
                                @endfor
                            @else
                                @foreach(old('steps', $project->steps ?? []) as $step)
                                @php $hVal = is_array($step) ? ($isEn ? $getEn($step['h'] ?? '') : $getId($step['h'] ?? '')) : ''; $pVal = is_array($step) ? ($isEn ? $getEn($step['p'] ?? '') : $getId($step['p'] ?? '')) : ''; if(!$isEn && $hVal==='' && isset($step['h']) && !str_contains($step['h'],'||') && $step['h']!=='') $hVal=$step['h']; if(!$isEn && $pVal==='' && isset($step['p']) && !str_contains($step['p'],'||') && $step['p']!=='') $pVal=$step['p']; @endphp
                                <div class="list-item">
                                    <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                                    <label class="field-label" style="font-size:.66rem">Heading — {{ $isEn?'EN':'ID' }}</label><input type="text" name="steps[{{ $isEn?'h_en':'h_id' }}][]" class="form-control form-control-sm" value="{{ $hVal }}" placeholder="{{ $isEn?'Step heading EN':'Judul ID' }}">
                                    <label class="field-label" style="font-size:.66rem;margin-top:.4rem">Paragraph — {{ $isEn?'EN':'ID' }}</label><textarea name="steps[{{ $isEn?'p_en':'p_id' }}][]" class="form-control" rows="2" placeholder="{{ $isEn?'Description EN':'Deskripsi ID' }}">{{ $pVal }}</textarea>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="add-btn" onclick="addStep()"><i class="bi bi-plus"></i> Add Step ({{ strtoupper($isEn?'en':'id') }})</button>
                    </div>
                </div>
            </div>

            {{-- OUTCOME --}}
            <div class="tab-content" id="tab-outcome">
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-graph-up"></i><div><h3>Outcome</h3><p>Stats grid atau result text — label ikut bahasa aktif</p></div></div>
                    <div class="field-group">
                        <label class="field-label">Outcome Type</label>
                        <div style="display:flex;gap:1rem">
                            <label class="form-check-sm" style="display:flex;align-items:center;gap:.3rem;cursor:pointer"><input type="radio" name="outcome_type" value="stats" {{ !empty($project->stats) ? 'checked' : '' }} onchange="toggleOutcome('stats')"> Stats Grid</label>
                            <label class="form-check-sm" style="display:flex;align-items:center;gap:.3rem;cursor:pointer"><input type="radio" name="outcome_type" value="result" {{ !empty($project->result) && empty($project->stats) ? 'checked' : '' }} onchange="toggleOutcome('result')"> Result Text</label>
                        </div>
                    </div>
                    <div id="outcomeStats" style="{{ empty($project->stats) ? 'display:none' : '' }}">
                        <div class="field-group">
                            <label class="field-label">Stats — Label {{ $isEn ? 'EN' : 'ID' }} saja</label>
                            <div id="statsList">
                                @php
                                  $oldN = old('stats.n'); $oldSuf = old('stats.suffix'); $oldL = old('stats.l_'.($isEn?'en':'id'));
                                  $hasOldStats = $oldN !== null || $oldSuf !== null || $oldL !== null;
                                @endphp
                                @if($hasOldStats)
                                    @php $cnt = max(count($oldN??[]),count($oldSuf??[]),count($oldL??[])); @endphp
                                    @for($i=0;$i<$cnt;$i++)
                                    <div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:80px 60px 1fr;gap:.45rem"><input type="text" name="stats[n][]" class="form-control form-control-sm" value="{{ $oldN[$i]??'' }}" placeholder="Number"><input type="text" name="stats[suffix][]" class="form-control form-control-sm" value="{{ $oldSuf[$i]??'' }}" placeholder="Suffix"><input type="text" name="stats[l_{{ $isEn?'en':'id' }}][]" class="form-control form-control-sm" value="{{ $oldL[$i]??'' }}" placeholder="Label {{ $isEn?'EN':'ID' }}"></div></div>
                                    @endfor
                                @else
                                    @foreach(old('stats', $project->stats ?? []) as $stat)
                                    @php $lVal = is_array($stat) ? ($isEn ? $getEn($stat['l']??'') : $getId($stat['l']??'')) : ''; if(!$isEn && $lVal==='' && isset($stat['l']) && !str_contains($stat['l'],'||') && $stat['l']!=='') $lVal=$stat['l']; @endphp
                                    <div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:80px 60px 1fr;gap:.45rem"><input type="text" name="stats[n][]" class="form-control form-control-sm" value="{{ is_array($stat)?($stat['n']??''):'' }}" placeholder="Number"><input type="text" name="stats[suffix][]" class="form-control form-control-sm" value="{{ is_array($stat)?($stat['suffix']??''):'' }}" placeholder="Suffix"><input type="text" name="stats[l_{{ $isEn?'en':'id' }}][]" class="form-control form-control-sm" value="{{ $lVal }}" placeholder="Label {{ $isEn?'EN':'ID' }}"></div></div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="add-btn" onclick="addStat()"><i class="bi bi-plus"></i> Add Stat ({{ $isEn?'EN':'ID' }})</button>
                        </div>
                    </div>
                    <div id="outcomeResult" style="{{ empty($project->stats) && !empty($project->result) ? '' : 'display:none' }}">
                        <div class="field-group">
                            <label class="field-label">Result Text — {{ $isEn?'EN':'ID' }}</label>
                            <textarea name="{{ $isEn?'result_en':'result_id' }}" class="form-control" rows="3" placeholder="{{ $isEn?'Outcome EN':'Hasil ID' }}">{{ $isEn ? $getEn($project->result) : $getId($project->result) }}</textarea>
                            <div class="field-hint">Jika stats kosong, teks ini tampil sebagai outcome</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MEDIA --}}
            <div class="tab-content" id="tab-media">
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-grid-3x3"></i><div><h3>Gallery — {{ $isEn?'EN':'ID' }}</h3><p>Ganti Generated → Image di card yang sama, upload tidak nambah card</p></div></div>
                    <div id="galleryList">
                        @foreach(old('gallery', $project->gallery ?? []) as $idx => $item)
                        @php $kVal = is_array($item) ? ($isEn ? $getEn($item['kind']??'') : $getId($item['kind']??'')) : ''; $cVal = is_array($item) ? ($isEn ? $getEn($item['cap']??'') : $getId($item['cap']??'')) : ''; if(!$isEn && $kVal==='' && isset($item['kind']) && !str_contains($item['kind'],'||') && $item['kind']!=='') $kVal=$item['kind']; if(!$isEn && $cVal==='' && isset($item['cap']) && !str_contains($item['cap'],'||') && $item['cap']!=='') $cVal=$item['cap']; @endphp
                        <div class="list-item">
                            <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                            <div class="field-group" style="margin-bottom:.4rem"><label class="field-label" style="font-size:.66rem">Kind — {{ $isEn?'EN':'ID' }}</label><input type="text" name="gallery[{{ $isEn?'kind_en':'kind_id' }}][]" class="form-control form-control-sm" value="{{ $kVal }}" placeholder="Film"></div>
                            <div class="field-group" style="margin-bottom:.4rem"><label class="field-label" style="font-size:.66rem">Caption — {{ $isEn?'EN':'ID' }}</label><input type="text" name="gallery[{{ $isEn?'cap_en':'cap_id' }}][]" class="form-control form-control-sm" value="{{ $cVal }}" placeholder="{{ $isEn?'Opening frame':'Frame pembuka' }}"></div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem">
                                <div><label class="field-label" style="font-size:.66rem">Media Type</label><select name="gallery[type][]" class="form-select form-select-sm" onchange="toggleGalleryMedia(this)"><option value="art" {{ empty($item['src']) && empty($item['video']) ? 'selected' : '' }}>Generated Art</option><option value="image" {{ !empty($item['src']) ? 'selected' : '' }}>Image</option><option value="video_url" {{ is_string($item['video']??null) && str_starts_with($item['video'],'http') ? 'selected' : '' }}>Video URL</option></select></div>
                                <div class="gallery-media-input" style="display:{{ !empty($item['src']) ? 'block' : 'none' }}"><label class="field-label" style="font-size:.66rem">Image File</label>@if(!empty($item['src']))<div style="margin-bottom:.3rem"><img src="{{ \App\Support\Works::img($item['src']) }}" style="width:100%;max-height:85px;object-fit:cover;border-radius:6px;border:1px solid var(--gray-200)"></div>@endif<input type="file" name="gallery_file[{{ $idx }}]" class="form-control form-control-sm" accept="image/*"><input type="hidden" name="gallery_existing_src[{{ $idx }}]" value="{{ $item['src'] ?? '' }}"></div>
                                <div class="gallery-media-input" style="display:{{ !empty($item['video']) && is_string($item['video']) ? 'block' : 'none' }}"><label class="field-label" style="font-size:.66rem">Video URL</label><input type="url" name="gallery[video_url][]" class="form-control form-control-sm" value="{{ is_string($item['video']??null)?$item['video']:'' }}" placeholder="https://..."></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="add-btn" onclick="addGalleryItem()"><i class="bi bi-plus"></i> Add Gallery Item ({{ $isEn?'EN':'ID' }})</button>
                </div>
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-file-earmark"></i><div><h3>Documentation — {{ $isEn?'EN':'ID' }}</h3><p>Label & meta per bahasa, href shared</p></div></div>
                    <div id="docsList">
                        @php $oldDL = old('docs.label_'.($isEn?'en':'id')); $oldDM = old('docs.meta_'.($isEn?'en':'id')); $oldDH = old('docs.href'); $hasOldDocs = $oldDL!==null || $oldDM!==null; @endphp
                        @if($hasOldDocs)
                            @php $cnt = max(count($oldDL??[]),count($oldDM??[]),count($oldDH??[])); @endphp
                            @for($i=0;$i<$cnt;$i++)
                            <div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr;gap:.45rem"><div><label class="field-label" style="font-size:.66rem">Label — {{ $isEn?'EN':'ID' }}</label><input type="text" name="docs[{{ $isEn?'label_en':'label_id' }}][]" class="form-control form-control-sm" value="{{ $oldDL[$i]??'' }}" placeholder="Label"></div><div><label class="field-label" style="font-size:.66rem">Meta — {{ $isEn?'EN':'ID' }}</label><input type="text" name="docs[{{ $isEn?'meta_en':'meta_id' }}][]" class="form-control form-control-sm" value="{{ $oldDM[$i]??'' }}" placeholder="PDF — 24 pages"></div></div><div class="field-group" style="margin-top:.4rem"><label class="field-label" style="font-size:.66rem">URL (shared)</label><input type="url" name="docs[href][]" class="form-control form-control-sm" value="{{ $oldDH[$i]??'' }}" placeholder="https://..."></div></div>
                            @endfor
                        @else
                            @foreach(old('docs', $project->docs ?? []) as $doc)
                            @php $lVal = is_array($doc) ? ($isEn ? $getEn($doc['label']??'') : $getId($doc['label']??'')) : ''; $mVal = is_array($doc) ? ($isEn ? $getEn($doc['meta']??'') : $getId($doc['meta']??'')) : ''; if(!$isEn && $lVal==='' && isset($doc['label']) && !str_contains($doc['label'],'||') && $doc['label']!=='') $lVal=$doc['label']; if(!$isEn && $mVal==='' && isset($doc['meta']) && !str_contains($doc['meta'],'||') && $doc['meta']!=='') $mVal=$doc['meta']; @endphp
                            <div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr;gap:.45rem"><div><label class="field-label" style="font-size:.66rem">Label — {{ $isEn?'EN':'ID' }}</label><input type="text" name="docs[{{ $isEn?'label_en':'label_id' }}][]" class="form-control form-control-sm" value="{{ $lVal }}" placeholder="Label"></div><div><label class="field-label" style="font-size:.66rem">Meta — {{ $isEn?'EN':'ID' }}</label><input type="text" name="docs[{{ $isEn?'meta_en':'meta_id' }}][]" class="form-control form-control-sm" value="{{ $mVal }}" placeholder="PDF — 24 pages"></div></div><div class="field-group" style="margin-top:.4rem"><label class="field-label" style="font-size:.66rem">URL (shared)</label><input type="url" name="docs[href][]" class="form-control form-control-sm" value="{{ is_array($doc)?($doc['href']??''):'' }}" placeholder="https://..."></div></div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="add-btn" onclick="addDoc()"><i class="bi bi-plus"></i> Add Document ({{ $isEn?'EN':'ID' }})</button>
                </div>
            </div>

            {{-- CONTEXT --}}
            <div class="tab-content" id="tab-context">
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-diagram-3"></i><div><h3>Use Cases — {{ $isEn?'EN':'ID' }}</h3><p>Di mana dipakai</p></div></div>
                    <div id="usecasesList">
                        @php $oldUH = old('usecases.h_'.($isEn?'en':'id')); $oldUP = old('usecases.p_'.($isEn?'en':'id')); $hasOldUse = $oldUH!==null || $oldUP!==null; @endphp
                        @if($hasOldUse)
                            @php $cnt = max(count($oldUH??[]),count($oldUP??[])); @endphp
                            @for($i=0;$i<$cnt;$i++)
                            <div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><label class="field-label" style="font-size:.66rem">Heading — {{ $isEn?'EN':'ID' }}</label><input type="text" name="usecases[{{ $isEn?'h_en':'h_id' }}][]" class="form-control form-control-sm" value="{{ $oldUH[$i]??'' }}" placeholder="Heading"><label class="field-label" style="font-size:.66rem;margin-top:.4rem">Paragraph — {{ $isEn?'EN':'ID' }}</label><textarea name="usecases[{{ $isEn?'p_en':'p_id' }}][]" class="form-control" rows="2" placeholder="Description">{{ $oldUP[$i]??'' }}</textarea></div>
                            @endfor
                        @else
                            @foreach(old('usecases', $project->usecases ?? []) as $use)
                            @php $hVal = is_array($use)?($isEn?$getEn($use['h']??''):$getId($use['h']??'')):''; $pVal = is_array($use)?($isEn?$getEn($use['p']??''):$getId($use['p']??'')):''; if(!$isEn && $hVal==='' && isset($use['h']) && !str_contains($use['h'],'||') && $use['h']!=='') $hVal=$use['h']; if(!$isEn && $pVal==='' && isset($use['p']) && !str_contains($use['p'],'||') && $use['p']!=='') $pVal=$use['p']; @endphp
                            <div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><label class="field-label" style="font-size:.66rem">Heading — {{ $isEn?'EN':'ID' }}</label><input type="text" name="usecases[{{ $isEn?'h_en':'h_id' }}][]" class="form-control form-control-sm" value="{{ $hVal }}" placeholder="Heading"><label class="field-label" style="font-size:.66rem;margin-top:.4rem">Paragraph — {{ $isEn?'EN':'ID' }}</label><textarea name="usecases[{{ $isEn?'p_en':'p_id' }}][]" class="form-control" rows="2" placeholder="Description">{{ $pVal }}</textarea></div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="add-btn" onclick="addUseCase()"><i class="bi bi-plus"></i> Add Use Case ({{ $isEn?'EN':'ID' }})</button>
                </div>
                <div class="group-card">
                    <div class="group-head"><i class="bi bi-people"></i><div><h3>Credits — {{ $isEn?'EN':'ID' }}</h3><p>Role per bahasa, name shared</p></div></div>
                    <div id="creditsList">
                        @php $oldCR = old('credits.role_'.($isEn?'en':'id')); $oldCN = old('credits.name'); $hasOldCred = $oldCR!==null; @endphp
                        @if($hasOldCred)
                            @php $cnt = max(count($oldCR??[]),count($oldCN??[])); @endphp
                            @for($i=0;$i<$cnt;$i++)
                            <div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr;gap:.45rem"><div><label class="field-label" style="font-size:.66rem">Role — {{ $isEn?'EN':'ID' }}</label><input type="text" name="credits[{{ $isEn?'role_en':'role_id' }}][]" class="form-control form-control-sm" value="{{ $oldCR[$i]??'' }}" placeholder="Role"></div><div><label class="field-label" style="font-size:.66rem">Name (shared)</label><input type="text" name="credits[name][]" class="form-control form-control-sm" value="{{ $oldCN[$i]??'' }}" placeholder="Fugo Creative"></div></div></div>
                            @endfor
                        @else
                            @foreach(old('credits', $project->credits ?? []) as $credit)
                            @php $rVal = is_array($credit)?($isEn?$getEn($credit['role']??''):$getId($credit['role']??'')):''; if(!$isEn && $rVal==='' && isset($credit['role']) && !str_contains($credit['role'],'||') && $credit['role']!=='') $rVal=$credit['role']; @endphp
                            <div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr;gap:.45rem"><div><label class="field-label" style="font-size:.66rem">Role — {{ $isEn?'EN':'ID' }}</label><input type="text" name="credits[{{ $isEn?'role_en':'role_id' }}][]" class="form-control form-control-sm" value="{{ $rVal }}" placeholder="Role"></div><div><label class="field-label" style="font-size:.66rem">Name (shared)</label><input type="text" name="credits[name][]" class="form-control form-control-sm" value="{{ is_array($credit)?($credit['name']??''):'' }}" placeholder="Fugo Creative"></div></div></div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="add-btn" onclick="addCredit()"><i class="bi bi-plus"></i> Add Credit ({{ $isEn?'EN':'ID' }})</button>
                </div>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:.5rem;margin-top:1rem;padding-top:1rem;border-top:1px solid var(--gray-200)">
                <a href="{{ route('admin.portfolio.projects.index', ['locale'=>$locale]) }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes ({{ strtoupper($locale) }})</button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
const LOCALE = "{{ $locale }}";
const IS_EN = LOCALE === 'en';
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.proj-nav button').forEach(btn=>{
        btn.addEventListener('click', ()=>{
            document.querySelectorAll('.proj-nav button').forEach(b=>b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-'+btn.dataset.tab).classList.add('active');
        });
    });
    document.querySelectorAll('input[type="color"]').forEach(input=>{
        input.addEventListener('input', ()=>{ input.nextElementSibling.value=input.value; });
    });
    document.getElementById('projectForm').addEventListener('submit', function(e){
        const hidden=document.getElementById('tagsHidden');
        const tags=[...document.querySelectorAll('#tagsDisplay .tag-chip')].map(el=>el.textContent.replace(/\s*\×\s*$/,'').trim()).filter(Boolean);
        if(hidden) hidden.remove();
        tags.forEach(t=>{const inp=document.createElement('input');inp.type='hidden';inp.name='tags[]';inp.value=t;e.target.appendChild(inp);});
        if(tags.length===0){const inp=document.createElement('input');inp.type='hidden';inp.name='tags';inp.value='';e.target.appendChild(inp);}
        const items=document.querySelectorAll('#galleryList .list-item');
        items.forEach((el,i)=>{
            const fi=el.querySelector('input[type="file"][name^="gallery_file"]');
            if(fi) fi.name='gallery_file['+i+']';
            const hs=el.querySelector('input[name^="gallery_existing_src"]');
            if(hs) hs.name='gallery_existing_src['+i+']';
        });
    });
});
function addTag(){
    const input=document.getElementById('tagInput'); const val=input.value.trim(); if(!val) return;
    const chip=document.createElement('span'); chip.className='tag-chip';
    chip.style.cssText='background:var(--gray-100);border:1px solid var(--gray-200);border-radius:4px;padding:.2rem .5rem;font-size:.72rem;display:flex;align-items:center;gap:.2rem';
    chip.innerHTML=val+'<button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:var(--gray-400);cursor:pointer;font-size:.65rem">&times;</button>';
    document.getElementById('tagsDisplay').appendChild(chip); input.value='';
}
function addAbout(){
    const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><textarea name="about_${IS_EN?'en':'id'}[]" class="form-control" rows="2" placeholder="${IS_EN?'English paragraph':'Paragraf Bahasa'}"></textarea></div>`;
    document.getElementById('aboutList').insertAdjacentHTML('beforeend', html);
}
function addStep(){
    const hName=IS_EN?'steps[h_en][]':'steps[h_id][]';
    const pName=IS_EN?'steps[p_en][]':'steps[p_id][]';
    const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><label class="field-label" style="font-size:.66rem">Heading — ${IS_EN?'EN':'ID'}</label><input type="text" name="${hName}" class="form-control form-control-sm" placeholder="${IS_EN?'Step heading EN':'Judul ID'}"><label class="field-label" style="font-size:.66rem;margin-top:.4rem">Paragraph — ${IS_EN?'EN':'ID'}</label><textarea name="${pName}" class="form-control" rows="2" placeholder="${IS_EN?'Description EN':'Deskripsi ID'}"></textarea></div>`;
    document.getElementById('stepsList').insertAdjacentHTML('beforeend', html);
}
function addStat(){
    const lName=IS_EN?'stats[l_en][]':'stats[l_id][]';
    const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:80px 60px 1fr;gap:.45rem"><input type="text" name="stats[n][]" class="form-control form-control-sm" placeholder="Number"><input type="text" name="stats[suffix][]" class="form-control form-control-sm" placeholder="Suffix"><input type="text" name="${lName}" class="form-control form-control-sm" placeholder="Label ${IS_EN?'EN':'ID'}"></div></div>`;
    document.getElementById('statsList').insertAdjacentHTML('beforeend', html);
}
function addGalleryItem(){
    const idx=document.querySelectorAll('#galleryList .list-item').length;
    const kindName=IS_EN?'gallery[kind_en][]':'gallery[kind_id][]';
    const capName=IS_EN?'gallery[cap_en][]':'gallery[cap_id][]';
    const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div class="field-group" style="margin-bottom:.4rem"><label class="field-label" style="font-size:.66rem">Kind — ${IS_EN?'EN':'ID'}</label><input type="text" name="${kindName}" class="form-control form-control-sm" placeholder="Film"></div><div class="field-group" style="margin-bottom:.4rem"><label class="field-label" style="font-size:.66rem">Caption — ${IS_EN?'EN':'ID'}</label><input type="text" name="${capName}" class="form-control form-control-sm" placeholder="${IS_EN?'Opening frame':'Frame pembuka'}"></div><div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem"><div><label class="field-label" style="font-size:.66rem">Media Type</label><select name="gallery[type][]" class="form-select form-select-sm" onchange="toggleGalleryMedia(this)"><option value="art">Generated Art</option><option value="image" selected>Image</option><option value="video_url">Video URL</option></select></div><div class="gallery-media-input" style="display:block"><label class="field-label" style="font-size:.66rem">Image File</label><input type="file" name="gallery_file[${idx}]" class="form-control form-control-sm" accept="image/*"><input type="hidden" name="gallery_existing_src[${idx}]" value=""></div><div class="gallery-media-input" style="display:none"><label class="field-label" style="font-size:.66rem">Video URL</label><input type="url" name="gallery[video_url][]" class="form-control form-control-sm" placeholder="https://..."></div></div></div>`;
    document.getElementById('galleryList').insertAdjacentHTML('beforeend', html);
}
function addDoc(){
    const labelName=IS_EN?'docs[label_en][]':'docs[label_id][]';
    const metaName=IS_EN?'docs[meta_en][]':'docs[meta_id][]';
    const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr;gap:.45rem"><div><label class="field-label" style="font-size:.66rem">Label — ${IS_EN?'EN':'ID'}</label><input type="text" name="${labelName}" class="form-control form-control-sm" placeholder="Label"></div><div><label class="field-label" style="font-size:.66rem">Meta — ${IS_EN?'EN':'ID'}</label><input type="text" name="${metaName}" class="form-control form-control-sm" placeholder="PDF — 24 pages"></div></div><div class="field-group" style="margin-top:.4rem"><label class="field-label" style="font-size:.66rem">URL (shared)</label><input type="url" name="docs[href][]" class="form-control form-control-sm" placeholder="https://..."></div></div>`;
    document.getElementById('docsList').insertAdjacentHTML('beforeend', html);
}
function addUseCase(){
    const hName=IS_EN?'usecases[h_en][]':'usecases[h_id][]';
    const pName=IS_EN?'usecases[p_en][]':'usecases[p_id][]';
    const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><label class="field-label" style="font-size:.66rem">Heading — ${IS_EN?'EN':'ID'}</label><input type="text" name="${hName}" class="form-control form-control-sm" placeholder="Heading"><label class="field-label" style="font-size:.66rem;margin-top:.4rem">Paragraph — ${IS_EN?'EN':'ID'}</label><textarea name="${pName}" class="form-control" rows="2" placeholder="Description"></textarea></div>`;
    document.getElementById('usecasesList').insertAdjacentHTML('beforeend', html);
}
function addCredit(){
    const rName=IS_EN?'credits[role_en][]':'credits[role_id][]';
    const html=`<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr;gap:.45rem"><div><label class="field-label" style="font-size:.66rem">Role — ${IS_EN?'EN':'ID'}</label><input type="text" name="${rName}" class="form-control form-control-sm" placeholder="Role"></div><div><label class="field-label" style="font-size:.66rem">Name (shared)</label><input type="text" name="credits[name][]" class="form-control form-control-sm" placeholder="Fugo Creative"></div></div></div>`;
    document.getElementById('creditsList').insertAdjacentHTML('beforeend', html);
}
function toggleOutcome(type){
    document.getElementById('outcomeStats').style.display=type==='stats'?'block':'none';
    document.getElementById('outcomeResult').style.display=type==='result'?'block':'none';
}
function toggleGalleryMedia(select){
    const container=select.closest('.list-item');
    const inputs=container.querySelectorAll('.gallery-media-input');
    const val=select.value;
    inputs.forEach(el=>el.style.display='none');
    if(val==='image') inputs[0].style.display='block';
    if(val==='video_url') inputs[1].style.display='block';
}
</script>
@endpush
