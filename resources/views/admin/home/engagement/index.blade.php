@extends('admin.layouts.app')
@section('title', 'Engagement Models')
@section('page-title', 'Engagement Models')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
    <li class="breadcrumb-item active">Engagement Models</li>
@endsection

@push('styles')
<style>
    .eng-toggle{position:relative;width:36px;height:20px;background:var(--gray-200);border-radius:10px;cursor:pointer;transition:background .2s;flex-shrink:0;}
    .eng-toggle.on{background:var(--green-500);}
    .eng-toggle::after{content:'';position:absolute;top:2px;left:2px;width:16px;height:16px;background:#fff;border-radius:50%;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);}
    .eng-toggle.on::after{transform:translateX(16px);}
    .eng-letter{width:36px;height:36px;border-radius:50%;background:var(--green-50);color:var(--green-600);display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:700;}
</style>
@endpush

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Engagement Models</h2>
        <p>Manage the engagement models displayed on the services page</p>
    </div>
    <a href="{{ route('admin.services.engagement.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Model</a>
</div>

@if(session('success'))
    <div class="alert alert-success" style="border-radius:var(--radius-md);font-size:.8125rem;padding:.75rem 1rem;background:#dcfce7;color:#166534;display:flex;align-items:center;gap:.5rem;">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th style="width:50px">Order</th>
                    <th style="width:50px">Letter</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th style="width:80px">Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($engagements as $item)
                <tr id="eng-row-{{ $item->id }}">
                    <td style="color:var(--gray-500)">{{ $item->sort_order }}</td>
                    <td><div class="eng-letter">{{ $item->letter }}</div></td>
                    <td><span class="fw-600">{{ $item->title }}</span></td>
                    <td style="max-width:300px;color:var(--gray-500)">{{ Str::limit(strip_tags($item->description), 120) }}</td>
                    <td>
                        <div class="eng-toggle {{ $item->is_active ? 'on' : '' }}"
                             onclick="toggleEng({{ $item->id }}, this)"
                             title="Toggle active/inactive">
                        </div>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.services.engagement.edit', $item->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.services.engagement.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this model?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-handshake"></i>
                            <p>No engagement models found</p>
                            <a href="{{ route('admin.services.engagement.create') }}" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Add Model</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
async function toggleEng(id, el) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    el.style.opacity = '0.5';
    try {
        const res = await fetch('/admin/services/engagement/' + id + '/toggle-active', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
            el.classList.toggle('on', data.is_active);
        }
    } catch (e) {
        console.error(e);
    }
    el.style.opacity = '1';
}
</script>
@endpush
