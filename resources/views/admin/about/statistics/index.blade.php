@extends('admin.layouts.app')
@section('title', 'Statistics Management')
@section('page-title', 'Statistics Management')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item active">Statistics</li>
@endsection

@push('styles')
<style>
    .stat-card{display:flex;align-items:center;gap:1rem;padding:1rem 1.25rem;background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);margin-bottom:.75rem;transition:box-shadow .2s;}
    .stat-card:hover{box-shadow:var(--shadow-sm);}
    .stat-num{font-family:var(--f-mono,monospace);font-size:1.1rem;font-weight:700;color:var(--green-500);width:32px;text-align:center;flex-shrink:0;}
    .stat-info{flex:1;min-width:0;}
    .stat-name{font-size:.9rem;font-weight:600;color:var(--gray-900);}
    .stat-value{font-size:.8rem;color:var(--gray-500);margin-top:.125rem;}
    .stat-suffix{font-size:.7rem;background:var(--gray-100);color:var(--gray-600);padding:.1rem .5rem;border-radius:var(--radius-sm);margin-left:.35rem;}
    .stat-label{font-size:.75rem;color:var(--gray-500);margin-top:.125rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    .stat-badge{display:inline-flex;align-items:center;font-size:.65rem;font-weight:600;padding:.15rem .5rem;border-radius:99px;line-height:1.2;}
    .stat-badge.on{background:var(--green-50);color:var(--green-700);}
    .stat-badge.off{background:var(--gray-100);color:var(--gray-400);}
    .stat-acts{display:flex;gap:.3rem;flex-shrink:0;}
    .svc-toggle{position:relative;width:36px;height:20px;background:var(--gray-200);border-radius:10px;cursor:pointer;transition:background .2s;flex-shrink:0;}
    .svc-toggle.on{background:var(--green-500);}
    .svc-toggle::after{content:'';position:absolute;top:2px;left:2px;width:16px;height:16px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);}
    .svc-toggle.on::after{transform:translateX(16px);}
    #alertContainer{position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;}
</style>
@endpush

@section('content')
<div id="alertContainer"></div>

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2 style="margin:0">Statistics Management</h2>
        <p style="margin:0;color:var(--gray-500);font-size:.8125rem">Manage statistics shown on the About page.</p>
    </div>
    <a href="{{ route('admin.about.statistics.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Statistic
    </a>
</div>

<div id="statsList">
    @foreach($stats as $stat)
    @include('admin.about.statistics._stat_card', ['stat' => $stat, 'index' => $loop->index])
    @endforeach
</div>

@if($stats->isEmpty())
<div class="card" style="text-align:center;padding:3rem">
    <i class="bi bi-layers" style="font-size:2rem;color:var(--gray-300)"></i>
    <div style="font-size:.9rem;font-weight:500;color:var(--gray-500);margin-top:.5rem">No statistics found</div>
    <div style="font-size:.8rem;color:var(--gray-400);margin-top:.25rem">Click <strong>"Add Statistic"</strong> to create your first statistic.</div>
</div>
@endif

@endsection

@push('scripts')
<script src="{{ asset('vendor/alpine/alpine.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('statsList');
    let dragSrcEl = null;

    const draggables = container.querySelectorAll('.stat-card');
    draggables.forEach((item, index) => {
        item.setAttribute('draggable', 'true');
        item.classList.add('draggable-item');

        item.addEventListener('dragstart', function(e) {
            dragSrcEl = this;
            this.classList.add('dragging');
            setTimeout(() => this.classList.add('hide'), 0);
            e.dataTransfer.effectAllowed = 'move';
        });

        item.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            return false;
        });

        item.addEventListener('dragenter', function(e) {
            this.classList.add('drag-over');
        });

        item.addEventListener('dragleave', function(e) {
            this.classList.remove('drag-over');
        });

        item.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('drag-over');
            if (this !== dragSrcEl) {
                const newIndex = Array.from(container.children).indexOf(this);
                const oldIndex = Array.from(container.children).indexOf(dragSrcEl);

                let order = [];
                container.childNodes.forEach((node, i) => {
                    if (node.nodeType === 1) {
                        const id = node.getAttribute('data-id');
                        order.push(id);
                    }
                });

                fetch('/admin/about/statistics/reorder', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', data.message);
                    } else {
                        showAlert('danger', data.message);
                    }
                })
                .catch(err => showAlert('danger', err.message));
            }
        });

        item.addEventListener('dragend', function(e) {
            this.classList.remove('dragging');
            this.classList.remove('hide');
        });
    });

    window.showAlert = function(type, msg) {
        const el = document.createElement('div');
        el.className = 'alert alert-' + type;
        el.style.cssText = 'border-radius:var(--radius-md);font-size:.8125rem;padding:.75rem 1rem;display:flex;align-items:center;gap:.5rem;min-width:280px;box-shadow:var(--shadow-sm);';
        if (type === 'success') { el.style.background = '#dcfce7'; el.style.color = '#166534'; }
        else { el.style.background = '#fef2f2'; el.style.color = '#991b1b'; }
        el.innerHTML = '<i class="bi bi-' + (type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill') + '"></i> ' + msg;
        document.getElementById('alertContainer').appendChild(el);
        setTimeout(() => el.remove(), 4000);
    };
});
</script>
@endpush
