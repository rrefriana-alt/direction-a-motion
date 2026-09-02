@extends('admin.layouts.app')
@section('title', 'Contact')
@section('page-title', 'Contact')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Contact</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Contact Management</h2>
        <p>Manage contact page settings, social links, and messages</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.contact.messages.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-inbox"></i> Messages</a>
        <a href="{{ route('admin.contact.settings.edit') }}" class="btn btn-secondary btn-sm"><i class="bi bi-gear"></i> Page Settings</a>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg"></i> Add Social Link</button>
    </div>
</div>

<div class="form-section" style="max-width:720px">
    <div class="d-flex align-items-center gap-3">
        <div style="width:40px;height:40px;border-radius:var(--radius-md);background:#fef3c7;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <i class="bi bi-info-circle" style="color:#d97706"></i>
        </div>
        <div style="flex:1">
            <div class="fw-600" style="font-size:.85rem;color:var(--gray-900)">Page Settings</div>
            <div style="font-size:.76rem;color:var(--gray-500)">Edit the contact page headline, phone, email, and studio addresses.</div>
        </div>
        <a href="{{ route('admin.contact.settings.edit') }}" class="btn btn-secondary btn-sm">Edit</a>
    </div>
</div>

<div class="page-header" style="margin-bottom:1rem">
    <h2 style="font-size:1rem">Social Media Links</h2>
</div>

<div class="card-white card-white--flush">
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Platform</th>
                    <th>Icon</th>
                    <th>Display Text</th>
                    <th>URL</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr>
                    <td><span class="fw-600">{{ ucfirst($contact->platform) }}</span></td>
                    <td><i class="{{ $contact->icon_class }}" style="color:var(--gray-500)"></i> <span style="font-size:.73rem;color:var(--gray-400)">{{ $contact->icon_class }}</span></td>
                    <td>{{ $contact->display_text }}</td>
                    <td><a href="{{ $contact->url }}" target="_blank" style="color:var(--green-600);font-size:.73rem;text-decoration:none">{{ Str::limit($contact->url, 35) }}</a></td>
                    <td style="color:var(--gray-500)">{{ $contact->order }}</td>
                    <td>
                        <button class="btn-toggle {{ $contact->is_active ? 'badge-active' : 'badge-inactive' }}" data-id="{{ $contact->id }}" style="cursor:pointer;border:none">
                            {{ $contact->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $contact->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this link?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <div class="modal fade" id="editModal{{ $contact->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.contact.update', $contact->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h6 class="modal-title">Edit Contact</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="form-label">Platform</label>
                                        <input type="text" class="form-control" name="platform" value="{{ $contact->platform }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Icon Class</label>
                                        <input type="text" class="form-control" name="icon_class" value="{{ $contact->icon_class }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">URL</label>
                                        <input type="url" class="form-control" name="url" value="{{ $contact->url }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Display Text</label>
                                        <input type="text" class="form-control" name="display_text" value="{{ $contact->display_text }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Order</label>
                                        <input type="number" class="form-control" name="order" value="{{ $contact->order }}" required>
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
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-chat-dots"></i>
                            <p>No social links yet</p>
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
            <form action="{{ route('admin.contact.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title">Add Social Link</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Platform</label>
                        <input type="text" class="form-control" name="platform" placeholder="e.g. whatsapp, instagram, linkedin" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Icon Class</label>
                        <input type="text" class="form-control" name="icon_class" placeholder="e.g. bi bi-whatsapp" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">URL</label>
                        <input type="url" class="form-control" name="url" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Display Text</label>
                        <input type="text" class="form-control" name="display_text" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Order</label>
                        <input type="number" class="form-control" name="order" value="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Add Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.btn-toggle').forEach(btn => {
    btn.addEventListener('click', async function() {
        const id = this.dataset.id;
        const res = await fetch(`/admin/contact/${id}/toggle-active`, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json'}
        });
        const data = await res.json();
        if (data.success) location.reload();
    });
});
</script>
@endpush
