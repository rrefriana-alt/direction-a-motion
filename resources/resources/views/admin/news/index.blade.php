@extends('admin.layout')

@section('title', 'News')
@section('page-title', 'News & Blog')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">News & Blog</h4>
        <a href="{{ route('admin.news.create') }}" class="btn btn-accent">
            <i class="bi bi-pencil-square me-1"></i> Write Article
        </a>
    </div>

    <div class="card card-modern">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->category }}</td>
                                <td>{{ $item->author }}</td>
                                <td>
                                    @if($item->status === 'Published')
                                        <span class="badge badge-status bg-success">Published</span>
                                    @elseif($item->status === 'Draft')
                                        <span class="badge badge-status bg-warning text-dark">Draft</span>
                                    @else
                                        <span class="badge badge-status bg-secondary">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state text-center py-5">
                                        <i class="bi bi-journal-text fs-1 text-muted mb-3 d-block"></i>
                                        <h5 class="text-muted mb-0">No articles found</h5>
                                        <p class="text-muted mb-3">Get started by creating your first article.</p>
                                        <a href="{{ route('admin.news.create') }}" class="btn btn-accent btn-sm">Write Article</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
