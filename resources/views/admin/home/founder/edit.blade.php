@extends('admin.layouts.app')
@section('title', 'Founder Quote')
@section('page-title', 'Founder Quote')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item active">Founder Quote</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Founder Quote</h2>
        <p>Edit the founder quote, name, and photo on the homepage</p>
    </div>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.founder.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Quote <span style="color:var(--red-600)">*</span></label>
                <textarea name="quote" class="form-control @error('quote') is-invalid @enderror" id="quoteInput" rows="3" required>{{ old('quote', $settings['quote']) }}</textarea>
                @error('quote') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Name <span style="color:var(--red-600)">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="nameInput" value="{{ old('name', $settings['name']) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Title <span style="color:var(--red-600)">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="titleInput" value="{{ old('title', $settings['title']) }}" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Photo</label>
                <div id="dropZone" style="border:2px dashed var(--gray-200);border-radius:var(--radius-md);padding:1.5rem;text-align:center;cursor:pointer;transition:all .2s" onclick="document.getElementById('imageInput').click()">
                    <i class="bi bi-cloud-arrow-up" style="font-size:1.5rem;color:var(--gray-400)"></i>
                    <div style="font-size:.8rem;color:var(--gray-500);margin-top:.25rem">{{ $settings['image'] ? 'Click to replace photo' : 'Click to upload photo' }}</div>
                    <div style="font-size:.7rem;color:var(--gray-400)">JPG, PNG (max 2MB)</div>
                </div>
                <input type="file" name="image" class="form-control d-none" id="imageInput" accept="image/*">
                @if($settings['image'])
                <div id="currentImage" style="margin-top:.5rem">
                    <img src="{{ asset('img/' . $settings['image']) }}" alt="Founder" style="height:64px;width:64px;object-fit:cover;border-radius:50%;border:2px solid var(--gray-200)">
                </div>
                @endif
                <div id="imagePreview" style="margin-top:.5rem;display:none">
                    <img id="previewImg" style="height:64px;width:64px;object-fit:cover;border-radius:50%;border:2px solid var(--gray-200)">
                </div>
                @error('image') <div style="font-size:.75rem;color:var(--red-600);margin-top:.25rem">{{ $message }}</div> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Changes</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:1.5rem">
            <div style="font-size:.72rem;font-weight:600;color:var(--green-600);letter-spacing:.05em;margin-bottom:1rem;text-transform:uppercase">06 — From the founder</div>
            <blockquote style="font-size:.9rem;color:var(--gray-900);line-height:1.5;margin:0 0 1rem 0;font-style:italic;border-left:3px solid var(--green-500);padding-left:1rem" id="previewQuote">"{{ $settings['quote'] }}"</blockquote>
            <div style="display:flex;align-items:center;gap:.75rem">
                @if($settings['image'])
                <img src="{{ asset('img/' . $settings['image']) }}" alt="Founder" id="previewImage" style="width:40px;height:40px;border-radius:50%;object-fit:cover">
                @else
                <div id="previewImagePlaceholder" style="width:40px;height:40px;border-radius:50%;background:var(--gray-100);display:flex;align-items:center;justify-content:center;color:var(--gray-400)"><i class="bi bi-person"></i></div>
                @endif
                <div>
                    <div style="font-size:.8rem;font-weight:600;color:var(--gray-900)" id="previewName">{{ $settings['name'] }}</div>
                    <div style="font-size:.72rem;color:var(--gray-500)" id="previewTitle">{{ $settings['title'] }}, Fugo Creative Group</div>
                </div>
            </div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">Founder quote section</div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quoteInput = document.getElementById('quoteInput');
    const nameInput = document.getElementById('nameInput');
    const titleInput = document.getElementById('titleInput');
    const previewQuote = document.getElementById('previewQuote');
    const previewName = document.getElementById('previewName');
    const previewTitle = document.getElementById('previewTitle');

    quoteInput.addEventListener('input', () => { previewQuote.textContent = '"' + (quoteInput.value || 'Quote...') + '"'; });
    nameInput.addEventListener('input', () => { previewName.textContent = nameInput.value || 'Name'; });
    titleInput.addEventListener('input', () => { previewTitle.textContent = (titleInput.value || 'Title') + ', Fugo Creative Group'; });

    const imageInput = document.getElementById('imageInput');
    const dropZone = document.getElementById('dropZone');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const url = URL.createObjectURL(this.files[0]);
            previewImg.src = url;
            imagePreview.style.display = 'block';
            dropZone.style.display = 'none';
            const currentImage = document.getElementById('currentImage');
            if (currentImage) currentImage.style.display = 'none';
        }
    });

    dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.style.borderColor = 'var(--green-500)'; });
    dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor = 'var(--gray-200)'; });
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = 'var(--gray-200)';
        if (e.dataTransfer.files.length) {
            imageInput.files = e.dataTransfer.files;
            imageInput.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endpush
