@extends('admin.layouts.app')
@section('title', 'Timeline')
@section('page-title', 'Timeline')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item active">Timeline</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Timeline</h2>
        <p>Manage your company history milestones</p>
    </div>
    <a href="{{ route('admin.about.timeline.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Create</a>
</div>

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Description</th>
                    <th>Icon</th>
                    <th>Order</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($timelines as $timeline)
                <tr>
                    <td><span class="fw-600" style="color:var(--green-600)">{{ $timeline->year }}</span></td>
                    <td style="max-width:400px;color:var(--gray-500)">{{ Str::limit($timeline->description, 80) }}</td>
                    <td style="color:var(--gray-500)">{{ $timeline->icon ?? '—' }}</td>
                    <td style="color:var(--gray-500)">{{ $timeline->sort_order ?? 0 }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.about.timeline.edit', $timeline->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('admin.about.timeline.destroy', $timeline->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this entry?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="bi bi-clock-history"></i>
                            <p>No timeline entries yet</p>
                            <a href="{{ route('admin.about.timeline.create') }}" class="btn btn-primary btn-sm" style="margin-top:.5rem"><i class="bi bi-plus-lg"></i> Add Entry</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
