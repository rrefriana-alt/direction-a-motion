/* ==========================================================================
   FUGO CREATIVE — Direction A "SIGNAL"  ·  motion layer
   Lenis (smooth scroll) + GSAP (ScrollTrigger, SplitText) + Three.js hero.

   Architecture — one rAF for the whole page:
     Lenis  â†’  gsap.ticker  â†’  ScrollTrigger.update()  â†’  WebGL hero
   Two animation loops are what make sites like this stutter, so there is
   exactly one, and Lenis is the thing that owns scroll position.

   Every library is optional. If a CDN fails, `degrade()` reveals all content
   and the page stays usable — a broken hero is never worth a blank site.
   ========================================================================== */
(() => {
'use strict';

const RM   = matchMedia('(prefers-reduced-motion: reduce)').matches;
const FINE = matchMedia('(hover:hover) and (pointer:fine)').matches;
const $  = (s, c = document) => c.querySelector(s);
const $$ = (s, c = document) => [...c.querySelectorAll(s)];
const html = document.documentElement;

/* ---------------------------------------------------------- device tier --- */
/* Decided before anything that depends on it — retrofitting fallbacks is how
   "we'll optimise later" turns into "we cut the WebGL".                      */
const TIER = (() => {
  if (RM) return 'off';
  const c = navigator.connection;
  if (c?.saveData || /^(slow-)?2g$/.test(c?.effectiveType || '')) return 'off';
  try {
    const t = document.createElement('canvas');
    if (!t.getContext('webgl2') && !t.getContext('webgl')) return 'off';
  } catch { return 'off'; }
  const cores = navigator.hardwareConcurrency || 4;
  const mem   = navigator.deviceMemory || 4;
  const coarse = matchMedia('(pointer:coarse)').matches;
  if (cores <= 4 || mem <= 4) return coarse ? 'off' : 'reduced';
  return coarse ? 'reduced' : 'full';
})();
html.dataset.tier = TIER;

/* Shared scroll state — the WebGL module reads this instead of touching the
   DOM or starting its own listener.                                          */
const SCROLL = window.__fugoScroll = { y: 0, velocity: 0, progress: 0, tier: TIER };

/* -------------------------------------------------------------- degrade --- */
function degrade(why) {
  console.warn('[fugo] motion degraded:', why);
  html.classList.add('no-motion');
  $$('.fade-up,.fade-in,[data-reveal],.hero__title,.reveal-line').forEach(el => el.classList.add('is-in'));
  $('.loader')?.classList.add('is-done');
  document.body.classList.add('ready');
}

/* ============================================================== i18n ====== */
/* Split text and language switching fight each other unless the order is
   forced. SplitText replaces an element's contents with per-word/char spans;
   writing new copy over the top leaves the instance pointing at nodes that no
   longer exist, so its next revert() restores the *previous* language. And an
   element that has been split no longer holds plain text to swap.

   So every split is registered here, and a language change always runs:
     revert every split  â†’  write the new copy  â†’  re-split
   Nothing depends on a listener having been registered first, which is what
   made this intermittent: switching language while the preloader was still up
   used to leave the headline in the old language permanently. */

const SPLITS = [];

function registerSplit(el, inst) { SPLITS.push({ el, inst }); }

function revertSplits() {
  while (SPLITS.length) {
    const { el, inst } = SPLITS.pop();
    if (inst && typeof inst.revert === 'function') { try { inst.revert(); } catch {} }
    else if (el.dataset.raw != null) el.textContent = el.dataset.raw;
    el.removeAttribute('data-split-done');
  }
}

const I18N = {
  set(lang) {
    if (lang !== 'en' && lang !== 'id') return;

    revertSplits();
    html.lang = lang;

    $$('[data-en]').forEach(el => {
      const v = el.getAttribute('data-' + lang);
      if (v == null) return;
      if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') { el.placeholder = v; return; }
      // Every element gets its copy written, split or not. The old code
      // skipped [data-split] and left it to a listener, which is exactly the
      // path that could not run yet during load.
      el.dataset.raw = v;
      if (v.includes('<')) el.innerHTML = v;
      else el.textContent = v;
    });

    const pill = $('.lang');
    if (pill) {
      pill.dataset.lang = lang;
      $$('.lang__btn', pill).forEach(b => b.classList.toggle('is-on', b.dataset.lang === lang));
    }
    try { localStorage.setItem('fugo-lang', lang); } catch {}

    document.dispatchEvent(new CustomEvent('langchange', { detail: lang }));
  },
  init() {
    $$('.lang__btn').forEach(b => b.addEventListener('click', () => I18N.set(b.dataset.lang)));
    let saved = null;
    try { saved = localStorage.getItem('fugo-lang'); } catch {}
    if (saved && saved !== html.lang) I18N.set(saved);
  }
};

/* ====================================================== boot the engine === */
function boot() {
  I18N.init();
  forms();                       // works with or without GSAP
  navBehaviour();

  if (!window.gsap) return degrade('gsap missing');
  const { gsap } = window;
  const ST = window.ScrollTrigger;
  if (!ST) return degrade('ScrollTrigger missing');
  gsap.registerPlugin(ST);
  if (window.SplitText) gsap.registerPlugin(window.SplitText);

  /* ---- scroll driver -------------------------------------------------- */
  let lenis = null;
  if (window.Lenis && !RM) {
    lenis = new Lenis({
      duration: 1.05,
      // expo-out: quick start, long settle — matches --e-out in core.css
      easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smoothWheel: true,
      // Native momentum feels better on phones and saves battery.
      syncTouch: false,
    });
    lenis.on('scroll', ({ scroll, velocity, progress }) => {
      SCROLL.y = scroll; SCROLL.velocity = velocity; SCROLL.progress = progress;
      ST.update();
    });
    gsap.ticker.add(t => lenis.raf(t * 1000));
    // Frame-skipping after a long task desyncs scrubbed timelines from the
    // actual scroll position, so it stays off.
    gsap.ticker.lagSmoothing(0);
    window.__fugoLenis = lenis;
  } else {
    addEventListener('scroll', () => {
      const prev = SCROLL.y;
      SCROLL.y = scrollY;
      SCROLL.velocity = SCROLL.y - prev;
      SCROLL.progress = SCROLL.y / Math.max(1, document.body.scrollHeight - innerHeight);
    }, { passive: true });
  }
  const scrollTo = (target, offset = 0) =>
    lenis ? lenis.scrollTo(target, { offset })
          : target.scrollIntoView({ behavior: RM ? 'auto' : 'smooth' });

  /* Measurements taken before fonts and images land are wrong, and wrong
     measurements cause almost every "the pin is offset" bug.                */
  document.fonts?.ready.then(() => ST.refresh());
  addEventListener('load', () => ST.refresh(), { once: true });
  let rt; addEventListener('resize', () => { clearTimeout(rt); rt = setTimeout(() => ST.refresh(), 200); });

  /* ---- run the pieces -------------------------------------------------- */
  const api = { gsap, ST, lenis, scrollTo };
  preloader(api);
  reveals(api);
  progressBar(api);
  manifesto(api);
  counters(api);
  servicesIndex(api);
  horizontalWork(api);
  parallax(api);
  velocitySkew(api);
  marquees(api);
  cursor(api);
  magnetic(api);
  spotlight();
  peek(api);
  pageTransitions(api);
  anchors(api);
}

/* ========================================================== preloader ==== */
/* Real signal (fonts + hero media), not a timer. A preloader that exists to
   hide a slow site is a bug wearing a costume.                              */
function preloader({ gsap, ST }) {
  const el = $('.loader');
  const hero = () => heroIntro({ gsap, ST });

  // Skip the preloader entirely if:
  //   (a) OS has "reduce motion" / animations disabled (prefers-reduced-motion)
  //   (b) User is returning to home from another page this session (nav-in curtain handles the transition)
  const skipLoader = RM || (() => { try { return !!sessionStorage.getItem('fugo-home-seen'); } catch { return false; } })();
  if (!el || skipLoader) {
    if (el) el.style.display = 'none';
    document.body.classList.add('ready');
    hero();
    return;
  }

  // Mark home as visited so future returns skip the preloader
  try { sessionStorage.setItem('fugo-home-seen', '1'); } catch {}

  const num = $('.loader__num', el), bar = $('.loader__bar', el);
  const state = { p: 0 };
  let ready = false;
  Promise.all([
    document.fonts?.ready ?? Promise.resolve(),
    new Promise(r => (document.readyState === 'complete' ? r() : addEventListener('load', r, { once: true }))),
  ]).then(() => { ready = true; });

  // A preloader that fails to lift hides the entire site — the single worst
  // failure this page can have. It gets a hard deadline regardless of what
  // the animation is doing.
  const failsafe = setTimeout(() => {
    if (document.body.classList.contains('ready')) return;
    console.warn('[fugo] preloader failsafe');
    el.style.display = 'none';
    document.body.classList.add('ready');
    hero();
    ST.refresh();
  }, 6000);

  const tl = gsap.timeline();
  const tick = () => {
    state.p = Math.min(state.p + (ready ? 9 : 1.9), ready ? 100 : 92);
    if (num) num.textContent = String(Math.floor(state.p)).padStart(3, '0');
    if (bar) bar.style.width = state.p + '%';
    if (state.p < 100) return requestAnimationFrame(tick);
    tl.to(el, {
      yPercent: -100, duration: 0.9, ease: 'expo.inOut',
      onStart: () => { document.body.classList.add('ready'); clearTimeout(failsafe); },
      onComplete: () => { el.style.display = 'none'; ST.refresh(); },
    }).add(hero, '-=0.55');
  };
  requestAnimationFrame(tick);
}

/* ======================================================== hero intro ===== */
function heroIntro({ gsap, ST }) {
  const title = $('.hero__title');
  const tl = gsap.timeline({ defaults: { ease: 'expo.out' } });

  const chars = splitHeroTargets();

  if (title) title.classList.add('is-in');

  if (RM) {
    gsap.set([chars, '.hero .fade-up', '.hero .reveal-line .tint'], { clearProps: 'all', opacity: 1, y: 0 });
    $$('.hero .fade-up, .hero .reveal-line').forEach(e => e.classList.add('is-in'));
    return;
  }

  /* set + to rather than from: `to` guarantees the resting state is written,
     so a tween that is interrupted or never plays cannot leave the headline
     parked off-screen. */
  gsap.set(chars, { yPercent: 118 });
  gsap.set('.hero .reveal-line .tint', { yPercent: 112 });

  tl.to(chars, { yPercent: 0, duration: 1.05, stagger: { each: 0.022, from: 'start' } }, 0)
    .to('.hero .reveal-line .tint', { yPercent: 0, duration: 1.15 }, 0.18)
    .from('.hero__canvas', { opacity: 0, duration: 1.6, ease: 'power2.out' }, 0)
    .fromTo('.hero .eyebrow', { y: 18, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, clearProps: 'opacity,y' }, 0.15)
    .fromTo('.hero__meta > *', { y: 26, opacity: 0 }, { y: 0, opacity: 1, duration: 0.9, stagger: 0.09, clearProps: 'opacity,y' }, 0.42)
    .fromTo('.hero .row.between', { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, clearProps: 'opacity,y' }, 0.62);

  // Whatever happens to the timeline, the headline ends up readable.
  gsap.delayedCall(3.2, () => gsap.set([chars, '.hero .reveal-line .tint'], { yPercent: 0, opacity: 1 }));

  $$('.hero .fade-up, .hero .reveal-line').forEach(e => e.classList.add('is-in'));

  // Hero exit — the title lifts and dims as the next section takes over.
  ScrollTrigger.create({
    trigger: '.hero',
    start: 'top top',
    end: 'bottom top',
    scrub: 0.6,
    animation: gsap.to('.hero__in', { yPercent: -14, opacity: 0.15, ease: 'none' }),
  });

  // Re-split whatever i18n just wrote. The copy is already correct by this
  // point, so this only has to rebuild the characters and replay the reveal.
  document.addEventListener('langchange', () => {
    const fresh = splitHeroTargets();
    if (fresh.length && !RM) {
      gsap.set(fresh, { yPercent: 110 });
      gsap.to(fresh, { yPercent: 0, duration: 0.7, ease: 'expo.out', stagger: 0.014 });
    }
    ScrollTrigger.refresh();
  });
}

/* Splits every [data-split] element and returns the characters. Safe to call
   repeatedly — revertSplits() has already put the elements back to plain text
   before the new copy was written. */
function splitHeroTargets() {
  const chars = [];
  $$('[data-split]').forEach(el => {
    if (el.hasAttribute('data-split-done')) return;
    el.setAttribute('data-split-done', '');
    if (window.SplitText) {
      const inst = new SplitText(el, { type: 'chars,words', charsClass: 'char', wordsClass: 'word' });
      registerSplit(el, inst);
      chars.push(...inst.chars);
    } else {
      // Manual fallback, registered the same way so a language change can
      // still put the plain text back before rewriting it.
      const raw = el.textContent;
      el.dataset.raw = raw;
      registerSplit(el, null);
      el.innerHTML = raw.split(' ').map(w =>
        `<span class="word">${[...w].map(c => `<span class="char">${c}</span>`).join('')}</span>`).join(' ');
      chars.push(...$$('.char', el));
    }
  });
  return chars;
}

/* ========================================================== reveals ====== */
/* One ScrollTrigger per element is wasteful at this page length; batch()
   groups them into a handful of shared listeners.                           */
function reveals({ gsap, ST }) {
  // Headlines get the new masked line reveal; they opt out of the generic
  // fade so only one thing animates them.
  const heads = window.SplitText
    ? $$('h1.display, h2.display').filter(h => !h.closest('.hero'))
    : [];
  heads.forEach(h => h.classList.add('is-in', 'is-split-head'));

  const els = $$('.fade-up, .fade-in, [data-reveal]')
    .filter(el => !el.closest('.hero') && !el.classList.contains('is-split-head'));

  if (RM) { els.forEach(e => e.classList.add('is-in')); heads.forEach(h => h.classList.add('is-in')); }
  else if (els.length) {
    // batch() groups what would otherwise be ~40 separate scroll listeners.
    ST.batch(els, {
      start: 'top 88%',
      onEnter: batch => batch.forEach((el, i) =>
        gsap.delayedCall(i * 0.07, () => el.classList.add('is-in'))),
    });
    // Anything already on screen at load should not wait for a scroll event.
    requestAnimationFrame(() => els.forEach(el => {
      if (el.getBoundingClientRect().top < innerHeight * 0.9) el.classList.add('is-in');
    }));
  }

  // Masked line reveal — the workhorse effect the original build lacked.
  const splitHead = (h, animate) => {
    if (h.hasAttribute('data-split-done')) return;
    h.setAttribute('data-split-done', '');
    const sp = new SplitText(h, { type: 'lines', linesClass: 'line' });
    // Registered so a language change reverts it before overwriting the copy.
    registerSplit(h, sp);
    sp.lines.forEach(l => {
      const m = document.createElement('span');
      m.className = 'line-mask';
      l.parentNode.insertBefore(m, l);
      m.appendChild(l);
    });
    if (!animate || RM) return;
    gsap.set(sp.lines, { yPercent: 118 });
    gsap.to(sp.lines, {
      yPercent: 0, duration: 1.1, ease: 'expo.out', stagger: 0.08,
      scrollTrigger: { trigger: h, start: 'top 86%', once: true },
    });
  };
  heads.forEach(h => splitHead(h, true));

  // i18n has already reverted the split and written the new copy by the time
  // this fires, so all that is left is to rebuild the masks — silently,
  // because the reveal has already been seen.
  document.addEventListener('langchange', () => {
    heads.forEach(h => { h.classList.add('is-in', 'is-split-head'); splitHead(h, false); });
    ST.refresh();
  });
}

/* ===================================================== progress bar ====== */
function progressBar({ gsap, ST }) {
  const p = $('.prog'); if (!p) return;
  gsap.set(p, { scaleX: 0, transformOrigin: 'left center' });
  ST.create({
    start: 0, end: 'max',
    onUpdate: self => gsap.set(p, { scaleX: self.progress }),
  });
}

/* ======================================================== manifesto ====== */
/* Pinned and scrubbed: the words light word-by-word as you scroll through,
   which turns a paragraph nobody reads into the thing they remember.        */
function manifesto({ gsap, ST }) {
  const section = $('.manifesto');
  const box = $('.manifesto p[data-en]');
  if (!section || !box) return;

  const build = () => {
    const src = box.getAttribute('data-' + html.lang) || box.dataset.raw || box.innerHTML;
    box.dataset.raw = box.dataset.raw || src;
    box.innerHTML = src.split(' ').map(w => {
      const hl = w.startsWith('*');
      return `<span class="w${hl ? ' hl' : ''}">${hl ? w.slice(1) : w}</span>`;
    }).join(' ');
  };
  build();
  document.addEventListener('langchange', () => { build(); ST.refresh(); });

  if (RM) { $$('.w', box).forEach(w => w.classList.add('on')); return; }

  ST.create({
    trigger: section,
    start: 'top 72%',
    end: 'bottom 62%',
    scrub: 0.5,
    onUpdate: self => {
      const ws = $$('.w', box);
      const n = Math.round(self.progress * (ws.length + 2));
      ws.forEach((w, i) => w.classList.toggle('on', i < n));
    },
  });
}

/* ========================================================= counters ====== */
function counters({ gsap, ST }) {
  $$('[data-count]').forEach(el => {
    const target = parseFloat(el.dataset.count);
    const dec = (el.dataset.count.split('.')[1] || '').length;
    if (RM) { el.textContent = target.toFixed(dec); return; }
    const o = { v: 0 };
    gsap.to(o, {
      v: target, duration: 1.6, ease: 'power3.out',
      scrollTrigger: { trigger: el, start: 'top 88%', once: true },
      onUpdate: () => { el.textContent = o.v.toFixed(dec); },
    });
  });
}

/* ================================================== services sticky idx == */
function servicesIndex({ gsap, ST }) {
  const idx = $$('.svc__idx'), panels = $$('.svc__panels .card');
  if (!idx.length || !panels.length) return;
  panels.forEach((p, i) => {
    ST.create({
      trigger: p, start: 'top 55%', end: 'bottom 55%',
      onToggle: self => { if (self.isActive) idx.forEach((a, j) => a.classList.toggle('on', j === i)); },
    });
  });
  idx.forEach((a, i) => {
    a.style.cursor = 'pointer';
    a.addEventListener('click', () => {
      const l = window.__fugoLenis;
      l ? l.scrollTo(panels[i], { offset: -innerHeight * 0.25 })
        : panels[i].scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
  });
}

/* ================================================= horizontal work ======= */
/* Real pin + scrub, instead of the tall-wrapper trick. ScrollTrigger owns the
   height, so it stays correct through resize, font load and locale change.  */
function horizontalWork({ gsap, ST }) {
  const wrap = $('.hscroll');
  const track = $('.hscroll__track', wrap || document);
  if (!wrap || !track) return;

  // Scroll-driven at every width. Leaving phones on native swipe means most
  // visitors only ever see the first card, which defeats the section.
  if (RM) {
    wrap.classList.add('is-native');
    return;
  }

  // Lenis leaves touch scrolling native (it feels better and saves battery),
  // so on touch devices ScrollTrigger is nudged from the native scroll event
  // as well — otherwise the row can lag a frame behind the finger.
  if (matchMedia('(pointer: coarse)').matches) {
    addEventListener('scroll', () => ST.update(), { passive: true });
  }

  const distance = () => Math.max(0, track.scrollWidth - innerWidth + 32);
  // The scroll extent has to match the track, or the last card is unreachable
  // (too short) or the section stalls on an empty screen (too long).
  const sizeWrap = () => {
    // Scroll extent must match the track: too short and the last card is
    // unreachable, too long and the section stalls on an empty screen.
    // Phones get a little extra so the row is not racing past the thumb.
    const pace = matchMedia('(pointer: coarse)').matches ? 1.25 : 1;
    wrap.style.height = (100 + (distance() / innerHeight) * 100 * pace) + 'vh';
  };
  sizeWrap();

  gsap.to(track, {
    x: () => -distance(),
    ease: 'none',
    scrollTrigger: {
      trigger: wrap,
      start: 'top top',
      end: 'bottom bottom',
      scrub: 0.75,
      invalidateOnRefresh: true,
      onRefreshInit: sizeWrap,
    },
  });

  // Counter-parallax inside each frame so the row does not read as one slab.
  $$('.wcard__art', track).forEach(art => {
    gsap.fromTo(art, { xPercent: 6 }, {
      xPercent: -6, ease: 'none',
      scrollTrigger: { trigger: wrap, start: 'top top', end: 'bottom bottom', scrub: 1 },
    });
  });
}

/* ========================================================= parallax ====== */
function parallax({ gsap }) {
  if (RM) return;
  $$('[data-para]').forEach(el => {
    const s = parseFloat(el.dataset.para) || 0.12;
    gsap.to(el, {
      yPercent: -s * 100, ease: 'none',
      scrollTrigger: { trigger: el, start: 'top bottom', end: 'bottom top', scrub: true },
    });
  });
}

/* ================================================== velocity skew ======== */
/* Subtle, clamped and damped. Undamped it reads as a rendering bug rather
   than an effect, which is why the clamp is this tight.                     */
function velocitySkew({ gsap }) {
  if (RM || TIER === 'off') return;
  const cards = $$('.wcard, .svc__panels .card');
  if (!cards.length) return;
  const set = gsap.quickSetter(cards, 'skewY', 'deg');
  let cur = 0;
  gsap.ticker.add(() => {
    const want = gsap.utils.clamp(-3, 3, SCROLL.velocity * 0.12);
    cur += (want - cur) * 0.1;
    if (Math.abs(cur) < 0.005) cur = 0;
    set(cur);
  });
}

/* ========================================================= marquees ====== */
function marquees({ gsap }) {
  $$('.marquee').forEach(m => {
    const track = $('.marquee__track', m);
    if (!track) return;

    // One wrapper holding every copy means one transform per frame instead of
    // one per copy, and no chance of the copies drifting apart.
    const row = document.createElement('div');
    row.className = 'marquee__row';
    m.insertBefore(row, track);
    row.appendChild(track);

    const dir = m.classList.contains('marquee--rev') ? -1 : 1;
    // Honour the design's --spd (seconds for one track width to pass).
    const spd = parseFloat(getComputedStyle(m).getPropertyValue('--spd')) || 34;

    let trackW = 0, x = 0, boost = 0, hover = 0;
    m.addEventListener('pointerenter', () => { hover = 1; });
    m.addEventListener('pointerleave', () => { hover = 0; });

    const fill = () => {
      trackW = track.offsetWidth;
      if (!trackW) return;
      // Enough copies to cover the viewport plus one spare, so the seam is
      // always off-screen no matter how wide the window gets.
      const need = Math.ceil(m.offsetWidth / trackW) + 2;
      while (row.children.length < need) row.appendChild(track.cloneNode(true));
      while (row.children.length > need && row.children.length > 2) row.lastChild.remove();
    };
    fill();
    addEventListener('resize', fill);
    document.fonts?.ready.then(fill);

    // Always keep marquee running regardless of reduced motion setting
    // if (RM) return;

    let last = performance.now();
    gsap.ticker.add(() => {
      const now = performance.now();
      const dt = Math.min(0.05, (now - last) * 0.001);
      last = now;
      if (!trackW) { fill(); return; }

      // Scroll speed nudges the marquee, damped so it eases in and out rather
      // than snapping between speeds every frame.
      const want = Math.min(Math.abs(SCROLL.velocity) * 0.06, 2.4);
      boost += (want - boost) * 0.06;
      const pause = hover ? 0.12 : 1;                    // hover slows, not stops

      // px/second, not px/frame — otherwise a 120Hz screen runs it twice as fast
      x -= dir * (trackW / spd) * (1 + boost) * pause * dt;
      x %= trackW;
      if (x > 0) x -= trackW;
      row.style.transform = `translate3d(${x.toFixed(2)}px,0,0)`;
    });
  });
}

/* =========================================================== cursor ====== */
function cursor({ gsap }) {
  if (!FINE || RM) return;
  const ring = Object.assign(document.createElement('div'), { className: 'cursor' });
  const dot  = Object.assign(document.createElement('div'), { className: 'cursor-dot' });
  const lab  = Object.assign(document.createElement('div'), { className: 'cursor-label' });
  document.body.append(ring, dot, lab);

  const rx = gsap.quickTo(ring, 'x', { duration: 0.42, ease: 'power3' });
  const ry = gsap.quickTo(ring, 'y', { duration: 0.42, ease: 'power3' });
  const dx = gsap.quickTo(dot, 'x', { duration: 0.08, ease: 'power2' });
  const dy = gsap.quickTo(dot, 'y', { duration: 0.08, ease: 'power2' });

  addEventListener('mousemove', e => {
    document.body.classList.add('cur-live');
    rx(e.clientX); ry(e.clientY); dx(e.clientX); dy(e.clientY);
    lab.style.left = e.clientX + 'px'; lab.style.top = e.clientY + 'px';
  }, { passive: true });

  const hot = 'a,button,.card,.wcard,.wrow,.chip,[data-cursor]';
  document.addEventListener('mouseover', e => {
    const t = e.target.closest(hot); if (!t) return;
    document.body.classList.add('cur-hover');
    if (t.dataset.cursor) { lab.textContent = t.dataset.cursor; document.body.classList.add('cur-label'); }
  });
  document.addEventListener('mouseout', e => {
    if (!e.target.closest(hot)) return;
    document.body.classList.remove('cur-hover', 'cur-label');
  });
}

/* ======================================================== magnetic ======= */
function magnetic({ gsap }) {
  if (!FINE || RM) return;
  $$('[data-magnet]').forEach(el => {
    const str = parseFloat(el.dataset.magnet) || 0.34;
    const xTo = gsap.quickTo(el, 'x', { duration: 0.5, ease: 'elastic.out(1,0.45)' });
    const yTo = gsap.quickTo(el, 'y', { duration: 0.5, ease: 'elastic.out(1,0.45)' });
    el.addEventListener('mousemove', e => {
      const r = el.getBoundingClientRect();
      xTo((e.clientX - r.left - r.width / 2) * str);
      yTo((e.clientY - r.top - r.height / 2) * str);
    });
    el.addEventListener('mouseleave', () => { xTo(0); yTo(0); });
  });
}

/* ======================================================= spotlight ======= */
function spotlight() {
  $$('.card').forEach(c => c.addEventListener('mousemove', e => {
    const r = c.getBoundingClientRect();
    c.style.setProperty('--mx', (e.clientX - r.left) + 'px');
    c.style.setProperty('--my', (e.clientY - r.top) + 'px');
  }));
}

/* ============================================================ peek ======= */
function peek({ gsap }) {
  const rows = $$('.wrow[data-peek]');
  if (!rows.length || !FINE || RM) return;
  const box = Object.assign(document.createElement('div'), { className: 'peek' });
  document.body.appendChild(box);
  const xTo = gsap.quickTo(box, 'x', { duration: 0.55, ease: 'power3' });
  const yTo = gsap.quickTo(box, 'y', { duration: 0.55, ease: 'power3' });
  rows.forEach(r => {
    r.addEventListener('mouseenter', () => { box.innerHTML = r.dataset.peek; box.classList.add('on'); });
    r.addEventListener('mouseleave', () => box.classList.remove('on'));
  });
  addEventListener('mousemove', e => { xTo(e.clientX); yTo(e.clientY); }, { passive: true });
}

/* ================================================= page transitions ====== */
/* A curtain wipe on internal navigation. Prototyped before the pages needed
   it, because retrofitting this is where sites pick up their jank.          */
function pageTransitions({ gsap }) {
  const curtain = $('.curtain');
  if (!curtain || RM) return;

  const lift = () => {
    html.classList.remove('nav-in');
    gsap.set(curtain, { yPercent: -100, pointerEvents: 'none' });
  };

  // Arrived through a transition: the curtain is already down (set in <head>),
  // so lift it. Anything else and it was never covering in the first place.
  if (html.classList.contains('nav-in')) {
    const guard = setTimeout(lift, 2500);       // never trap the page behind it
    gsap.fromTo(curtain,
      { yPercent: 0 },
      { yPercent: -100, duration: 0.72, ease: 'expo.inOut', delay: 0.05,
        onComplete: () => { clearTimeout(guard); lift(); } });
  } else {
    lift();
  }

  document.addEventListener('click', e => {
    const a = e.target.closest('a[href]');
    if (!a) return;
    const url = new URL(a.href, location.href);
    if (url.origin !== location.origin) return;
    if (a.target === '_blank' || e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;
    if (url.pathname === location.pathname && url.hash) return;   // in-page anchor
    if (url.href === location.href) return;
    e.preventDefault();
    try { sessionStorage.setItem('fugo-nav', '1'); } catch {}
    curtain.style.pointerEvents = 'auto';
    // If navigation stalls, go anyway rather than sitting under a black panel.
    const bail = setTimeout(() => { location.href = url.href; }, 1200);
    gsap.fromTo(curtain,
      { yPercent: 100 },
      { yPercent: 0, duration: 0.6, ease: 'expo.inOut',
        onComplete: () => { clearTimeout(bail); location.href = url.href; } });
  });

  // Back/forward out of bfcache must not restore a lowered curtain.
  addEventListener('pageshow', e => { if (e.persisted) lift(); });
}

/* ========================================================== anchors ====== */
function anchors({ scrollTo }) {
  $$('a[href^="#"]').forEach(a => a.addEventListener('click', e => {
    const id = a.getAttribute('href');
    if (id.length < 2) return;
    const t = $(id); if (!t) return;
    e.preventDefault();
    scrollTo(t, -70);
  }));
}

/* ============================================================== nav ====== */
function navBehaviour() {
  const bar = $('.nav');
  const burger = $('.burger');
  if (burger) burger.addEventListener('click', () => {
    const open = document.body.classList.toggle('menu-open');
    burger.setAttribute('aria-expanded', String(open));
    const l = window.__fugoLenis;
    open ? l?.stop() : l?.start();          // never scroll behind an open menu
  });
  $$('.menu a').forEach(a => a.addEventListener('click', () => {
    document.body.classList.remove('menu-open'); window.__fugoLenis?.start();
  }));
  addEventListener('keydown', e => {
    if (e.key === 'Escape') { document.body.classList.remove('menu-open'); window.__fugoLenis?.start(); }
  });
  if (!bar) return;
  let last = 0;
  const on = () => {
    const y = SCROLL.y || scrollY;
    if (y === last) return;
    bar.classList.toggle('is-solid', y > 24);
    if (!document.body.classList.contains('menu-open'))
      bar.classList.toggle('is-up', y > last && y > 340);
    last = y;
  };
  addEventListener('scroll', on, { passive: true });
  (window.gsap ? gsap.ticker.add(on) : setInterval(on, 120));
}

/* ============================================================ forms ====== */
function forms() {
  $$('.field input,.field textarea').forEach(i => {
    const f = i.closest('.field');
    const sync = () => f.classList.toggle('filled', !!i.value);
    i.addEventListener('input', sync); i.addEventListener('blur', sync); sync();
  });
  $$('.chips').forEach(g => $$('.chip', g).forEach(c =>
    c.addEventListener('click', () => c.classList.toggle('on'))));
  const form = $('form[data-demo]');
  if (form) form.addEventListener('submit', e => {
    e.preventDefault();
    const btn = $('button[type=submit]', form);
    const en = btn.dataset.en, id = btn.dataset.id;
    btn.textContent = html.lang === 'id' ? 'Terkirim âœ“' : 'Sent âœ“';
    btn.disabled = true;
    setTimeout(() => {
      btn.textContent = html.lang === 'id' ? id : en;
      btn.disabled = false; form.reset();
      $$('.field', form).forEach(f => f.classList.remove('filled'));
    }, 2600);
  });
}

/* ============================================================== go ======= */
// Libraries load with `defer`, so DOMContentLoaded is the earliest safe point.
document.readyState === 'loading'
  ? document.addEventListener('DOMContentLoaded', boot)
  : boot();

// If the CDN is unreachable the page must still be readable.
setTimeout(() => {
  if (!window.gsap && !html.classList.contains('no-motion')) degrade('libraries never arrived');
}, 4000);
})();

