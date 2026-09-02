@extends('admin.layouts.app')
@section('title', 'Edit Application')
@section('page-title', 'Review Application')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.index') }}">Career</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.career.applications.index') }}">Applications</a></li>
    <li class="breadcrumb-item active">Review</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Review Application</h2>
        <p>Update application status for {{ $application->full_name }}</p>
    </div>
    <a href="{{ route('admin.career.applications.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.25rem;align-items:start;">
    <div class="card-white">
        <div style="font-size:.95rem;font-weight:600;color:#1a1d29;margin-bottom:1rem;">Application Details</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;font-size:.8125rem;">
            <div>
                <div style="color:#6b7280;font-size:.7rem;text-transform:uppercase;font-weight:600;margin-bottom:.15rem;">Full Name</div>
                <div style="color:#1a1d29;font-weight:500;">{{ $application->full_name }}</div>
            </div>
            <div>
                <div style="color:#6b7280;font-size:.7rem;text-transform:uppercase;font-weight:600;margin-bottom:.15rem;">Email</div>
                <div style="color:#1a1d29;font-weight:500;">{{ $application->email }}</div>
            </div>
            <div>
                <div style="color:#6b7280;font-size:.7rem;text-transform:uppercase;font-weight:600;margin-bottom:.15rem;">Phone</div>
                <div style="color:#1a1d29;font-weight:500;">{{ $application->phone ?? '-' }}</div>
            </div>
            <div>
                <div style="color:#6b7280;font-size:.7rem;text-transform:uppercase;font-weight:600;margin-bottom:.15rem;">Position</div>
                <div style="color:#1a1d29;font-weight:500;">{{ $application->position ?? '-' }}</div>
            </div>
            <div>
                <div style="color:#6b7280;font-size:.7rem;text-transform:uppercase;font-weight:600;margin-bottom:.15rem;">Education</div>
                <div style="color:#1a1d29;font-weight:500;">{{ ucfirst(str_replace('_', ' ', $application->education ?? '-')) }}</div>
            </div>
            <div>
                <div style="color:#6b7280;font-size:.7rem;text-transform:uppercase;font-weight:600;margin-bottom:.15rem;">Job Field</div>
                <div style="color:#1a1d29;font-weight:500;">{{ ucfirst(str_replace('_', ' ', $application->last_job_field ?? '-')) }}</div>
            </div>
            <div>
                <div style="color:#6b7280;font-size:.7rem;text-transform:uppercase;font-weight:600;margin-bottom:.15rem;">Date Applied</div>
                <div style="color:#1a1d29;font-weight:500;">{{ $application->created_at->format('M d, Y') }}</div>
            </div>
            <div>
                <div style="color:#6b7280;font-size:.7rem;text-transform:uppercase;font-weight:600;margin-bottom:.15rem;">Current Status</div>
                <div style="font-weight:500;">
                    @switch($application->status)
                        @case('pending')
                            <span class="badge-inactive" style="background:#fef3c7;color:#92400e;">Pending</span>
                            @break
                        @case('reviewed')
                            <span style="background:#e0e7ff;color:#4338ca;padding:.2rem .6rem;border-radius:6px;font-size:.7rem;font-weight:500;">Reviewed</span>
                            @break
                        @case('accepted')
                            <span class="badge-active">Accepted</span>
                            @break
                        @case('rejected')
                            <span class="badge-inactive">Rejected</span>
                            @break
                        @default
                            <span class="badge-inactive">{{ $application->status }}</span>
                    @endswitch
                </div>
            </div>
        </div>

        @if($application->cover_letter)
        <div style="margin-top:1.25rem;">
            <div style="color:#6b7280;font-size:.7rem;text-transform:uppercase;font-weight:600;margin-bottom:.35rem;">Cover Letter</div>
            <div style="font-size:.8125rem;color:#374151;line-height:1.6;background:#f9fafb;padding:1rem;border-radius:8px;">{{ $application->cover_letter }}</div>
        </div>
        @endif

        <div style="display:flex;gap:.75rem;margin-top:1.25rem;">
            @if($application->resume_path)
            <a href="{{ route('admin.career.applications.download-resume', $application->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-file-earmark-pdf"></i> Resume</a>
            @endif
            @if($application->portfolio_path)
            <a href="{{ route('admin.career.applications.download-portfolio', $application->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-folder-zip"></i> Portfolio</a>
            @endif
        </div>
    </div>

    <div class="card-white">
        <div style="font-size:.95rem;font-weight:600;color:#1a1d29;margin-bottom:1rem;">Update Status</div>
        <form action="{{ route('admin.career.applications.update-status', $application->id) }}" method="POST">
            @csrf
            <div style="margin-bottom:1rem;">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['pending','reviewed','accepted','rejected'] as $s)
                    <option value="{{ $s }}" {{ $application->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;"><i class="bi bi-check2"></i> Update Status</button>
        </form>
    </div>
</div>
@endsection
