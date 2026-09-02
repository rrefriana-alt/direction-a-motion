@extends('admin.layouts.app')
@section('title', 'Create Capability')
@section('page-title', 'Create Capability')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.capabilities.index') }}">Capabilities</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Create Capability</h2>
        <p>Add a new capability card to the homepage</p>
    </div>
    <a href="{{ route('admin.home.capabilities.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start">
    <div class="card-white" style="max-width:640px">
        <form action="{{ route('admin.home.capabilities.store') }}" method="POST" enctype="multipart/form-data" id="capForm">
            @csrf

            <div class="form-group">
                <label class="form-label">Title <span style="color:var(--red-600)">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="titleInput" value="{{ old('title') }}" required placeholder="e.g. Design">
                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Description <span style="color:var(--red-600)">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="descInput" rows="3" required placeholder="Brief description of this capability...">{{ old('description') }}</textarea>
                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Tags</label>
                <div id="tagsContainer" style="display:flex;flex-wrap:wrap;gap:.35rem;padding:.5rem;border:1px solid var(--gray-200);border-radius:var(--radius-md);min-height:38px;cursor:text" onclick="document.getElementById('tagInput').focus()">
                    <input type="text" id="tagInput" style="border:none;outline:none;flex:1;min-width:100px;font-size:.8rem;padding:0" placeholder="Type and press Enter to add tag...">
                </div>
                <input type="hidden" name="tags" id="tagsHidden" value="{{ old('tags') }}">
                <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Press Enter or comma to add a tag</div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <div class="form-group">
                    <label class="form-label">Number</label>
                    <input type="number" class="form-control" name="number" id="numberInput" value="{{ old('number', 1) }}" min="0">
                    <div style="font-size:.72rem;color:var(--gray-400);margin-top:.25rem">Card number (01, 02, etc.)</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Card Image</label>
                <div id="dropZone" style="border:2px dashed var(--gray-200);border-radius:var(--radius-md);padding:1.5rem;text-align:center;cursor:pointer;transition:all .2s" onclick="document.getElementById('imageInput').click()">
                    <i class="bi bi-cloud-arrow-up" style="font-size:1.5rem;color:var(--gray-400)"></i>
                    <div style="font-size:.8rem;color:var(--gray-500);margin-top:.25rem">Click to upload or drag and drop</div>
                    <div style="font-size:.7rem;color:var(--gray-400)">JPG, PNG, SVG, WebP (max 4MB)</div>
                </div>
                <input type="file" class="form-control d-none" name="image" id="imageInput" accept="image/*">
                <div id="imagePreview" style="margin-top:.5rem;display:none">
                    <img id="previewImg" style="max-width:100%;max-height:120px;border-radius:var(--radius-sm);border:1px solid var(--gray-200)">
                    <button type="button" class="btn btn-secondary btn-sm" style="margin-top:.25rem;font-size:.7rem" onclick="removeImage()"><i class="bi bi-x"></i> Remove</button>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.home.capabilities.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Save Capability</button>
            </div>
        </form>
    </div>

    <div>
        <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Live Preview</div>
        <div class="card-white" style="padding:0;overflow:hidden">
            <div style="height:140px;background:var(--gray-900);overflow:hidden;display:flex;align-items:center;justify-content:center">
                <img id="cardPreviewImg" style="display:none;width:100%;height:100%;object-fit:cover">
                <div id="cardPreviewPlaceholder" style="color:var(--gray-600)"><i class="bi bi-image" style="font-size:1.5rem"></i></div>
            </div>
            <div style="padding:1rem">
                <div style="font-size:.65rem;font-weight:700;color:var(--green-600);letter-spacing:.05em;margin-bottom:.5rem" id="cardPreviewNumber">01</div>
                <div style="font-size:.9rem;font-weight:600;color:var(--gray-900);margin-bottom:.25rem" id="cardPreviewTitle">Title</div>
                <div style="font-size:.73rem;color:var(--gray-500);margin-bottom:.75rem" id="cardPreviewDesc">Description will appear here...</div>
                <div class="d-flex gap-1" style="flex-wrap:wrap" id="cardPreviewTags"></div>
            </div>
        </div>
        <div style="font-size:.72rem;color:var(--gray-400);margin-top:.5rem;text-align:center">This is how it will appear on the homepage</div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live preview
    const titleInput = document.getElementById('titleInput');
    const descInput = document.getElementById('descInput');
    const numberInput = document.getElementById('numberInput');
    const previewTitle = document.getElementById('cardPreviewTitle');
    const previewDesc = document.getElementById('cardPreviewDesc');
    const previewNumber = document.getElementById('cardPreviewNumber');

    titleInput.addEventListener('input', () => { previewTitle.textContent = titleInput.value || 'Title'; });
    descInput.addEventListener('input', () => { previewDesc.textContent = descInput.value || 'Description will appear here...'; });
    numberInput.addEventListener('input', () => { previewNumber.textContent = String(numberInput.value || 1).padStart(2, '0'); });

    // Tags
    let tags = [];
    const tagInput = document.getElementById('tagInput');
    const tagsHidden = document.getElementById('tagsHidden');
    const tagsContainer = document.getElementById('tagsContainer');
    const previewTags = document.getElementById('cardPreviewTags');

    function renderTags() {
        tagsContainer.querySelectorAll('.tag-chip').forEach(el => el.remove());
        previewTags.innerHTML = '';
        tags.forEach((tag, i) => {
            const chip = document.createElement('span');
            chip.className = 'tag-chip';
            chip.style.cssText = 'background:var(--gray-100);color:var(--gray-700);padding:.15rem .5rem;border-radius:4px;font-size:.73rem;display:flex;align-items:center;gap:.25rem';
            chip.innerHTML = tag + ' <button type="button" style="background:none;border:none;color:var(--gray-400);cursor:pointer;padding:0;font-size:.8rem" onclick="removeTag(' + i + ')">&times;</button>';
            tagsContainer.insertBefore(chip, tagInput);
            previewTags.innerHTML += '<span style="background:var(--gray-100);color:var(--gray-600);padding:.1rem .4rem;border-radius:4px;font-size:.6rem;font-weight:500">' + tag + '</span>';
        });
        tagsHidden.value = tags.join(',');
    }

    window.removeTag = function(i) {
        tags.splice(i, 1);
        renderTags();
    };

    tagInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const val = tagInput.value.replace(',', '').trim();
            if (val && !tags.includes(val)) {
                tags.push(val);
                renderTags();
            }
            tagInput.value = '';
        }
    });

    // Image preview
    const imageInput = document.getElementById('imageInput');
    const dropZone = document.getElementById('dropZone');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const cardPreviewImg = document.getElementById('cardPreviewImg');
    const cardPreviewPlaceholder = document.getElementById('cardPreviewPlaceholder');

    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const url = URL.createObjectURL(this.files[0]);
            previewImg.src = url;
            imagePreview.style.display = 'block';
            dropZone.style.display = 'none';
            cardPreviewImg.src = url;
            cardPreviewImg.style.display = 'block';
            cardPreviewPlaceholder.style.display = 'none';
        }
    });

    window.removeImage = function() {
        imageInput.value = '';
        imagePreview.style.display = 'none';
        dropZone.style.display = 'block';
        cardPreviewImg.style.display = 'none';
        cardPreviewPlaceholder.style.display = 'flex';
    };

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
