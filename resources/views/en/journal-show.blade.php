<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>{{ $post->title }} — Fugo Creative Journal</title>
<meta name="description" content="{{ $post->excerpt }}">
<meta name="theme-color" content="#07080a">
<link rel="canonical" href="{{ route('journal.show', ['locale'=>$locale, 'slug'=>$post->slug]) }}">
<meta property="og:type" content="article">
<meta property="og:site_name" content="Fugo Creative">
<meta property="og:locale" content="en_US">
<meta property="og:locale:alternate" content="id_ID">
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ $post->excerpt }}">
<meta property="og:url" content="{{ route('journal.show', ['locale'=>$locale, 'slug'=>$post->slug]) }}">
@if(!empty($post->featured_image))
<meta property="og:image" content="{{ asset('img/' . $post->featured_image) }}">
@else
<meta property="og:image" content="https://fugocreativegroup.com/assets/img/og.png">
@endif
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
      <a class="nav__link" href="{{ url($locale.'/about') }}">Studio</a>
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
    <li class="menu__item"><a href="{{ url($locale.'/about') }}">Studio</a></li>
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
    <div class="article">
      <p class="crumb fade-up"><a href="{{ url($locale) }}">Fugo</a> <span>/</span> <a href="{{ route('journal.index', ['locale'=>$locale]) }}" data-en="Journal" data-id="Jurnal">Journal</a> <span>/</span> <span>{{ $post->category_display }}</span></p>
      <div class="card__tags fade-up" data-delay="1" style="margin-top:1.2rem">
        <a class="tag" href="{{ route('journal.index', ['category' => $post->category]) }}" style="text-decoration:none">{{ $post->category_display }}</a>
        <span class="tag">{{ $post->read_time }} min read</span>
      </div>
      <h1 class="display h-xl mt-s fade-up" data-delay="1">{{ $post->title }}</h1>
      <p class="lede mt-s fade-up" data-delay="2" style="font-size:clamp(1.15rem,1.6vw,1.45rem)">{{ $post->excerpt }}</p>
      <div class="abyline abyline--bare fade-up" data-delay="2">
        <span class="bfeat__avatar" aria-hidden="true">{{ strtoupper(mb_substr($post->author ?? 'F', 0, 1)) }}</span>
        <div>
          <strong>{{ $post->author }}</strong>
          <span>{{ $post->published_date?->format('d M Y') }} &nbsp;·&nbsp; {{ $post->view_count }} <span>reads</span></span>
        </div>
        <div class="ashare">
          <button class="ashare__btn" type="button" data-copylink="{{ route('journal.show', ['locale'=>$locale, 'slug'=>$post->slug]) }}" aria-label="Copy link">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7"/><path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7"/></svg>
            <span class="ashare__tip">Copy link</span>
          </button>
          <a class="ashare__btn" href="https://wa.me/?text={{ urlencode($post->title . ' ' . route('journal.show', ['locale'=>$locale, 'slug'=>$post->slug])) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5-1.3A10 10 0 1 0 12 2zm5.4 14.1c-.2.7-1.3 1.3-1.9 1.4-.5.1-1.1.1-1.8-.1-.4-.1-1-.3-1.7-.6-2.9-1.3-4.8-4.2-5-4.4-.1-.2-1.1-1.5-1.1-2.9s.7-2 1-2.3c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5s.8 1.9.8 2c.1.1.1.3 0 .5l-.4.5c-.1.2-.3.3-.1.6.2.3.8 1.4 1.8 2.2 1.2 1.1 2.3 1.5 2.6 1.6.3.2.5.1.7-.1l.8-1c.2-.3.4-.2.7-.1l2 1c.3.1.5.2.6.4 0 .1 0 .7-.3 1.1z"/></svg>
            <span class="ashare__tip">WhatsApp</span>
          </a>
          <a class="ashare__btn" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('journal.show', ['locale'=>$locale, 'slug'=>$post->slug])) }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.22 8.1h4.56V23H.22V8.1zM8.34 8.1h4.37v2h.06c.61-1.15 2.1-2.37 4.32-2.37 4.62 0 5.47 3.04 5.47 7v8.27h-4.55v-7.33c0-1.75-.03-4-2.44-4-2.44 0-2.82 1.9-2.82 3.87V23H8.34V8.1z"/></svg>
            <span class="ashare__tip">LinkedIn</span>
          </a>
        </div>
      </div>
      @if(!empty($post->featured_image) && file_exists(public_path('img/' . $post->featured_image)))
      <figure class="article__hero fade-up" data-delay="2" style="margin-bottom:0">
        <img src="{{ asset('img/' . $post->featured_image) }}" alt="{{ $post->title }}">
      </figure>
      <figcaption class="article__cap fade-up" data-delay="2">{{ $post->title }} — Fugo Creative, {{ $post->published_date?->format('Y') }}</figcaption>
      @endif
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell">
    <div class="article">
      <div class="article__body fade-up">{!! nl2br(e($post->content)) !!}</div>
      <div class="card__tags fade-up" style="margin-top:2.2rem">
        <a class="tag" href="{{ route('journal.index', ['category' => $post->category]) }}" style="text-decoration:none">{{ $post->category_display }}</a>
        <a class="tag" href="{{ route('journal.index', ['locale'=>$locale]) }}" style="text-decoration:none" data-en="Studio journal" data-id="Jurnal studio">Studio journal</a>
      </div>
      <div class="abyline fade-up">
        <span class="bfeat__avatar" aria-hidden="true">{{ strtoupper(mb_substr($post->author ?? 'F', 0, 1)) }}</span>
        <div>
          <strong>{{ $post->author }}</strong>
          <span>Contributor, Fugo Creative Group — Bandung / Jakarta / Bali</span>
        </div>
      </div>

      @if($newerPost || $olderPost)
      <nav class="aprevnext fade-up" aria-label="More articles">
        @if($newerPost)
        <a class="aprevnext__link" href="{{ route('journal.show', $newerPost->slug) }}">
          <span class="bcard__meta"><span aria-hidden="true">←</span> <span>Newer</span></span>
          <span class="aprevnext__t">{{ $newerPost->title }}</span>
        </a>
        @else
        <span></span>
        @endif
        @if($olderPost)
        <a class="aprevnext__link aprevnext__link--next" href="{{ route('journal.show', $olderPost->slug) }}">
          <span class="bcard__meta"><span>Older</span> <span aria-hidden="true">→</span></span>
          <span class="aprevnext__t">{{ $olderPost->title }}</span>
        </a>
        @endif
      </nav>
      @endif

      <div class="mt-l fade-up">
        <a class="tlink green" href="{{ route('journal.index', ['locale'=>$locale]) }}" data-en="← Back to journal" data-id="← Kembali ke jurnal">← Back to journal</a>
      </div>
    </div>
  </div>
</section>

@if($morePosts->count())
<section class="section" style="padding-top:0">
  <div class="shell">
    <div class="row between end gap-m">
      <div>
        <p class="eyebrow"><span>Keep reading</span></p>
        <h2 class="display h-xl mt-s fade-up" data-delay="1"
            data-en="More from<br>the studio" data-id="Lainnya dari<br>studio">More from<br>the studio</h2>
      </div>
      <a class="tlink fade-up" data-delay="2" href="{{ route('journal.index', ['locale'=>$locale]) }}"
         data-en="All articles →" data-id="Semua artikel →">All articles →</a>
    </div>
    <div class="bgrid mt-l">
      @foreach($morePosts as $i => $more)
      <article class="bcard fade-up" data-delay="{{ $i }}" data-cursor="Read">
        <div class="bcard__art">
          @if(!empty($more->featured_image) && file_exists(public_path('img/' . $more->featured_image)))
            <img src="{{ asset('img/' . $more->featured_image) }}" alt="{{ $more->title }}" loading="lazy">
          @else
            @include('partials.jart', ['seed' => $more->id])
          @endif
          <span class="tag">{{ $more->category_display }}</span>
        </div>
        <div class="bcard__body">
          <div class="bcard__meta">
            <span>{{ $more->published_date?->format('d M Y') }}</span>
            <span class="dot">&bull;</span>
            <span>{{ $more->read_time }} min read</span>
          </div>
          <h3><a href="{{ route('journal.show', $more->slug) }}">{{ $more->title }}</a></h3>
          <p class="bcard__ex">{{ $more->excerpt }}</p>
          <div class="bcard__foot">
            <a class="tlink green" href="{{ route('journal.show', $more->slug) }}"
               data-en="Read article →" data-id="Baca artikel →">Read article →</a>
          </div>
        </div>
      </article>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="section cta">
  <div class="cta__glow" aria-hidden="true"></div>
  <div class="shell">
    <p class="eyebrow is-plain fade-up" style="justify-content:center">Available for Q4 2026 projects</p>
    <h2 class="display cta__big mt-s fade-up" data-delay="1" data-en="Let's build&lt;br&gt;something" data-id="Ayo bangun&lt;br&gt;sesuatu">Let's build<br>something</h2>
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
        <ul><li><a href="{{ url($locale.'/work') }}">Work</a></li><li><a href="{{ url($locale.'/services') }}">Services</a></li><li><a href="{{ url($locale.'/about') }}">Studio</a></li><li><a href="{{ url($locale.'/contact') }}">Contact</a></li><li><a href="{{ url($locale.'/contact') }}">Careers</a></li></ul>
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
        <h5>Studios</h5>
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
<script>
document.addEventListener('click', function (e) {
  var btn = e.target.closest('[data-copylink]');
  if (!btn) return;
  var done = function () {
    var tip = btn.querySelector('.ashare__tip');
    var original = tip ? tip.textContent : '';
    btn.classList.add('is-copied');
    if (tip) tip.textContent = document.documentElement.lang === 'id' ? 'Tersalin!' : 'Copied!';
    setTimeout(function () {
      btn.classList.remove('is-copied');
      if (tip) tip.textContent = original;
    }, 1600);
  };
  var url = btn.getAttribute('data-copylink');
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(url).then(done).catch(done);
  } else {
    var ta = document.createElement('textarea');
    ta.value = url; document.body.appendChild(ta); ta.select();
    try { document.execCommand('copy'); } catch (err) {}
    document.body.removeChild(ta); done();
  }
});
</script>
</body>
</html>
