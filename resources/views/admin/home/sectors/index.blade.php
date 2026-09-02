@extends('admin.layouts.app')
@section('title', 'Sectors')
@section('page-title', 'Sectors')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Sectors</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Sectors</h2>
        <p>Manage the "Who we work with" section on the homepage</p>
    </div>
    <a href="{{ route('admin.home.sectors.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Sector</a>
</div>

@if($sectors->count() > 0)
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1rem">
    @foreach($sectors as $sector)
    <div class="card-white" style="padding:0;overflow:hidden;position:relative">
        <div style="padding:1.25rem">
            <div class="d-flex justify-content-between align-items-start" style="margin-bottom:.5rem">
                <div style="font-size:.65rem;font-weight:700;color:var(--green-600);letter-spacing:.05em">{{ str_pad($sector->sort_order, 2, '0', STR_PAD_LEFT) }}</div>
                @if(!$sector->is_active)
                    <span class="badge-inactive" style="font-size:.6rem">Inactive</span>
                @endif
            </div>
            <div style="font-size:.95rem;font-weight:600;color:var(--gray-900);margin-bottom:.15rem">{{ $sector->heading_en }}</div>
            @if($sector->heading_id && $sector->heading_id !== $sector->heading_en)
                <div style="font-size:.73rem;color:var(--gray-400);margin-bottom:.5rem;font-style:italic">{{ $sector->heading_id }}</div>
            @endif
            <div style="font-size:.72rem;color:var(--gray-500);margin-bottom:.75rem">{{ $sector->items_count }} client{{ $sector->items_count !== 1 ? 's' : '' }}</div>
            @if($sector->items->count() > 0)
            <div class="d-flex gap-1" style="flex-wrap:wrap;margin-bottom:1rem">
                @foreach($sector->items->take(6) as $item)
                    <span style="background:var(--gray-100);color:var(--gray-600);padding:.15rem .45rem;border-radius:4px;font-size:.65rem;font-weight:500">{{ $item->name }}</span>
                @endforeach
                @if($sector->items->count() > 6)
                    <span style="background:var(--gray-100);color:var(--gray-500);padding:.15rem .45rem;border-radius:4px;font-size:.65rem">+{{ $sector->items->count() - 6 }}</span>
                @endif
            </div>
            @endif
            <div class="d-flex gap-1">
                <a href="{{ route('admin.home.sectors.edit', $sector->id) }}" class="btn btn-secondary btn-sm" style="flex:1;text-align:center"><i class="bi bi-pencil"></i> Edit</a>
                <form action="{{ route('admin.home.sectors.destroy', $sector->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this sector and all its clients?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card-white">
    <div class="empty-state">
        <i class="bi bi-diagram-3"></i>
        <p>No sectors yet</p>
        <a href="{{ route('admin.home.sectors.create') }}" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Add Sector</a>
    </div>
</div>
@endif
@endsection
