@extends('admin.layout')

@section('title', 'Services')
@section('page-title', 'Services')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="d-flex align-center justify-between mb-4">
    <h2 class="mb-0 fs-4 fw-bold text-primary">Service Categories</h2>
    <button class="btn btn-accent" onclick="document.getElementById('addForm').classList.toggle('d-none')">
        <i class="bi bi-plus-lg"></i> Add Category
    </button>
</div>

<div class="row">
    <!-- List -->
    <div class="col-md-8">
        @forelse($categories as $category)
            <div class="card mb-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex gap-3 align-items-center">
                            @if($category->image)
                                <img src="{{ $category->image }}" alt="" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                            @else
                                <div style="width:60px;height:60px;background:var(--bg-input);border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--tx-muted)"><i class="bi bi-image"></i></div>
                            @endif
                            <h4 class="fw-bold mb-1" style="color:var(--tx-primary)">{{ $category->name }}</h4>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.services.edit', $category->id) }}" class="btn btn-sm btn-ghost">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <p class="text-secondary mb-3">{{ $category->description }}</p>
                    
                    @if($category->items->count() > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($category->items as $item)
                                <span class="badge badge-muted">{{ $item->title }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="bi bi-inboxes"></i></div>
                <h6>No Services Found</h6>
                <p>Click "Add Category" to create one.</p>
            </div>
        @endforelse
    </div>

    <!-- Create Form -->
    <div class="col-md-4 d-none" id="addForm">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0" style="color:var(--tx-primary)"><i class="bi bi-plus-circle"></i> New Category</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Panel Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <hr style="border-color:var(--border);margin:1.5rem 0;">
                    
                    <h6 class="fw-bold mb-3" style="color:var(--tx-primary)">Service Items (Tags)</h6>
                    <div id="itemsContainer">
                        <div class="item-row mb-2">
                            <input type="text" name="items_title[]" class="form-control form-control-sm mb-1" placeholder="Item Name (e.g. Logo Design)">
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-ghost btn-sm mb-4" onclick="addItemRow()">
                        <i class="bi bi-plus"></i> Add Item
                    </button>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-accent w-full justify-content-center">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function addItemRow() {
        const container = document.getElementById('itemsContainer');
        const row = document.createElement('div');
        row.className = 'item-row mb-2 d-flex gap-2';
        row.innerHTML = `
            <input type="text" name="items_title[]" class="form-control form-control-sm" placeholder="Item Name">
            <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
        `;
        container.appendChild(row);
    }
</script>
@endsection
