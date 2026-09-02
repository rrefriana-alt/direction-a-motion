@extends('admin.layouts.app')
@section('title', 'Capabilities')
@section('page-title', 'Capabilities')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Capabilities</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Capabilities</h2>
        <p>Manage the capability cards displayed on the homepage</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.home.capabilities-header.edit') }}" class="btn btn-secondary btn-sm"><i class="bi bi-card-heading"></i> Section Header</a>
        <a href="{{ route('admin.home.capabilities.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Capability</a>
    </div>
</div>

@if($capabilities->count() > 0)
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1rem">
    @foreach($capabilities as $cap)
    <div class="card-white" style="padding:0;overflow:hidden;position:relative">
        <div style="height:140px;background:var(--gray-900);overflow:hidden;display:flex;align-items:center;justify-content:center">
            @if($cap->image)
                <img src="{{ asset('img/' . $cap->image) }}" alt="{{ $cap->title }}" style="width:100%;height:100%;object-fit:cover">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--gray-600)">
                    <i class="bi bi-image" style="font-size:1.5rem"></i>
                </div>
            @endif
        </div>
        <div style="padding:1rem">
            <div class="d-flex justify-content-between align-items-start" style="margin-bottom:.5rem">
                <div style="font-size:.65rem;font-weight:700;color:var(--green-600);letter-spacing:.05em">{{ str_pad($cap->number, 2, '0', STR_PAD_LEFT) }}</div>
                @if(!$cap->is_active)
                    <span class="badge-inactive" style="font-size:.6rem">Inactive</span>
                @endif
            </div>
            <div style="font-size:.9rem;font-weight:600;color:var(--gray-900);margin-bottom:.25rem">{{ $cap->title }}</div>
            <div style="font-size:.73rem;color:var(--gray-500);margin-bottom:.75rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $cap->description }}</div>
            @if($cap->tags)
            <div class="d-flex gap-1" style="flex-wrap:wrap;margin-bottom:.75rem">
                @foreach(json_decode($cap->tags, true) ?? [] as $tag)
                    <span style="background:var(--gray-100);color:var(--gray-600);padding:.1rem .4rem;border-radius:4px;font-size:.6rem;font-weight:500">{{ $tag }}</span>
                @endforeach
            </div>
            @endif
            <div class="d-flex gap-1">
                <a href="{{ route('admin.home.capabilities.edit', $cap->id) }}" class="btn btn-secondary btn-sm" style="flex:1;text-align:center"><i class="bi bi-pencil"></i> Edit</a>
                <form action="{{ route('admin.home.capabilities.destroy', $cap->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this capability?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if(method_exists($capabilities, 'links') && $capabilities->hasPages())
<div style="margin-top:1.5rem">
    {{ $capabilities->links() }}
</div>
@endif
@else
<div class="card-white">
    <div class="empty-state">
        <i class="bi bi-layers"></i>
        <p>No capabilities yet</p>
        <a href="{{ route('admin.home.capabilities.create') }}" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Add Capability</a>
    </div>
</div>
@endif
@endsection
