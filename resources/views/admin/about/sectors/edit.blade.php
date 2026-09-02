@extends('admin.layouts.app')
@section('title', 'Edit Sector')
@section('page-title', 'Edit Sector')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.sectors.index') }}">Sectors</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@push('styles')
<style>
    .fg{display:flex;flex-direction:column;gap:.25rem;margin-bottom:1rem;}
    .fg-label{font-size:.75rem;font-weight:600;color:var(--gray-700);}
    .fg-input{border:1px solid var(--gray-300);border-radius:var(--radius-md);padding:.5rem .75rem;font-size:.8rem;color:var(--gray-900);transition:all .2s;}
    .fg-input:focus{border-color:var(--green-500);box-shadow:0 0 0 3px rgba(16,185,129,.1);outline:none;}
    textarea.fg-input{resize:vertical;min-height:60px;}
    .fl-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .svc-toggle{position:relative;width:36px;height:20px;background:var(--gray-200);border-radius:10px;cursor:pointer;transition:background .2s;flex-shrink:0;}
    .svc-toggle.on{background:var(--green-500);}
    .svc-toggle::after{content:'';position:absolute;top:2px;left:2px;width:16px;height:16px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);}
    .svc-toggle.on::after{transform:translateX(16px);}
    .item-row{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-md);padding:1rem;margin-bottom:.75rem;position:relative;}
    .remove-item{position:absolute;top:.5rem;right:.5rem;cursor:pointer;color:var(--danger);font-size:1rem;}
    #alertContainer{position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;}
</style>
@endpush

@section('content')
<div id="alertContainer"></div>

<form action="{{ route('admin.about.sectors.update', $sector->id) }}" method="POST" id="sectorForm">
    @csrf
    @method('PUT')
    <div class="card mb-4">
        <div class="card-header">
            <h3 style="margin:0"><i class="bi bi-pencil"></i> Edit Sector</h3>
        </div>
        <div class="card-body">
            <div class="fl-2">
                <div class="fg">
                    <label class="fg-label">Heading EN <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="heading_en" class="fg-input" required value="{{ $sector->heading_en }}">
                </div>
                <div class="fg">
                    <label class="fg-label">Heading ID <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="heading_id" class="fg-input" required value="{{ $sector->heading_id }}">
                </div>
            </div>

            <div class="fl-2">
                <div class="fg">
                    <label class="fg-label">Sort Order</label>
                    <input type="number" name="sort_order" class="fg-input" min="0" value="{{ $sector->sort_order }}">
                </div>
                <div class="fg">
                    <label class="fg-label">Status</label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <div class="svc-toggle {{ $sector->is_active ? 'on' : '' }}" id="toggleStatus"></div>
                        <span style="font-size:.75rem;color:var(--gray-600)" id="statusText">{{ $sector->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <input type="hidden" name="is_active" value="{{ $sector->is_active ? '1' : '0' }}" id="statusInput">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 style="margin:0"><i class="bi bi-box-seam"></i> Sector Items ({{ $sector->items->count() ?? 0 }})</h3>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItemRow()">
                <i class="bi bi-plus"></i> Add Item
            </button>
        </div>
        <div class="card-body" id="itemsContainer">
            @if($sector->items && $sector->items->count())
                @foreach($sector->items as $idx => $item)
                <div class="item-row" data-item-id="{{ $item->id }}">
                    <input type="hidden" name="items[{{ $idx }}][id]" value="{{ $item->id }}">
                    <div class="fl-2">
                        <div class="fg">
                            <label class="fg-label">Item Name</label>
                            <input type="text" name="items[{{ $idx }}][item_name]" class="fg-input" value="{{ $item->item_name }}">
                        </div>
                        <div class="fg">
                            <label class="fg-label">Icon (Bootstrap)</label>
                            <input type="text" name="items[{{ $idx }}][icon]" class="fg-input" placeholder="bi-circle" value="{{ $item->icon ?? '' }}">
                        </div>
                    </div>
                    <div class="fg">
                        <label class="fg-label">Description</label>
                        <input type="text" name="items[{{ $idx }}][description]" class="fg-input" placeholder="Optional description..." value="{{ $item->description ?? '' }}">
                    </div>
                    <div class="fl-2">
                        <div class="fg">
                            <label class="fg-label">Sort Order</label>
                            <input type="number" name="items[{{ $idx }}][sort_order]" class="fg-input" min="0" value="{{ $item->sort_order }}">
                        </div>
                        <div class="fg">
                            <label class="fg-label">Status</label>
                            <div style="display:flex;align-items:center;gap:.5rem;">
                                <div class="svc-toggle {{ $item->is_active ? 'on' : '' }}"></div>
                                <span style="font-size:.75rem;color:var(--gray-600)">{{ $item->is_active ? 'Active' : 'Inactive' }}</span>
                            </div>
                            <input type="hidden" name="items[{{ $idx }}][is_active]" value="{{ $item->is_active ? '1' : '0' }}">
                        </div>
                    </div>
                    <button type="button" class="remove-item" onclick="removeItemRow(this)" title="Remove item">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                @endforeach
            @else
                <div class="svc-empty">
                    <i class="bi bi-inbox"></i>
                    <div>No items yet. Click "Add Item" to create one.</div>
                </div>
            @endif
        </div>
    </div>

    <div style="display:flex;gap:.75rem;justify-content:flex-end;">
        <a href="{{ route('admin.about.sectors.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Sector</button>
    </div>
</form>

<script>
let itemCount = {{ $sector->items->count() ?? 0 }};

function addItemRow() {
    const container = document.getElementById('itemsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'item-row';
    newRow.innerHTML = `
        <input type="hidden" name="items[${itemCount}][id]" value="">
        <div class="fl-2">
            <div class="fg">
                <label class="fg-label">Item Name</label>
                <input type="text" name="items[${itemCount}][item_name]" class="fg-input">
            </div>
            <div class="fg">
                <label class="fg-label">Icon (Bootstrap)</label>
                <input type="text" name="items[${itemCount}][icon]" class="fg-input" placeholder="bi-circle">
            </div>
        </div>
        <div class="fg">
            <label class="fg-label">Description</label>
            <input type="text" name="items[${itemCount}][description]" class="fg-input" placeholder="Optional description...">
        </div>
        <div class="fl-2">
            <div class="fg">
                <label class="fg-label">Sort Order</label>
                <input type="number" name="items[${itemCount}][sort_order]" class="fg-input" min="0">
            </div>
            <div class="fg">
                <label class="fg-label">Status</label>
                <div style="display:flex;align-items:center;gap:.5rem;">
                    <div class="svc-toggle on"></div>
                    <span style="font-size:.75rem;color:var(--gray-600)">Active</span>
                </div>
                <input type="hidden" name="items[${itemCount}][is_active]" value="1">
            </div>
        </div>
        <button type="button" class="remove-item" onclick="removeItemRow(this)" title="Remove item">
            <i class="bi bi-x-lg"></i>
        </button>
    `;
    container.appendChild(newRow);
    itemCount++;
}

function removeItemRow(btn) {
    btn.closest('.item-row').remove();
}

document.getElementById('toggleStatus').addEventListener('click', function() {
    this.classList.toggle('on');
    const isActive = this.classList.contains('on');
    document.getElementById('statusInput').value = isActive ? '1' : '0';
    document.getElementById('statusText').textContent = isActive ? 'Active' : 'Inactive';
});
</script>
@endsection
