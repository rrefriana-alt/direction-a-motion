@extends('admin.layout')

@section('title', 'Edit Article')
@section('page-title', 'Edit Article')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-modern">
        <div class="card-body">
            <form action="{{ route('admin.news.update', $news->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label form-label-modern">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-modern" id="title" name="title" value="{{ old('title', $news->title) }}" required>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="category" class="form-label form-label-modern">Category</label>
                        <select class="form-control form-control-modern" id="category" name="category">
                            <option value="General" {{ old('category', $news->category) == 'General' ? 'selected' : '' }}>General</option>
                            <option value="Company" {{ old('category', $news->category) == 'Company' ? 'selected' : '' }}>Company</option>
                            <option value="Industry" {{ old('category', $news->category) == 'Industry' ? 'selected' : '' }}>Industry</option>
                            <option value="Technology" {{ old('category', $news->category) == 'Technology' ? 'selected' : '' }}>Technology</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="author" class="form-label form-label-modern">Author</label>
                        <input type="text" class="form-control form-control-modern" id="author" name="author" value="{{ old('author', $news->author) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label form-label-modern">Status</label>
                        <select class="form-control form-control-modern" id="status" name="status">
                            <option value="Draft" {{ old('status', $news->status) == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Published" {{ old('status', $news->status) == 'Published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="body" class="form-label form-label-modern">Body</label>
                    <textarea class="form-control form-control-modern" id="body" name="body" rows="6">{{ old('body', $news->body) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.news.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-accent">Update Article</button>
                </div>
            </form>
        </div>
    </div>
@endsection
