@extends('admin.layout')

@section('title', 'Projects')
@section('page-title', 'Portfolio / Projects')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Projects</h2>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg me-2"></i>Add Project
        </a>
    </div>
</div>

<div class="card card-modern">
    <div class="card-body p-0">
        @if($projects->count() > 0)
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Category</th>
                            <th>Year</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>
                                @if($project->hero_image)
                                    <img src="{{ asset('storage/' . $project->hero_image) }}" alt="{{ $project->title }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px; border-radius: 4px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="align-middle fw-semibold">{{ $project->title }}</td>
                            <td class="align-middle">{{ $project->client }}</td>
                            <td class="align-middle">{{ $project->category }}</td>
                            <td class="align-middle">{{ $project->year }}</td>
                            <td class="align-middle text-end">
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state text-center p-5">
                <i class="bi bi-folder2-open display-4 text-muted mb-3 d-block"></i>
                <h4 class="text-muted mb-3">No projects found</h4>
                <a href="{{ route('admin.projects.create') }}" class="btn btn-accent">
                    <i class="bi bi-plus-lg me-2"></i>Add Your First Project
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
