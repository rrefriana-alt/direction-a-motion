@extends('admin.layouts.app')
@section('title', 'Edit Article')
@section('page-title', 'Edit Article')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">News</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit Article</h2>
        <p>Update this news article</p>
    </div>
    <a href="{{ route('admin.news.list') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<style>
.news-edit-grid{display:grid;grid-template-columns:3fr 2fr;gap:1.5rem;align-items:start}
.news-preview{position:sticky;top:90px;max-height:calc(100vh - 120px);overflow-y:auto}
@media(max-width:1023.98px){
    .news-edit-grid{grid-template-columns:1fr}
    .news-preview{position:static;max-height:none}
}
</style>

<div class="news-edit-grid">
<div class="card-white">
    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data" id="newsForm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="fTitle">Title</label>
            <input type="text" id="fTitle" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $news->title) }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="fCategory">Category</label>
                <select id="fCategory" name="category" class="form-select @error('category') is-invalid @enderror" required>
                    <option value="">Select category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $news->category) === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="fAuthor">Author</label>
                <input type="text" id="fAuthor" name="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $news->author) }}" required>
                @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="row g-3 mt-0">
            <div class="col-md-4">
                <label class="form-label" for="fDate">Published Date</label>
                <input type="date" id="fDate" name="published_date" class="form-control @error('published_date') is-invalid @enderror" value="{{ old('published_date', $news->published_date) }}" required>
                @error('published_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label" for="fRead">Read Time (min)</label>
                <input type="number" id="fRead" name="read_time" class="form-control @error('read_time') is-invalid @enderror" value="{{ old('read_time', $news->read_time) }}" min="1" required>
                @error('read_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="fPublished" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                    <label class="form-check-label" for="fPublished">Published</label>
                </div>
            </div>
        </div>
        <div class="mb-3 mt-3">
            <label class="form-label" for="fImage">Featured Image</label>
            @if($news->featured_image)
                <div class="mb-2">
                    <img src="{{ asset('img/' . $news->featured_image) }}" alt="" style="height:60px;border-radius:6px">
                </div>
            @endif
            <input type="file" id="fImage" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
            @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="fExcerpt">Excerpt</label>
            <textarea id="fExcerpt" name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="2" required>{{ old('excerpt', $news->excerpt) }}</textarea>
            @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="fContent">Content</label>
            <textarea id="fContent" name="content" class="form-control @error('content') is-invalid @enderror" rows="12" required>{{ old('content', $news->content) }}</textarea>
            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="fFeatured" name="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                <label class="form-check-label" for="fFeatured">Featured Article</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Changes</button>
    </form>
</div>

<div class="card-white news-preview" style="border-radius:12px;box-shadow:0 8px 28px rgba(15,23,42,.08);padding:24px" aria-live="polite">
    <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1.1rem">
        <i class="bi bi-eye" style="font-size:1rem"></i>
        <strong style="font-size:.95rem">Article Preview</strong>
        <span class="badge-active" style="margin-left:auto">Live</span>
    </div>

    <div id="pvEmpty" style="display:none;text-align:center;padding:2.5rem 1rem;color:var(--gray-400)">
        <i class="bi bi-pencil-square" style="font-size:1.8rem"></i>
        <p style="margin-top:.6rem">Start typing to see preview…</p>
    </div>

    <article id="pvBody">
        <div id="pvImgWrap" style="margin-bottom:1rem">
            <img id="pvImg" src="{{ $news->featured_image ? asset('img/' . $news->featured_image) : '' }}" alt="" style="width:100%;height:190px;object-fit:cover;border-radius:10px;{{ $news->featured_image ? '' : 'display:none' }}">
            <div id="pvImgEmpty" style="{{ $news->featured_image ? 'display:none;' : '' }}width:100%;height:150px;border-radius:10px;border:1.5px dashed var(--gray-200);display:flex;flex-direction:column;gap:.3rem;align-items:center;justify-content:center;color:var(--gray-400);font-size:.8rem">
                <i class="bi bi-image" style="font-size:1.4rem"></i>
                No featured image
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:.6rem;flex-wrap:wrap">
            <span class="badge-category" id="pvCat">{{ ucfirst($news->category ?? 'Uncategorized') }}</span>
            <span id="pvStatus" style="font-size:.68rem;font-weight:700;padding:.2rem .6rem;border-radius:100px"></span>
        </div>
        <h1 id="pvTitle" style="font-size:1.45rem;font-weight:800;line-height:1.2;letter-spacing:-.02em;margin:0 0 .7rem"></h1>
        <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.9rem">
            <span id="pvAvatar" style="width:32px;height:32px;border-radius:50%;display:inline-grid;place-items:center;background:var(--green-500,#16a34a);color:#fff;font-weight:700;font-size:.8rem;flex:none"></span>
            <div style="font-size:.8rem;line-height:1.35">
                <div id="pvAuthor" style="font-weight:600"></div>
                <div style="color:var(--gray-400)"><span id="pvDate"></span> · <span id="pvRead"></span></div>
            </div>
        </div>
        <p id="pvExcerpt" style="font-style:italic;color:var(--gray-500);border-left:3px solid var(--green-500,#16a34a);padding-left:.8rem;margin:0 0 1rem;font-size:.9rem;line-height:1.6"></p>
        <div id="pvContent" style="font-size:.9rem;line-height:1.75;color:var(--gray-700)"></div>
    </article>
</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const $ = id => document.getElementById(id);
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const esc = s => (s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

    function fmtDate(v) {
        if (!v) return 'Draft';
        const p = v.split('-');
        if (p.length !== 3) return v;
        return parseInt(p[2], 10) + ' ' + (months[parseInt(p[1], 10) - 1] || '') + ' ' + p[0];
    }
    function paint() {
        const title = $('fTitle').value.trim();
        const excerpt = $('fExcerpt').value.trim();
        const content = $('fContent').value.trim();
        const author = $('fAuthor').value.trim();
        const cat = $('fCategory').value;
        const date = $('fDate').value;
        const read = parseInt($('fRead').value, 10);
        const published = $('fPublished').checked;
        const featured = $('fFeatured').checked;

        const isEmpty = !title && !excerpt && !content;
        $('pvEmpty').style.display = isEmpty ? 'block' : 'none';
        $('pvBody').style.display = isEmpty ? 'none' : 'block';
        if (isEmpty) return;

        $('pvTitle').textContent = title || 'Untitled article';
        $('pvTitle').style.color = title ? '' : 'var(--gray-300)';
        $('pvCat').textContent = cat ? cat.charAt(0).toUpperCase() + cat.slice(1) : 'Uncategorized';
        $('pvAuthor').textContent = author || 'Unknown author';
        $('pvAvatar').textContent = (author || 'F').charAt(0).toUpperCase();
        $('pvDate').textContent = fmtDate(date);
        $('pvRead').textContent = (read > 0 ? read : '–') + ' min read';
        const st = $('pvStatus');
        st.textContent = (published ? 'Published' : 'Draft') + (featured ? ' ★ Featured' : '');
        st.style.background = published ? 'var(--green-50,#ecfdf5)' : 'var(--gray-100,#f3f4f6)';
        st.style.color = published ? 'var(--green-600,#16a34a)' : 'var(--gray-500,#6b7280)';

        $('pvExcerpt').textContent = excerpt;
        $('pvExcerpt').style.display = excerpt ? 'block' : 'none';
        $('pvContent').innerHTML = esc(content)
            .split(/\n{2,}/).map(p => '<p style="margin:0 0 .9em">' + p.replace(/\n/g, '<br>') + '</p>').join('');
    }
    function paintImage(input) {
        const img = $('pvImg'), empty = $('pvImgEmpty');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { img.src = e.target.result; img.style.display = 'block'; empty.style.display = 'none'; };
            reader.readAsDataURL(input.files[0]);
        }
    }
    ['fTitle','fExcerpt','fContent','fAuthor','fCategory','fDate','fRead'].forEach(id => {
        const el = $(id);
        el.addEventListener('input', paint);
        el.addEventListener('change', paint);
    });
    ['fPublished','fFeatured'].forEach(id => $(id).addEventListener('change', paint));
    $('fImage').addEventListener('change', function() { paintImage(this); });
    paint();
});
</script>
@endpush
