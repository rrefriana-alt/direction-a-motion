@extends('admin.layout')

@section('title', 'Add Project')
@section('page-title', 'Add Project')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Projects
        </a>
    </div>
</div>

<div class="card card-modern">
    <div class="card-body">
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="title" class="form-label-modern">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-modern @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="client" class="form-label-modern">Client</label>
                    <input type="text" class="form-control form-control-modern @error('client') is-invalid @enderror" id="client" name="client" value="{{ old('client') }}">
                    @error('client')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="category" class="form-label-modern">Category</label>
                    <input type="text" class="form-control form-control-modern @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category') }}">
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="year" class="form-label-modern">Year</label>
                    <input type="text" class="form-control form-control-modern @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year') }}">
                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="hero_image" class="form-label-modern">Hero Image</label>
                <input type="file" class="form-control form-control-modern @error('hero_image') is-invalid @enderror" id="hero_image" name="hero_image" accept="image/*">
                @error('hero_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="challenge" class="form-label-modern">Challenge</label>
                <textarea class="form-control form-control-modern @error('challenge') is-invalid @enderror" id="challenge" name="challenge" rows="4">{{ old('challenge') }}</textarea>
                @error('challenge')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="solution" class="form-label-modern">Solution</label>
                <textarea class="form-control form-control-modern @error('solution') is-invalid @enderror" id="solution" name="solution" rows="4">{{ old('solution') }}</textarea>
                @error('solution')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="result" class="form-label-modern">Result</label>
                <textarea class="form-control form-control-modern @error('result') is-invalid @enderror" id="result" name="result" rows="4">{{ old('result') }}</textarea>
                @error('result')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-accent">
                    <i class="bi bi-save me-2"></i>Save Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
