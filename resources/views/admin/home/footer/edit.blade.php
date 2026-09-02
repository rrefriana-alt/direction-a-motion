@extends('admin.layouts.app')
@section('title', 'Edit Footer')
@section('page-title', 'Footer Settings')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Footer</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Footer Settings</h2>
        <p>Edit footer description and social media links</p>
    </div>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.footer.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Description <span style="color:var(--red-600)">*</span></label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="descInput" rows="3" required>{{ old('description', $settings['description']) }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phoneInput" value="{{ old('phone', $settings['phone']) }}" placeholder="+62 821 2100 0680">
                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $settings['email']) }}" placeholder="hello@fugocreativegroup.com">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Address (Bandung — HQ)</label>
                <textarea name="address_bandung" class="form-control @error('address_bandung') is-invalid @enderror" rows="2">{{ old('address_bandung', $settings['address_bandung']) }}</textarea>
                @error('address_bandung') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Address (Jakarta)</label>
                <textarea name="address_jakarta" class="form-control @error('address_jakarta') is-invalid @enderror" rows="2">{{ old('address_jakarta', $settings['address_jakarta']) }}</textarea>
                @error('address_jakarta') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Address (Bali)</label>
                <textarea name="address_bali" class="form-control @error('address_bali') is-invalid @enderror" rows="2">{{ old('address_bali', $settings['address_bali']) }}</textarea>
                @error('address_bali') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <hr style="margin:1.5rem 0;border:none;border-top:1px solid var(--gray-100)">
            <div style="font-size:.85rem;font-weight:600;color:var(--gray-700);margin-bottom:1rem">Social Media Links</div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label"><i class="bi bi-instagram"></i> Instagram</label>
                    <input type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram', $settings['instagram']) }}" placeholder="https://instagram.com/fugocreative">
                    @error('instagram') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="bi bi-linkedin"></i> LinkedIn</label>
                    <input type="url" name="linkedin" class="form-control @error('linkedin') is-invalid @enderror" value="{{ old('linkedin', $settings['linkedin']) }}" placeholder="https://linkedin.com/company/...">
                    @error('linkedin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="bi bi-tiktok"></i> TikTok</label>
                    <input type="url" name="tiktok" class="form-control @error('tiktok') is-invalid @enderror" value="{{ old('tiktok', $settings['tiktok']) }}" placeholder="https://tiktok.com/@fugo.creative">
                    @error('tiktok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label"><i class="bi bi-youtube"></i> YouTube</label>
                    <input type="url" name="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ old('youtube', $settings['youtube']) }}" placeholder="https://youtube.com/@fugocreative">
                    @error('youtube') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.5rem;background:var(--gray-900);color:white">
            <div style="font-size:.8rem;font-weight:700;color:white;margin-bottom:.5rem">Fugo<span style="color:var(--green-400)">Creative</span></div>
            <p style="font-size:.72rem;color:rgba(255,255,255,.6);margin-bottom:1rem;line-height:1.5;max-width:30ch" id="previewDesc">{{ $settings['description'] }}</p>
            <div style="display:flex;gap:1rem;margin-bottom:1rem">
                <div>
                    <div style="font-size:.65rem;font-weight:600;color:var(--green-400);text-transform:uppercase;margin-bottom:.25rem">Navigate</div>
                    <div style="font-size:.65rem;color:rgba(255,255,255,.5)">Work · Services · Studio · Contact</div>
                </div>
            </div>
            <div style="display:flex;gap:.5rem;margin-bottom:1rem">
                <a href="{{ $settings['instagram'] }}" target="_blank" style="color:rgba(255,255,255,.5);font-size:.7rem">Instagram</a>
                <span style="color:rgba(255,255,255,.2)">·</span>
                <a href="{{ $settings['linkedin'] }}" target="_blank" style="color:rgba(255,255,255,.5);font-size:.7rem">LinkedIn</a>
                <span style="color:rgba(255,255,255,.2)">·</span>
                <a href="{{ $settings['tiktok'] }}" target="_blank" style="color:rgba(255,255,255,.5);font-size:.7rem">TikTok</a>
            </div>
            <div style="font-size:.65rem;color:rgba(255,255,255,.4);border-top:1px solid rgba(255,255,255,.1);padding-top:.75rem;display:flex;justify-content:space-between">
                <span>© 2026 PT Fugo Creative Group</span>
                <span id="previewPhone">{{ $settings['phone'] }}</span>
            </div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">Footer on all pages</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const descInput = document.getElementById('descInput');
    const phoneInput = document.getElementById('phoneInput');
    const previewDesc = document.getElementById('previewDesc');
    const previewPhone = document.getElementById('previewPhone');

    descInput.addEventListener('input', () => { previewDesc.textContent = descInput.value || 'Description...'; });
    phoneInput.addEventListener('input', () => { previewPhone.textContent = phoneInput.value || '+62 ...'; });
});
</script>
@endpush
