@extends('admin.layouts.app')
@section('title', 'Admin Users')
@section('page-title', 'Admin Users')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Admin Users</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Admin Users</h2>
        <p>Manage admin accounts for this panel</p>
    </div>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg"></i> Add Admin</button>
</div>

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td><span class="fw-600">{{ $admin->name }}</span></td>
                    <td style="color:var(--gray-500)">{{ $admin->email }}</td>
                    <td style="color:var(--gray-400);font-size:.73rem">{{ $admin->created_at->format('M d, Y') }}</td>
                    <td class="text-end">
                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $admin->id }}"><i class="bi bi-pencil"></i></button>
                        @if($admin->id !== auth('admin')->id())
                        <form action="{{ route('admin.account.destroy', $admin->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this admin?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>

                <div class="modal fade" id="editModal{{ $admin->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.account.update', $admin->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h6 class="modal-title">Edit Admin</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ $admin->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ $admin->email }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Password <span style="font-weight:400;color:var(--gray-400)">(leave blank to keep current)</span></label>
                                        <input type="password" class="form-control" name="password" minlength="8">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" minlength="8">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <p>No admin users</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.account.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title">Add Admin</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" minlength="8" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" minlength="8" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Add Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
