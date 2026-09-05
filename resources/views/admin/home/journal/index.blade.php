@extends('admin.layouts.app')
@section('title', 'Journal — Homepage')
@section('page-title', 'Journal — Homepage Section')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Journal</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Journal <span style="font-size:.75rem;font-weight:500;color:var(--gray-400)">Section 07 — Homepage</span></h2>
        <p>Kelola header &amp; artikel yang tampil di homepage ({{ strtoupper($locale) }})</p>
    </div>
    <div style="display:flex;gap:.5rem">
        <a href="{{ route('admin.home.journal.header.edit', ['locale' => $locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-type"></i> Edit Header</a>
        <a href="{{ route('admin.home.journal.curation.edit', ['locale' => $locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-pin"></i> Atur Kurasi</a>
        <a href="{{ route('admin.news.list', ['locale' => $locale]) }}" class="btn btn-primary btn-sm"><i class="bi bi-newspaper"></i> Kelola Artikel</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start">
    <div class="card-white">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <h3 style="font-size:.95rem;font-weight:700;margin:0">Header Preview ({{ strtoupper($locale) }})</h3>
            <span class="badge-{{ $mode === 'manual' ? 'active' : 'inactive' }}">{{ $mode === 'manual' ? 'Manual' : 'Auto Latest' }}</span>
        </div>
        <div style="border:1px dashed var(--gray-200);border-radius:var(--radius);padding:1.5rem;background:#07080a;color:#f4f5f2">
            <div style="font-family:monospace;font-size:.68rem;letter-spacing:.18em;text-transform:uppercase;color:#9ba1ab;margin-bottom:.8rem">{!! $header['eyebrow'] !!}</div>
            <div style="font-size:1.6rem;font-weight:800;line-height:1.05;letter-spacing:-.03em;margin-bottom:.8rem">{!! $header['title'] !!}</div>
            <p style="font-size:.85rem;color:#9ba1ab;line-height:1.6;margin-bottom:1rem">{{ $header['lede'] }}</p>
            <span style="font-size:.85rem;color:#3ddc97">{{ $header['cta'] }}</span>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.75rem">
            {{ $publishedCount }} artikel published tersedia ·
            <a href="{{ url($locale) }}" target="_blank" rel="noopener">Lihat Homepage ↗</a>
        </div>
    </div>

    <div class="card-white">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <h3 style="font-size:.95rem;font-weight:700;margin:0">Slot Homepage (3)</h3>
            @if($mode === 'manual')
                <span style="font-size:.72rem;color:var(--gray-400)">Urutan = Slot 1 → 3</span>
            @else
                <span style="font-size:.72rem;color:var(--gray-400)">Otomatis: terbaru</span>
            @endif
        </div>
        @forelse($previewPosts as $i => $post)
        <div style="display:flex;gap:.9rem;align-items:center;padding:.8rem;border:1px solid var(--gray-100);border-radius:var(--radius);margin-bottom:.7rem">
            <span style="font-family:monospace;font-size:.7rem;color:var(--green-600);font-weight:700">0{{ $i + 1 }}</span>
            @if(!empty($post->featured_image) && file_exists(public_path('img/' . $post->featured_image)))
                <img src="{{ asset('img/' . $post->featured_image) }}" alt="" style="width:72px;height:52px;object-fit:cover;border-radius:8px;flex:none">
            @else
                <span style="width:72px;height:52px;border-radius:8px;overflow:hidden;flex:none;display:block;background:#0d0f13">@include('partials.jart', ['seed' => $post->id])</span>
            @endif
            <div style="min-width:0">
                <div style="font-weight:600;font-size:.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $post->title }}</div>
                <div style="font-size:.72rem;color:var(--gray-400)">{{ $post->category_display }} · {{ $post->published_date?->format('d M Y') }}</div>
            </div>
        </div>
        @empty
        <div class="empty-state" style="padding:2rem 1rem;text-align:center;color:var(--gray-400)">
            <i class="bi bi-newspaper" style="font-size:1.6rem"></i>
            <p style="margin:.5rem 0 1rem">Belum ada artikel published</p>
            <a href="{{ route('admin.news.create', ['locale' => $locale]) }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Buat Artikel Pertama</a>
        </div>
        @endforelse
    </div>
</div>
@endsection
