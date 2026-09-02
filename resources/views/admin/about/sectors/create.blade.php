@extends('admin.layouts.app')
@section('title', 'Add Sector')
@section('page-title', 'Add Sector')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.sectors.index') }}">Sectors</a></li>
    <li class="breadcrumb-item active">Add New</li>
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
    .item-row{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-md);padding:1rem;margin-bottom:.75rem;}
    .remove-item{cursor:pointer;color:var(--danger);font-size:1rem;}
    #alertContainer{position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;}
</style>
@endpush

@section('content')
<div id="alertContainer"></div>

<form action="{{ route('admin.about.sectors.store') }}" method="POST" id="sectorForm">
    @csrf
    <div class="card mb-4">
        <div class="card-header">
            <h3 style="margin:0"><i class="bi bi-plus-circle"></i> New Sector</h3>
        </div>
        <div class="card-body">
            <div class="fl-2">
                <div class="fg">
                    <label class="fg-label">Heading EN <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="heading_en" class="fg-input" required placeholder="e.g. Technology & Innovation">
                </div>
                <div class="fg">
                    <label class="fg-label">Heading ID <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="heading_id" class="fg-input" required placeholder="e.g. Teknologi & Inovasi">
                </div>
            </div>

            <div class="fl-2">
                <div class="fg">
                    <label class="fg-label">Sort Order</label>
                    <input type="number" name="sort_order" class="fg-input" min="0">
                </div>
                <div class="fg">
                    <label class="fg-label">Status</label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <div class="svc-toggle on" id="toggleStatus"></div>
                        <span style="font-size:.75rem;color:var(--gray-600)">Active</span>
                    </div>
                    <input type="hidden" name="is_active" value="1" id="statusInput">
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 style="margin:0"><i class="bi bi-box-seam"></i> Sector Items</h3>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItemRow()">
                <i class="bi bi-plus"></i> Add Item
            </button>
        </div>
        <div class="card-body" id="itemsContainer">
            <div class="item-row" id="item-template" style="display:none;">
                <div class="fl-2">
                    <div class="fg">
                        <label class="fg-label">Item Name</label>
                        <input type="text" name="items[__INDEX__][item_name]" class="fg-input">
                    </div>
                    <div class="fg">
                        <label class="fg-label">Icon (Bootstrap)</label>
                        <input type="text" name="items[__INDEX__][icon]" class="fg-input" placeholder="bi-circle">
                    </div>
                </div>
                <div class="fg">
                    <label class="fg-label">Description</label>
                    <input type="text" name="items[__INDEX__][description]" class="fg-input" placeholder="Optional description...">
                </div>
                <div class="fl-2">
                    <div class="fg">
                        <label class="fg-label">Sort Order</label>
                        <input type="number" name="items[__INDEX__][sort_order]" class="fg-input" min="0">
                    </div>
                    <div class="fg">
                        <label class="fg-label">Status</label>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <div class="svc-toggle on" id="item-toggle-__INDEX__"></div>
                            <span style="font-size:.75rem;color:var(--gray-600)">Active</span>
                        </div>
                        <input type="hidden" name="items[__INDEX__][is_active]" value="1" id="item-status-__INDEX__">
                    </div>
                </div>
                <button type="button" class="remove-item" onclick="removeItemRow(this)" title="Remove item">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
    </div>

    <div style="display:flex;gap:.75rem;justify-content:flex-end;">
        <a href="{{ route('admin.about.sectors.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Sector</button>
    </div>
</form>

<script>
let itemCount = 0;

function addItemRow() {
    const template = document.getElementById('item-template');
    const clone = template.cloneNode(true);
    clone.id = 'item-' + itemCount;
    clone.style.display = '';
    clone.setAttribute('data-index', itemCount);

    const elements = clone.querySelectorAll('[name]');
    elements.forEach(el => {
        el.name = el.name.replace('__INDEX__', itemCount);
    });

    const toggle = clone.querySelector('#item-toggle-__INDEX__');
    toggle.id = 'item-toggle-' + itemCount;
    toggle.addEventListener('click', function() {
        this.classList.toggle('on');
        const isActive = this.classList.contains('on');
        const statusInput = clone.querySelector('#item-status-__INDEX__');
        statusInput.id = 'item-status-' + itemCount;
        statusInput.value = isActive ? '1' : '0';
    });

    const statusText = clone.querySelectorAll('span');
    statusText.forEach(span => {
        if (span.textContent === 'Active') {
            span.id = 'item-status-text-' + itemCount;
        }
    });

    const removeBtn = clone.querySelector('.remove-item');
    removeBtn.setAttribute('onclick', 'removeItemRow(this)');

    document.getElementById('itemsContainer').appendChild(clone);
    itemCount++;
}

function removeItemRow(btn) {
    btn.closest('.item-row').remove();
}

document.getElementById('toggleStatus').addEventListener('click', function() {
    this.classList.toggle('on');
    const isActive = this.classList.contains('on');
    document.getElementById('statusInput').value = isActive ? '1' : '0';
});
</script>
@endsection
