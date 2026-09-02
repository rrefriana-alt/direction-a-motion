@extends('admin.layouts.app')
@section('title', 'Client Logos')
@section('page-title', 'Client Logos')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Client Logos</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Client Logos</h2>
        <p>Manage the client ticker carousel on the homepage</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.home.clients.carousel') }}" class="btn btn-secondary btn-sm"><i class="bi bi-toggle2-on"></i> Carousel</a>
        <a href="{{ route('admin.home.clients.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Logo</a>
    </div>
</div>

<div class="card-white card-white--flush">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid var(--gray-100)">
        <form action="{{ route('admin.home.clients.index') }}" method="GET" class="d-flex gap-2" style="flex-wrap:wrap">
            <input type="text" name="search" class="form-control" placeholder="Search logos..." value="{{ $search ?? '' }}" style="flex:1;min-width:200px;max-width:400px">
            <select name="category" class="form-select" style="max-width:200px">
                <option value="">All Categories</option>
                @foreach($categories as $slug => $label)
                    <option value="{{ $slug }}" {{ ($category ?? '') === $slug ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary btn-sm"><i class="bi bi-search"></i> Search</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th style="width:60px">Order</th>
                    <th style="width:80px">Logo</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientLogos as $logo)
                <tr>
                    <td style="color:var(--gray-500)">{{ $logo->sort_order }}</td>
                    <td>
                        <img src="{{ asset('assets/img/clients/' . $logo->image) }}" alt="{{ $logo->name }}" style="height:28px;width:auto;object-fit:contain">
                    </td>
                    <td><span class="fw-600">{{ $logo->name }}</span></td>
                    <td>
                        @if($logo->category && isset($categories[$logo->category]))
                            <span class="badge-category">{{ $categories[$logo->category] }}</span>
                        @else
                            <span style="color:var(--gray-400)">—</span>
                        @endif
                    </td>
                    <td>
                        @if($logo->is_active)
                            <span class="badge-active">Active</span>
                        @else
                            <span class="badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.home.clients.edit', $logo->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.home.clients.destroy', $logo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this logo?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-image"></i>
                            <p>No client logos found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($clientLogos, 'links') && $clientLogos->hasPages())
    <div style="padding:.75rem 1.25rem;border-top:1px solid var(--gray-100)">
        {{ $clientLogos->links() }}
    </div>
    @endif
</div>
@endsection
