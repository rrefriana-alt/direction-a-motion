@extends('admin.layouts.app')
@section('title', 'Process Steps')
@section('page-title', 'Process Steps')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Process Steps</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Process Steps</h2>
        <p>Manage the "How we work" step-by-step section</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.home.process-header.edit') }}" class="btn btn-secondary btn-sm"><i class="bi bi-card-heading"></i> Section Header</a>
        <a href="{{ route('admin.home.process.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Step</a>
    </div>
</div>

@if($steps->count() > 0)
<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1rem">
    @foreach($steps as $step)
    <div class="card-white" style="padding:0;overflow:hidden;position:relative">
        <div style="padding:1.25rem">
            <div class="d-flex justify-content-between align-items-start" style="margin-bottom:.5rem">
                <div style="font-size:1.5rem;font-weight:800;color:var(--green-600);line-height:1">{{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}</div>
                @if(!$step->is_active)
                    <span class="badge-inactive" style="font-size:.6rem">Inactive</span>
                @endif
            </div>
            <div style="font-size:.95rem;font-weight:600;color:var(--gray-900);margin-bottom:.15rem">{{ $step->title_en }}</div>
            @if($step->title_id && $step->title_id !== $step->title_en)
                <div style="font-size:.73rem;color:var(--gray-400);margin-bottom:.5rem;font-style:italic">{{ $step->title_id }}</div>
            @endif
            <div style="font-size:.73rem;color:var(--gray-500);margin-bottom:1rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">{{ $step->description_en }}</div>
            <div class="d-flex gap-1">
                <a href="{{ route('admin.home.process.edit', $step->id) }}" class="btn btn-secondary btn-sm" style="flex:1;text-align:center"><i class="bi bi-pencil"></i> Edit</a>
                <form action="{{ route('admin.home.process.destroy', $step->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this step?')">
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
        <i class="bi bi-list-ol"></i>
        <p>No process steps yet</p>
        <a href="{{ route('admin.home.process.create') }}" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Add Step</a>
    </div>
</div>
@endif
@endsection
