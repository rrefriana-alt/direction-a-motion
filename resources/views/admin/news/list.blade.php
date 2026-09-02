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

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th style="width:60px">Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                <tr>
                    <td>
                        @if($item->featured_image)
                            <img src="{{ asset('img/' . $item->featured_image) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:var(--radius-sm)">
                        @else
                            <div style="width:40px;height:40px;border-radius:var(--radius-sm);background:var(--gray-100);display:flex;align-items:center;justify-content:center">
                                <i class="bi bi-image" style="color:var(--gray-400)"></i>
                            </div>
                        @endif
                    </td>
                    <td><span class="fw-600">{{ $item->title }}</span></td>
                    <td><span class="badge-category">{{ ucfirst($item->category) }}</span></td>
                    <td style="color:var(--gray-500)">{{ $item->author }}</td>
                    <td style="color:var(--gray-400);font-size:.73rem">{{ $item->published_date }}</td>
                    <td>
                        @if($item->is_published)
                            <span class="badge-active">Published</span>
                        @else
                            <span class="badge-inactive">Draft</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.news.show', $item->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this article?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-newspaper"></i>
                            <p>No articles yet</p>
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
