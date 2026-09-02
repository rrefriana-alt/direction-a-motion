@extends('admin.layouts.app')
@section('title', 'Edit Statistic')
@section('page-title', 'Edit Statistic')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.statistics.index') }}">Statistics</a></li>
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
    #alertContainer{position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;}
</style>
@endpush

@section('content')
<div id="alertContainer"></div>

<form action="{{ route('admin.about.statistics.update', $stat->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-header">
            <h3 style="margin:0"><i class="bi bi-pencil"></i> Edit Statistic</h3>
        </div>
        <div class="card-body">
            <div class="fl-2">
                <div class="fg">
                    <label class="fg-label">Value <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="value" class="fg-input" required value="{{ $stat->value }}">
                </div>
                <div class="fg">
                    <label class="fg-label">Suffix</label>
                    <input type="text" name="suffix" class="fg-input" value="{{ $stat->suffix ?? '' }}">
                </div>
            </div>

            <div class="fg">
                <label class="fg-label">Label <span style="color:var(--danger)">*</span></label>
                <input type="text" name="label" class="fg-input" required value="{{ $stat->label }}">
            </div>

            <div class="fl-2">
                <div class="fg">
                    <label class="fg-label">Sort Order</label>
                    <input type="number" name="sort_order" class="fg-input" min="0" value="{{ $stat->sort_order }}">
                </div>
                <div class="fg">
                    <label class="fg-label">Status</label>
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <div class="svc-toggle {{ $stat->is_active ? 'on' : '' }}" id="toggleStatus"></div>
                        <span style="font-size:.75rem;color:var(--gray-600)" id="statusText">{{ $stat->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <input type="hidden" name="is_active" value="{{ $stat->is_active ? '1' : '0' }}" id="statusInput">
                </div>
            </div>
        </div>
    </div>

    <div style="display:flex;gap:.75rem;margin-top:1.25rem;justify-content:flex-end;">
        <a href="{{ route('admin.about.statistics.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Statistic</button>
    </div>
</form>

<script>
document.getElementById('toggleStatus').addEventListener('click', function() {
    this.classList.toggle('on');
    const isActive = this.classList.contains('on');
    document.getElementById('statusInput').value = isActive ? '1' : '0';
    document.getElementById('statusText').textContent = isActive ? 'Active' : 'Inactive';
});
</script>
@endsection
