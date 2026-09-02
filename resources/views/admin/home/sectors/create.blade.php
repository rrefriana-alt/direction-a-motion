@extends('admin.layouts.app')
@section('title', 'Add Sector')
@section('page-title', 'Add Sector')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.sectors.index') }}">Sectors</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Add Sector</h2>
        <p>Create a new sector for the "Who we work with" section</p>
    </div>
    <a href="{{ route('admin.home.sectors.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.sectors.store') }}" method="POST" id="sectorForm">
            @csrf

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Heading (EN) <span style="color:var(--red-600)">*</span></label>
                    <input type="text" class="form-control @error('heading_en') is-invalid @enderror" name="heading_en" id="headingEnInput" value="{{ old('heading_en') }}" required placeholder="e.g. Finance & Banking">
                    @error('heading_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Heading (ID)</label>
                    <input type="text" class="form-control @error('heading_id') is-invalid @enderror" name="heading_id" id="headingIdInput" value="{{ old('heading_id') }}" placeholder="e.g. Keuangan — Perbankan">
                    @error('heading_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Clients <span style="color:var(--red-600)">*</span></label>
                <div id="itemsContainer">
                    <div class="item-row d-flex gap-1" style="margin-bottom:.35rem">
                        <input type="text" class="form-control item-input" name="items[]" value="" placeholder="Client name" style="flex:1">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)" style="flex-shrink:0"><i class="bi bi-x"></i></button>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" style="margin-top:.35rem" onclick="addItem()"><i class="bi bi-plus"></i> Add Client</button>
                <input type="hidden" name="items" id="itemsHidden">
                @error('items') <div style="font-size:.75rem;color:var(--red-600);margin-top:.25rem">{{ $message }}</div> @enderror
                @error('items.*') <div style="font-size:.75rem;color:var(--red-600);margin-top:.25rem">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home.sectors.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Sector</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.25rem">
            <div style="font-size:.95rem;font-weight:600;color:var(--gray-900);margin-bottom:.15rem" id="previewHeading">Sector Heading</div>
            <div style="font-size:.73rem;color:var(--gray-400);margin-bottom:.5rem;font-style:italic;display:none" id="previewHeadingId"></div>
            <div style="font-size:.72rem;color:var(--gray-500);margin-bottom:.75rem" id="previewCount">0 clients</div>
            <div class="d-flex gap-1" style="flex-wrap:wrap" id="previewItems"></div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">This is how it will appear on the homepage</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const headingEnInput = document.getElementById('headingEnInput');
    const headingIdInput = document.getElementById('headingIdInput');
    const previewHeading = document.getElementById('previewHeading');
    const previewHeadingId = document.getElementById('previewHeadingId');
    const previewCount = document.getElementById('previewCount');
    const previewItems = document.getElementById('previewItems');

    headingEnInput.addEventListener('input', () => { previewHeading.textContent = headingEnInput.value || 'Sector Heading'; });
    headingIdInput.addEventListener('input', () => {
        const val = headingIdInput.value;
        previewHeadingId.textContent = val;
        previewHeadingId.style.display = val ? 'block' : 'none';
    });

    function updatePreview() {
        const inputs = document.querySelectorAll('.item-input');
        const names = [];
        inputs.forEach(input => {
            if (input.value.trim()) names.push(input.value.trim());
        });
        previewCount.textContent = names.length + ' client' + (names.length !== 1 ? 's' : '');
        previewItems.innerHTML = names.map(n => '<span style="background:var(--gray-100);color:var(--gray-600);padding:.15rem .45rem;border-radius:4px;font-size:.65rem;font-weight:500">' + n + '</span>').join('');
    }

    window.addItem = function() {
        const container = document.getElementById('itemsContainer');
        const row = document.createElement('div');
        row.className = 'item-row d-flex gap-1';
        row.style.cssText = 'margin-bottom:.35rem';
        row.innerHTML = '<input type="text" class="form-control item-input" name="items[]" value="" placeholder="Client name" style="flex:1"><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)" style="flex-shrink:0"><i class="bi bi-x"></i></button>';
        container.appendChild(row);
        row.querySelector('input').addEventListener('input', updatePreview);
        row.querySelector('input').focus();
    };

    window.removeItem = function(btn) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            btn.closest('.item-row').remove();
            updatePreview();
        }
    };

    document.querySelectorAll('.item-input').forEach(input => {
        input.addEventListener('input', updatePreview);
    });
});
</script>
@endpush
