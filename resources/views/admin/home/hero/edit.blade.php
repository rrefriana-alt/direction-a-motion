@extends('admin.layouts.app')
@section('title', 'Edit Hero')
@section('page-title', 'Hero Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Hero</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Hero Settings — EN / ID</h2>
        <p>Edit tagline & description per bahasa (switching bahasa = switching konten)</p>
    </div>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.hero.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Tagline — EN <span style="color:var(--red-600)">*</span></label>
                    <input type="text" name="tagline_en" class="form-control @error('tagline_en') is-invalid @enderror" value="{{ old('tagline_en', $settings['tagline_en']) }}" required>
                    @error('tagline_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Tagline — ID <span style="color:var(--red-600)">*</span></label>
                    <input type="text" name="tagline_id" class="form-control @error('tagline_id') is-invalid @enderror" value="{{ old('tagline_id', $settings['tagline_id']) }}" required>
                    @error('tagline_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Description — EN <span style="color:var(--red-600)">*</span></label>
                    <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" rows="3" required>{{ old('description_en', $settings['description_en']) }}</textarea>
                    @error('description_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Description — ID <span style="color:var(--red-600)">*</span></label>
                    <textarea name="description_id" class="form-control @error('description_id') is-invalid @enderror" rows="3" required>{{ old('description_id', $settings['description_id']) }}</textarea>
                    @error('description_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save EN/ID</button>
            </div>
        </form>
    </div>
    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Preview</div>
        <div class="card-white" style="padding:1.5rem;background:var(--gray-900);color:white;text-align:center">
            <div style="font-size:.7rem;color:var(--gray-400)">EN: {{ $settings['tagline_en'] }}</div>
            <div style="font-size:.7rem;color:var(--green-400)">ID: {{ $settings['tagline_id'] }}</div>
        </div>
    </div>
</div>
@endsection
