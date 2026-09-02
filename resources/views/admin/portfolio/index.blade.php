@extends('admin.layouts.app')
@section('title', 'Portfolio')
@section('page-title', 'Portfolio')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Portfolio</li>
@endsection

@section('content')
<div class="page-header">
    <h2>Portfolio</h2>
    <p>Manage your portfolio projects and showcase your work.</p>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <a href="{{ route('admin.portfolio.projects.index') }}" class="dashboard-card h-100">
            <div class="dashboard-card-icon"><i class="bi bi-folder2-open"></i></div>
            <div class="dashboard-card-title">Projects</div>
            <p class="dashboard-card-desc">Create, edit, and manage individual portfolio projects.</p>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('admin.portfolio.view-all') }}" class="dashboard-card h-100">
            <div class="dashboard-card-icon" style="background:#e0f2fe;color:#0ea5e9"><i class="bi bi-grid-3x3-gap"></i></div>
            <div class="dashboard-card-title">View All Projects</div>
            <p class="dashboard-card-desc">Toggle which projects are displayed on the public portfolio page.</p>
        </a>
    </div>
</div>
@endsection
