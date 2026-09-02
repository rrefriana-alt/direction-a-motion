@extends('admin.layouts.app')
@section('title', 'Big Marquee')
@section('page-title', 'Big Marquee')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Big Marquee</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Big Marquee</h2>
        <p>Manage the scrolling text on the homepage</p>
    </div>
    <a href="{{ route('admin.home.marquee.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Item</a>
</div>

@if($marqueeItems->count())
<div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.5rem">
    @foreach($marqueeItems as $item)
    <div style="background:var(--gray-50);border:1px solid var(--gray-100);border-radius:var(--radius-md);padding:.75rem 1rem;display:flex;align-items:center;gap:.75rem;min-width:200px;flex:1;max-width:300px">
        <div style="flex:1;min-width:0">
            <div style="font-size:.82rem;font-weight:600;color:var(--gray-900);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $item->text }}</div>
            <div style="font-size:.7rem;color:var(--gray-400);margin-top:.15rem">
                Order: {{ $item->sort_order }} ·
                @if($item->is_active)
                    <span style="color:var(--green-600)">Active</span>
                @else
                    <span style="color:var(--gray-400)">Inactive</span>
                @endif
            </div>
        </div>
        <div style="display:flex;gap:.25rem;flex-shrink:0">
            <a href="{{ route('admin.home.marquee.edit', $item->id) }}" class="btn btn-secondary btn-sm" style="padding:.25rem .5rem"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.home.marquee.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this item?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" style="padding:.25rem .5rem"><i class="bi bi-trash"></i></button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card-white" style="padding:3rem;text-align:center">
    <i class="bi bi-type" style="font-size:2rem;color:var(--gray-300)"></i>
    <p style="color:var(--gray-500);margin-top:.5rem">No marquee items yet</p>
    <a href="{{ route('admin.home.marquee.create') }}" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Add First Item</a>
</div>
@endif
@endsection
