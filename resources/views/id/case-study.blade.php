<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>BRI Debit Virtual TVC — Case Study — Fugo Creative</title>
<meta name="description" content="How Fugo produced the BRImo virtual debit launch TVC — concept, script, casting, shoot and post handled in-house on a six-week turnaround across three cities.">
<meta name="theme-color" content="#07080a">
<link rel="canonical" href="https://fugocreativegroup.com/case-study.html">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Fugo Creative">
<meta property="og:locale" content="id_ID">
<meta property="og:locale:alternate" content="en_US">
<meta property="og:title" content="BRI Debit Virtual TVC — Case Study — Fugo Creative">
<meta property="og:description" content="How Fugo produced the BRImo virtual debit launch TVC — concept, script, casting, shoot and post handled in-house on a six-week turnaround across three cities.">
<meta property="og:url" content="https://fugocreativegroup.com/case-study.html">
<meta property="og:image" content="https://fugocreativegroup.com/assets/img/og.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="BRI Debit Virtual TVC — Case Study — Fugo Creative">
<meta name="twitter:description" content="How Fugo produced the BRImo virtual debit launch TVC — concept, script, casting, shoot and post handled in-house on a six-week turnaround across three cities.">
<meta name="twitter:image" content="https://fugocreativegroup.com/assets/img/og.png">
<script type="application/ld+json">
{"@@context":"https://schema.org","@@graph":[
 {"@@type":"Organization","@@id":"https://fugocreativegroup.com/#org",
  "name":"PT Fugo Creative Group","alternateName":"Fugo Creative",
  "url":"https://fugocreativegroup.com/","logo":"https://fugocreativegroup.com/assets/img/og.png",
  "email":"hello@fugocreativegroup.com","telephone":"+62-821-2100-0680","foundingDate":"2016",
  "description":"Indonesian creative group: design, production house, events, merchandise and AI agents.",
  "sameAs":["https://instagram.com/fugocreative","https://id.linkedin.com/company/fugo-creativegroup"],
  "address":{"@@type":"PostalAddress","streetAddress":"Jl. Permata Taman Sari Raya No.21, Arcamanik","addressLocality":"Bandung","addressCountry":"ID"}},
 {"@@type":"LocalBusiness","name":"Fugo Creative — Bandung (HQ)","parentOrganization":{"@@id":"https://fugocreativegroup.com/#org"},
  "image":"https://fugocreativegroup.com/assets/img/og.png","telephone":"+62-821-2100-0680",
  "address":{"@@type":"PostalAddress","streetAddress":"Jl. Permata Taman Sari Raya No.21, Arcamanik","addressLocality":"Bandung","addressCountry":"ID"}},
 {"@@type":"LocalBusiness","name":"Fugo Creative — Jakarta","parentOrganization":{"@@id":"https://fugocreativegroup.com/#org"},
  "image":"https://fugocreativegroup.com/assets/img/og.png","telephone":"+62-821-2100-0680",
  "address":{"@@type":"PostalAddress","streetAddress":"Jl. Srengseng Sawah No.16, Jagakarsa","addressLocality":"Jakarta Selatan","addressCountry":"ID"}},
 {"@@type":"LocalBusiness","name":"Fugo Creative — Bali","parentOrganization":{"@@id":"https://fugocreativegroup.com/#org"},
  "image":"https://fugocreativegroup.com/assets/img/og.png","telephone":"+62-821-2100-0680",
  "address":{"@@type":"PostalAddress","streetAddress":"Jl. Tukad Melangit, Samplangan","addressLocality":"Gianyar, Bali","addressCountry":"ID"}}
]}
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wdth,wght@12..96,75..100,400..800&family=Inter+Tight:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/core.css') }}?v={{ filemtime(public_path('assets/css/core.css')) }}">
<link rel="stylesheet" href="{{ asset('assets/css/motion.css') }}?v={{ filemtime(public_path('assets/css/motion.css')) }}">
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
      <a class="nav__link" href="{{ url($locale.'/about') }}">Tentang</a>
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
    <li class="menu__item"><a href="{{ url($locale.'/about') }}">Tentang</a></li>
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
    <p class="crumb fade-up"><a href="{{ url($locale) }}">Fugo</a> <span>/</span> <a href="{{ url($locale.'/work') }}">Karya</a> <span>/</span> <span>BRI</span></p>
    <h1 class="display h-xxl mt-s fade-up" data-delay="1">BRI Debit<br>Virtual TVC</h1>
    <div class="row gap-l mt-m fade-up" data-delay="2">
      <div><p class="mono faint">Klien</p><p class="mt-s">Bank Rakyat Indonesia</p></div>
      <div><p class="mono faint">Lingkup</p><p class="mt-s">Konsep — Naskah — Produksi — Pasca</p></div>
      <div><p class="mono faint">Tahun</p><p class="mt-s">2025</p></div>
      <div><p class="mono faint">Divisi</p><p class="mt-s">Rumah Produksi</p></div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:clamp(1.5rem,3vw,2.5rem)">
  <div class="shell">
    <div class="card fade-up" style="padding:0;overflow:hidden">
      <div style="aspect-ratio:16/8">
        <svg viewBox="0 0 1200 600" preserveAspectRatio="xMidYMid slice" style="width:100%;height:100%">
          <defs><linearGradient id="cs" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#0e3c8c"/><stop offset="1" stop-color="#07080a"/></linearGradient></defs>
          <rect width="1200" height="600" fill="url(#cs)"/>
          <circle cx="900" cy="150" r="260" fill="#3ddc97" opacity=".13"/>
          <rect x="120" y="190" width="380" height="240" rx="24" fill="#0b1226" stroke="#3ddc97" stroke-opacity=".45"/>
          <rect x="164" y="240" width="86" height="58" rx="10" fill="#c8f24e" opacity=".85"/>
          <text x="164" y="380" fill="#e8eaf2" font-family="monospace" font-size="30" letter-spacing="7">•••• 8842</text>
          <path d="M640 430c90-140 200-180 420-150" stroke="#c8f24e" stroke-width="2" fill="none" opacity=".7"/>
        </svg>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell grid g-12">
    <div class="col-4"><p class="eyebrow fade-up">Brief</p></div>
    <div class="col-8">
      <p class="h-lg fade-up" style="max-width:26ch">Menjelaskan produk yang tidak bisa dipegang.</p>
      <p class="lede mt-m fade-up" data-delay="1">Kartu debit virtual BRImo tidak punya objek fisik untuk difilmkan, tidak ada kemasan untuk dibuka, dan daftar kepatuhan yang lebih panjang dari naskahnya. Iklan ini harus membuat produk tak kasat mata terasa lebih aman daripada kartu plastik.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell grid g-12">
    <div class="col-4"><p class="eyebrow fade-up">Yang kami lakukan</p></div>
    <div class="col-8">
      <div class="steps">
        <div class="step fade-up"><span class="step__n">01</span><div class="step__b"><h3>Menemukan momen manusia</h3><p>Kami berhenti menjual kartunya dan mulai memfilmkan dua detik setelah seseorang sadar ia bisa membayar tanpa kartu.</p></div></div>
        <div class="step fade-up" data-delay="1"><span class="step__n">02</span><div class="step__b"><h3>Membangun UI di kamera</h3><p>Konten layar dirender lebih dulu dan diputar di lokasi syuting, sehingga tim kepatuhan menyetujui frame yang benar-benar tayang.</p></div></div>
        <div class="step fade-up" data-delay="2"><span class="step__n">03</span><div class="step__b"><h3>Sekali edit, sembilan format</h3><p>Satu kali syuting menghasilkan TVC 30 detik, tiga cutdown 15 detik, edit vertikal untuk sosial, dan loop LED di cabang.</p></div></div>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell">
    <div class="stats">
      <div class="stat fade-up"><p class="stat__n"><span data-count="9">0</span></p><p class="stat__l">Deliverable dari satu syuting</p></div>
      <div class="stat fade-up" data-delay="1"><p class="stat__n"><span data-count="6">0</span></p><p class="stat__l">Brief ke tayang</p></div>
      <div class="stat fade-up" data-delay="2"><p class="stat__n"><span data-count="0">0</span></p><p class="stat__l">Syuting ulang kepatuhan</p></div>
      <div class="stat fade-up" data-delay="3"><p class="stat__n"><span data-count="3">0</span></p><p class="stat__l">Kanal tayang pekan yang sama</p></div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell row between center gap-m">
    <a class="tlink" href="{{ url($locale.'/work') }}">← Semua karya</a>
    <a class="tlink green" href="{{ url($locale.'/work') }}"Proyek berikutnya →">Proyek berikutnya →</a>
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
          <svg class="brand__mark" viewBox="0 0 32 32" aria-hidden="true"><path d="M11 6h14l-3.4 5.6H7.6zM7.6 14h12l-3.4 5.6H4.2zM4.2 22h10l-3.4 5.6H.8z" fill="#3ddc97"/></svg>
          <span class="brand__txt">Fugo<span>Creative</span></span>
        </a>
        <p class="muted mt-m" style="max-width:34ch;font-size:.92rem">PT Fugo Creative Group — creative company yang menghadirkan solusi inovatif dan berdampak sejak 2016.</p>
      </div>
      <div>
        <h5>Navigasi</h5>
        <ul><li><a href="{{ url($locale.'/work') }}">Karya</a></li><li><a href="{{ url($locale.'/services') }}">Layanan</a></li><li><a href="{{ url($locale.'/about') }}">Tentang</a></li><li><a href="{{ url($locale.'/contact') }}">Kontak</a></li><li><a href="{{ url($locale.'/contact') }}">Karier</a></li></ul>
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
        <h5>Kantor</h5>
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
