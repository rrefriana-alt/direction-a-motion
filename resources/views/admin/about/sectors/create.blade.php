@extends('admin.layouts.app')
@section('title', 'Add Sector')
@section('page-title', 'Add Sector')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.sectors.index') }}">Sectors</a></li>
    <li class="breadcrumb-item active">Add New</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Add Sector</h2>
        <p>Create a new sector with items for the About page.</p>
    </div>
    <a href="{{ route('admin.about.sectors.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<form action="{{ route('admin.about.sectors.store') }}" method="POST" id="sectorForm">
    @csrf

    <div class="card-white" style="max-width:720px">
        <div class="form-section-title">Sector Info</div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Heading (EN) <span class="required">*</span></label>
                    <input type="text" name="heading_en" class="form-control @error('heading_en') is-invalid @enderror" value="{{ old('heading_en') }}" required placeholder="e.g. Technology & Innovation">
                    @error('heading_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Heading (ID) <span class="required">*</span></label>
                    <input type="text" name="heading_id" class="form-control @error('heading_id') is-invalid @enderror" value="{{ old('heading_id') }}" required placeholder="e.g. Teknologi & Inovasi">
                    @error('heading_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div style="display:flex;align-items:center;gap:.5rem;padding-top:.35rem">
                        <div class="svc-toggle on" id="toggleStatus"></div>
                        <span style="font-size:.78rem;color:var(--gray-600)">Active</span>
                    </div>
                    <input type="hidden" name="is_active" value="1" id="statusInput">
                </div>
            </div>
        </div>
    </div>

    <div class="card-white" style="max-width:720px">
        <div class="d-flex justify-content-between align-items-center" style="margin-bottom:1rem;padding-bottom:.75rem;border-bottom:1px solid var(--gray-100)">
            <div class="form-section-title" style="margin:0;border:none;padding:0">Sector Items</div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="addItemRow()"><i class="bi bi-plus-lg"></i> Add Item</button>
        </div>

        <div id="itemsContainer">
            <div class="item-row" id="item-template" style="display:none">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" name="items[__INDEX__][name]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Icon</label>
                            <input type="text" name="items[__INDEX__][icon]" class="form-control" placeholder="bi-circle">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Order</label>
                            <input type="number" name="items[__INDEX__][sort_order]" class="form-control" min="0" value="0">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <input type="text" name="items[__INDEX__][description]" class="form-control" placeholder="Optional description">
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div style="display:flex;align-items:center;gap:.5rem">
                        <div class="svc-toggle on" data-idx="__INDEX__"></div>
                        <span style="font-size:.78rem;color:var(--gray-600)">Active</span>
                    </div>
                    <input type="hidden" name="items[__INDEX__][is_active]" value="1">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeItemRow(this)"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-white" style="max-width:720px">
        <div class="form-actions" style="margin:0;padding:0;border:none">
            <a href="{{ route('admin.about.sectors.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Sector</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
var itemCount = 0;

function addItemRow() {
    var template = document.getElementById('item-template');
    var clone = template.cloneNode(true);
    clone.id = 'item-' + itemCount;
    clone.style.display = '';
    clone.querySelectorAll('[name]').forEach(function(el) {
        el.name = el.name.replace('__INDEX__', itemCount);
    });
    var toggle = clone.querySelector('.svc-toggle');
    toggle.dataset.idx = itemCount;
    toggle.classList.add('on');
    toggle.addEventListener('click', function() {
        this.classList.toggle('on');
        var input = this.parentElement.nextElementSibling;
        input.value = this.classList.contains('on') ? '1' : '0';
    });
    clone.querySelector('.btn-danger').setAttribute('onclick', 'removeItemRow(this)');
    document.getElementById('itemsContainer').appendChild(clone);
    itemCount++;
}

function removeItemRow(btn) {
    btn.closest('.item-row').remove();
}

document.getElementById('toggleStatus').addEventListener('click', function() {
    this.classList.toggle('on');
    var isActive = this.classList.contains('on');
    document.getElementById('statusInput').value = isActive ? '1' : '0';
    this.nextElementSibling.textContent = isActive ? 'Active' : 'Inactive';
});
</script>
@endpush
