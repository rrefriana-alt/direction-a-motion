/* ==========================================================================
   FUGO CREATIVE — work case-study modals
   --------------------------------------------------------------------------
   The /work list opens a per-project dialog instead of navigating to a page.
   Every modal is server-rendered and hidden, so the EN/ID switcher in
   motion.js translates it like any other copy on the page.

   The URL hash is the single source of truth (#work/<slug>), which gives us
   deep links, a working browser back button and a shareable link for free.
   ========================================================================== */
(() => {
  'use strict';

  const $  = (s, c = document) => c.querySelector(s);
  const $$ = (s, c = document) => [...c.querySelectorAll(s)];
  const RM = matchMedia('(prefers-reduced-motion: reduce)').matches;
  const PREFIX = '#work/';

  let root = null;
  let modals = new Map();
  let lb = null;
  let current = null;        // open .wm element
  let opener = null;         // the row that opened it, for focus restore
  let pushed = false;        // did we add the history entry ourselves?

  /* ---------------------------------------------------------- scroll lock */
  const lock = () => {
    document.body.classList.add('wm-open');
    const l = window.__fugoLenis;
    if (l) l.stop(); else document.documentElement.classList.add('wm-lock');
  };
  const unlock = () => {
    document.body.classList.remove('wm-open');
    const l = window.__fugoLenis;
    if (l) l.start(); else document.documentElement.classList.remove('wm-lock');
  };

  /* ------------------------------------------------------------- counters */
  // Deliberately not motion.js's [data-count]: those are ScrollTrigger-driven
  // and a hidden modal has no meaningful scroll position to trigger against.
  function countUp(modal) {
    $$('[data-wm-count]', modal).forEach(el => {
      const target = parseFloat(el.dataset.wmCount);
      if (!isFinite(target)) return;
      if (RM || target === 0) { el.textContent = el.dataset.wmCount; return; }
      const dec = (el.dataset.wmCount.split('.')[1] || '').length;
      const t0 = performance.now();
      const dur = 1100;
      const step = now => {
        const p = Math.min(1, (now - t0) / dur);
        const eased = 1 - Math.pow(1 - p, 3);
        el.textContent = (target * eased).toFixed(dec);
        if (p < 1) requestAnimationFrame(step);
        else el.textContent = el.dataset.wmCount;
      };
      requestAnimationFrame(step);
    });
  }

  /* --------------------------------------------------------- focus helper */
  const FOCUSABLE = 'a[href],button:not([disabled]),input,select,textarea,[tabindex]:not([tabindex="-1"])';

  function trap(e) {
    if (e.key !== 'Tab' || !current) return;
    const panel = $('.wm__panel', current);
    const items = $$(FOCUSABLE, panel).filter(el => el.offsetParent !== null);
    if (!items.length) return;
    const first = items[0], last = items[items.length - 1];
    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
    else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
  }

  /* ------------------------------------------------------------ open/close */
  function show(slug) {
    const modal = modals.get(slug);
    if (!modal || current === modal) return;
    if (current) hide({ keepLock: true });

    current = modal;
    modal.hidden = false;
    const scroller = $('.wm__scroll', modal);
    if (scroller) scroller.scrollTop = 0;
    // Flush layout so the transition has a start value to interpolate from.
    // A rAF would do the same, except rAF never fires in a background tab —
    // which would leave the modal open but permanently transparent.
    void modal.offsetWidth;
    modal.classList.add('is-open');
    lock();
    countUp(modal);
    ($('.wm__close', modal) || scroller)?.focus({ preventScroll: true });
  }

  function hide({ keepLock = false } = {}) {
    if (!current) return;
    const modal = current;
    current = null;
    modal.classList.remove('is-open');
    closeLightbox();

    const done = () => { modal.hidden = true; };
    if (RM) done();
    else {
      const t = setTimeout(done, 700);
      modal.addEventListener('transitionend', function once(e) {
        if (e.target !== $('.wm__panel', modal)) return;
        modal.removeEventListener('transitionend', once);
        clearTimeout(t);
        done();
      });
    }

    if (!keepLock) {
      unlock();
      opener?.focus({ preventScroll: true });
      opener = null;
    }
  }

  /* --------------------------------------------------------------- routing */
  /* pushState (not location.hash) so switching between projects replaces the
     entry instead of stacking ten of them in the back button.             */
  const slugFromHash = () =>
    location.hash.startsWith(PREFIX) ? decodeURIComponent(location.hash.slice(PREFIX.length)) : null;

  function sync() {
    const slug = slugFromHash();
    if (slug && modals.has(slug)) show(slug);
    else hide();
  }

  function openSlug(slug, fromRow) {
    if (!modals.has(slug)) return;
    if (fromRow) opener = fromRow;
    const url = location.pathname + location.search + PREFIX + encodeURIComponent(slug);
    if (current) {
      history.replaceState({ wm: slug }, '', url);   // project → project
    } else {
      history.pushState({ wm: slug }, '', url);
      pushed = true;
    }
    show(slug);
  }

  function requestClose() {
    if (!current) return;
    if (pushed) { history.back(); return; }           // popstate closes it
    history.replaceState(null, '', location.pathname + location.search);
    hide();
  }

  addEventListener('popstate', () => {
    pushed = !!(history.state && history.state.wm);
    sync();
  });
  addEventListener('hashchange', sync);

  /* ------------------------------------------------------------- lightbox */
  function openLightbox(tile) {
    if (!lb) return;
    const media = $('.wm-lb__media', lb);
    const cap = $('.wm-lb__cap', lb);
    const src = $('.wm__tilemedia', tile);
    if (!media || !src) return;

    media.replaceChildren();
    const node = src.firstElementChild?.cloneNode(true);
    if (!node) return;
    if (node.tagName === 'VIDEO') { node.controls = true; node.muted = false; }
    media.appendChild(node);
    cap.textContent = $('.wm__tilecap', tile)?.innerText.replace(/\s*\n\s*/g, ' — ') || '';

    lb.hidden = false;
    void lb.offsetWidth;
    lb.classList.add('is-open');
    $('.wm-lb__close', lb)?.focus({ preventScroll: true });
    if (node.tagName === 'VIDEO' && node.getAttribute('src')) node.play?.().catch(() => {});
  }

  function closeLightbox() {
    if (!lb || lb.hidden) return;
    $('video', lb)?.pause?.();
    lb.classList.remove('is-open');
    const done = () => { lb.hidden = true; $('.wm-lb__media', lb)?.replaceChildren(); };
    RM ? done() : setTimeout(done, 360);
    if (current) $('.wm__close', current)?.focus({ preventScroll: true });
  }

  /* ---------------------------------------------------------------- wiring */
  document.addEventListener('click', e => {
    const row = e.target.closest('[data-wm-open]');
    if (row) { e.preventDefault(); openSlug(row.dataset.wmOpen, row); return; }

    const go = e.target.closest('[data-wm-go]');
    if (go) { e.preventDefault(); openSlug(go.dataset.wmGo); return; }

    if (e.target.closest('[data-lb-close]') || (lb && !lb.hidden && e.target === lb)) {
      closeLightbox(); return;
    }

    const tile = e.target.closest('[data-wm-lb]');
    if (tile) { e.preventDefault(); openLightbox(tile); return; }

    if (e.target.closest('[data-wm-close]')) { requestClose(); }
  });

  addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      if (lb && !lb.hidden) { e.stopPropagation(); closeLightbox(); return; }
      if (current) { e.stopPropagation(); requestClose(); }
      return;
    }
    trap(e);
  }, true);

  // Init after DOM ready so .wm-root exists even with defer
  const init = () => {
    root = $('.wm-root');
    if (!root) return;
    modals = new Map($$('.wm', root).map(m => [m.dataset.slug, m]));
    lb = $('#wm-lightbox');
    sync(); // deep link: /work#work/<slug> opens straight into that project
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
