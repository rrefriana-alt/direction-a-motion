@extends('admin.layout')
@section('title', 'View Message')
@section('page-title', 'Message Detail')

@section('content')
<div class="card card-modern mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">{{ $message->subject }}</h5>
            <div>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <strong>From:</strong><br>
                {{ $message->name }}
            </div>
            <div class="col-md-4">
                <strong>Email:</strong><br>
                <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
            </div>
            <div class="col-md-4">
                <strong>Date:</strong><br>
                {{ $message->created_at->format('F d, Y g:i A') }}
            </div>
        </div>

        <hr>
        
        <div class="mt-4">
            <strong>Message:</strong>
            <p class="mt-3 text-break" style="white-space: pre-wrap;">{{ $message->message }}</p>
        </div>
    </div>
</div>
@endsection

