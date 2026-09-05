@extends('admin.layouts.app')
@section('title', 'Home Management')
@section('page-title', 'Home Management')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Home</li>
@endsection

@section('content')
<div class="page-header">
    <h2>Home Management</h2>
    <p>Manage all homepage sections from here</p>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <a href="{{ route('admin.home.hero.edit') }}" class="dashboard-card">
            <div class="dashboard-card-icon"><i class="bi bi-badge-4k"></i></div>
            <div class="dashboard-card-title">Hero</div>
            <p class="dashboard-card-desc">Edit hero tagline and description text.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.clients.index') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#e0f2fe;color:#0ea5e9"><i class="bi bi-images"></i></div>
            <div class="dashboard-card-title">Client Logos</div>
            <p class="dashboard-card-desc">Manage the client ticker carousel.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.manifesto.edit') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#f5f3ff;color:#7c3aed"><i class="bi bi-quote"></i></div>
            <div class="dashboard-card-title">Manifesto</div>
            <p class="dashboard-card-desc">Edit manifesto subtitle and title text.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.stats.index') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#f0fdf4;color:#16a34a"><i class="bi bi-bar-chart"></i></div>
            <div class="dashboard-card-title">Statistics</div>
            <p class="dashboard-card-desc">Manage counter statistics on the homepage.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.capabilities-header.edit') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#f5f3ff;color:#8b5cf6"><i class="bi bi-card-heading"></i></div>
            <div class="dashboard-card-title">Capabilities Header</div>
            <p class="dashboard-card-desc">Edit section title and description.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.capabilities.index') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#ede9fe;color:#7c3aed"><i class="bi bi-layers"></i></div>
            <div class="dashboard-card-title">Capabilities Cards</div>
            <p class="dashboard-card-desc">Manage capability cards with images, descriptions, and tags.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.sectors.index') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#ecfdf5;color:#0891b2"><i class="bi bi-diagram-3"></i></div>
            <div class="dashboard-card-title">Sectors</div>
            <p class="dashboard-card-desc">Manage sector headings and client lists.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.process.index') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#fffbeb;color:#d97706"><i class="bi bi-list-ol"></i></div>
            <div class="dashboard-card-title">Process</div>
            <p class="dashboard-card-desc">Manage the step-by-step process section.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.founder.edit') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#fdf2f8;color:#db2777"><i class="bi bi-person-circle"></i></div>
            <div class="dashboard-card-title">Founder Quote</div>
            <p class="dashboard-card-desc">Edit founder quote, name, and photo.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.marquee.index') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#fef3c7;color:#f59e0b"><i class="bi bi-type"></i></div>
            <div class="dashboard-card-title">Big Marquee</div>
            <p class="dashboard-card-desc">Manage scrolling text marquee items.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.journal.index') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#ecfdf5;color:#059669"><i class="bi bi-journal-text"></i></div>
            <div class="dashboard-card-title">Journal</div>
            <p class="dashboard-card-desc">Manage homepage journal header and pinned articles.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.cta.edit') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#fff7ed;color:#ea580c"><i class="bi bi-megaphone"></i></div>
            <div class="dashboard-card-title">Call to Action</div>
            <p class="dashboard-card-desc">Edit the CTA eyebrow and title text.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.services-page.edit') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#ecfdf5;color:#059669"><i class="bi bi-gear"></i></div>
            <div class="dashboard-card-title">Services Page Header</div>
            <p class="dashboard-card-desc">Edit the services page headline and subtitle.</p>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.home.footer.edit') }}" class="dashboard-card">
            <div class="dashboard-card-icon" style="background:#eef2ff;color:#6366f1"><i class="bi bi-layout-text-window"></i></div>
            <div class="dashboard-card-title">Footer</div>
            <p class="dashboard-card-desc">Edit footer description and social links.</p>
        </a>
    </div>
</div>
@endsection
