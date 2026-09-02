@extends('admin.layouts.app')
@section('title', 'Edit Hero')
@section('page-title', 'Edit Career Hero')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.index') }}">Career</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.hero-benefits.index') }}">Hero Benefits</a></li>
    <li class="breadcrumb-item active">Hero</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Edit Hero Section</h2>
        <p>Update the career page hero description</p>
    </div>
    <a href="{{ route('admin.career.hero-benefits.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:640px;">
    <form action="{{ route('admin.career.hero-benefits.hero.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div style="margin-bottom:1rem;">
            <label class="form-label">Description <span style="color:#dc2626;">*</span></label>
            <textarea class="form-control" name="description" rows="6" required placeholder="Hero description text...">{{ old('description', $hero->description ?? '') }}</textarea>
        </div>

        <div style="margin-bottom:1.5rem;">
            <label style="display:flex;align-items:center;gap:.5rem;font-size:.8125rem;color:#374151;cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $hero->is_active ?? true) ? 'checked' : '' }}> Active
            </label>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:.5rem;">
            <a href="{{ route('admin.career.hero-benefits.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2"></i> Update Hero</button>
        </div>
    </form>
</div>
@endsection
