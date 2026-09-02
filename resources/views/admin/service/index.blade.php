@extends('admin.layouts.app')
@section('title', 'Services')
@section('page-title', 'Services')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Services</li>
@endsection

@section('content')
<div class="page-header">
    <h2>Services</h2>
    <p>Manage your service categories, details, and engagement models.</p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1rem">
    <a href="{{ route('admin.services.crud') }}" class="list-card">
        <div class="list-card-icon" style="background:var(--green-50);color:var(--green-600)"><i class="bi bi-gear"></i></div>
        <div>
            <div class="list-card-title">Manage Services (CRUD)</div>
            <p class="list-card-desc">Manage service categories, details, and items in a single page.</p>
        </div>
        <i class="bi bi-chevron-right list-card-arrow"></i>
    </a>

    <a href="{{ route('admin.services.engagement.index') }}" class="list-card">
        <div class="list-card-icon" style="background:#ecfdf5;color:#059669"><i class="bi bi-handshake"></i></div>
        <div>
            <div class="list-card-title">Engagement Models</div>
            <p class="list-card-desc">Manage engagement models (A, B, C) for the services page.</p>
        </div>
        <i class="bi bi-chevron-right list-card-arrow"></i>
    </a>

    <a href="{{ route('admin.home.services-page.edit') }}" class="list-card">
        <div class="list-card-icon" style="background:#fef3c7;color:#d97706"><i class="bi bi-type"></i></div>
        <div>
            <div class="list-card-title">Page Header</div>
            <p class="list-card-desc">Edit the services page headline and subtitle.</p>
        </div>
        <i class="bi bi-chevron-right list-card-arrow"></i>
    </a>
</div>
@endsection
