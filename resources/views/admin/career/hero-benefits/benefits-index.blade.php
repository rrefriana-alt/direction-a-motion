@extends('admin.layouts.app')
@section('title', 'Benefits')
@section('page-title', 'Hero Benefits')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.index') }}">Career</a></li>
    <li class="breadcrumb-item active">Hero Benefits</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Hero Benefits</h2>
        <p>Manage the benefits displayed in the career hero section</p>
    </div>
    <a href="{{ route('admin.career.hero-benefits.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add Benefit</a>
</div>

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th style="width:60px">Order</th>
                    <th>Icon</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($benefits as $benefit)
                <tr>
                    <td style="color:var(--gray-500)">{{ $benefit->sort_order ?? 0 }}</td>
                    <td>
                        @if($benefit->icon)
                            <div style="width:32px;height:32px;border-radius:var(--radius-sm);background:var(--green-50);display:flex;align-items:center;justify-content:center">
                                <i class="{{ $benefit->icon }}" style="color:var(--green-600);font-size:.85rem"></i>
                            </div>
                        @else
                            <span style="color:var(--gray-400)">—</span>
                        @endif
                    </td>
                    <td><span class="fw-600">{{ $benefit->title }}</span></td>
                    <td style="max-width:300px;color:var(--gray-500)">{{ Str::limit($benefit->description, 100) }}</td>
                    <td>
                        @if($benefit->is_active)
                            <span class="badge-active">Active</span>
                        @else
                            <span class="badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.career.hero-benefits.edit', $benefit->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.career.hero-benefits.destroy', $benefit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this benefit?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-gift"></i>
                            <p>No benefits found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
