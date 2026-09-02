@extends('admin.layout')
@section('title', 'Messages')
@section('page-title', 'Contact Messages')

@section('content')
<div class="card card-modern">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-modern align-middle">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $m)
                    <tr class="{{ !$m->is_read ? 'fw-bold bg-light' : '' }}">
                        <td>{{ $m->name }}</td>
                        <td>{{ $m->email }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($m->subject, 30) }}</td>
                        <td>{{ $m->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <span class="badge {{ $m->is_read ? 'bg-secondary' : 'bg-primary' }}">
                                {{ $m->is_read ? 'Read' : 'Unread' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.messages.show', $m->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('admin.messages.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?');">
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
                        <td colspan="6" class="text-center py-4 empty-state">No messages received yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

