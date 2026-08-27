@extends('admin.layout')

@section('title', 'Services')
@section('page-title', 'Services')

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

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="mb-0 fs-4 fw-bold">Service Categories</h2>
    </div>
    <div class="col-auto d-md-none">
        <button class="btn btn-accent" data-bs-toggle="collapse" data-bs-target="#addCategoryForm" aria-expanded="false" aria-controls="addCategoryForm">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </button>
    </div>
</div>

<div class="row">
    <!-- LEFT: List of existing categories -->
    <div class="col-md-8">
        @forelse($categories as $category)
            <div class="card card-modern mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h4 class="fw-bold mb-1">{{ $category->name }}</h4>
                        
                        <form action="{{ route('admin.services.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                    
                    @if($category->description)
                        <p class="text-secondary mb-3">{{ $category->description }}</p>
                    @endif
                    
                    <hr class="text-muted opacity-25 my-3">
                    
                    <h6 class="fw-semibold mb-3 text-dark">Sub-Services</h6>
                    
                    @if($category->items->count() > 0)
                        <div class="list-group list-group-flush border-0">
                            @foreach($category->items as $item)
                                <div class="list-group-item px-0 py-2 border-0 d-flex flex-column">
                                    <div class="fw-medium text-dark d-flex align-items-center mb-1">
                                        <i class="bi bi-check-circle-fill text-success me-2 small"></i>
                                        {{ $item->title }}
                                    </div>
                                    @if($item->description)
                                        <div class="text-secondary small ms-4">{{ $item->description }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small fst-italic mb-0">No sub-services found.</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state text-center py-5 bg-white rounded-3 border">
                <i class="bi bi-grid-3x3-gap text-muted fs-1 mb-3 d-block"></i>
                <h5 class="fw-semibold">No categories yet</h5>
                <p class="text-secondary mb-0">Create your first service category to get started.</p>
            </div>
        @endforelse
    </div>

    <!-- RIGHT: Add New Category Form -->
    <div class="col-md-4">
        <div class="collapse d-md-block" id="addCategoryForm">
            <div class="card card-modern sticky-top" style="top: 20px; z-index: 10;">
                <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4">
                    <h5 class="fw-bold mb-0">Add New Category</h5>
                </div>
                <div class="card-body p-4 pt-3">
                    <form action="{{ route('admin.services.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label form-label-modern fw-medium">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-modern" id="name" name="name" required placeholder="e.g. Video Production">
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label form-label-modern fw-medium">Description</label>
                            <textarea class="form-control form-control-modern" id="description" name="description" rows="3" placeholder="Brief overview of this category"></textarea>
                        </div>
                        
                        <hr class="text-muted opacity-25 my-4">
                        
                        <h6 class="fw-bold mb-3">Sub-Services</h6>
                        <p class="text-secondary small mb-3">Add up to 4 sub-services for this category.</p>
                        
                        @for($i = 0; $i < 4; $i++)
                            <div class="bg-light p-3 rounded-3 mb-3 border">
                                <div class="mb-2">
                                    <label for="items_title_{{ $i }}" class="form-label form-label-modern fw-medium small mb-1">Service {{ $i + 1 }} Title</label>
                                    <input type="text" class="form-control form-control-modern form-control-sm" id="items_title_{{ $i }}" name="items_title[]" placeholder="Title">
                                </div>
                                <div>
                                    <label for="items_desc_{{ $i }}" class="form-label form-label-modern fw-medium small mb-1">Service {{ $i + 1 }} Description</label>
                                    <input type="text" class="form-control form-control-modern form-control-sm" id="items_desc_{{ $i }}" name="items_desc[]" placeholder="Description">
                                </div>
                            </div>
                        @endfor
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-accent py-2 fw-semibold">
                                <i class="bi bi-check-lg me-1"></i> Save Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
