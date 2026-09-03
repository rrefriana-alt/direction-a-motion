@extends('admin.layouts.app')
@section('title', 'Sectors')
@section('page-title', 'Sectors')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item active">Sectors</li>
@endsection

@push('styles')
<style>
    .svc-list{display:flex;flex-direction:column;gap:0}
    .svc-card{display:flex;align-items:center;gap:1rem;padding:1rem 1.25rem;background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);transition:all .2s;cursor:grab}
    .svc-card:hover{box-shadow:var(--shadow-sm);border-color:var(--gray-300)}
    .svc-card.dragging{opacity:.5;border-style:dashed}
    .svc-card.drag-over{border-color:var(--green-500);box-shadow:0 0 0 2px rgba(16,185,129,.15)}
    .svc-num{font-family:'Inter',monospace;font-size:1.1rem;font-weight:700;color:var(--green-500);width:28px;text-align:center;flex-shrink:0}
    .svc-info{flex:1;min-width:0}
    .svc-label{font-size:.9rem;font-weight:600;color:var(--gray-900)}
    .svc-meta{display:flex;align-items:center;gap:.5rem;margin-top:.2rem;flex-wrap:wrap}
    .svc-badge{font-size:.7rem;font-weight:600;padding:.15rem .5rem;border-radius:50rem;line-height:1.2}
    .svc-badge--val{background:var(--green-50);color:var(--green-700)}
    .svc-badge--sfx{background:var(--gray-100);color:var(--gray-600)}
    .svc-badge--off{background:var(--gray-100);color:var(--gray-400)}
    .svc-acts{display:flex;align-items:center;gap:.35rem;flex-shrink:0}
    .drag-handle{color:var(--gray-300);cursor:grab;font-size:1rem;padding:.25rem}
    .drag-handle:hover{color:var(--gray-500)}
</style>
@endpush

@section('content')
<div id="alertContainer"></div>

<div x-data="{ expanded: [] }">

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Sectors</h2>
        <p>Manage sectors and their items for the About page.</p>
    </div>
    <a href="{{ route('admin.about.sectors.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Sector</a>
</div>

@if($sectors->isEmpty())
<div class="empty-state">
    <i class="bi bi-tag"></i>
    <p>No sectors yet. Click "Add Sector" to create your first one.</p>
</div>
@else
<div class="svc-list" id="sectorsList">
    @foreach($sectors as $index => $sector)
    @include('admin.about.sectors._sector_card', ['sector' => $sector, 'index' => $index])
    @endforeach
</div>
@endif

</div>
@endsection

@push('scripts')
<script>
function toggle(id) {
    var idx = Alpine.store('x').expanded.indexOf(id);
    if (idx > -1) Alpine.store('x').expanded.splice(idx, 1);
    else Alpine.store('x').expanded.push(id);
}

document.addEventListener('DOMContentLoaded', function() {
    var container = document.getElementById('sectorsList');
    if (!container) return;

    container.querySelectorAll('.svc-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            fetch(this.dataset.toggleUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            }).then(function(r) { return r.json(); }).then(function(data) {
                if (data.success) location.reload();
            });
        });
    });

    var dragSrc = null;
    container.querySelectorAll('.svc-card').forEach(function(card) {
        card.setAttribute('draggable', 'true');

        card.addEventListener('dragstart', function(e) {
            dragSrc = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        });

        card.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        });

        card.addEventListener('dragenter', function(e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });

        card.addEventListener('dragleave', function() {
            this.classList.remove('drag-over');
        });

        card.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            if (this === dragSrc) return;
            container.insertBefore(dragSrc, this);
            saveOrder();
        });

        card.addEventListener('dragend', function() {
            this.classList.remove('dragging');
            container.querySelectorAll('.svc-card').forEach(function(c) { c.classList.remove('drag-over'); });
        });
    });

    function saveOrder() {
        var ids = [];
        container.querySelectorAll('.svc-card').forEach(function(c) { ids.push(c.dataset.id); });
        fetch('{{ route("admin.about.sectors.reorder") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ order: ids })
        }).then(function(r) { return r.json(); }).then(function(d) {
            if (d.success) showToast('success', d.message);
            else showToast('danger', d.message);
        }).catch(function(e) { showToast('danger', e.message); });
    }

    window.showToast = function(type, msg) {
        var el = document.createElement('div');
        el.className = 'alert alert-' + type;
        el.style.cssText = 'border-radius:var(--radius-md);font-size:.8rem;padding:.6rem 1rem;display:flex;align-items:center;gap:.5rem;min-width:260px;box-shadow:var(--shadow-sm);';
        if (type === 'success') { el.style.background = '#dcfce7'; el.style.color = '#166534'; }
        else { el.style.background = '#fef2f2'; el.style.color = '#991b1b'; }
        el.innerHTML = '<i class="bi bi-' + (type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill') + '"></i> ' + msg;
        document.getElementById('alertContainer').appendChild(el);
        setTimeout(function() { el.remove(); }, 4000);
    };
});
</script>
@endpush
