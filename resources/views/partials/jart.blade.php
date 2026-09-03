{{-- Generative journal cover art — 5 theme-matched variants picked by seed.
     Usage: @include('partials.jart', ['seed' => $post->id]) --}}
@php
$v = abs((int) ($seed ?? 0)) % 5;
$uid = 'jg' . abs((int) ($seed ?? 0));
@endphp
@if($v === 0)
<svg viewBox="0 0 400 240" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
  <defs><linearGradient id="{{ $uid }}a" x1="0" y1="0" x2="1" y2="1">
    <stop offset="0" stop-color="#3ddc97" stop-opacity=".95"/><stop offset="1" stop-color="#c8f24e" stop-opacity=".3"/></linearGradient></defs>
  <rect width="400" height="240" fill="#0d0f13"/>
  <g stroke="#23272f"><path d="M0 60h400M0 120h400M0 180h400M100 0v240M200 0v240M300 0v240"/></g>
  <circle cx="200" cy="118" r="68" fill="url(#{{ $uid }}a)"/>
  <circle cx="200" cy="118" r="86" fill="none" stroke="#3ddc97" stroke-opacity=".35"/>
</svg>
@elseif($v === 1)
<svg viewBox="0 0 400 240" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
  <defs><radialGradient id="{{ $uid }}b" cx=".5" cy=".5" r=".5">
    <stop offset="0" stop-color="#3ddc97" stop-opacity=".5"/><stop offset="1" stop-color="#3ddc97" stop-opacity="0"/></radialGradient></defs>
  <rect width="400" height="240" fill="#0d0f13"/>
  <rect width="400" height="240" fill="url(#{{ $uid }}b)"/>
  <g fill="none" stroke="#3ddc97">
    <circle cx="290" cy="120" r="34" stroke-width="2"/>
    <circle cx="290" cy="120" r="58" stroke-opacity=".55"/>
    <circle cx="290" cy="120" r="84" stroke-opacity=".28"/>
    <circle cx="290" cy="120" r="112" stroke-opacity=".14" stroke-dasharray="4 6"/>
  </g>
  <circle cx="290" cy="120" r="10" fill="#c8f24e"/>
  <g stroke="#23272f"><path d="M0 200h400"/></g>
</svg>
@elseif($v === 2)
<svg viewBox="0 0 400 240" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
  <defs><linearGradient id="{{ $uid }}c" x1="0" y1="1" x2="0" y2="0">
    <stop offset="0" stop-color="#3ddc97" stop-opacity=".25"/><stop offset="1" stop-color="#3ddc97"/></linearGradient></defs>
  <rect width="400" height="240" fill="#0d0f13"/>
  <g stroke="#23272f"><path d="M0 60h400M0 120h400M0 180h400"/></g>
  <g>
    <rect x="52" y="150" width="26" height="60" rx="4" fill="#23272f"/>
    <rect x="88" y="118" width="26" height="92" rx="4" fill="#23272f"/>
    <rect x="124" y="160" width="26" height="50" rx="4" fill="#23272f"/>
    <rect x="160" y="96" width="26" height="114" rx="4" fill="url(#{{ $uid }}c)"/>
    <rect x="196" y="130" width="26" height="80" rx="4" fill="#23272f"/>
    <rect x="232" y="70" width="26" height="140" rx="4" fill="url(#{{ $uid }}c)"/>
    <rect x="268" y="142" width="26" height="68" rx="4" fill="#23272f"/>
    <rect x="304" y="108" width="26" height="102" rx="4" fill="#c8f24e" opacity=".75"/>
  </g>
</svg>
@elseif($v === 3)
<svg viewBox="0 0 400 240" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
  <defs><linearGradient id="{{ $uid }}d" x1="0" y1="0" x2="1" y2="1">
    <stop offset="0" stop-color="#c8f24e" stop-opacity=".8"/><stop offset="1" stop-color="#3ddc97" stop-opacity=".1"/></linearGradient></defs>
  <rect width="400" height="240" fill="#0d0f13"/>
  <g stroke="#23272f"><path d="M0 60h400M0 120h400M0 180h400M100 0v240M200 0v240M300 0v240"/></g>
  <path d="M120 0 40 240h90L210 0z" fill="url(#{{ $uid }}d)" opacity=".8"/>
  <path d="M250 0 170 240h60L310 0z" fill="url(#{{ $uid }}d)" opacity=".35"/>
  <rect x="262" y="56" width="76" height="76" rx="10" fill="none" stroke="#3ddc97" stroke-width="1.5"/>
  <g fill="#3ddc97"><circle cx="70" cy="70" r="5"/><circle cx="330" cy="180" r="5"/><circle cx="90" cy="190" r="4" opacity=".6"/></g>
</svg>
@else
<svg viewBox="0 0 400 240" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
  <defs><radialGradient id="{{ $uid }}e" cx="0" cy="1" r="1.1">
    <stop offset="0" stop-color="#3ddc97" stop-opacity=".55"/><stop offset="1" stop-color="#3ddc97" stop-opacity="0"/></radialGradient></defs>
  <rect width="400" height="240" fill="#0d0f13"/>
  <rect width="400" height="240" fill="url(#{{ $uid }}e)"/>
  <g fill="none" stroke="#c8f24e">
    <path d="M-20 260 A150 150 0 0 1 130 110" stroke-width="2"/>
    <path d="M-20 260 A200 200 0 0 1 180 60" stroke-opacity=".5"/>
    <path d="M-20 260 A250 250 0 0 1 230 10" stroke-opacity=".25" stroke-dasharray="5 7"/>
  </g>
  <g fill="#23272f">
    <circle cx="330" cy="60" r="3"/><circle cx="352" cy="60" r="3"/><circle cx="374" cy="60" r="3"/>
    <circle cx="330" cy="82" r="3"/><circle cx="352" cy="82" r="3"/><circle cx="374" cy="82" r="3"/>
    <circle cx="330" cy="104" r="3"/><circle cx="352" cy="104" r="3"/><circle cx="374" cy="104" r="3"/>
  </g>
  <circle cx="112" cy="128" r="7" fill="#3ddc97"/>
</svg>
@endif
