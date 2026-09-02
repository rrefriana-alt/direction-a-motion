@extends('admin.layouts.app')
@section('title', 'Contact Page Settings')
@section('page-title', 'Contact Page Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.contact.index') }}">Contact</a></li>
    <li class="breadcrumb-item active">Page Settings</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Contact Page Settings</h2>
        <p>Edit the contact page header, contact info, and studio addresses</p>
    </div>
    <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:640px">
    <form action="{{ route('admin.contact.settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        <h6 style="font-weight:600;color:#1a1d29;margin-bottom:1rem">Page Header</h6>
        <div class="mb-3">
            <label class="form-label">Headline</label>
            <input type="text" name="headline" class="form-control @error('headline') is-invalid @enderror" value="{{ old('headline', $settings['headline']) }}" required>
            @error('headline') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Subtitle</label>
            <textarea name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" rows="2" required>{{ old('subtitle', $settings['subtitle']) }}</textarea>
            @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <hr>
        <h6 style="font-weight:600;color:#1a1d29;margin-bottom:1rem">Contact Information</h6>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $settings['phone']) }}" required>
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $settings['email']) }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <hr>
        <h6 style="font-weight:600;color:#1a1d29;margin-bottom:1rem">Studio Addresses</h6>
        <div class="mb-3">
            <label class="form-label">Bandung Office</label>
            <textarea name="address_bdg" class="form-control @error('address_bdg') is-invalid @enderror" rows="2" required>{{ old('address_bdg', $settings['address_bdg']) }}</textarea>
            @error('address_bdg') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Jakarta Office</label>
            <textarea name="address_jkt" class="form-control @error('address_jkt') is-invalid @enderror" rows="2" required>{{ old('address_jkt', $settings['address_jkt']) }}</textarea>
            @error('address_jkt') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Bali Office</label>
            <textarea name="address_bali" class="form-control @error('address_bali') is-invalid @enderror" rows="2" required>{{ old('address_bali', $settings['address_bali']) }}</textarea>
            @error('address_bali') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Save Changes</button>
    </form>
</div>
@endsection
