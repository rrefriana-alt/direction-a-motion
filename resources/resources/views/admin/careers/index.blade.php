@extends('admin.layout')
@section('title', 'Careers')
@section('page-title', 'Career Management')

@section('content')
<div x-data="{ tab: 'open' }">
    <!-- Tabs -->
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <button class="nav-link" :class="{ 'active': tab === 'open' }" @click="tab = 'open'">Open Positions</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" :class="{ 'active': tab === 'applications' }" @click="tab = 'applications'">Applications</button>
        </li>
    </ul>

    <!-- Tab 1: Open Positions -->
    <div x-show="tab === 'open'">
        <div class="card card-modern mb-4">
            <div class="card-body">
                <h5 class="card-title mb-4">Manage Positions</h5>
                <div class="table-responsive">
                    <table class="table table-modern align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($careers as $career)
                            <tr>
                                <td>{{ $career->title }}</td>
                                <td>{{ $career->type }}</td>
                                <td>{{ $career->location }}</td>
                                <td>
                                    <span class="badge {{ $career->is_open ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $career->is_open ? 'Open' : 'Closed' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#editCareer{{ $career->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('admin.careers.destroy', $career->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 empty-state">No open positions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card card-modern">
            <div class="card-body">
                <h5 class="card-title mb-4">Add New Position</h5>
                <form action="{{ route('admin.careers.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="title" class="form-control form-control-modern" placeholder="Job Title" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="type" class="form-control form-control-modern" placeholder="Type (e.g. Full-time)" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="location" class="form-control form-control-modern" placeholder="Location" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="form-check form-switch w-100">
                                <input class="form-check-input" type="checkbox" name="is_open" id="isOpenAdd" value="1" checked>
                                <label class="form-check-label" for="isOpenAdd">Open</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-accent px-4">Add Position</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modals for Editing -->
        @foreach($careers as $career)
        <div class="modal fade" id="editCareer{{ $career->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.careers.update', $career->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Position</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label form-label-modern">Title</label>
                                <input type="text" name="title" class="form-control form-control-modern" value="{{ $career->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label form-label-modern">Type</label>
                                <input type="text" name="type" class="form-control form-control-modern" value="{{ $career->type }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label form-label-modern">Location</label>
                                <input type="text" name="location" class="form-control form-control-modern" value="{{ $career->location }}" required>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_open" value="1" {{ $career->is_open ? 'checked' : '' }}>
                                <label class="form-check-label">Open</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-accent">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Tab 2: Applications -->
    <div x-show="tab === 'applications'" style="display: none;">
        <div class="card card-modern">
            <div class="card-body">
                <h5 class="card-title mb-4">Job Applications</h5>
                <div class="table-responsive">
                    <table class="table table-modern align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Resume</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $app)
                            <tr>
                                <td>{{ $app->name }}</td>
                                <td>{{ $app->position }}</td>
                                <td>
                                    @php
                                        $badgeClass = match(strtolower($app->status)) {
                                            'new' => 'bg-primary',
                                            'reviewed' => 'bg-warning text-dark',
                                            'accepted' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} badge-status">{{ ucfirst($app->status) }}</span>
                                </td>
                                <td>{{ $app->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($app->resume_path)
                                    <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-text"></i> View</a>
                                    @else
                                    <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('admin.careers.update-application', $app->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm d-inline-block w-auto me-2" onchange="this.form.submit()">
                                            <option value="new" {{ $app->status === 'new' ? 'selected' : '' }}>New</option>
                                            <option value="reviewed" {{ $app->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                            <option value="accepted" {{ $app->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                            <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </form>
                                    <form action="{{ route('admin.careers.destroy-application', $app->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this application?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 empty-state">No applications found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

