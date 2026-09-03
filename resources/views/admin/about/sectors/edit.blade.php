@extends('admin.layouts.app')
@section('title', 'Edit Sector')
@section('page-title', 'Edit Sector')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.sectors.index') }}">Sectors</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit Sector</h2>
        <p>Update sector info and manage its items.</p>
    </div>
    <a href="{{ route('admin.about.sectors.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<form action="{{ route('admin.about.sectors.update', $sector->id) }}" method="POST" id="sectorForm">
    @csrf
    @method('PUT')

    <div class="card-white" style="max-width:720px">
        <div class="form-section-title">Sector Info</div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Heading (EN) <span class="required">*</span></label>
                    <input type="text" name="heading_en" class="form-control @error('heading_en') is-invalid @enderror" value="{{ old('heading_en', $sector->heading_en) }}" required>
                    @error('heading_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Heading (ID) <span class="required">*</span></label>
                    <input type="text" name="heading_id" class="form-control @error('heading_id') is-invalid @enderror" value="{{ old('heading_id', $sector->heading_id) }}" required>
                    @error('heading_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $sector->sort_order) }}" min="0">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div style="display:flex;align-items:center;gap:.5rem;padding-top:.35rem">
                        <div class="svc-toggle {{ $sector->is_active ? 'on' : '' }}" id="toggleStatus"></div>
                        <span style="font-size:.78rem;color:var(--gray-600)" id="statusText">{{ $sector->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <input type="hidden" name="is_active" value="{{ $sector->is_active ? '1' : '0' }}" id="statusInput">
                </div>
            </div>
        </div>
    </div>

    <div class="card-white" style="max-width:720px">
        <div class="d-flex justify-content-between align-items-center" style="margin-bottom:1rem;padding-bottom:.75rem;border-bottom:1px solid var(--gray-100)">
            <div class="form-section-title" style="margin:0;border:none;padding:0">Sector Items ({{ $sector->items->count() ?? 0 }})</div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="addItemRow()"><i class="bi bi-plus-lg"></i> Add Item</button>
        </div>

        <div id="itemsContainer">
            @if($sector->items && $sector->items->count())
                @foreach($sector->items as $idx => $item)
                <div class="item-row" style="background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-md);padding:1rem;margin-bottom:.75rem;position:relative">
                    <input type="hidden" name="items[{{ $idx }}][id]" value="{{ $item->id }}">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input type="text" name="items[{{ $idx }}][name]" class="form-control" value="{{ $item->name }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Icon</label>
                                <input type="text" name="items[{{ $idx }}][icon]" class="form-control" placeholder="bi-circle" value="{{ $item->icon ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Order</label>
                                <input type="number" name="items[{{ $idx }}][sort_order]" class="form-control" min="0" value="{{ $item->sort_order }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <input type="text" name="items[{{ $idx }}][description]" class="form-control" placeholder="Optional description" value="{{ $item->description ?? '' }}">
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div style="display:flex;align-items:center;gap:.5rem">
                            <div class="svc-toggle {{ $item->is_active ? 'on' : '' }}" onclick="this.classList.toggle('on');this.parentElement.nextElementSibling.value=this.classList.contains('on')?'1':'0'"></div>
                            <span style="font-size:.78rem;color:var(--gray-600)">{{ $item->is_active ? 'Active' : 'Inactive' }}</span>
                        </div>
                        <input type="hidden" name="items[{{ $idx }}][is_active]" value="{{ $item->is_active ? '1' : '0' }}">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeItemRow(this)"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="card-white" style="max-width:720px">
        <div class="form-actions" style="margin:0;padding:0;border:none">
            <a href="{{ route('admin.about.sectors.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
var itemCount = {{ $sector->items->count() ?? 0 }};

function addItemRow() {
    var container = document.getElementById('itemsContainer');
    var html = '<div class="item-row" style="background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-md);padding:1rem;margin-bottom:.75rem;position:relative">'
        + '<input type="hidden" name="items[' + itemCount + '][id]" value="">'
        + '<div class="row g-3">'
        + '<div class="col-md-5"><div class="form-group"><label class="form-label">Name</label>'
        + '<input type="text" name="items[' + itemCount + '][name]" class="form-control"></div></div>'
        + '<div class="col-md-4"><div class="form-group"><label class="form-label">Icon</label>'
        + '<input type="text" name="items[' + itemCount + '][icon]" class="form-control" placeholder="bi-circle"></div></div>'
        + '<div class="col-md-3"><div class="form-group"><label class="form-label">Order</label>'
        + '<input type="number" name="items[' + itemCount + '][sort_order]" class="form-control" min="0" value="0"></div></div>'
        + '</div>'
        + '<div class="form-group"><label class="form-label">Description</label>'
        + '<input type="text" name="items[' + itemCount + '][description]" class="form-control" placeholder="Optional description"></div>'
        + '<div class="d-flex justify-content-between align-items-center">'
        + '<div style="display:flex;align-items:center;gap:.5rem">'
        + '<div class="svc-toggle on" onclick="this.classList.toggle(\'on\');this.parentElement.nextElementSibling.value=this.classList.contains(\'on\')?\'1\':\'0\'"></div>'
        + '<span style="font-size:.78rem;color:var(--gray-600)">Active</span></div>'
        + '<input type="hidden" name="items[' + itemCount + '][is_active]" value="1">'
        + '<button type="button" class="btn btn-danger btn-sm" onclick="removeItemRow(this)"><i class="bi bi-trash"></i></button>'
        + '</div></div>';
    container.insertAdjacentHTML('beforeend', html);
    itemCount++;
}

function removeItemRow(btn) {
    btn.closest('.item-row').remove();
}

document.getElementById('toggleStatus').addEventListener('click', function() {
    this.classList.toggle('on');
    var isActive = this.classList.contains('on');
    document.getElementById('statusInput').value = isActive ? '1' : '0';
    document.getElementById('statusText').textContent = isActive ? 'Active' : 'Inactive';
});
</script>
@endpush
