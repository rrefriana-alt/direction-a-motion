@extends('admin.layout')

@section('title', 'Edit Service')
@section('page-title', 'Edit Service')

@section('content')

<div class="d-flex align-center gap-3 mb-4">
    <a href="{{ route('admin.services.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    <h2 class="mb-0 fs-4 fw-bold text-primary">Edit Category</h2>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Panel Image</label>
                @if($service->image)
                    <div class="mb-2">
                        <img src="{{ $service->image }}" style="height:80px;border-radius:8px;object-fit:cover;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            
            <div class="form-group mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ $service->description }}</textarea>
            </div>

            <hr style="border-color:var(--border);margin:1.5rem 0;">
            
            <h6 class="fw-bold mb-3" style="color:var(--tx-primary)">Service Items (Tags)</h6>
            <div id="itemsContainer">
                @foreach($service->items as $item)
                    <div class="item-row mb-2 d-flex gap-2">
                        <input type="text" name="items_title[]" class="form-control form-control-sm" value="{{ $item->title }}" placeholder="Item Name">
                        <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()"><i class="bi bi-x"></i></button>
                    </div>
                @endforeach
                @if($service->items->count() == 0)
                    <div class="item-row mb-2">
                        <input type="text" name="items_title[]" class="form-control form-control-sm mb-1" placeholder="Item Name">
                    </div>
                @endif
            </div>
            
            <button type="button" class="btn btn-ghost btn-sm mb-4" onclick="addItemRow()">
                <i class="bi bi-plus"></i> Add Item
            </button>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.services.index') }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-accent"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
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
