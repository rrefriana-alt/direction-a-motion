@extends('admin.layouts.app')
@section('title', 'News')
@section('page-title', 'News')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">News</li>
@endsection

@section('content')
<div class="page-header">
    <h2>News Management</h2>
    <p>Manage news articles and publications</p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:1rem">
    <a href="{{ route('admin.news.list') }}" class="list-card">
        <div class="list-card-icon" style="background:var(--green-50);color:var(--green-600)"><i class="bi bi-newspaper"></i></div>
        <div>
            <div class="list-card-title">All Articles</div>
            <p class="list-card-desc">View, edit, and delete existing news articles.</p>
        </div>
        <i class="bi bi-chevron-right list-card-arrow"></i>
    </a>

    <a href="{{ route('admin.news.create') }}" class="list-card">
        <div class="list-card-icon" style="background:#ecfdf5;color:#059669"><i class="bi bi-plus-circle"></i></div>
        <div>
            <div class="list-card-title">Create Article</div>
            <p class="list-card-desc">Write a new news article.</p>
        </div>
        <i class="bi bi-chevron-right list-card-arrow"></i>
    </a>
</div>
@endsection
