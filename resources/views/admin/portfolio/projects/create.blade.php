@extends('admin.layouts.app')
@section('title', 'Create Project')
@section('page-title', 'Create Project')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.index') }}">Portfolio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.portfolio.projects.index') }}">Projects</a></li>
    <li class="breadcrumb-item active">Create</li>
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
        <h2>Create New Project</h2>
        <p style="font-size:.8rem;color:var(--gray-500)">Add a new project to the work portfolio</p>
    </div>
    <a href="{{ route('admin.portfolio.projects.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<form action="{{ route('admin.portfolio.projects.store') }}" method="POST" enctype="multipart/form-data" id="projectForm">
    @csrf

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
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="e.g. BRI Debit Virtual TVC">
            </div>
            <div class="bilingual">
                <div class="field-group bilingual-col" data-lang="ENGLISH">
                    <label class="field-label">Client Name</label>
                    <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" placeholder="Bank Rakyat Indonesia">
                </div>
                <div class="field-group bilingual-col" data-lang="BAHASA">
                    <label class="field-label">Category <span style="color:var(--danger)">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="">Select category</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem">
                <div class="field-group">
                    <label class="field-label">Year</label>
                    <input type="text" name="year" class="form-control" value="{{ old('year', date('Y')) }}" placeholder="2025">
                </div>
                <div class="field-group">
                    <label class="field-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>
                <div class="field-group">
                    <label class="field-label">Homepage Order</label>
                    <input type="number" name="homepage_order" class="form-control" value="{{ old('homepage_order', 0) }}" min="0">
                </div>
            </div>
            <div class="bilingual">
                <div class="field-group bilingual-col" data-lang="ENGLISH">
                    <label class="field-label">Scope (EN||ID)</label>
                    <input type="text" name="scope" class="form-control" value="{{ old('scope') }}" placeholder="Concept — Script — Production">
                    <div class="field-hint">Use EN||ID format for bilingual</div>
                </div>
                <div class="field-group bilingual-col" data-lang="BAHASA">
                    <label class="field-label">Division (EN||ID)</label>
                    <input type="text" name="division" class="form-control" value="{{ old('division') }}" placeholder="Production House||Rumah Produksi">
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
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="field-hint">Shown on the work list page</div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Hero Image</label>
                        <input type="file" name="hero_image" class="form-control" accept="image/*">
                        <div class="field-hint">Shown at the top of the modal</div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Client Logo</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        <div class="field-hint">Client logo shown in modal facts strip</div>
                    </div>
                </div>
                <div>
                    <div class="field-group">
                        <label class="field-label">Background Color</label>
                        <div style="display:flex;gap:.5rem;align-items:center">
                            <input type="color" name="bg_color" class="color-input" value="{{ old('bg_color', '#101722') }}">
                            <input type="text" class="form-control form-control-sm" value="{{ old('bg_color', '#101722') }}" style="max-width:100px" readonly>
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Accent Color</label>
                        <div style="display:flex;gap:.5rem;align-items:center">
                            <input type="color" name="accent_color" class="color-input" value="{{ old('accent_color', '#3ddc97') }}">
                            <input type="text" class="form-control form-control-sm" value="{{ old('accent_color', '#3ddc97') }}" style="max-width:100px" readonly>
                        </div>
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
                    <label class="field-label">Lede (EN||ID)</label>
                    <textarea name="lede" class="form-control" rows="2">{{ old('lede') }}</textarea>
                    <div class="field-hint">Short headline below the title in modal</div>
                </div>
                <div class="field-group bilingual-col" data-lang="BAHASA">
                    <label class="field-label">Result (EN||ID)</label>
                    <textarea name="result" class="form-control" rows="2">{{ old('result') }}</textarea>
                    <div class="field-hint">Shown if no stats are added</div>
                </div>
            </div>
            <div class="field-group">
                <label class="field-label">About — What it is</label>
                <div id="aboutList"></div>
                <button type="button" class="add-btn" onclick="addAbout()"><i class="bi bi-plus"></i> Add Paragraph</button>
            </div>
            <div class="field-group">
                <label class="field-label">Tags</label>
                <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:.5rem" id="tagsDisplay"></div>
                <div style="display:flex;gap:.5rem">
                    <input type="text" id="tagInput" class="form-control form-control-sm" placeholder="Add a tag and press Enter" style="max-width:200px" onkeydown="if(event.key==='Enter'){event.preventDefault();addTag()}">
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
                <div id="stepsList"></div>
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
                        <input type="radio" name="outcome_type" value="stats" checked onchange="toggleOutcome('stats')"> Stats Grid
                    </label>
                    <label class="form-check-sm" style="display:flex;align-items:center;gap:.35rem;cursor:pointer">
                        <input type="radio" name="outcome_type" value="result" onchange="toggleOutcome('result')"> Result Text
                    </label>
                </div>
            </div>
            <div id="outcomeStats">
                <div class="field-group">
                    <label class="field-label">Stats</label>
                    <div id="statsList"></div>
                    <button type="button" class="add-btn" onclick="addStat()"><i class="bi bi-plus"></i> Add Stat</button>
                </div>
            </div>
            <div id="outcomeResult" style="display:none">
                <div class="field-group">
                    <label class="field-label">Result Text (EN||ID)</label>
                    <textarea name="result_text" class="form-control" rows="3">{{ old('result') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB: Gallery --}}
    <div class="tab-content" id="tab-gallery">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Gallery Items</label>
                <div id="galleryList"></div>
                <button type="button" class="add-btn" onclick="addGalleryItem()"><i class="bi bi-plus"></i> Add Gallery Item</button>
            </div>
        </div>
    </div>

    {{-- TAB: Docs --}}
    <div class="tab-content" id="tab-docs">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Documentation</label>
                <div id="docsList"></div>
                <button type="button" class="add-btn" onclick="addDoc()"><i class="bi bi-plus"></i> Add Document</button>
            </div>
        </div>
    </div>

    {{-- TAB: Use Cases --}}
    <div class="tab-content" id="tab-usecases">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Where It Is Used</label>
                <div id="usecasesList"></div>
                <button type="button" class="add-btn" onclick="addUseCase()"><i class="bi bi-plus"></i> Add Use Case</button>
            </div>
        </div>
    </div>

    {{-- TAB: Credits --}}
    <div class="tab-content" id="tab-credits">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Credits</label>
                <div id="creditsList"></div>
                <button type="button" class="add-btn" onclick="addCredit()"><i class="bi bi-plus"></i> Add Credit</button>
            </div>
        </div>
    </div>

    {{-- TAB: Settings --}}
    <div class="tab-content" id="tab-settings">
        <div class="card-white">
            <div class="field-group">
                <label class="field-label">Case Study URL</label>
                <input type="text" name="case_study" class="form-control" value="{{ old('case_study') }}" placeholder="e.g. case-study or https://...">
                <div class="field-hint">Relative path or full URL. Leave blank to hide the link.</div>
            </div>
            <div class="field-group">
                <label class="field-label">Description (legacy)</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
            </div>
            <div style="display:flex;gap:1.5rem">
                <div class="field-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label" style="font-size:.8rem">Active</label>
                    </div>
                </div>
                <div class="field-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1">
                        <label class="form-check-label" style="font-size:.8rem">Featured on Homepage</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;justify-content:flex-end;gap:.5rem;margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--gray-200)">
        <a href="{{ route('admin.portfolio.projects.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Create Project</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.tab-nav button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-nav button').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
        });
    });
    document.querySelectorAll('input[type="color"]').forEach(input => {
        input.addEventListener('input', () => { input.nextElementSibling.value = input.value; });
    });
    document.getElementById('projectForm').addEventListener('submit', function(e) {
        // expand JSON tag into multiple hidden inputs so Laravel receives tags[] as array of strings, not one JSON string
        const hidden = document.getElementById('tagsHidden');
        const tags = [...document.querySelectorAll('#tagsDisplay .tag-chip')].map(el => el.textContent.replace(/\s*\×\s*$/, '').trim()).filter(Boolean);
        hidden.remove();
        tags.forEach(t => {
            const inp = document.createElement('input');
            inp.type = 'hidden'; inp.name = 'tags[]'; inp.value = t;
            e.target.appendChild(inp);
        });
        if (tags.length === 0) {
            const inp = document.createElement('input'); inp.type='hidden'; inp.name='tags'; inp.value=''; e.target.appendChild(inp);
        }
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
    const html = `<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div class="bilingual"><div class="bilingual-col" data-lang="EN"><textarea name="about[]" class="form-control" rows="2" placeholder="English paragraph"></textarea></div><div class="bilingual-col" data-lang="ID"><textarea class="form-control" rows="2" placeholder="Bahasa paragraph" disabled></textarea></div></div></div>`;
    document.getElementById('aboutList').insertAdjacentHTML('beforeend', html);
}

function addStep() {
    const html = `<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div class="bilingual"><div class="bilingual-col" data-lang="HEADING (EN||ID)"><input type="text" name="steps[h][]" class="form-control" placeholder="Step heading"></div><div class="bilingual-col" data-lang="PARAGRAPH (EN||ID)"><textarea name="steps[p][]" class="form-control" rows="2" placeholder="Step description"></textarea></div></div></div>`;
    document.getElementById('stepsList').insertAdjacentHTML('beforeend', html);
}

function addStat() {
    const html = `<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:80px 60px 1fr;gap:.5rem"><input type="text" name="stats[n][]" class="form-control form-control-sm" placeholder="Number"><input type="text" name="stats[suffix][]" class="form-control form-control-sm" placeholder="Suffix"><input type="text" name="stats[l][]" class="form-control form-control-sm" placeholder="Label (EN||ID)"></div></div>`;
    document.getElementById('statsList').insertAdjacentHTML('beforeend', html);
}

function addGalleryItem() {
    const html = `<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:.5rem"><div><label class="field-label" style="font-size:.65rem">Kind (EN||ID)</label><input type="text" name="gallery[kind][]" class="form-control form-control-sm" placeholder="Film||Film"></div><div><label class="field-label" style="font-size:.65rem">Caption (EN||ID)</label><input type="text" name="gallery[cap][]" class="form-control form-control-sm" placeholder="Opening frame||Frame pembuka"></div></div><div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.5rem"><div><label class="field-label" style="font-size:.65rem">Media Type</label><select name="gallery[type][]" class="form-select form-select-sm" onchange="toggleGalleryMedia(this)"><option value="art">Generated Art</option><option value="image">Image</option><option value="video_url">Video URL</option><option value="video_upload">Video Upload</option></select></div><div class="gallery-media-input" style="display:none"><label class="field-label" style="font-size:.65rem">Image File</label><input type="file" name="gallery_file[]" class="form-control form-control-sm" accept="image/*"></div><div class="gallery-media-input" style="display:none"><label class="field-label" style="font-size:.65rem">Video URL</label><input type="url" name="gallery[video_url][]" class="form-control form-control-sm" placeholder="https://..."></div></div></div>`;
    document.getElementById('galleryList').insertAdjacentHTML('beforeend', html);
}

function addDoc() {
    const html = `<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.5rem"><div><label class="field-label" style="font-size:.65rem">Label (EN||ID)</label><input type="text" name="docs[label][]" class="form-control form-control-sm"></div><div><label class="field-label" style="font-size:.65rem">Meta (EN||ID)</label><input type="text" name="docs[meta][]" class="form-control form-control-sm" placeholder="PDF — 24 pages"></div><div><label class="field-label" style="font-size:.65rem">URL (optional)</label><input type="url" name="docs[href][]" class="form-control form-control-sm" placeholder="https://..."></div></div></div>`;
    document.getElementById('docsList').insertAdjacentHTML('beforeend', html);
}

function addUseCase() {
    const html = `<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div class="bilingual"><div class="bilingual-col" data-lang="HEADING (EN||ID)"><input type="text" name="usecases[h][]" class="form-control" placeholder="Use case heading"></div><div class="bilingual-col" data-lang="PARAGRAPH (EN||ID)"><textarea name="usecases[p][]" class="form-control" rows="2" placeholder="Use case description"></textarea></div></div></div>`;
    document.getElementById('usecasesList').insertAdjacentHTML('beforeend', html);
}

function addCredit() {
    const html = `<div class="list-item"><button type="button" class="remove-btn" onclick="this.closest('.list-item').remove()"><i class="bi bi-x"></i></button><div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem"><div><label class="field-label" style="font-size:.65rem">Role (EN||ID)</label><input type="text" name="credits[role][]" class="form-control form-control-sm" placeholder="Concept & script||Konsep & naskah"></div><div><label class="field-label" style="font-size:.65rem">Name</label><input type="text" name="credits[name][]" class="form-control form-control-sm" placeholder="Fugo Creative"></div></div></div>`;
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
