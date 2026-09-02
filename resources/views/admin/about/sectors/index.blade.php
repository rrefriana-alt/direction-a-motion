@extends('admin.layouts.app')
@section('title', 'Sector Management')
@section('page-title', 'Sector Management')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item active">Sectors</li>
@endsection

@push('styles')
<style>
    .sector-card{display:flex;flex-direction:column;background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);overflow:hidden;margin-bottom:1rem;transition:box-shadow .2s;}
    .sector-card:hover{box-shadow:var(--shadow-sm);}
    .sector-hdr{padding:1rem 1.25rem;display:flex;align-items:center;gap:.75rem;cursor:pointer;user-select:none;transition:background .15s;}
    .sector-hdr:hover{background:var(--gray-50);}
    .sector-body{padding:0 1.25rem 1.25rem;border-top:1px solid var(--gray-100);}
    .sector-num{font-family:var(--f-mono,monospace);font-size:1.1rem;font-weight:700;color:var(--green-500);width:32px;text-align:center;flex-shrink:0;}
    .sector-info{flex:1;min-width:0;}
    .sector-name{font-size:.9rem;font-weight:600;color:var(--gray-900);}
    .sector-desc{font-size:.75rem;color:var(--gray-500);margin-top:.125rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
    .sector-badge{display:inline-flex;align-items:center;font-size:.65rem;font-weight:600;padding:.15rem .5rem;border-radius:99px;line-height:1.2;}
    .sector-badge.on{background:var(--green-50);color:var(--green-700);}
    .sector-badge.off{background:var(--gray-100);color:var(--gray-400);}
    .sector-acts{display:flex;gap:.3rem;flex-shrink:0;}
    .svc-chevron{transition:transform .2s;font-size:.75rem;color:var(--gray-400);}
    .svc-chevron.open{transform:rotate(90deg);}
    .sector-item{padding:.5rem .75rem;background:#fff;border:1px solid var(--gray-100);border-radius:var(--radius-sm);margin-top:.5rem;display:flex;align-items:center;gap:.5rem;}
    .sector-item .item-name{font-size:.8rem;color:var(--gray-900);flex:1;}
    .sector-item .item-desc{font-size:.65rem;color:var(--gray-500);margin-top:.125rem;}
    .svc-toggle{position:relative;width:36px;height:20px;background:var(--gray-200);border-radius:10px;cursor:pointer;transition:background .2s;flex-shrink:0;}
    .svc-toggle.on{background:var(--green-500);}
    .svc-toggle::after{content:'';position:absolute;top:2px;left:2px;width:16px;height:16px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);}
    .svc-toggle.on::after{transform:translateX(16px);}
    .svc-empty{text-align:center;padding:2rem;color:var(--gray-500);font-size:.8rem;}
    #alertContainer{position:fixed;top:1rem;right:1rem;z-index:9999;display:flex;flex-direction:column;gap:.5rem;}
</style>
@endpush

@section('content')
<div id="alertContainer"></div>

<div x-data="sectorMgmt()" x-init="init()">

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2 style="margin:0">Sector Management</h2>
        <p style="margin:0;color:var(--gray-500);font-size:.8125rem">Manage sectors and their items for the About page.</p>
    </div>
    <a href="{{ route('admin.about.sectors.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Sector
    </a>
</div>

<div id="sectorsList">
    @foreach($sectors as $index => $sector)
    @include('admin.about.sectors._sector_card', ['sector' => $sector, 'index' => $index])
    @endforeach
</div>

@if($sectors->isEmpty())
<div class="card" style="text-align:center;padding:3rem">
    <i class="bi bi-layers" style="font-size:2rem;color:var(--gray-300)"></i>
    <div style="font-size:.9rem;font-weight:500;color:var(--gray-500);margin-top:.5rem">No sectors found</div>
    <div style="font-size:.8rem;color:var(--gray-400);margin-top:.25rem">Click <strong>"Add Sector"</strong> to create your first sector.</div>
</div>
@endif

</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/alpine/alpine.min.js') }}"></script>
<script>
function sectorMgmt() {
    return {
        init() {
            const container = document.getElementById('sectorsList');
            let dragSrcEl = null;

            const draggables = container.querySelectorAll('.sector-card');
            draggables.forEach((item, index) => {
                item.setAttribute('draggable', 'true');

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
                        let order = [];
                        container.childNodes.forEach((node, i) => {
                            if (node.nodeType === 1) {
                                const id = node.getAttribute('data-id');
                                order.push(id);
                            }
                        });

                        fetch('/admin/about/sectors/reorder', {
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
        }
    }
}

function toggleSector(id) {
    fetch('/admin/about/sectors/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function showAlert(type, msg) {
    const el = document.createElement('div');
    el.className = 'alert alert-' + type;
    el.style.cssText = 'border-radius:var(--radius-md);font-size:.8125rem;padding:.75rem 1rem;display:flex;align-items:center;gap:.5rem;min-width:280px;box-shadow:var(--shadow-sm);';
    if (type === 'success') { el.style.background = '#dcfce7'; el.style.color = '#166534'; }
    else { el.style.background = '#fef2f2'; el.style.color = '#991b1b'; }
    el.innerHTML = '<i class="bi bi-' + (type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill') + '"></i> ' + msg;
    document.getElementById('alertContainer').appendChild(el);
    setTimeout(() => el.remove(), 4000);
}
</script>
@endpush
