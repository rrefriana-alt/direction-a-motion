@extends('admin.layouts.app')
@section('title', 'Edit: ' . $project->title)
@section('page-title', 'Edit Project')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">Portfolio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.projects.index') }}">Projects</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<style>
.tab-nav{display:flex;gap:0;border-bottom:2px solid var(--gray-200);margin-bottom:1.5rem;overflow-x:auto;scrollbar-width:none}
.tab-nav::-webkit-scrollbar{display:none}
.tab-nav button{padding:.6rem 1rem;font-size:.78rem;font-weight:500;color:var(--gray-400);background:none;border:none;border-bottom:2px solid transparent;margin-bottom:-2px;white-space:nowrap;cursor:pointer;transition:all .2s}
.tab-nav button:hover{color:var(--gray-700)}
.tab-nav button.active{color:var(--green-600);border-bottom-color:var(--green-500);font-weight:600}
.tab-content{display:none}
.tab-content.active{display:block}
.field-group{margin-bottom:1.25rem}
.field-label{font-size:.75rem;font-weight:600;color:var(--gray-700);margin-bottom:.35rem;display:block}
.field-hint{font-size:.7rem;color:var(--gray-400);margin-top:.15rem}
.bilingual{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
.bilingual-col{position:relative}
.bilingual-col::before{content:attr(data-lang);position:absolute;top:-.55rem;left:.5rem;font-size:.6rem;font-weight:600;color:var(--gray-400);background:white;padding:0 .25rem;z-index:1}
.list-item{background:var(--gray-50);border:1px solid var(--gray-100);border-radius:var(--radius-md);padding:1rem;margin-bottom:.75rem;position:relative}
.list-item .remove-btn{position:absolute;top:.5rem;right:.5rem;width:24px;height:24px;border-radius:50%;background:var(--danger-bg);border:none;color:var(--danger);font-size:.7rem;cursor:pointer;display:flex;align-items:center;justify-content:center}
.list-item .remove-btn:hover{background:var(--danger);color:#fff}
.add-btn{display:inline-flex;align-items:center;gap:.35rem;padding:.4rem .8rem;background:var(--gray-50);border:1px dashed var(--gray-300);border-radius:var(--radius-md);color:var(--gray-500);font-size:.75rem;font-weight:500;cursor:pointer;transition:all .2s}
.add-btn:hover{border-color:var(--green-500);color:var(--green-600);background:var(--green-50)}
.color-input{width:100%;height:38px;border:1px solid var(--gray-200);border-radius:var(--radius-md);cursor:pointer;padding:2px}
.form-check-sm{font-size:.78rem}
</style>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit: {{ $project->title }}</h2>
        <p style="font-size:.8rem;color:var(--gray-500)">Manage all project content and modal data</p>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.portfolio.projects.destroy', ['locale' => $locale ?? request()->route('locale') ?? 'en', 'project' => $project->id]) }}" method="POST" onsubmit="return confirm('Delete this project permanently?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
        </form>
        <a href="{{ route('admin.portfolio.projects.index', ['locale' => $locale ?? request()->route('locale') ?? 'en']) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<form action="{{ route('admin.portfolio.projects.update', ['locale' => $locale ?? request()->route('locale') ?? 'en', 'project' => $project->id]) }}" method="POST" enctype="multipart/form-data" id="projectForm">
    @csrf
    @method('PUT')

    <div class="tab-nav" id="tabNav">
        <button type="button" class="active" data-tab="details"><i class="bi bi-info-circle"></i> Details</button>
        <button type="button" data-tab="images"><i class="bi bi-image"></i> Images</button>
        <button type="button" data-tab="content"><i class="bi bi-text-paragraph"></i> Content</button>
        <button type="button" data-tab="steps"><i class="bi bi-list-ol"></i> Steps</button>
        <button type="button" data-tab="outcome"><i class="bi bi-graph-up"></i> Outcome</button>
        <button type="button" data-tab="gallery"><i class="bi bi-grid-3x3"></i> Gallery</button>
        <button type="button" data-tab="docs"><i class="bi bi-file-earmark"></i> Docs</button>
        <button type="button" data-tab="usecases"><i class="bi bi-diagram-3"></i> Use Cases</button>
        <button type="button" data-tab="credits"><i class="bi bi-people"></i> Credits</button>
        <button type="button" data-tab="settings"><i class="bi bi-gear"></i> Settings</button>
    </div>

    {{-- TAB: Details --}}
    <div class="tab-content active" id="tab-details">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Title <span style="color:var(--danger)">*</span></label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
            </div>
            <div class="bilingual">
                <div class="field-group bilingual-col" data-lang="ENGLISH">
                    <label class="field-label">Client Name</label>
                    <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $project->client_name) }}" placeholder="Bank Rakyat Indonesia">
                </div>
                <div class="field-group bilingual-col" data-lang="BAHASA">
                    <label class="field-label">Category <span style="color:var(--danger)">*</span></label>
                    <select name="category" class="form-select" required>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category', $project->category) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem">
                <div class="field-group">
                    <label class="field-label">Year</label>
                    <input type="text" name="year" class="form-control" value="{{ old('year', $project->year) }}" placeholder="2025">
                </div>
                <div class="field-group">
                    <label class="field-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $project->sort_order) }}" min="0">
                </div>
                <div class="field-group">
                    <label class="field-label">Homepage Order</label>
                    <input type="number" name="homepage_order" class="form-control" value="{{ old('homepage_order', $project->homepage_order) }}" min="0">
                </div>
            </div>
            <div class="bilingual">
                <div class="field-group bilingual-col" data-lang="ENGLISH">
                    <label class="field-label">Scope — English</label>
                    <input type="text" name="scope_en" class="form-control" value="{{ old('scope_en', \Illuminate\Support\Str::before($project->scope ?? '', '||')) }}" placeholder="Concept — Script — Production">
                </div>
                <div class="field-group bilingual-col" data-lang="BAHASA">
                    <label class="field-label">Scope — Bahasa</label>
                    <input type="text" name="scope_id" class="form-control" value="{{ old('scope_id', str_contains($project->scope ?? '', '||') ? \Illuminate\Support\Str::after($project->scope, '||') : '') }}" placeholder="Konsep — Naskah — Produksi">
                </div>
            </div>
        </div>
    </div>

    {{-- TAB: Images --}}
    <div class="tab-content" id="tab-images">
        <div class="card-white">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
                <div>
                    <div class="field-group">
                        <label class="field-label">Card Image</label>
                        @if($project->image)
                            <div style="margin-bottom:.5rem"><img src="{{ asset('img/' . $project->image) }}" style="width:100%;max-height:160px;object-fit:cover;border-radius:var(--radius-md);border:1px solid var(--gray-200)"></div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="field-hint">Shown on the work list page</div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Hero Image</label>
                        @if($project->hero_image)
                            <div style="margin-bottom:.5rem"><img src="{{ asset('img/' . $project->hero_image) }}" style="width:100%;max-height:160px;object-fit:cover;border-radius:var(--radius-md);border:1px solid var(--gray-200)"></div>
                        @endif
                        <input type="file" name="hero_image" class="form-control" accept="image/*">
                        <div class="field-hint">Shown at the top of the modal</div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Client Logo</label>
                        @if($project->logo)
                            <div style="margin-bottom:.5rem"><img src="{{ asset('img/' . $project->logo) }}" style="max-height:60px;object-fit:contain;border-radius:var(--radius-sm);border:1px solid var(--gray-200);padding:.5rem;background:white"></div>
                        @endif
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        <div class="field-hint">Client logo shown in modal facts strip</div>
                    </div>
                </div>
                <div>
                    <div class="field-group">
                        <label class="field-label">Background Color (SVG Art)</label>
                        <div style="display:flex;gap:.5rem;align-items:center">
                            <input type="color" name="bg_color" class="color-input" value="{{ old('bg_color', $project->bg_color ?: '#101722') }}">
                            <input type="text" class="form-control form-control-sm" value="{{ old('bg_color', $project->bg_color ?: '#101722') }}" style="max-width:100px" readonly>
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Accent Color (SVG Art)</label>
                        <div style="display:flex;gap:.5rem;align-items:center">
                            <input type="color" name="accent_color" class="color-input" value="{{ old('accent_color', $project->accent_color ?: '#3ddc97') }}">
                            <input type="text" class="form-control form-control-sm" value="{{ old('accent_color', $project->accent_color ?: '#3ddc97') }}" style="max-width:100px" readonly>
                        </div>
                    </div>
                    <div style="margin-top:1rem;padding:1rem;background:{{ $project->bg_color ?: '#101722' }};border-radius:var(--radius-md);text-align:center">
                        <div style="font-size:.65rem;color:rgba(255,255,255,.5);margin-bottom:.5rem">ART PREVIEW</div>
                        <div style="font-size:1.5rem;font-weight:800;color:{{ $project->accent_color ?: '#3ddc97' }};opacity:.8">{{ strtoupper(substr($project->client_name ?? 'F', 0, 2)) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB: Content --}}
    <div class="tab-content" id="tab-content">
        <div class="card-white">
            <div class="bilingual">
                <div class="field-group bilingual-col" data-lang="ENGLISH">
                    <label class="field-label">Lede — English</label>
                    <textarea name="lede_en" class="form-control" rows="2" placeholder="Short headline EN">{{ old('lede_en', \Illuminate\Support\Str::before($project->lede ?? '', '||')) }}</textarea>
                </div>
                <div class="field-group bilingual-col" data-lang="BAHASA">
                    <label class="field-label">Lede — Bahasa</label>
                    <textarea name="lede_id" class="form-control" rows="2" placeholder="Headline singkat ID">{{ old('lede_id', str_contains($project->lede ?? '', '||') ? \Illuminate\Support\Str::after($project->lede, '||') : '') }}</textarea>
                </div>
            </div>
            <div class="bilingual">
                <div class="field-group bilingual-col" data-lang="ENGLISH">
                    <label class="field-label">Result — English</label>
                    <textarea name="result_en" class="form-control" rows="2" placeholder="Outcome EN">{{ old('result_en', \Illuminate\Support\Str::before($project->result ?? '', '||')) }}</textarea>
                </div>
                <div class="field-group bilingual-col" data-lang="BAHASA">
                    <label class="field-label">Result — Bahasa</label>
                    <textarea name="result_id" class="form-control" rows="2" placeholder="Hasil ID">{{ old('result_id', str_contains($project->result ?? '', '||') ? \Illuminate\Support\Str::after($project->result, '||') : '') }}</textarea>
                </div>
            </div>
            <div class="field-group">
                    <label class="field-label">About — What it is (multiple paragraphs, EN / ID)</label>
                <div id="aboutList">
                    @foreach(old('about', $project->about ?? []) as $i => $para)
                    @php $enP = is_array($para) ? ($para['en'] ?? $para[0] ?? '') : \Illuminate\Support\Str::before($para ?? '', '||'); $idP = is_array($para) ? ($para['id'] ?? '') : (str_contains($para ?? '', '||') ? \Illuminate\Support\Str::after($para, '||') : ''); @endphp
                    <div class="list-item">
                        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                        <div class="bilingual">
                            <div class="bilingual-col" data-lang="EN">
                                <textarea name="about_en[]" class="form-control" rows="2" placeholder="English paragraph">{{ $enP }}</textarea>
                            </div>
                            <div class="bilingual-col" data-lang="ID">
                                <textarea name="about_id[]" class="form-control" rows="2" placeholder="Paragraf Bahasa">{{ $idP }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-btn" onclick="addAbout()"><i class="bi bi-plus"></i> Add Paragraph</button>
            </div>
            <div class="field-group">
                <label class="field-label">Tags</label>
                <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:.5rem" id="tagsDisplay">
                    @foreach(old('tags', $project->tags ?? []) as $tag)
                        <span class="tag-chip" style="background:var(--gray-100);border:1px solid var(--gray-200);border-radius:4px;padding:.2rem .5rem;font-size:.73rem;display:flex;align-items:center;gap:.25rem">{{ $tag }}<button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:var(--gray-400);cursor:pointer;font-size:.65rem">&times;</button></span>
                    @endforeach
                </div>
                <div style="display:flex;gap:.5rem">
                    <input type="text" id="tagInput" class="form-control form-control-sm" placeholder="Add a tag and press Enter" style="max-width:200px">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="addTag()"><i class="bi bi-plus"></i></button>
                </div>
                <input type="hidden" name="tags[]" id="tagsHidden" value="">
            </div>
        </div>
    </div>

    {{-- TAB: Steps --}}
    <div class="tab-content" id="tab-steps">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">What We Did — Steps</label>
                <div id="stepsList">
                    @foreach(old('steps', $project->steps ?? []) as $step)
                    <div class="list-item">
                        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem"><div><label class="field-label" style="font-size:.65rem">Heading — EN</label><input type="text" name="steps[h_en][]" class="form-control" value="{{ is_array($step) ? \Illuminate\Support\Str::before($step['h'] ?? '', '||') : $step }}" placeholder="Step heading EN"></div><div><label class="field-label" style="font-size:.65rem">Heading — ID</label><input type="text" name="steps[h_id][]" class="form-control" value="{{ is_array($step) ? (str_contains($step['h'] ?? '', '||') ? \Illuminate\Support\Str::after($step['h'], '||') : '') : '' }}" placeholder="Judul ID"></div></div><div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-top:.5rem"><div><label class="field-label" style="font-size:.65rem">Paragraph — EN</label><textarea name="steps[p_en][]" class="form-control" rows="2" placeholder="Step description EN">{{ is_array($step) ? \Illuminate\Support\Str::before($step['p'] ?? '', '||') : '' }}</textarea></div><div><label class="field-label" style="font-size:.65rem">Paragraf — ID</label><textarea name="steps[p_id][]" class="form-control" rows="2" placeholder="Deskripsi ID">{{ is_array($step) ? (str_contains($step['p'] ?? '', '||') ? \Illuminate\Support\Str::after($step['p'], '||') : '') : '' }}</textarea></div></div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-btn" onclick="addStep()"><i class="bi bi-plus"></i> Add Step</button>
            </div>
        </div>
    </div>

    {{-- TAB: Outcome --}}
    <div class="tab-content" id="tab-outcome">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Outcome Type</label>
                <div style="display:flex;gap:1rem;margin-bottom:1rem">
                    <label class="form-check-sm" style="display:flex;align-items:center;gap:.35rem;cursor:pointer">
                        <input type="radio" name="outcome_type" value="stats" {{ !empty($project->stats) ? 'checked' : '' }} onchange="toggleOutcome('stats')"> Stats Grid
                    </label>
                    <label class="form-check-sm" style="display:flex;align-items:center;gap:.35rem;cursor:pointer">
                        <input type="radio" name="outcome_type" value="result" {{ !empty($project->result) && empty($project->stats) ? 'checked' : '' }} onchange="toggleOutcome('result')"> Result Text
                    </label>
                </div>
            </div>
            <div id="outcomeStats" style="{{ empty($project->stats) ? 'display:none' : '' }}">
                <div class="field-group">
                    <label class="field-label">Stats</label>
                    <div id="statsList">
                        @foreach(old('stats', $project->stats ?? []) as $stat)
                        <div class="list-item">
                            <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                            <div style="display:grid;grid-template-columns:80px 60px 1fr 1fr;gap:.5rem">
                                <input type="text" name="stats[n][]" class="form-control form-control-sm" value="{{ is_array($stat) ? ($stat['n'] ?? '') : '' }}" placeholder="Number">
                                <input type="text" name="stats[suffix][]" class="form-control form-control-sm" value="{{ is_array($stat) ? ($stat['suffix'] ?? '') : '' }}" placeholder="Suffix">
                                <input type="text" name="stats[l_en][]" class="form-control form-control-sm" value="{{ is_array($stat) ? \Illuminate\Support\Str::before($stat['l'] ?? '', '||') : '' }}" placeholder="Label EN">
                                <input type="text" name="stats[l_id][]" class="form-control form-control-sm" value="{{ is_array($stat) ? (str_contains($stat['l'] ?? '', '||') ? \Illuminate\Support\Str::after($stat['l'], '||') : '') : '' }}" placeholder="Label ID">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="add-btn" onclick="addStat()"><i class="bi bi-plus"></i> Add Stat</button>
                </div>
            </div>
            <div id="outcomeResult" style="{{ empty($project->stats) && !empty($project->result) ? '' : 'display:none' }}">
                <div class="field-group">
                    <label class="field-label">Result Text (EN||ID)</label>
                    <textarea name="result_text" class="form-control" rows="3">{{ old('result', $project->result) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB: Gallery --}}
    <div class="tab-content" id="tab-gallery">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Gallery Items</label>
                <div id="galleryList">
                    @foreach(old('gallery', $project->gallery ?? []) as $idx => $item)
                    <div class="list-item">
                        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:.5rem">
                            <div>
                                <label class="field-label" style="font-size:.65rem">Kind — EN</label>
                                <input type="text" name="gallery[kind_en][]" class="form-control form-control-sm" value="{{ is_array($item) ? \Illuminate\Support\Str::before($item['kind'] ?? '', '||') : '' }}" placeholder="Film">
                            </div>
                            <div>
                                <label class="field-label" style="font-size:.65rem">Kind — ID</label>
                                <input type="text" name="gallery[kind_id][]" class="form-control form-control-sm" value="{{ is_array($item) ? (str_contains($item['kind'] ?? '', '||') ? \Illuminate\Support\Str::after($item['kind'], '||') : '') : '' }}" placeholder="Film">
                            </div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:.5rem">
                            <div>
                                <label class="field-label" style="font-size:.65rem">Caption — EN</label>
                                <input type="text" name="gallery[cap_en][]" class="form-control form-control-sm" value="{{ is_array($item) ? \Illuminate\Support\Str::before($item['cap'] ?? '', '||') : '' }}" placeholder="Opening frame">
                            </div>
                            <div>
                                <label class="field-label" style="font-size:.65rem">Caption — ID</label>
                                <input type="text" name="gallery[cap_id][]" class="form-control form-control-sm" value="{{ is_array($item) ? (str_contains($item['cap'] ?? '', '||') ? \Illuminate\Support\Str::after($item['cap'], '||') : '') : '' }}" placeholder="Frame pembuka">
                            </div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.5rem">
                            <div>
                                <label class="field-label" style="font-size:.65rem">Media Type</label>
                                <select name="gallery[type][]" class="form-select form-select-sm" onchange="toggleGalleryMedia(this)">
                                    <option value="art" {{ empty($item['src']) && empty($item['video']) ? 'selected' : '' }}>Generated Art</option>
                                    <option value="image" {{ !empty($item['src']) ? 'selected' : '' }}>Image</option>
                                    <option value="video_url" {{ is_string($item['video'] ?? null) && str_starts_with($item['video'], 'http') ? 'selected' : '' }}>Video URL</option>
                                    <option value="video_upload" {{ !empty($item['src']) && empty($item['src']) && !str_starts_with($item['video'] ?? '', 'http') ? 'selected' : '' }}>Video Upload</option>
                                </select>
                            </div>
                            <div class="gallery-media-input" style="display:{{ !empty($item['src']) ? 'block' : 'none' }}">
                                <label class="field-label" style="font-size:.65rem">Image File</label>
                                @if(!empty($item['src']))<div style="margin-bottom:.35rem"><img src="{{ \App\Support\Works::img($item['src']) }}" style="width:100%;max-height:90px;object-fit:cover;border-radius:6px;border:1px solid var(--gray-200)"></div>@endif
                                <input type="file" name="gallery_file[{{ $idx }}]" class="form-control form-control-sm" accept="image/*">
                                <input type="hidden" name="gallery_existing_src[{{ $idx }}]" value="{{ $item['src'] ?? '' }}">
                            </div>
                            <div class="gallery-media-input" style="display:{{ !empty($item['video']) && is_string($item['video']) ? 'block' : 'none' }}">
                                <label class="field-label" style="font-size:.65rem">Video URL</label>
                                <input type="url" name="gallery[video_url][]" class="form-control form-control-sm" value="{{ is_string($item['video'] ?? null) ? $item['video'] : '' }}" placeholder="https://...">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-btn" onclick="addGalleryItem()"><i class="bi bi-plus"></i> Add Gallery Item</button>
            </div>
        </div>
    </div>

    {{-- TAB: Docs --}}
    <div class="tab-content" id="tab-docs">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Documentation</label>
                <div id="docsList">
                    @foreach(old('docs', $project->docs ?? []) as $doc)
                    <div class="list-item">
                        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.5rem">
                            <div>
                                <label class="field-label" style="font-size:.65rem">Label — EN</label>
                                <input type="text" name="docs[label_en][]" class="form-control form-control-sm" value="{{ is_array($doc) ? \Illuminate\Support\Str::before($doc['label'] ?? '', '||') : '' }}" placeholder="Label EN">
                            </div>
                            <div>
                                <label class="field-label" style="font-size:.65rem">Label — ID</label>
                                <input type="text" name="docs[label_id][]" class="form-control form-control-sm" value="{{ is_array($doc) ? (str_contains($doc['label'] ?? '', '||') ? \Illuminate\Support\Str::after($doc['label'], '||') : '') : '' }}" placeholder="Label ID">
                            </div>
                            <div>
                                <label class="field-label" style="font-size:.65rem">Meta — EN</label>
                                <input type="text" name="docs[meta_en][]" class="form-control form-control-sm" value="{{ is_array($doc) ? \Illuminate\Support\Str::before($doc['meta'] ?? '', '||') : '' }}" placeholder="PDF — 24 pages">
                            </div>
                            <div>
                                <label class="field-label" style="font-size:.65rem">Meta — ID</label>
                                <input type="text" name="docs[meta_id][]" class="form-control form-control-sm" value="{{ is_array($doc) ? (str_contains($doc['meta'] ?? '', '||') ? \Illuminate\Support\Str::after($doc['meta'], '||') : '') : '' }}" placeholder="PDF — 24 halaman">
                            </div>
                            <div>
                                <label class="field-label" style="font-size:.65rem">URL (optional)</label>
                                <input type="url" name="docs[href][]" class="form-control form-control-sm" value="{{ is_array($doc) ? ($doc['href'] ?? '') : '' }}" placeholder="https://...">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-btn" onclick="addDoc()"><i class="bi bi-plus"></i> Add Document</button>
            </div>
        </div>
    </div>

    {{-- TAB: Use Cases --}}
    <div class="tab-content" id="tab-usecases">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Where It Is Used</label>
                <div id="usecasesList">
                    @foreach(old('usecases', $project->usecases ?? []) as $use)
                    <div class="list-item">
                        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem"><div><label class="field-label" style="font-size:.65rem">Heading — EN</label><input type="text" name="usecases[h_en][]" class="form-control" value="{{ is_array($use) ? \Illuminate\Support\Str::before($use['h'] ?? '', '||') : '' }}" placeholder="Heading EN"></div><div><label class="field-label" style="font-size:.65rem">Heading — ID</label><input type="text" name="usecases[h_id][]" class="form-control" value="{{ is_array($use) ? (str_contains($use['h'] ?? '', '||') ? \Illuminate\Support\Str::after($use['h'], '||') : '') : '' }}" placeholder="Judul ID"></div></div><div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-top:.5rem"><div><label class="field-label" style="font-size:.65rem">Paragraph — EN</label><textarea name="usecases[p_en][]" class="form-control" rows="2" placeholder="Description EN">{{ is_array($use) ? \Illuminate\Support\Str::before($use['p'] ?? '', '||') : '' }}</textarea></div><div><label class="field-label" style="font-size:.65rem">Paragraf — ID</label><textarea name="usecases[p_id][]" class="form-control" rows="2" placeholder="Deskripsi ID">{{ is_array($use) ? (str_contains($use['p'] ?? '', '||') ? \Illuminate\Support\Str::after($use['p'], '||') : '') : '' }}</textarea></div></div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-btn" onclick="addUseCase()"><i class="bi bi-plus"></i> Add Use Case</button>
            </div>
        </div>
    </div>

    {{-- TAB: Credits --}}
    <div class="tab-content" id="tab-credits">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Credits</label>
                <div id="creditsList">
                    @foreach(old('credits', $project->credits ?? []) as $credit)
                    <div class="list-item">
                        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.5rem">
                            <div>
                                <label class="field-label" style="font-size:.65rem">Role — EN</label>
                                <input type="text" name="credits[role_en][]" class="form-control form-control-sm" value="{{ is_array($credit) ? \Illuminate\Support\Str::before($credit['role'] ?? '', '||') : '' }}" placeholder="Concept & script">
                            </div>
                            <div>
                                <label class="field-label" style="font-size:.65rem">Role — ID</label>
                                <input type="text" name="credits[role_id][]" class="form-control form-control-sm" value="{{ is_array($credit) ? (str_contains($credit['role'] ?? '', '||') ? \Illuminate\Support\Str::after($credit['role'], '||') : '') : '' }}" placeholder="Konsep & naskah">
                            </div>
                            <div>
                                <label class="field-label" style="font-size:.65rem">Name</label>
                                <input type="text" name="credits[name][]" class="form-control form-control-sm" value="{{ is_array($credit) ? ($credit['name'] ?? '') : '' }}" placeholder="Fugo Creative">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-btn" onclick="addCredit()"><i class="bi bi-plus"></i> Add Credit</button>
            </div>
        </div>
    </div>

    {{-- TAB: Settings --}}
    <div class="tab-content" id="tab-settings">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Case Study URL</label>
                <input type="text" name="case_study" class="form-control" value="{{ old('case_study', $project->case_study) }}" placeholder="e.g. case-study or https://...">
                <div class="field-hint">Relative path or full URL. Leave blank to hide the link.</div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="field-group">
                    <label class="field-label">Slug</label>
                    <input type="text" class="form-control" value="{{ $project->slug }}" disabled style="background:var(--gray-50)">
                    <div class="field-hint">Auto-generated from title</div>
                </div>
                <div class="field-group">
                    <label class="field-label">Legacy Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description', $project->description) }}</textarea>
                </div>
            </div>
            <div style="display:flex;gap:1.5rem">
                <div class="field-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $project->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" style="font-size:.8rem">Active (visible on site)</label>
                    </div>
                </div>
                <div class="field-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" style="font-size:.8rem">Featured on Homepage</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:.5rem;margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--gray-200)">
        <a href="{{ route('admin.portfolio.projects.index', ['locale' => $locale ?? request()->route('locale') ?? 'en']) }}" class="btn btn-secondary btn-sm">Cancel</a>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab navigation
    document.querySelectorAll('.tab-nav button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-nav button').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
        });
    });

    // Sync color inputs
    document.querySelectorAll('input[type="color"]').forEach(input => {
        input.addEventListener('input', () => {
            input.nextElementSibling.value = input.value;
        });
    });

    // Collect tags before submit - expand to tags[] entries
    document.getElementById('projectForm').addEventListener('submit', function(e) {
        const hidden = document.getElementById('tagsHidden');
        const tags = [...document.querySelectorAll('#tagsDisplay .tag-chip')].map(el => el.textContent.replace(/\s*\×\s*$/, '').trim()).filter(Boolean);
        if (hidden) hidden.remove();
        tags.forEach(t => { const inp=document.createElement('input'); inp.type='hidden'; inp.name='tags[]'; inp.value=t; e.target.appendChild(inp); });
        if (tags.length===0) { const inp=document.createElement('input'); inp.type='hidden'; inp.name='tags'; inp.value=''; e.target.appendChild(inp); }

        // Reindex gallery file inputs so upload maps to correct card after deletions/adds
        const items = document.querySelectorAll('#galleryList .list-item');
        items.forEach((el, i) => {
            const fileInput = el.querySelector('input[type="file"][name^="gallery_file"]');
            if (fileInput) fileInput.name = 'gallery_file[' + i + ']';
            const hiddenSrc = el.querySelector('input[name^="gallery_existing_src"]');
            if (hiddenSrc) hiddenSrc.name = 'gallery_existing_src[' + i + ']';
        });

        // Convert about textarea array to pipe-delimited strings
        document.querySelectorAll('#aboutList textarea[name="about[]"]').forEach(ta => {
            if (!ta.value.includes('||')) {
                // Keep as-is, controller will handle
            }
        });
    });
});

function addTag() {
    const input = document.getElementById('tagInput');
    const val = input.value.trim();
    if (!val) return;
    const chip = document.createElement('span');
    chip.className = 'tag-chip';
    chip.style.cssText = 'background:var(--gray-100);border:1px solid var(--gray-200);border-radius:4px;padding:.2rem .5rem;font-size:.73rem;display:flex;align-items:center;gap:.25rem';
    chip.innerHTML = val + '<button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:var(--gray-400);cursor:pointer;font-size:.65rem">&times;</button>';
    document.getElementById('tagsDisplay').appendChild(chip);
    input.value = '';
}

function addAbout() {
    const html = `<div class="list-item">
        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
        <div class="bilingual">
            <div class="bilingual-col" data-lang="EN">
                <textarea name="about_en[]" class="form-control" rows="2" placeholder="English paragraph"></textarea>
            </div>
            <div class="bilingual-col" data-lang="ID">
                <textarea name="about_id[]" class="form-control" rows="2" placeholder="Paragraf Bahasa"></textarea>
            </div>
        </div>
    </div>`;
    document.getElementById('aboutList').insertAdjacentHTML('beforeend', html);
}

function addStep() {
    const html = `<div class="list-item">
        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
        <div class="bilingual">
            <div class="bilingual-col" data-lang="HEADING (EN||ID)">
                <input type="text" name="steps[h][]" class="form-control" placeholder="Step heading">
            </div>
            <div class="bilingual-col" data-lang="PARAGRAPH (EN||ID)">
                <textarea name="steps[p][]" class="form-control" rows="2" placeholder="Step description"></textarea>
            </div>
        </div>
    </div>`;
    document.getElementById('stepsList').insertAdjacentHTML('beforeend', html);
}

function addStat() {
    const html = `<div class="list-item">
        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
        <div style="display:grid;grid-template-columns:80px 60px 1fr;gap:.5rem">
            <input type="text" name="stats[n][]" class="form-control form-control-sm" placeholder="Number">
            <input type="text" name="stats[suffix][]" class="form-control form-control-sm" placeholder="Suffix">
            <input type="text" name="stats[l][]" class="form-control form-control-sm" placeholder="Label (EN||ID)">
        </div>
    </div>`;
    document.getElementById('statsList').insertAdjacentHTML('beforeend', html);
}

function addGalleryItem() {
    const idx = document.querySelectorAll('#galleryList .list-item').length;
    const html = `<div class="list-item">
        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:.5rem">
            <div>
                <label class="field-label" style="font-size:.65rem">Kind — EN</label>
                <input type="text" name="gallery[kind_en][]" class="form-control form-control-sm" placeholder="Film">
            </div>
            <div>
                <label class="field-label" style="font-size:.65rem">Kind — ID</label>
                <input type="text" name="gallery[kind_id][]" class="form-control form-control-sm" placeholder="Film">
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:.5rem">
            <div>
                <label class="field-label" style="font-size:.65rem">Caption — EN</label>
                <input type="text" name="gallery[cap_en][]" class="form-control form-control-sm" placeholder="Opening frame">
            </div>
            <div>
                <label class="field-label" style="font-size:.65rem">Caption — ID</label>
                <input type="text" name="gallery[cap_id][]" class="form-control form-control-sm" placeholder="Frame pembuka">
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.5rem">
            <div>
                <label class="field-label" style="font-size:.65rem">Media Type</label>
                <select name="gallery[type][]" class="form-select form-select-sm" onchange="toggleGalleryMedia(this)">
                    <option value="art">Generated Art</option>
                    <option value="image" selected>Image</option>
                    <option value="video_url">Video URL</option>
                    <option value="video_upload">Video Upload</option>
                </select>
            </div>
            <div class="gallery-media-input" style="display:block">
                <label class="field-label" style="font-size:.65rem">Image File</label>
                <input type="file" name="gallery_file[${idx}]" class="form-control form-control-sm" accept="image/*">
                <input type="hidden" name="gallery_existing_src[${idx}]" value="">
            </div>
            <div class="gallery-media-input" style="display:none">
                <label class="field-label" style="font-size:.65rem">Video URL</label>
                <input type="url" name="gallery[video_url][]" class="form-control form-control-sm" placeholder="https://...">
            </div>
        </div>
    </div>`;
    document.getElementById('galleryList').insertAdjacentHTML('beforeend', html);
}

function addDoc() {
    const html = `<div class="list-item">
        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.5rem">
            <div>
                <label class="field-label" style="font-size:.65rem">Label (EN||ID)</label>
                <input type="text" name="docs[label][]" class="form-control form-control-sm">
            </div>
            <div>
                <label class="field-label" style="font-size:.65rem">Meta (EN||ID)</label>
                <input type="text" name="docs[meta][]" class="form-control form-control-sm" placeholder="PDF — 24 pages">
            </div>
            <div>
                <label class="field-label" style="font-size:.65rem">URL (optional)</label>
                <input type="url" name="docs[href][]" class="form-control form-control-sm" placeholder="https://...">
            </div>
        </div>
    </div>`;
    document.getElementById('docsList').insertAdjacentHTML('beforeend', html);
}

function addUseCase() {
    const html = `<div class="list-item">
        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
        <div class="bilingual">
            <div class="bilingual-col" data-lang="HEADING (EN||ID)">
                <input type="text" name="usecases[h][]" class="form-control" placeholder="Use case heading">
            </div>
            <div class="bilingual-col" data-lang="PARAGRAPH (EN||ID)">
                <textarea name="usecases[p][]" class="form-control" rows="2" placeholder="Use case description"></textarea>
            </div>
        </div>
    </div>`;
    document.getElementById('usecasesList').insertAdjacentHTML('beforeend', html);
}

function addCredit() {
    const html = `<div class="list-item">
        <button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem">
            <div>
                <label class="field-label" style="font-size:.65rem">Role (EN||ID)</label>
                <input type="text" name="credits[role][]" class="form-control form-control-sm" placeholder="Concept & script||Konsep & naskah">
            </div>
            <div>
                <label class="field-label" style="font-size:.65rem">Name</label>
                <input type="text" name="credits[name][]" class="form-control form-control-sm" placeholder="Fugo Creative">
            </div>
        </div>
    </div>`;
    document.getElementById('creditsList').insertAdjacentHTML('beforeend', html);
}

function toggleOutcome(type) {
    document.getElementById('outcomeStats').style.display = type === 'stats' ? 'block' : 'none';
    document.getElementById('outcomeResult').style.display = type === 'result' ? 'block' : 'none';
}

function toggleGalleryMedia(select) {
    const container = select.closest('.list-item');
    const inputs = container.querySelectorAll('.gallery-media-input');
    const val = select.value;
    inputs.forEach(el => el.style.display = 'none');
    if (val === 'image') inputs[0].style.display = 'block';
    if (val === 'video_url') inputs[1].style.display = 'block';
    if (val === 'video_upload') { inputs[0].style.display = 'block'; inputs[0].querySelector('input').accept = 'video/*'; }
}

</script>
@endpush
