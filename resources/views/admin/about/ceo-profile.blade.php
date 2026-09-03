@extends('admin.layouts.app')
@section('title', 'CEO Profile')
@section('page-title', 'CEO Profile')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item active">CEO Profile</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>CEO Profile</h2>
        <p>Edit the CEO profile photo, quote, and bio</p>
    </div>
    <a href="{{ route('admin.about.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:720px">
    <form action="{{ route('admin.about.ceo-profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Photo</label>
            @if(isset($ceo->photo) && $ceo->photo)
            <div style="margin-bottom:.75rem">
                <img src="{{ asset('img/' . $ceo->photo) }}" alt="CEO Photo" style="width:100px;height:100px;object-fit:cover;border-radius:50%;border:2px solid var(--gray-200)">
            </div>
            @endif
            <input type="file" class="form-control" name="photo" accept="image/*">
        </div>

        <div class="form-group">
            <label class="form-label">Quote</label>
            <input type="text" class="form-control" name="quote" value="{{ old('quote', $ceo->quote ?? '') }}" placeholder="Inspirational quote...">
        </div>

        <div class="form-group">
            <label class="form-label">Description 1</label>
            <textarea class="form-control" name="description1" rows="4" placeholder="First paragraph...">{{ old('description1', $ceo->description1 ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Description 2</label>
            <textarea class="form-control" name="description2" rows="4" placeholder="Second paragraph...">{{ old('description2', $ceo->description2 ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Signature</label>
            @if(isset($ceo->signature) && $ceo->signature)
            <div style="margin-bottom:.75rem">
                <img src="{{ asset('img/' . $ceo->signature) }}" alt="Signature" style="max-height:60px;border:1px solid var(--gray-200);border-radius:var(--radius-sm);padding:.5rem;background:#fff">
            </div>
            @endif
            <input type="file" class="form-control" name="signature" accept="image/*">
        </div>

        <div class="form-group">
            <label class="form-label">Greeting</label>
            <input type="text" class="form-control" name="greeting" value="{{ old('greeting', $ceo->greeting ?? '') }}" placeholder="e.g. Welcome to our company...">
        </div>

        <div class="row g-3">
            <div class="col-md-6 form-group">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $ceo->name ?? '') }}" placeholder="Full name">
            </div>
            <div class="col-md-6 form-group">
                <label class="form-label">Position</label>
                <input type="text" class="form-control" name="position" value="{{ old('position', $ceo->position ?? '') }}" placeholder="e.g. CEO & Founder">
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.about.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Profile</button>
        </div>
    </form>
</div>
@endsection

