@extends('admin.layouts.app')
@section('title', 'View Article')
@section('page-title', 'View Article')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">News</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>{{ $news->title }}</h2>
        <p>Published {{ $news->published_date }} by {{ $news->author }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('admin.news.list') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card-white" style="max-width:720px">
    <div class="d-flex gap-3 mb-3">
        <span style="background:#eff6ff;color:#2563eb;padding:.2rem .6rem;border-radius:6px;font-size:.75rem;font-weight:500">{{ ucfirst($news->category) }}</span>
        @if($news->is_published)
            <span class="badge-active">Published</span>
        @else
            <span class="badge-inactive">Draft</span>
        @endif
        @if($news->is_featured)
            <span style="background:#fef3c7;color:#92400e;padding:.2rem .6rem;border-radius:6px;font-size:.75rem;font-weight:500">Featured</span>
        @endif
    </div>
    @if($news->featured_image)
        <div class="mb-3">
            <img src="{{ asset('img/' . $news->featured_image) }}" alt="{{ $news->title }}" style="max-width:100%;border-radius:8px">
        </div>
    @endif
    <div class="mb-3">
        <strong>Excerpt:</strong>
        <p style="color:#6b7280">{{ $news->excerpt }}</p>
    </div>
    <div>
        <strong>Content:</strong>
        <div style="margin-top:.5rem;white-space:pre-wrap;line-height:1.7;color:#374151">{{ $news->content }}</div>
    </div>
    <div class="mt-3 d-flex gap-2">
        <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i> Edit</a>
        <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Delete this article?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
        </form>
    </div>
</div>
@endsection
