@extends('admin.layouts.app')
@section('title', 'Journal Curation')
@section('page-title', 'Journal Curation')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.home.journal.index', ['locale' => $locale]) }}">Journal</a></li>
    <li class="breadcrumb-item active">Curation</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2>Journal Curation</h2>
        <p>Pilih otomatis (terbaru) atau pin manual 3 artikel untuk homepage</p>
    </div>
    <a href="{{ route('admin.home.journal.index', ['locale' => $locale]) }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<div class="card-white" style="max-width:720px">
    <form action="{{ route('admin.home.journal.curation.update', ['locale' => $locale]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Mode Tampil <span style="color:var(--red-600)">*</span></label>
            <div style="display:flex;gap:1.5rem">
                <label style="display:flex;gap:.5rem;align-items:center;font-size:.9rem;cursor:pointer">
                    <input type="radio" name="mode" value="auto" {{ old('mode', $mode) === 'auto' ? 'checked' : '' }}>
                    Auto — 3 artikel published terbaru
                </label>
                <label style="display:flex;gap:.5rem;align-items:center;font-size:.9rem;cursor:pointer">
                    <input type="radio" name="mode" value="manual" {{ old('mode', $mode) === 'manual' ? 'checked' : '' }}>
                    Manual — pin pilihan sendiri
                </label>
            </div>
            @error('mode') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div id="slotBox" style="border:1px dashed var(--gray-200);border-radius:var(--radius);padding:1rem;margin-bottom:1rem">
            <div style="font-size:.75rem;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem">Pin Manual — Slot 1 = Featured (besar), Slot 2–3 = Mini</div>
            @for($s = 1; $s <= 3; $s++)
            <div class="form-group">
                <label class="form-label" for="slot_{{ $s }}">Slot {{ $s }}</label>
                <select id="slot_{{ $s }}" name="slot_{{ $s }}" class="form-control @error('slot_'.$s) is-invalid @enderror">
                    <option value="">— Kosongkan slot —</option>
                    @foreach($options as $opt)
                        <option value="{{ $opt->id }}" {{ (string) old('slot_'.$s, $pinnedIds[$s-1] ?? '') === (string) $opt->id ? 'selected' : '' }}>
                            {{ $opt->title }} — {{ $opt->published_date?->format('d M Y') }}
                        </option>
                    @endforeach
                </select>
                @error('slot_'.$s) <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            @endfor
            <div style="font-size:.72rem;color:var(--gray-400)">Hanya artikel <strong>published</strong> yang bisa di-pin. Slot kosong otomatis diisi artikel terbaru. Jika semua slot kosong/invalid → fallback ke mode Auto.</div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.home.journal.index', ['locale' => $locale]) }}" class="btn btn-secondary btn-sm">Cancel</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Simpan Kurasi</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const box = document.getElementById('slotBox');
    const sync = () => {
        const mode = document.querySelector('input[name="mode"]:checked');
        box.style.opacity = (mode && mode.value === 'manual') ? '1' : '.45';
        box.style.pointerEvents = (mode && mode.value === 'manual') ? 'auto' : 'none';
    };
    document.querySelectorAll('input[name="mode"]').forEach(r => r.addEventListener('change', sync));
    sync();
});
</script>
@endpush
