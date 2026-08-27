@extends('admin.layout')
@section('title', 'Edit Admin')
@section('page-title', 'Edit Admin User')

@section('content')
<div class="card card-modern mx-auto" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label form-label-modern">Name</label>
                <input type="text" class="form-control form-control-modern @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label form-label-modern">Email Address</label>
                <input type="email" class="form-control form-control-modern @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label form-label-modern">Password (Leave blank to keep current)</label>
                <input type="password" class="form-control form-control-modern @error('password') is-invalid @enderror" id="password" name="password" minlength="8">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Back</a>
                <button type="submit" class="btn btn-accent">Update User</button>
            </div>
        </form>
    </div>
</div>
@endsection

