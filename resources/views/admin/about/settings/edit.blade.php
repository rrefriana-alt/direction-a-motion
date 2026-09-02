@extends('admin.layouts.app')
@section('title', 'About Page Settings')
@section('page-title', 'About Page Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.about.index') }}">About</a></li>
    <li class="breadcrumb-item active">Page Settings</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>About Page Settings</h2>
        <p>Edit the about page header, subtitle, and belief section</p>
    </div>
    <a href="{{ route('admin.about.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:640px">
    <form action="{{ route('admin.about.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-section-title">Page Header</div>

        <div class="form-group">
            <label class="form-label">Headline</label>
            <input type="text" name="headline" class="form-control @error('headline') is-invalid @enderror" value="{{ old('headline', $settings['headline']) }}" required>
            @error('headline') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">e.g. "A creative group, not a vendor list"</div>
        </div>

        <div class="form-group">
            <label class="form-label">Subtitle</label>
            <textarea name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" rows="2" required>{{ old('subtitle', $settings['subtitle']) }}</textarea>
            @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-section-title" style="margin-top:1.5rem">Our Belief</div>

        <div class="form-group">
            <label class="form-label">Belief Title</label>
            <input type="text" name="belief_title" class="form-control @error('belief_title') is-invalid @enderror" value="{{ old('belief_title', $settings['belief_title']) }}" required>
            @error('belief_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Belief Text</label>
            <textarea name="belief_text" class="form-control @error('belief_text') is-invalid @enderror" rows="3" required>{{ old('belief_text', $settings['belief_text']) }}</textarea>
            @error('belief_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Belief Elaboration</label>
            <textarea name="belief_elaboration" class="form-control @error('belief_elaboration') is-invalid @enderror" rows="3" required>{{ old('belief_elaboration', $settings['belief_elaboration']) }}</textarea>
            @error('belief_elaboration') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check-lg"></i> Save Changes</button>
        </div>
    </form>
</div>
@endsection
