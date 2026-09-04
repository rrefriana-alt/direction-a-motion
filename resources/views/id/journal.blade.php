<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>Journal — Fugo Creative — Notes, stories &amp; takes</title>
<meta name="description" content="Process notes, project stories and takes on the creative industry from Fugo Creative Group — Bandung, Jakarta, Bali.">
<meta name="theme-color" content="#07080a">
<link rel="canonical" href="https://fugocreativegroup.com/journal">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Fugo Creative">
<meta property="og:locale" content="id_ID">
<meta property="og:locale:alternate" content="en_US">
<meta property="og:title" content="Journal — Fugo Creative">
<meta property="og:description" content="Process notes, project stories and takes on the creative industry from Fugo Creative Group.">
<meta property="og:url" content="https://fugocreativegroup.com/journal">
<meta property="og:image" content="https://fugocreativegroup.com/assets/img/og.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Journal — Fugo Creative">
<meta name="twitter:description" content="Process notes, project stories and takes on the creative industry from Fugo Creative Group.">
<meta name="twitter:image" content="https://fugocreativegroup.com/assets/img/og.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wdth,wght@12..96,75..100,400..800&family=Inter+Tight:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/core.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/motion.css') }}">
<link rel="apple-touch-icon" href="{{ asset('assets/img/apple-touch-icon.png') }}">
<link rel="icon" href="{{ asset('assets/img/apple-touch-icon.png') }}" type="image/png">
<script>/* set before first paint: only pages arrived at via a curtain
   transition start covered, so a failed script can never black out the site */
try{if(sessionStorage.getItem('fugo-nav')){document.documentElement.classList.add('nav-in');sessionStorage.removeItem('fugo-nav');}}catch(e){}</script>
</head>
<body>

<!-- page-transition curtain -->
<div class="curtain" aria-hidden="true"><span class="curtain__mark">Create to <em>melesat bersama.</em></span></div>

<div class="prog" aria-hidden="true"></div>
<header class="nav is-solid">
  <div class="nav__in">
    <a class="brand" href="{{ url($locale) }}" aria-label="Fugo Creative — home">
      <img class="brand__mark" src="{{ asset('assets/img/logo-full.webp') }}" alt="Fugo Creative">
    </a>
    <nav class="nav__links" aria-label="Primary">
      <a class="nav__link" href="{{ url($locale) }}">Beranda</a>
      <a class="nav__link" href="{{ url($locale.'/work') }}">Karya</a>
      <a class="nav__link" href="{{ url($locale.'/services') }}">Layanan</a>
      <a class="nav__link" href="{{ url($locale.'/about') }}">Studio</a>
      <a class="nav__link" href="{{ url($locale.'/contact') }}">Kontak</a>
    </nav>
    <div class="nav__side">
                        @php $p = trim(preg_replace('#^(en|id)(/|$)#', '', trim(request()->path(), '/')), '/'); $qs = request()->getQueryString() ? '?' . request()->getQueryString() : ''; @endphp
            <div class="lang" data-lang="id" role="group" aria-label="Language">
        <span class="lang__pill" aria-hidden="true"></span>
        <a class="lang__btn" href="{{ url('en' . ($p ? '/'.$p : '') . $qs) }}" aria-label="English">EN</a>
        <a class="lang__btn is-on" href="{{ url('id' . ($p ? '/'.$p : '') . $qs) }}" aria-label="Bahasa Indonesia">ID</a>
      </div>
      <a class="btn btn--green btn--sm" href="{{ url($locale.'/contact') }}" data-magnet=".28">Mulai proyek</a>
      <button class="burger" aria-label="Menu" aria-expanded="false"><i></i><i></i></button>
    </div>
  </div>
</header>
<div class="menu" id="menu">
  <ul class="menu__list">
    <li class="menu__item"><a href="{{ url($locale) }}">Beranda</a></li>
    <li class="menu__item"><a href="{{ url($locale.'/work') }}">Karya</a></li>
    <li class="menu__item"><a href="{{ url($locale.'/services') }}">Layanan</a></li>
    <li class="menu__item"><a href="{{ url($locale.'/about') }}">Studio</a></li>
    <li class="menu__item"><a href="{{ url($locale.'/contact') }}">Kontak</a></li>
  </ul>
  <div class="menu__foot">
    <span>hello@fugocreativegroup.com</span><span>+62 821 2100 0680</span><span>Bandung — Jakarta — Bali</span>
  </div>
</div>
<main>

<section class="phead">
  <div class="phead__glow" aria-hidden="true"></div>
  <div class="shell">
    <p class="crumb fade-up"><a href="{{ url($locale) }}">Fugo</a> <span>/</span> <span>Jurnal</span></p>
    <h1 class="display h-xxl mt-s fade-up" data-delay="1">Jurnal<br>studio</h1>
    <p class="lede mt-m fade-up" data-delay="2">Catatan proses, cerita proyek, dan pandangan soal industri — ditulis oleh orang-orang yang membuat karyanya.</p>
  </div>
</section>

<section class="section" style="padding-top:clamp(2rem,4vw,3rem)">
  <div class="shell">
    <div class="chips fade-up" style="margin-bottom:2.5rem" role="group" aria-label="Filter">
      <a class="chip {{ empty($activeCategory) ? 'on' : '' }}" href="{{ route('journal.index', ['locale'=>$locale]) }}">Semua</a>
      @foreach($categories as $cat)
        <a class="chip {{ $activeCategory === $cat ? 'on' : '' }}" href="{{ route('journal.index', ['category' => $cat]) }}">{{ ucfirst($cat) }}</a>
      @endforeach
    </div>

    @if($posts->count())
    <p class="mono faint fade-up" style="margin-bottom:1.8rem">{{ $posts->total() }} <span>artikel</span></p>
    <div class="bgrid">
      @foreach($posts as $i => $post)
      <article class="bcard fade-up" data-delay="{{ $i % 3 }}" data-cursor="Read">
        <div class="bcard__art">
          @if(!empty($post->featured_image) && file_exists(public_path('img/' . $post->featured_image)))
            <img src="{{ asset('img/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy">
          @else
            @include('partials.jart', ['seed' => $post->id])
          @endif
          <span class="tag">{{ $post->category_display }}</span>
        </div>
        <div class="bcard__body">
          <div class="bcard__meta">
            <span class="green">{{ str_pad($posts->firstItem() + $i, 2, '0', STR_PAD_LEFT) }}</span>
            <span class="dot">&bull;</span>
            <span>{{ $post->published_date?->format('d M Y') }}</span>
            <span class="dot">&bull;</span>
            <span>{{ $post->read_time }} min read</span>
          </div>
          <h3><a href="{{ route('journal.show', ['locale'=>$locale, 'slug'=>$post->slug]) }}">{{ $post->title }}</a></h3>
          <p class="bcard__ex">{{ $post->excerpt }}</p>
          <div class="bcard__foot">
            <a class="tlink green" href="{{ route('journal.show', ['locale'=>$locale, 'slug'=>$post->slug]) }}">Read article →</a>
          </div>
        </div>
      </article>
      @endforeach
    </div>

    @if($posts->hasPages())
    <div class="jpager">
      <nav aria-label="Journal pages">
        @if($posts->onFirstPage())
          <span aria-disabled="true">←</span>
        @else
          <a href="{{ $posts->previousPageUrl() }}" aria-label="Previous page">←</a>
        @endif
        @foreach(range(1, $posts->lastPage()) as $page)
          @if($page == $posts->currentPage())
            <span aria-current="page">{{ $page }}</span>
          @else
            <a href="{{ $posts->url($page) }}">{{ $page }}</a>
          @endif
        @endforeach
        @if($posts->hasMorePages())
          <a href="{{ $posts->nextPageUrl() }}" aria-label="Next page">→</a>
        @else
          <span aria-disabled="true">→</span>
        @endif
      </nav>
    </div>
    @endif
    @else
    <p class="lede muted">Belum ada artikel — silakan kembali lagi.</p>
    @endif
  </div>
</section>

<section class="section cta">
  <div class="cta__glow" aria-hidden="true"></div>
  <div class="shell">
    <p class="eyebrow is-plain fade-up" style="justify-content:center">Tersedia untuk proyek Q4 2026</p>
    <h2 class="display cta__big mt-s fade-up" data-delay="1">Ayo bangun<br>sesuatu</h2>
    <div class="row gap-s mt-l fade-up" data-delay="2" style="justify-content:center">
      <a class="btn btn--green" href="{{ url($locale.'/contact') }}" data-magnet=".34" data-cursor="Go"><span>Mulai proyek</span><span class="ico" aria-hidden="true">↗</span></a>
      <a class="btn btn--ghost" href="mailto:hello@fugocreativegroup.com">hello@fugocreativegroup.com</a>
    </div>
  </div>
</section>
</main>

<footer class="foot">
  <div class="shell">
    <div class="foot__top">
      <div>
        <a class="brand" href="{{ url($locale) }}">
          <img class="brand__mark" src="{{ asset('assets/img/logo-full.webp') }}" alt="Fugo Creative">
        </a>
        <p class="muted mt-m" style="max-width:34ch;font-size:.92rem">PT Fugo Creative Group — creative company yang menghadirkan solusi inovatif dan berdampak sejak 2016.</p>
      </div>
      <div>
        <h5>Navigasi</h5>
        <ul><li><a href="{{ url($locale.'/work') }}">Karya</a></li><li><a href="{{ url($locale.'/services') }}">Layanan</a></li><li><a href="{{ url($locale.'/about') }}">Studio</a></li><li><a href="{{ url($locale.'/contact') }}">Kontak</a></li><li><a href="{{ url($locale.'/contact') }}">Karier</a></li></ul>
      </div>
      <div>
        <h5>Ikuti</h5>
        <ul>
          <li><a href="https://instagram.com/fugocreative" rel="noopener">Instagram</a></li>
          <li><a href="https://id.linkedin.com/company/fugo-creativegroup" rel="noopener">LinkedIn</a></li>
          <li><a href="https://tiktok.com/@fugo.creative" rel="noopener">TikTok</a></li>
          <li><a href="https://youtube.com/@fugocreative" rel="noopener">YouTube</a></li>
        </ul>
      </div>
      <div>
        <h5>Studio</h5>
        <address><strong style="color:var(--ink)">Bandung — HQ</strong><br>Jl. Permata Taman Sari Raya No.21, Arcamanik</address>
        <address><strong style="color:var(--ink)">Jakarta</strong><br>Jl. Srengseng Sawah No.16, Jagakarsa</address>
        <address><strong style="color:var(--ink)">Bali</strong><br>Jl. Tukad Melangit, Samplangan, Gianyar</address>
      </div>
    </div>
    <p class="display foot__word" aria-hidden="true">FUGO</p>
    <div class="foot__bot">
      <span>© 2026 PT Fugo Creative Group</span>
      <span><a href="tel:+6282121000680">+62 821 2100 0680</a></span>
    </div>
  </div>
</footer>
<!-- — motion stack ────────────────────────────────────────────────
     GSAP 3.13+ (free, all plugins incl. SplitText) — Lenis.
     Three.js is index-only — the WebGL hero does not exist on inner pages.
     motion.js degrades the whole page gracefully if any of these fail. -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrollTrigger.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/SplitText.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/lenis@1/dist/lenis.min.js" defer></script>
<script src="{{ asset('assets/js/motion.js') }}" defer></script>
</body>
</html>
