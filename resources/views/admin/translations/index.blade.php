@extends('admin.layouts.app')
@section('title', 'Translations — EN | ID')
@section('page-title', 'Translations')
@section('breadcrumb')
    <li class="breadcrumb-item active">Translations</li>
@endsection

@section('content')
<style>
.tr-tabs{display:flex;gap:.35rem;flex-wrap:wrap;margin-bottom:1.25rem}
.tr-tab{padding:.55rem 1rem;border-radius:999px;font-size:.78rem;font-weight:600;border:1px solid var(--gray-200);background:#fff;color:var(--gray-600);text-decoration:none;display:inline-flex;align-items:center;gap:.5rem;transition:all .18s}
.tr-tab:hover{border-color:var(--gray-300);color:var(--gray-800)}
.tr-tab.active{background:var(--gray-900);color:#fff;border-color:var(--gray-900)}
.tr-tab .badge{font-size:.62rem;padding:.15rem .4rem;border-radius:999px;background:var(--gray-100);color:var(--gray-600);font-weight:700}
.tr-tab.active .badge{background:rgba(255,255,255,.18);color:#fff}
.tr-section{background:#fff;border:1px solid var(--gray-200);border-radius:var(--radius-lg);padding:1.25rem 1.25rem 1rem;margin-bottom:1rem}
.tr-section-head{display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem;padding-bottom:.85rem;border-bottom:1px solid var(--gray-100)}
.tr-section-head h3{font-size:.95rem;font-weight:700;color:var(--gray-900);margin:0;display:flex;align-items:center;gap:.5rem}
.tr-section-head .hint{font-size:.72rem;color:var(--gray-400)}
.tr-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
@media(max-width:720px){.tr-grid{grid-template-columns:1fr}}
.tr-bar{height:6px;background:var(--gray-100);border-radius:999px;overflow:hidden}
.tr-bar i{display:block;height:100%;background:var(--green-500);border-radius:999px;transition:width .3s}
</style>

<div class="page-header d-flex justify-content-between align-items-center" style="margin-bottom:1rem">
    <div>
        <h2 style="display:flex;align-items:center;gap:.6rem">Translations <span style="font-size:.7rem;background:#07080a;color:#fff;padding:.2rem .55rem;border-radius:999px;letter-spacing:.06em">EN | ID</span></h2>
        <p>Switching bahasa = switching konten. EN di <code>/en</code> · ID di <code>/id</code>. Edit per page / section — tone samakan tema dark editorial (#07080a, #3ddc97, #c8f24e).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ url('/en') }}" target="_blank" class="btn btn-secondary btn-sm"><i class="bi bi-eye"></i> View EN</a>
        <a href="{{ url('/id') }}" target="_blank" class="btn btn-secondary btn-sm"><i class="bi bi-eye"></i> View ID</a>
    </div>
</div>

<div class="tr-tabs">
    @foreach($groups as $key => $g)
        <a href="{{ route('admin.translations.index', ['tab'=>$key]) }}" class="tr-tab {{ $active===$key ? 'active' : '' }}">
            <i class="bi bi-{{ $g['icon'] }}"></i> {{ $g['label'] }}
            <span class="badge">{{ $stats[$key]['filled'] }}/{{ $stats[$key]['total'] }}</span>
        </a>
    @endforeach
</div>

@php $g = $groups[$active]; @endphp
<div style="display:flex;gap:1rem;align-items:center;margin-bottom:1rem;flex-wrap:wrap">
    <div style="flex:1;min-width:220px">
        <div style="font-size:.72rem;color:var(--gray-500);margin-bottom:.25rem">{{ $g['label'] }} — {{ $stats[$active]['pct'] }}% ID terisi</div>
        <div class="tr-bar"><i style="width:{{ $stats[$active]['pct'] }}%"></i></div>
    </div>
    <div style="font-size:.72rem;color:var(--gray-400)">Tips: ID panjang pakai <code>&lt;br&gt;</code> biar 2 baris hemat space hero.</div>
</div>

<form action="{{ route('admin.translations.update') }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="active_tab" value="{{ $active }}">

    @foreach($g['sections'] as $secKey => $sec)
    <div class="tr-section">
        <div class="tr-section-head">
            <h3><i class="bi bi-layers" style="color:var(--green-500)"></i> {{ $sec['label'] }}</h3>
            <span class="hint">{{ count($sec['keys']) }} field — EN kiri, ID kanan</span>
        </div>

        <div class="tr-grid">
        @foreach($sec['keys'] as $k)
            @php $isTextarea = str_contains($k, 'description') || str_contains($k, 'title') || str_contains($k, 'subtitle') || str_contains($k, 'lede') || strlen($values[$k] ?? '') > 80; @endphp
            <div class="form-group" style="margin-bottom:0">
                <label class="form-label" style="display:flex;justify-content:space-between;align-items:center">
                    <span>{{ str_replace('_', ' ', Str::title(str_replace(['_en','_id'], '', $k))) }} — <span style="color:{{ str_ends_with($k,'_id') ? '#059669' : '#6b7280' }}">{{ str_ends_with($k,'_en') ? 'EN' : (str_ends_with($k,'_id') ? 'ID' : '—') }}</span></span>
                    @if(str_ends_with($k,'_id') && empty(trim($values[$k] ?? ''))) <span style="font-size:.62rem;background:#fef2f2;color:#b91c1c;padding:.1rem .35rem;border-radius:999px;font-weight:700">kosong → fallback EN</span> @endif
                </label>
                @if($isTextarea)
                    <textarea name="{{ $k }}" rows="{{ str_contains($k,'description') || str_contains($k,'subtitle') ? 3 : 2 }}" class="form-control @error($k) is-invalid @enderror" placeholder="{{ $k }}">{{ old($k, $values[$k] ?? '') }}</textarea>
                @else
                    <input type="text" name="{{ $k }}" value="{{ old($k, $values[$k] ?? '') }}" class="form-control @error($k) is-invalid @enderror" placeholder="{{ $k }}">
                @endif
                @error($k) <div class="invalid-feedback">{{ $message }}</div> @enderror
                @if(str_ends_with($k,'_en')) <div style="font-size:.66rem;color:var(--gray-400);margin-top:.2rem">Sumber EN — tampil di /en</div> @else <div style="font-size:.66rem;color:var(--gray-400);margin-top:.2rem">Terjemahan ID — tampil di /id</div> @endif
            </div>
        @endforeach
        </div>
    </div>
    @endforeach

    <div style="position:sticky;bottom:0;background:rgba(249,250,251,.92);backdrop-filter:blur(8px);border:1px solid var(--gray-200);border-radius:var(--radius-lg);padding:.85rem 1rem;display:flex;justify-content:space-between;align-items:center;gap:1rem;margin-top:1rem">
        <div style="font-size:.73rem;color:var(--gray-500)"><i class="bi bi-info-circle" style="color:var(--green-500)"></i> Perubahan langsung aktif di <code>/{{ $active === 'home' ? '' : $active }}</code> per locale — reload <code>/en</code> & <code>/id</code> untuk cek.</div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-check2"></i> Save {{ $g['label'] }} — EN | ID</button>
    </div>
</form>

<div style="margin-top:1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1rem">
    <div class="card-white" style="border-left:3px solid var(--green-500)">
        <div style="font-size:.75rem;font-weight:700;color:var(--gray-900);margin-bottom:.35rem"><i class="bi bi-lightbulb" style="color:var(--green-500)"></i> Tone rekomendasi (frontend gelap)</div>
        <div style="font-size:.76rem;color:var(--gray-600);line-height:1.6">Hero ID pakai <b>Tumbuh dan / melesat bersama.</b> — gradien <code>core.css --grad-signal #3ddc97→#c8f24e</code> di <code>.tint</code>. Manifesto ID: “Tiap tantangan bisnis pasti ada solusinya... on-point.” Biar sinkron tema dark editorial.</div>
    </div>
    <div class="card-white">
        <div style="font-size:.75rem;font-weight:700;color:var(--gray-900);margin-bottom:.35rem">File permanen</div>
        <div style="font-size:.76rem;color:var(--gray-600)">Sisa string jarang ganti tetap di <code>resources/translations/map.json</code> (490 entri, fallback). DB <code>settings</code> adalah source utama untuk switching konten.</div>
    </div>
</div>
@endsection
