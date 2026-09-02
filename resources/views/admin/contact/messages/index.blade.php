@extends('admin.layouts.app')
@section('title', 'Messages Inbox')
@section('page-title', 'Messages Inbox')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.contact.index') }}">Contact</a></li>
    <li class="breadcrumb-item active">Messages</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Messages Inbox</h2>
        <p>Contact form submissions from the website</p>
    </div>
    <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card-white">
    @if($messages->count() > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width:40px"></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th style="width:120px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                <tr style="{{ !$message->is_read ? 'font-weight:600' : '' }}">
                    <td>
                        <button class="btn btn-sm toggle-read-btn" data-id="{{ $message->id }}" title="Toggle read status" style="background:none;border:none;cursor:pointer;padding:4px">
                            <i class="bi {{ $message->is_read ? 'bi-envelope-open' : 'bi-envelope-fill' }}" style="color:{{ $message->is_read ? 'var(--gray-400)' : '#10b981' }};font-size:1.1rem"></i>
                        </button>
                    </td>
                    <td>{{ $message->name }}</td>
                    <td><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></td>
                    <td style="max-width:300px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $message->message }}</td>
                    <td style="white-space:nowrap">{{ $message->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <form action="{{ route('admin.contact.messages.destroy', $message->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus pesan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align:center;padding:3rem;color:var(--gray-400)">
        <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
        No messages yet.
    </div>
    @endif
</div>

<script>
document.querySelectorAll('.toggle-read-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        fetch(`/admin/contact/messages/${id}/toggle-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(r => r.json()).then(data => {
            if (data.success) location.reload();
        });
    });
});
</script>
@endsection
