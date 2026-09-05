@extends('admin.layouts.app')
@section('title', 'All Articles')
@section('page-title', 'News Articles')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">News</a></li>
    <li class="breadcrumb-item active">All Articles</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>All Articles</h2>
        <p>View and manage all news articles</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> New Article</a>
</div>

<div class="card-white" style="margin-bottom:1rem">
    <form method="GET" action="{{ route('admin.news.list') }}" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:center">
        <div style="position:relative;flex:1;min-width:220px">
            <i class="bi bi-search" style="position:absolute;left:.8rem;top:50%;transform:translateY(-50%);color:var(--gray-400);font-size:.85rem"></i>
            <input type="text" name="q" class="form-control" placeholder="Cari judul, penulis, excerpt…" value="{{ $search ?? '' }}" style="padding-left:2.2rem">
        </div>
        <select name="category" class="form-control" style="width:auto">
            <option value="">Semua kategori</option>
            @foreach($categories ?? [] as $cat)
                <option value="{{ $cat }}" {{ ($activeCategory ?? '') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
            @endforeach
        </select>
        <div style="position:relative" id="sortWrap">
            <button type="button" class="form-control" id="sortBtn" aria-haspopup="true" aria-expanded="false" style="width:auto;display:inline-flex;align-items:center;gap:.5rem;cursor:pointer;background:#fff">
                <i class="bi bi-funnel" style="font-size:.8rem"></i>
                <span id="sortLabel">{{ ['latest' => 'Terbaru', 'oldest' => 'Terlama', 'views' => 'Most Views'][($sort ?? 'latest')] ?? 'Filter' }}</span>
                <i class="bi bi-chevron-down" style="font-size:.65rem;color:var(--gray-400)"></i>
            </button>
            <div id="sortMenu" style="display:none;position:absolute;right:0;top:calc(100% + 6px);min-width:170px;background:#fff;border:1px solid var(--gray-200);border-radius:10px;box-shadow:0 12px 32px rgba(0,0,0,.12);padding:.35rem;z-index:50">
                @foreach(['latest' => 'Terbaru', 'oldest' => 'Terlama', 'views' => 'Most Views'] as $val => $label)
                    <a href="{{ request()->fullUrlWithQuery(['sort' => $val]) }}" data-sort-link
                       style="display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:.55rem .8rem;border-radius:7px;font-size:.85rem;color:{{ ($sort ?? 'latest') === $val ? 'var(--green-600)' : 'var(--gray-700)' }};font-weight:{{ ($sort ?? 'latest') === $val ? '700' : '400' }};text-decoration:none;background:{{ ($sort ?? 'latest') === $val ? 'var(--green-50)' : 'transparent' }}">
                        {{ $label }}
                        @if(($sort ?? 'latest') === $val)<i class="bi bi-check2" style="font-size:.8rem"></i>@endif
                    </a>
                @endforeach
            </div>
        </div>
        @if(!empty($search) || !empty($activeCategory) || (($sort ?? 'latest') !== 'latest'))
            <a href="{{ route('admin.news.list') }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Reset</a>
        @endif
    </form>
</div>

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th style="width:64px">Cover</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th style="width:70px">Views</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                <tr>
                    <td>
                        @if(!empty($item->featured_image) && file_exists(public_path('img/' . $item->featured_image)))
                            <img src="{{ asset('img/' . $item->featured_image) }}" alt="" style="width:56px;height:40px;object-fit:cover;border-radius:8px;display:block">
                        @else
                            <span style="width:56px;height:40px;border-radius:8px;overflow:hidden;display:block;background:#0d0f13">@include('partials.jart', ['seed' => $item->id])</span>
                        @endif
                    </td>
                    <td style="min-width:220px">
                        <div style="display:flex;align-items:center;gap:.4rem">
                            @if($item->is_featured)
                                <i class="bi bi-star-fill" style="color:#f59e0b;font-size:.75rem" title="Featured"></i>
                            @endif
                            <span class="fw-600">{{ $item->title }}</span>
                        </div>
                        <div style="font-size:.75rem;color:var(--gray-400);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:340px">{{ $item->excerpt }}</div>
                        <div style="margin-top:.25rem">
                            @if(in_array($item->id, $pinnedIds ?? []))
                                <span class="badge-active" title="Tampil di homepage">Homepage</span>
                            @endif
                        </div>
                    </td>
                    <td><span class="badge-category">{{ ucfirst($item->category) }}</span></td>
                    <td style="color:var(--gray-500)">{{ $item->author }}</td>
                    <td style="color:var(--gray-500);font-size:.78rem;white-space:nowrap">{{ $item->published_date?->format('d M Y') }}</td>
                    <td style="color:var(--gray-500);font-size:.8rem"><i class="bi bi-eye" style="font-size:.72rem"></i> {{ number_format($item->view_count ?? 0) }}</td>
                    <td>
                        @if($item->is_published)
                            <span class="badge-active">Published</span>
                        @else
                            <span class="badge-inactive">Draft</span>
                        @endif
                    </td>
                    <td class="text-end" style="white-space:nowrap">
                        <a href="{{ route('admin.news.show', $item->id) }}" class="btn btn-secondary btn-sm" title="Lihat"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this article?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state" style="padding:2.5rem 1rem;text-align:center">
                            <i class="bi bi-newspaper" style="font-size:1.8rem;color:var(--gray-300)"></i>
                            @if(!empty($search) || !empty($activeCategory))
                                <p>Tidak ada artikel yang cocok dengan filter</p>
                                <a href="{{ route('admin.news.list') }}" class="btn btn-secondary btn-sm">Reset filter</a>
                            @else
                                <p>No articles yet</p>
                                <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Buat Artikel Pertama</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($news, 'links'))
    <div style="padding:.75rem 1.25rem;border-top:1px solid var(--gray-100)">
        {{ $news->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrap = document.getElementById('sortWrap');
    const btn = document.getElementById('sortBtn');
    const menu = document.getElementById('sortMenu');
    if (!wrap || !btn || !menu) return;
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const open = menu.style.display === 'block';
        menu.style.display = open ? 'none' : 'block';
        btn.setAttribute('aria-expanded', String(!open));
    });
    document.addEventListener('click', function(e) {
        if (!wrap.contains(e.target)) {
            menu.style.display = 'none';
            btn.setAttribute('aria-expanded', 'false');
        }
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            menu.style.display = 'none';
            btn.setAttribute('aria-expanded', 'false');
        }
    });
    // carry typed-but-unsubmitted search text into sort links
    menu.querySelectorAll('a[data-sort-link]').forEach(a => {
        a.addEventListener('click', function() {
            const q = document.querySelector('input[name="q"]');
            const url = new URL(a.href, window.location.origin);
            if (q && q.value.trim() !== '') url.searchParams.set('q', q.value.trim());
            a.href = url.toString();
        });
    });
});
</script>
@endpush
