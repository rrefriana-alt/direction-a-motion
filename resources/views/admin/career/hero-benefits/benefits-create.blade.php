@extends('admin.layouts.app')
@section('title', 'Create Benefit')
@section('page-title', 'Create Benefit')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.index') }}">Career</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.hero-benefits.index') }}">Hero Benefits</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Create Benefit</h2>
        <p>Add a new benefit to the career page</p>
    </div>
    <a href="{{ route('admin.career.hero-benefits.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:640px;">
    <form action="{{ route('admin.career.hero-benefits.benefits.store') }}" method="POST">
        @csrf
        <div style="margin-bottom:1rem;">
            <label class="form-label">Benefit Title <span style="color:#dc2626;">*</span></label>
            <input type="text" class="form-control" name="benefit_title" value="{{ old('benefit_title') }}" required placeholder="e.g. Health Insurance">
        </div>

        <div style="margin-bottom:1rem;">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="4" placeholder="Brief description of this benefit...">{{ old('description') }}</textarea>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
            <div>
                <label class="form-label">Icon Class <span style="color:#dc2626;">*</span></label>
                <select name="icon_class" class="form-select" required>
                    <option value="">Select icon</option>
                    @foreach($iconClasses as $icon)
                    <option value="{{ $icon }}" {{ old('icon_class') === $icon ? 'selected' : '' }}>{{ $icon }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
            </div>
        </div>

        <div style="margin-bottom:1.5rem;">
            <label style="display:flex;align-items:center;gap:.5rem;font-size:.8125rem;color:#374151;cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}> Active
            </label>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:.5rem;">
            <a href="{{ route('admin.career.hero-benefits.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check2"></i> Save Benefit</button>
        </div>
    </form>
</div>
@endsection
