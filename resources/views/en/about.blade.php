<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>About — Fugo Creative — Indonesian Creative Group Since 2016</title>
<meta name="description" content="PT Fugo Creative Group started in 2016 printing merchandise in Bandung. Nine years on: five divisions, three cities, 65+ clients across finance, government and lifestyle.">
<meta name="theme-color" content="#07080a">
<link rel="canonical" href="https://fugocreativegroup.com/about.html">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Fugo Creative">
<meta property="og:locale" content="en_US">
<meta property="og:locale:alternate" content="id_ID">
<meta property="og:title" content="About — Fugo Creative — Indonesian Creative Group Since 2016">
<meta property="og:description" content="PT Fugo Creative Group started in 2016 printing merchandise in Bandung. Nine years on: five divisions, three cities, 65+ clients across finance, government and lifestyle.">
<meta property="og:url" content="https://fugocreativegroup.com/about.html">
<meta property="og:image" content="https://fugocreativegroup.com/assets/img/og.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="About — Fugo Creative — Indonesian Creative Group Since 2016">
<meta name="twitter:description" content="PT Fugo Creative Group started in 2016 printing merchandise in Bandung. Nine years on: five divisions, three cities, 65+ clients across finance, government and lifestyle.">
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
<div class="curtain" aria-hidden="true"><span class="curtain__mark">Create to <em>Elevate</em></span></div>

<div class="prog" aria-hidden="true"></div>
<header class="nav is-solid">
  <div class="nav__in">
    <a class="brand" href="{{ url($locale) }}" aria-label="Fugo Creative — home">
      <img class="brand__mark" src="{{ asset('assets/img/logo-full.webp') }}" alt="Fugo Creative">
    </a>
    <nav class="nav__links" aria-label="Primary">
      <a class="nav__link" href="{{ url($locale) }}">Home</a>
      <a class="nav__link" href="{{ url($locale.'/work') }}">Work</a>
      <a class="nav__link" href="{{ url($locale.'/services') }}">Services</a>
      <a class="nav__link is-active" href="{{ url($locale.'/about') }}">About</a>
      <a class="nav__link" href="{{ url($locale.'/contact') }}">Contact</a>
    </nav>
    <div class="nav__side">
                        @php $p = trim(preg_replace('#^(en|id)(/|$)#', '', trim(request()->path(), '/')), '/'); $qs = request()->getQueryString() ? '?' . request()->getQueryString() : ''; @endphp
            <div class="lang" data-lang="en" role="group" aria-label="Language">
        <span class="lang__pill" aria-hidden="true"></span>
        <a class="lang__btn is-on" href="{{ url('en' . ($p ? '/'.$p : '') . $qs) }}" aria-label="English">EN</a>
        <a class="lang__btn" href="{{ url('id' . ($p ? '/'.$p : '') . $qs) }}" aria-label="Bahasa Indonesia">ID</a>
      </div>
      <a class="btn btn--green btn--sm" href="{{ url($locale.'/contact') }}" data-magnet=".28">Start a project</a>
      <button class="burger" aria-label="Menu" aria-expanded="false"><i></i><i></i></button>
    </div>
  </div>
</header>
<div class="menu" id="menu">
  <ul class="menu__list">
    <li class="menu__item"><a href="{{ url($locale) }}">Home</a></li>
    <li class="menu__item"><a href="{{ url($locale.'/work') }}">Work</a></li>
    <li class="menu__item"><a href="{{ url($locale.'/services') }}">Services</a></li>
    <li class="menu__item"><a href="{{ url($locale.'/about') }}">About</a></li>
    <li class="menu__item"><a href="{{ url($locale.'/contact') }}">Contact</a></li>
  </ul>
  <div class="menu__foot">
    <span>hello@fugocreativegroup.com</span><span>+62 821 2100 0680</span><span>Bandung — Jakarta — Bali</span>
  </div>
</div>
<main>

<section class="phead">
  <div class="phead__glow" aria-hidden="true"></div>
  <div class="shell">
    <p class="crumb fade-up"><a href="{{ url($locale) }}">Fugo</a> <span>/</span> <span>About</span></p>
    @php $aboutHeadline = \App\Models\Setting::get('about_page_headline', 'A creative group,<br>not a vendor list'); @endphp
    <h1 class="display h-xxl mt-s fade-up" data-delay="1">{!! $aboutHeadline !!}</h1>
    @php $aboutSubtitle = \App\Models\Setting::get('about_page_subtitle', 'We started in 2016 printing merchandise. Nine years later we run five divisions across three cities — and we still answer the phone ourselves.'); @endphp
    <p class="lede mt-m fade-up" data-delay="2">{{ $aboutSubtitle }}</p>
  </div>
</section>
<section class="section" style="padding-top:clamp(2rem,4vw,3rem)">
  <div class="shell grid g-12">
    <div class="col-5">
      @php $beliefTitle = \App\Models\Setting::get('about_belief_title', 'Our belief'); @endphp
      <p class="eyebrow fade-up">{{ $beliefTitle }}</p>
    </div>
    <div class="col-7">
      @php $beliefText = \App\Models\Setting::get('about_belief_text', 'Every brief can be solved with creativity, an innovative route, and execution that actually lands.'); @endphp
      <p class="h-lg fade-up" style="font-size:clamp(1.3rem,2.6vw,2rem);max-width:24ch">{{ $beliefText }}</p>
      @php $beliefElab = \App\Models\Setting::get('about_belief_elaboration', 'We reject the word impossible. Not as a slogan — as a working method: when a route is blocked we go and find the next one, and we tell you what it costs before you commit.'); @endphp
      <p class="lede mt-m fade-up" data-delay="1">{{ $beliefElab }}</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell">
    <div class="stats">
      @foreach($statistics as $index => $stat)
      <div class="stat fade-up" @if($index > 0) data-delay="{{ $index }}" @endif><p class="stat__n"><span data-count="{{ $stat->value }}">0</span>@if($stat->suffix)<sup>{{ $stat->suffix }}</sup>@endif</p><p class="stat__l">{{ $stat->label }}</p></div>
      @endforeach
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell grid g-12">
    <div class="col-4">
      <p class="eyebrow fade-up">Timeline</p>
      <h2 class="display h-xl mt-s fade-up" data-delay="1">Nine years,<br>four divisions</h2>
    </div>
    <div class="col-8">
      <div class="steps">
        @foreach($timelines as $index => $timeline)
        <div class="step fade-up" @if($index > 0) data-delay="{{ min($index, 5) }}" @endif>
          <span class="step__n">{{ $timeline->year }}</span>
          <div class="step__b"><p class="muted" style="padding-top:.4rem">{{ $timeline->description }}</p></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell">
    <div class="quote fade-up">
      <div>
        <p class="eyebrow" style="margin-bottom:1.6rem">From the founder</p>
        <blockquote>&ldquo;{{ $content['about']['founder']['quote'] }}&rdquo;</blockquote>
        <div class="quote__by">
          @if($ceoProfile && $ceoProfile->photo)
            <img src="{{ asset('img/' . $ceoProfile->photo) }}" alt="{{ $ceoProfile->name }}" class="avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
          @else
            <img src="{{ asset('assets/img/Pa-Sona.jpg') }}" alt="Sona Lesmana" class="avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
          @endif
          <span><strong style="color:var(--ink)">{{ $content['about']['founder']['name'] }}</strong><br>
            <span>{{ $content['about']['founder']['title'] }}</span></span>
        </div>
      </div>
      <div class="quote__art">
        @if($ceoProfile && $ceoProfile->photo)
          <img src="{{ asset('img/' . $ceoProfile->photo) }}" alt="{{ $ceoProfile->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
        @else
          <img src="{{ asset('assets/img/Pa-Sona.jpg') }}" alt="Founder Quote Image" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
        @endif
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell">
    <p class="eyebrow fade-up">Offices</p>
    <h2 class="display h-xl mt-s fade-up" data-delay="1">Three cities</h2>
    <div class="fade-up" data-delay="2" style="display: flex; width: 100%; margin-top: 2.5rem; border: 1px solid rgba(255,255,255,.15); border-radius: 16px; overflow: hidden;">
      <div style="flex: 1; padding: 2rem 2.5rem; border-right: 1px solid rgba(255,255,255,.15); box-sizing: border-box;">
        <h4 style="margin: 0 0 0.8rem 0; font-size: 1.1rem; font-weight: 700; color: #fff;">Bandung — HQ</h4>
        <p class="muted" style="margin: 0; font-size: 0.9rem; line-height: 1.4; opacity: 0.7;">{{ \App\Models\Setting::get('contact_address_bdg', 'Jl. Permata Taman Sari Raya No.21, Arcamanik') }}</p>
      </div>
      <div style="flex: 1; padding: 2rem 2.5rem; border-right: 1px solid rgba(255,255,255,.15); box-sizing: border-box;">
        <h4 style="margin: 0 0 0.8rem 0; font-size: 1.1rem; font-weight: 700; color: #fff;">Jakarta</h4>
        <p class="muted" style="margin: 0; font-size: 0.9rem; line-height: 1.4; opacity: 0.7;">{{ \App\Models\Setting::get('contact_address_jkt', 'Jl. Srengseng Sawah No.16, Jagakarsa') }}</p>
      </div>
      <div style="flex: 1; padding: 2rem 2.5rem; box-sizing: border-box;">
        <h4 style="margin: 0 0 0.8rem 0; font-size: 1.1rem; font-weight: 700; color: #fff;">Bali</h4>
        <p class="muted" style="margin: 0; font-size: 0.9rem; line-height: 1.4; opacity: 0.7;">{{ \App\Models\Setting::get('contact_address_bali', 'Jl. Tukad Melangit, Samplangan, Gianyar') }}</p>
      </div>
    </div>
  </div>
</section>

<section class="section cta">
  <div class="cta__glow" aria-hidden="true"></div>
  <div class="shell">
    <p class="eyebrow is-plain fade-up" style="justify-content:center">Available for Q4 2026 projects</p>
    <h2 class="display cta__big mt-s fade-up" data-delay="1">Let's build<br>something</h2>
    <div class="row gap-s mt-l fade-up" data-delay="2" style="justify-content:center">
      <a class="btn btn--green" href="{{ url($locale.'/contact') }}" data-magnet=".34" data-cursor="Go"><span>Start a project</span><span class="ico" aria-hidden="true">↗</span></a>
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
        <p class="muted mt-m" style="max-width:34ch;font-size:.92rem">PT Fugo Creative Group — a creative company delivering innovative, high-impact solutions since 2016.</p>
      </div>
      <div>
        <h5>Navigate</h5>
        <ul><li><a href="{{ url($locale.'/work') }}">Work</a></li><li><a href="{{ url($locale.'/services') }}">Services</a></li><li><a href="{{ url($locale.'/about') }}">About</a></li><li><a href="{{ url($locale.'/contact') }}">Contact</a></li><li><a href="{{ url($locale.'/contact') }}">Careers</a></li></ul>
      </div>
      <div>
        <h5>Follow</h5>
        <ul>
          <li><a href="https://instagram.com/fugocreative" rel="noopener">Instagram</a></li>
          <li><a href="https://id.linkedin.com/company/fugo-creativegroup" rel="noopener">LinkedIn</a></li>
          <li><a href="https://tiktok.com/@fugo.creative" rel="noopener">TikTok</a></li>
          <li><a href="https://youtube.com/@fugocreative" rel="noopener">YouTube</a></li>
        </ul>
      </div>
      <div>
        <h5>Offices</h5>
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

