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

<div class="card-white" style="max-width:720px">
    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $news->title) }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                    <option value="">Select category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $news->category) === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Author</label>
                <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $news->author) }}" required>
                @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="row g-3 mt-0">
            <div class="col-md-4">
                <label class="form-label">Published Date</label>
                <input type="date" name="published_date" class="form-control @error('published_date') is-invalid @enderror" value="{{ old('published_date', $news->published_date) }}" required>
                @error('published_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Read Time (min)</label>
                <input type="number" name="read_time" class="form-control @error('read_time') is-invalid @enderror" value="{{ old('read_time', $news->read_time) }}" min="1" required>
                @error('read_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                    <label class="form-check-label">Published</label>
                </div>
            </div>
        </div>
        <div class="mb-3 mt-3">
            <label class="form-label">Featured Image</label>
            @if($news->featured_image)
                <div class="mb-2">
                    <img src="{{ asset('img/' . $news->featured_image) }}" alt="" style="height:60px;border-radius:6px">
                </div>
            @endif
            <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
            @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Excerpt</label>
            <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="2" required>{{ old('excerpt', $news->excerpt) }}</textarea>
            @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="12" required>{{ old('content', $news->content) }}</textarea>
            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                <label class="form-check-label">Featured Article</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Changes</button>
    </form>
</div>
@endsection
