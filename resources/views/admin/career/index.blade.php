@extends('admin.layouts.app')
@section('title', 'Career')
@section('page-title', 'Career')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Career</li>
@endsection

@section('content')
<div class="page-header">
    <h2>Career</h2>
    <p>Manage job applications, positions, and the career page hero section.</p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1rem">
    <a href="{{ route('admin.career.applications.index') }}" class="list-card">
        <div class="list-card-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-people"></i></div>
        <div style="flex:1">
            <div class="list-card-title">Applications</div>
            <p class="list-card-desc">Review and manage candidate applications.</p>
            @if(isset($stats['total_applications']))
            <div style="margin-top:.4rem"><span class="badge-active">{{ $stats['total_applications'] }} total</span></div>
            @endif
        </div>
        <i class="bi bi-chevron-right list-card-arrow"></i>
    </a>

    <a href="{{ route('admin.career.positions.index') }}" class="list-card">
        <div class="list-card-icon" style="background:var(--green-50);color:var(--green-600)"><i class="bi bi-briefcase"></i></div>
        <div style="flex:1">
            <div class="list-card-title">Positions</div>
            <p class="list-card-desc">Create and manage open job positions.</p>
            @if(isset($stats['total_positions']))
            <div style="margin-top:.4rem"><span class="badge-active">{{ $stats['total_positions'] }} positions</span></div>
            @endif
        </div>
        <i class="bi bi-chevron-right list-card-arrow"></i>
    </a>

    <a href="{{ route('admin.career.hero-benefits.index') }}" class="list-card">
        <div class="list-card-icon" style="background:#eff6ff;color:#2563eb"><i class="bi bi-star"></i></div>
        <div style="flex:1">
            <div class="list-card-title">Hero & Benefits</div>
            <p class="list-card-desc">Manage the career page hero section and benefits list.</p>
            @if(isset($stats['total_benefits']))
            <div style="margin-top:.4rem"><span class="badge-active">{{ $stats['total_benefits'] }} benefits</span></div>
            @endif
        </div>
        <i class="bi bi-chevron-right list-card-arrow"></i>
    </a>
</div>
@endsection
