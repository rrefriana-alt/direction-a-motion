/* Static page generator for Direction A. Run: node _build.js
   Keeps nav/footer identical across pages without a runtime framework. */
const fs = require('fs');

const head = (title, desc, file = '') => `<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<title>${title}</title>
<meta name="description" content="${desc}">
<meta name="theme-color" content="#07080a">
<link rel="canonical" href="https://fugocreativegroup.com/${file}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Fugo Creative">
<meta property="og:locale" content="en_US">
<meta property="og:locale:alternate" content="id_ID">
<meta property="og:title" content="${title}">
<meta property="og:description" content="${desc}">
<meta property="og:url" content="https://fugocreativegroup.com/${file}">
<meta property="og:image" content="https://fugocreativegroup.com/assets/img/og.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="${title}">
<meta name="twitter:description" content="${desc}">
<meta name="twitter:image" content="https://fugocreativegroup.com/assets/img/og.png">
<script type="application/ld+json">
{"@context":"https://schema.org","@graph":[
 {"@type":"Organization","@id":"https://fugocreativegroup.com/#org",
  "name":"PT Fugo Creative Group","alternateName":"Fugo Creative",
  "url":"https://fugocreativegroup.com/","logo":"https://fugocreativegroup.com/assets/img/og.png",
  "email":"hello@fugocreativegroup.com","telephone":"+62-821-2100-0680","foundingDate":"2016",
  "description":"Indonesian creative group: design, production house, events, merchandise and AI agents.",
  "sameAs":["https://instagram.com/fugocreative","https://id.linkedin.com/company/fugo-creativegroup"],
  "address":{"@type":"PostalAddress","streetAddress":"Jl. Permata Taman Sari Raya No.21, Arcamanik","addressLocality":"Bandung","addressCountry":"ID"}},
 {"@type":"LocalBusiness","name":"Fugo Creative — Bandung (HQ)","parentOrganization":{"@id":"https://fugocreativegroup.com/#org"},
  "image":"https://fugocreativegroup.com/assets/img/og.png","telephone":"+62-821-2100-0680",
  "address":{"@type":"PostalAddress","streetAddress":"Jl. Permata Taman Sari Raya No.21, Arcamanik","addressLocality":"Bandung","addressCountry":"ID"}},
 {"@type":"LocalBusiness","name":"Fugo Creative — Jakarta","parentOrganization":{"@id":"https://fugocreativegroup.com/#org"},
  "image":"https://fugocreativegroup.com/assets/img/og.png","telephone":"+62-821-2100-0680",
  "address":{"@type":"PostalAddress","streetAddress":"Jl. Srengseng Sawah No.16, Jagakarsa","addressLocality":"Jakarta Selatan","addressCountry":"ID"}},
 {"@type":"LocalBusiness","name":"Fugo Creative — Bali","parentOrganization":{"@id":"https://fugocreativegroup.com/#org"},
  "image":"https://fugocreativegroup.com/assets/img/og.png","telephone":"+62-821-2100-0680",
  "address":{"@type":"PostalAddress","streetAddress":"Jl. Tukad Melangit, Samplangan","addressLocality":"Gianyar, Bali","addressCountry":"ID"}}
]}
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wdth,wght@12..96,75..100,400..800&family=Inter+Tight:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/core.css">
<link rel="stylesheet" href="assets/css/motion.css">
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='8' fill='%2307080a'/%3E%3Cpath d='M11 8h13l-3 5H8zM8 15h11l-3 5H5zM5 22h9l-3 5H2z' fill='%233ddc97'/%3E%3C/svg%3E">
<script>/* set before first paint: only pages arrived at via a curtain
   transition start covered, so a failed script can never black out the site */
try{if(sessionStorage.getItem('fugo-nav')){document.documentElement.classList.add('nav-in');sessionStorage.removeItem('fugo-nav');}}catch(e){}</script>
</head>
<body>

<!-- page-transition curtain -->
<div class="curtain" aria-hidden="true"><span class="curtain__mark">Create to <em>Elevate</em></span></div>

<div class="prog" aria-hidden="true"></div>`;

const LINKS = [
  ['index.html', 'Home', 'Beranda'],
  ['work.html', 'Work', 'Karya'],
  ['services.html', 'Services', 'Layanan'],
  ['about.html', 'Studio', 'Studio'],
  ['contact.html', 'Contact', 'Kontak'],
];

const nav = (active) => `
<header class="nav is-solid">
  <div class="nav__in">
    <a class="brand" href="index.html" aria-label="Fugo Creative — home">
      <svg class="brand__mark" viewBox="0 0 32 32" aria-hidden="true">
        <path d="M11 6h14l-3.4 5.6H7.6zM7.6 14h12l-3.4 5.6H4.2zM4.2 22h10l-3.4 5.6H.8z" fill="#3ddc97"/>
      </svg>
      <span class="brand__txt">Fugo<span>Creative</span></span>
    </a>
    <nav class="nav__links" aria-label="Primary">
      ${LINKS.map(([h, en, id]) =>
        `<a class="nav__link${h === active ? ' is-active' : ''}" href="${h}" data-en="${en}" data-id="${id}">${en}</a>`).join('\n      ')}
    </nav>
    <div class="nav__side">
      <div class="lang" data-lang="en" role="group" aria-label="Language">
        <span class="lang__pill" aria-hidden="true"></span>
        <button class="lang__btn is-on" data-lang="en" aria-label="English">EN</button>
        <button class="lang__btn" data-lang="id" aria-label="Bahasa Indonesia">ID</button>
      </div>
      <a class="btn btn--green btn--sm" href="contact.html" data-magnet=".28" data-en="Start a project" data-id="Mulai proyek">Start a project</a>
      <button class="burger" aria-label="Menu" aria-expanded="false"><i></i><i></i></button>
    </div>
  </div>
</header>
<div class="menu" id="menu">
  <ul class="menu__list">
    ${LINKS.map(([h, en, id]) => `<li class="menu__item"><a href="${h}" data-en="${en}" data-id="${id}">${en}</a></li>`).join('\n    ')}
  </ul>
  <div class="menu__foot">
    <span>hello@fugocreativegroup.com</span><span>+62 821 2100 0680</span><span>Bandung · Jakarta · Bali</span>
  </div>
</div>`;

const cta = `
<section class="section cta">
  <div class="cta__glow" aria-hidden="true"></div>
  <div class="shell">
    <p class="eyebrow is-plain fade-up" style="justify-content:center" data-en="Available for Q4 2026 projects" data-id="Tersedia untuk proyek Q4 2026">Available for Q4 2026 projects</p>
    <h2 class="display cta__big mt-s fade-up" data-delay="1" data-en="Let's build&lt;br&gt;something" data-id="Ayo bangun&lt;br&gt;sesuatu">Let's build<br>something</h2>
    <div class="row gap-s mt-l fade-up" data-delay="2" style="justify-content:center">
      <a class="btn btn--green" href="contact.html" data-magnet=".34" data-cursor="Go"><span data-en="Start a project" data-id="Mulai proyek">Start a project</span><span class="ico" aria-hidden="true">↗</span></a>
      <a class="btn btn--ghost" href="mailto:hello@fugocreativegroup.com">hello@fugocreativegroup.com</a>
    </div>
  </div>
</section>`;

const foot = (label) => `
<footer class="foot">
  <div class="shell">
    <div class="foot__top">
      <div>
        <a class="brand" href="index.html">
          <svg class="brand__mark" viewBox="0 0 32 32" aria-hidden="true"><path d="M11 6h14l-3.4 5.6H7.6zM7.6 14h12l-3.4 5.6H4.2zM4.2 22h10l-3.4 5.6H.8z" fill="#3ddc97"/></svg>
          <span class="brand__txt">Fugo<span>Creative</span></span>
        </a>
        <p class="muted mt-m" style="max-width:34ch;font-size:.92rem" data-en="PT Fugo Creative Group — a creative company delivering innovative, high-impact solutions since 2016." data-id="PT Fugo Creative Group — creative company yang menghadirkan solusi inovatif dan berdampak sejak 2016.">PT Fugo Creative Group — a creative company delivering innovative, high-impact solutions since 2016.</p>
      </div>
      <div>
        <h5 data-en="Navigate" data-id="Navigasi">Navigate</h5>
        <ul>${LINKS.slice(1).map(([h, en, id]) => `<li><a href="${h}" data-en="${en}" data-id="${id}">${en}</a></li>`).join('')}<li><a href="contact.html" data-en="Careers" data-id="Karier">Careers</a></li></ul>
      </div>
      <div>
        <h5 data-en="Follow" data-id="Ikuti">Follow</h5>
        <ul>
          <li><a href="https://instagram.com/fugocreative" rel="noopener">Instagram</a></li>
          <li><a href="https://id.linkedin.com/company/fugo-creativegroup" rel="noopener">LinkedIn</a></li>
          <li><a href="https://tiktok.com/@fugo.creative" rel="noopener">TikTok</a></li>
          <li><a href="https://youtube.com/@fugocreative" rel="noopener">YouTube</a></li>
        </ul>
      </div>
      <div>
        <h5 data-en="Studios" data-id="Studio">Studios</h5>
        <address><strong style="color:var(--ink)">Bandung — HQ</strong><br>Jl. Permata Taman Sari Raya No.21, Arcamanik</address>
        <address><strong style="color:var(--ink)">Jakarta</strong><br>Jl. Srengseng Sawah No.16, Jagakarsa</address>
        <address><strong style="color:var(--ink)">Bali</strong><br>Jl. Tukad Melangit, Samplangan, Gianyar</address>
      </div>
    </div>
    <p class="display foot__word" aria-hidden="true">FUGO</p>
    <div class="foot__bot">
      <span>© 2026 PT Fugo Creative Group</span>
      <span>${label}</span>
      <span><a href="tel:+6282121000680">+62 821 2100 0680</a></span>
    </div>
  </div>
</footer>
<!-- ── motion stack ────────────────────────────────────────────────
     GSAP 3.13+ (free, all plugins incl. SplitText) · Lenis.
     Three.js is index-only — the WebGL hero does not exist on inner pages.
     motion.js degrades the whole page gracefully if any of these fail. -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrollTrigger.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/SplitText.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/lenis@1/dist/lenis.min.js" defer></script>
<script src="assets/js/motion.js" defer></script>
</body>
</html>`;

const page = ({ file, title, desc, body, withCta = true }) =>
  fs.writeFileSync(__dirname + '/' + file,
    head(title, desc, file) + nav(file) + '\n<main>\n' + body + (withCta ? cta : '') + '\n</main>\n' +
    foot('Concept redesign — Direction A “Signal”'));

/* ---------- shared bits ---------- */
const phead = (num, kicker, kickerId, h, hId, lede, ledeId) => `
<section class="phead">
  <div class="phead__glow" aria-hidden="true"></div>
  <div class="shell">
    <p class="crumb fade-up"><a href="index.html">Fugo</a> <span>/</span> <span data-en="${kicker}" data-id="${kickerId}">${kicker}</span></p>
    <h1 class="display h-xxl mt-s fade-up" data-delay="1" data-en="${h}" data-id="${hId}">${h.replace(/&lt;br&gt;/g, '<br>')}</h1>
    <p class="lede mt-m fade-up" data-delay="2" data-en="${lede}" data-id="${ledeId}">${lede}</p>
  </div>
</section>`;

/* ================= WORK ================= */
const projects = [
  ['001', 'BRI Debit Virtual TVC', 'Bank Rakyat Indonesia', 'Production', '2025', '#0e3c8c', 'case-study.html'],
  ['002', 'Dealer Campaign System', 'Daihatsu', 'Design', '2024', '#1a1f2b', 'case-study.html'],
  ['003', 'National Transport Expo', 'Kemenhub', 'Events', '2024', '#123', 'case-study.html'],
  ['004', 'Partner Welcome Kit', 'Telkomsel', 'Merch', '2023', '#5a1414', 'case-study.html'],
  ['005', 'Annual Report 2023', 'Bank Mandiri', 'Design', '2023', '#0a2f4a', 'case-study.html'],
  ['006', 'Cabin Crew Uniform Line', 'Citilink', 'Merch', '2023', '#0f3d2e', 'case-study.html'],
  ['007', 'Ramadan Brand Film', 'bjb Syariah', 'Production', '2025', '#2a1a4a', 'case-study.html'],
  ['008', 'Sales Kickoff Gathering', 'BTPN', 'Events', '2024', '#3a2410', 'case-study.html'],
  ['009', 'Product Launch Coverage', 'Suzuki', 'Production', '2024', '#141b2e', 'case-study.html'],
  ['010', 'Brand Identity Refresh', 'Nutrigoat', 'Design', '2025', '#123a1e', 'case-study.html'],
];
const peekSvg = (c) => `&lt;svg viewBox=&quot;0 0 300 210&quot; preserveAspectRatio=&quot;none&quot; style=&quot;width:100%;height:100%&quot;&gt;&lt;rect width=&quot;300&quot; height=&quot;210&quot; fill=&quot;${c}&quot;/&gt;&lt;circle cx=&quot;220&quot; cy=&quot;40&quot; r=&quot;90&quot; fill=&quot;%233ddc97&quot; opacity=&quot;.28&quot;/&gt;&lt;rect x=&quot;28&quot; y=&quot;120&quot; width=&quot;120&quot; height=&quot;10&quot; rx=&quot;5&quot; fill=&quot;%23ffffff&quot; opacity=&quot;.5&quot;/&gt;&lt;rect x=&quot;28&quot; y=&quot;144&quot; width=&quot;70&quot; height=&quot;10&quot; rx=&quot;5&quot; fill=&quot;%23c8f24e&quot; opacity=&quot;.7&quot;/&gt;&lt;/svg&gt;`;

page({
  file: 'work.html',
  title: 'Selected Work — Fugo Creative | Campaigns, Film, Events',
  desc: 'Campaign, film, event and merchandise work for BRI, Daihatsu, Kemenhub, Telkomsel and Bank Mandiri — produced in-house across Bandung, Jakarta and Bali.',
  body: phead('', 'Work', 'Karya',
    'Selected&lt;br&gt;work', 'Karya&lt;br&gt;pilihan',
    'Ten projects that show the range: a national TVC, a dealer system used in 200+ locations, a three-day expo, and 12,000 kits shipped on time.',
    'Sepuluh proyek yang menunjukkan rentang kami: TVC nasional, sistem dealer di 200+ lokasi, expo tiga hari, dan 12.000 kit terkirim tepat waktu.') + `
<section class="section" style="padding-top:clamp(2rem,4vw,3rem)">
  <div class="shell">
    <div class="chips fade-up" style="margin-bottom:2.5rem" role="group" aria-label="Filter">
      <button class="chip on" data-filter="all" data-en="All" data-id="Semua">All</button>
      <button class="chip" data-filter="Design">Design</button>
      <button class="chip" data-filter="Production" data-en="Production" data-id="Produksi">Production</button>
      <button class="chip" data-filter="Events" data-en="Events" data-id="Acara">Events</button>
      <button class="chip" data-filter="Merch">Merch</button>
    </div>
    <div class="wlist">
      ${projects.map(([n, t, c, cat, y, col, href]) => `
      <a class="wrow fade-up" href="${href}" data-cat="${cat}" data-cursor="Open" data-peek="${peekSvg(col.replace('#', '%23'))}">
        <span class="wrow__n">${n}</span>
        <span class="wrow__t">${t}</span>
        <span class="wrow__c">${c} · ${cat}</span>
        <span class="wrow__y">${y}</span>
      </a>`).join('')}
    </div>
    <p class="mono faint mt-l" id="wcount"></p>
  </div>
</section>
<script>
(()=>{const chips=[...document.querySelectorAll('[data-filter]')],rows=[...document.querySelectorAll('.wrow')],out=document.getElementById('wcount');
const apply=f=>{let n=0;rows.forEach(r=>{const ok=f==='all'||r.dataset.cat===f;r.style.display=ok?'':'none';if(ok)n++});
out.textContent=n+(document.documentElement.lang==='id'?' proyek ditampilkan':' projects shown')};
chips.forEach(c=>c.addEventListener('click',()=>{chips.forEach(x=>x.classList.remove('on'));c.classList.add('on');apply(c.dataset.filter)}));
apply('all');document.addEventListener('langchange',()=>apply(document.querySelector('.chip.on').dataset.filter));})();
</script>`
});

/* ================= SERVICES ================= */
const svc = [
  ['01', 'Fugo Design', 'Desain',
    'Brand systems, campaign POSM, corporate reporting and digital assets — built to survive print, LED and social.',
    'Sistem brand, POSM kampanye, laporan korporat, dan aset digital — dibangun untuk bertahan di cetak, LED, dan sosial.',
    [['Creative Campaign (POSM)', 'Poster, flyer, banner, billboard, print ad, LED, newsletter, welcome kit'],
     ['Branding', 'Naming, logo, packaging, graphic standards manual'],
     ['Corporate', 'Annual report, company profile, calendar, stationery'],
     ['Digital Campaign', '2D/3D filters, motion graphics, bumpers, presentation design']]],
  ['02', 'Production House', 'Production House',
    'TVC, company profile, digital video and event documentation — scripting, shoot, grade and score in-house.',
    'TVC, company profile, video digital, dan dokumentasi acara — naskah, syuting, grading, dan scoring in-house.',
    [['Commercial & TVC', 'Concept, script, casting, shoot, post-production'],
     ['Company Profile', 'Full production from scripting through original music'],
     ['Digital Video', 'Social-first cutdowns, vertical formats, ad variants'],
     ['Coverage', 'Event documentation, product photography and videography']]],
  ['03', 'Event Organizer', 'Event Organizer',
    'Conferences, exhibitions, incentive trips and corporate gatherings — run end to end.',
    'Konferensi, pameran, incentive trip, dan gathering korporat — dijalankan end to end.',
    [['Meeting & Conference', 'Training, workshop, staff meeting, industry conference'],
     ['Exhibition', 'Trade show, job fair, art and wedding exhibitions'],
     ['Incentive', 'Gathering, business trip, holiday trip, team building'],
     ['Special', 'CSR, cultural, political and celebration events']]],
  ['04', 'Merch Production', 'Merch Production',
    'Souvenirs, uniforms and welcome kits produced at scale with materials we can stand behind.',
    'Souvenir, seragam, dan welcome kit diproduksi dalam skala besar dengan material yang bisa kami pertanggungjawabkan.',
    [['Souvenir', 'Mug, notebook, pen, umbrella, USB, bag, calendar, keychain'],
     ['Uniform', 'Shirt, polo, vest, sweater, jacket, trousers, footwear'],
     ['Welcome Kit', 'Curated boxes with packaging design and fulfilment'],
     ['Sourcing & QC', 'Material selection, sampling, quality control, delivery']]],
  ['05', 'AI Agent', 'AI Agent',
    'Custom AI agents and automations that take repetitive work off your team — briefed, built, and wired into the tools you already use.',
    'AI agent dan otomasi khusus yang mengambil pekerjaan berulang dari tim Anda — dirancang, dibangun, dan terhubung ke tools yang sudah Anda pakai.',
    [['Customer Agents', 'WhatsApp and web agents that answer, qualify and hand over cleanly'],
     ['Workflow Automation', 'Briefs, approvals, reporting and handovers, run without chasing'],
     ['Content Ops', 'Bulk copy, translation and asset variants at campaign scale'],
     ['Integrations', 'Connected to the CRM, sheets and channels the team already lives in']]],
];

page({
  file: 'services.html',
  title: 'Services — Fugo Creative | Design, Film, Events, Merch, AI',
  desc: 'Five specialist divisions under one roof: Design, Production House, Event Organizer, Merch Production and AI Agent. Brief one team, skip the agency handoff tax.',
  body: phead('', 'Services', 'Layanan',
    'Five studios,&lt;br&gt;one invoice', 'Lima studio,&lt;br&gt;satu invoice',
    'Most agencies subcontract at least half of this. We do not — which is why the schedule holds and the brand stays consistent across every touchpoint.',
    'Kebanyakan agensi mensubkontrakkan setengahnya. Kami tidak — karena itu jadwal terjaga dan brand tetap konsisten di setiap titik sentuh.') + `
<section class="section">
  <div class="shell stack gap-xl">
    ${svc.map(([n, t, tId, d, dId, rows]) => `
    <article class="card fade-up" id="s${n}" data-cursor="${t}">
      <div class="grid g-12" style="align-items:start">
        <div class="col-5">
          <p class="card__num">${n}</p>
          <h3 data-en="${t}" data-id="${tId}">${t}</h3>
          <p data-en="${d}" data-id="${dId}">${d}</p>
          <a class="btn btn--ghost mt-m" href="contact.html" data-en="Brief this team" data-id="Brief tim ini">Brief this team</a>
        </div>
        <div class="col-7">
          <dl class="stack">
            ${rows.map(([k, v]) => `
            <div style="padding-block:1rem;border-top:1px solid var(--line)">
              <dt class="h-lg" style="font-size:1.05rem">${k}</dt>
              <dd class="muted" style="font-size:.92rem;margin-top:.35rem">${v}</dd>
            </div>`).join('')}
          </dl>
        </div>
      </div>
    </article>`).join('')}
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell">
    <p class="eyebrow fade-up" data-en="Engagement models" data-id="Model kerja sama">Engagement models</p>
    <h2 class="display h-xl mt-s fade-up" data-delay="1" data-en="Three ways to work&lt;br&gt;with us" data-id="Tiga cara bekerja&lt;br&gt;dengan kami">Three ways to work<br>with us</h2>
    <div class="grid g-12 mt-l">
      <div class="col-4 card fade-up">
        <p class="card__num">A</p><h3 data-en="Project" data-id="Proyek">Project</h3>
        <p data-en="One brief, one deliverable, fixed scope and fixed price. Best for launches and one-off films." data-id="Satu brief, satu deliverable, lingkup dan harga tetap. Cocok untuk peluncuran dan film sekali jalan.">One brief, one deliverable, fixed scope and fixed price. Best for launches and one-off films.</p>
      </div>
      <div class="col-4 card fade-up" data-delay="1">
        <p class="card__num">B</p><h3 data-en="Retainer" data-id="Retainer">Retainer</h3>
        <p data-en="A monthly design and content allocation — the subscription model, with a named team and a real SLA." data-id="Alokasi desain dan konten bulanan — model langganan, dengan tim tetap dan SLA yang jelas.">A monthly design and content allocation — the subscription model, with a named team and a real SLA.</p>
      </div>
      <div class="col-4 card fade-up" data-delay="2">
        <p class="card__num">C</p><h3 data-en="Embedded" data-id="Embedded">Embedded</h3>
        <p data-en="We sit inside your marketing team for a campaign cycle: strategy, production and on-site delivery." data-id="Kami masuk ke tim marketing Anda untuk satu siklus kampanye: strategi, produksi, dan eksekusi di lokasi.">We sit inside your marketing team for a campaign cycle: strategy, production and on-site delivery.</p>
      </div>
    </div>
  </div>
</section>`
});

/* ================= ABOUT ================= */
const timeline = [
  ['2016', 'Founded as a merchandise production channel in Bandung.', 'Berdiri sebagai kanal produksi merchandise di Bandung.'],
  ['2018', 'Production house division opens; first TVC work.', 'Divisi production house dibuka; karya TVC pertama.'],
  ['2020', 'Incorporated as PT Fugo Creative Group.', 'Resmi menjadi PT Fugo Creative Group.'],
  ['2022', 'Event organizer division formalised.', 'Divisi event organizer diresmikan.'],
  ['2024', 'Jakarta branch opens; Bali studio follows.', 'Cabang Jakarta dibuka; studio Bali menyusul.'],
  ['2025', '65+ clients across finance, government, automotive and lifestyle.', '65+ klien di sektor keuangan, pemerintahan, otomotif, dan gaya hidup.'],
  ['2026', 'Artificial Intelligence division launched — agents and automation as the fifth studio.', 'Divisi Artificial Intelligence diluncurkan — agent dan otomasi sebagai studio kelima.'],
];

page({
  file: 'about.html',
  title: 'Studio — Fugo Creative | Indonesian Creative Group Since 2016',
  desc: 'PT Fugo Creative Group started in 2016 printing merchandise in Bandung. Nine years on: five divisions, three cities, 65+ clients across finance, government and lifestyle.',
  body: phead('', 'Studio', 'Studio',
    'A creative group,&lt;br&gt;not a vendor list', 'Creative group,&lt;br&gt;bukan daftar vendor',
    'We started in 2016 printing merchandise. Nine years later we run five divisions across three cities — and we still answer the phone ourselves.',
    'Kami mulai pada 2016 dengan mencetak merchandise. Sembilan tahun kemudian kami menjalankan lima divisi di tiga kota — dan kami masih mengangkat telepon sendiri.') + `
<section class="section" style="padding-top:clamp(2rem,4vw,3rem)">
  <div class="shell grid g-12">
    <div class="col-5">
      <p class="eyebrow fade-up" data-en="Our belief" data-id="Keyakinan kami">Our belief</p>
    </div>
    <div class="col-7">
      <p class="h-lg fade-up" style="font-size:clamp(1.3rem,2.6vw,2rem);max-width:24ch" data-en="Every brief can be solved with creativity, an innovative route, and execution that actually lands." data-id="Setiap brief bisa diselesaikan dengan kreativitas, jalur inovatif, dan eksekusi yang benar-benar mendarat.">Every brief can be solved with creativity, an innovative route, and execution that actually lands.</p>
      <p class="lede mt-m fade-up" data-delay="1" data-en="We reject the word impossible. Not as a slogan — as a working method: when a route is blocked we go and find the next one, and we tell you what it costs before you commit." data-id="Kami menolak kata mustahil. Bukan sebagai slogan — tapi sebagai metode kerja: ketika satu jalur tertutup, kami cari jalur berikutnya, dan kami sampaikan biayanya sebelum Anda memutuskan.">We reject the word impossible. Not as a slogan — as a working method: when a route is blocked we go and find the next one, and we tell you what it costs before you commit.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell">
    <div class="stats">
      <div class="stat fade-up"><p class="stat__n"><span data-count="9">0</span><sup>+</sup></p><p class="stat__l" data-en="Years" data-id="Tahun">Years</p></div>
      <div class="stat fade-up" data-delay="1"><p class="stat__n"><span data-count="65">0</span><sup>+</sup></p><p class="stat__l" data-en="Clients" data-id="Klien">Clients</p></div>
      <div class="stat fade-up" data-delay="2"><p class="stat__n"><span data-count="5">0</span></p><p class="stat__l" data-en="Divisions" data-id="Divisi">Divisions</p></div>
      <div class="stat fade-up" data-delay="3"><p class="stat__n"><span data-count="3">0</span></p><p class="stat__l" data-en="Cities" data-id="Kota">Cities</p></div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell grid g-12">
    <div class="col-4">
      <p class="eyebrow fade-up" data-en="Timeline" data-id="Linimasa">Timeline</p>
      <h2 class="display h-xl mt-s fade-up" data-delay="1" data-en="Nine years,&lt;br&gt;four divisions" data-id="Sembilan tahun,&lt;br&gt;empat divisi">Nine years,<br>four divisions</h2>
    </div>
    <div class="col-8">
      <div class="steps">
        ${timeline.map(([y, t, tId], i) => `
        <div class="step fade-up"${i ? ` data-delay="${Math.min(i, 5)}"` : ''}>
          <span class="step__n">${y}</span>
          <div class="step__b"><p class="muted" style="padding-top:.4rem" data-en="${t}" data-id="${tId}">${t}</p></div>
        </div>`).join('')}
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell">
    <div class="quote fade-up">
      <div>
        <p class="eyebrow" style="margin-bottom:1.6rem" data-en="From the founder" data-id="Dari pendiri">From the founder</p>
        <blockquote data-en="&ldquo;To become a creative industry company with real, positive impact for every stakeholder — through solutions that are useful before they are beautiful.&rdquo;" data-id="&ldquo;Menjadi perusahaan industri kreatif yang berdampak positif bagi seluruh stakeholder — lewat solusi yang berguna sebelum ia indah.&rdquo;">&ldquo;To become a creative industry company with real, positive impact for every stakeholder — through solutions that are useful before they are beautiful.&rdquo;</blockquote>
        <div class="quote__by"><span class="avatar" aria-hidden="true">SL</span><span><strong style="color:var(--ink)">Sona Lesmana</strong><br><span data-en="Founder &amp; CEO" data-id="Pendiri &amp; CEO">Founder &amp; CEO</span></span></div>
      </div>
      <div class="quote__art" aria-hidden="true">
        <span class="quote__ring"></span><span class="quote__ring"></span><span class="quote__ring"></span>
        <span class="quote__mark">&ldquo;</span>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell">
    <p class="eyebrow fade-up" data-en="Studios" data-id="Studio">Studios</p>
    <h2 class="display h-xl mt-s fade-up" data-delay="1" data-en="Three cities" data-id="Tiga kota">Three cities</h2>
    <div class="sectors mt-l fade-up" data-delay="2">
      <div class="sector"><h4>Bandung — HQ</h4><p class="muted" style="font-size:.92rem">Jl. Permata Taman Sari Raya No.21, Arcamanik</p></div>
      <div class="sector"><h4>Jakarta</h4><p class="muted" style="font-size:.92rem">Jl. Srengseng Sawah No.16, Jagakarsa</p></div>
      <div class="sector"><h4>Bali</h4><p class="muted" style="font-size:.92rem">Jl. Tukad Melangit, Samplangan, Gianyar</p></div>
    </div>
  </div>
</section>`
});

/* ================= CASE STUDY ================= */
page({
  file: 'case-study.html',
  title: 'BRI Debit Virtual TVC — Case Study | Fugo Creative',
  desc: 'How Fugo produced the BRImo virtual debit launch TVC — concept, script, casting, shoot and post handled in-house on a six-week turnaround across three cities.',
  body: `
<section class="phead">
  <div class="phead__glow" aria-hidden="true"></div>
  <div class="shell">
    <p class="crumb fade-up"><a href="index.html">Fugo</a> <span>/</span> <a href="work.html" data-en="Work" data-id="Karya">Work</a> <span>/</span> <span>BRI</span></p>
    <h1 class="display h-xxl mt-s fade-up" data-delay="1">BRI Debit<br>Virtual TVC</h1>
    <div class="row gap-l mt-m fade-up" data-delay="2">
      <div><p class="mono faint" data-en="Client" data-id="Klien">Client</p><p class="mt-s">Bank Rakyat Indonesia</p></div>
      <div><p class="mono faint" data-en="Scope" data-id="Lingkup">Scope</p><p class="mt-s">Concept · Script · Production · Post</p></div>
      <div><p class="mono faint" data-en="Year" data-id="Tahun">Year</p><p class="mt-s">2025</p></div>
      <div><p class="mono faint" data-en="Division" data-id="Divisi">Division</p><p class="mt-s">Production House</p></div>
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
    <div class="col-4"><p class="eyebrow fade-up" data-en="The brief" data-id="Brief">The brief</p></div>
    <div class="col-8">
      <p class="h-lg fade-up" style="max-width:26ch" data-en="Explain a product nobody can hold." data-id="Menjelaskan produk yang tidak bisa dipegang.">Explain a product nobody can hold.</p>
      <p class="lede mt-m fade-up" data-delay="1" data-en="BRImo's virtual debit card had no physical object to film, no packaging to unbox, and a compliance list longer than the script. The commercial had to make an invisible product feel safer than a plastic one." data-id="Kartu debit virtual BRImo tidak punya objek fisik untuk difilmkan, tidak ada kemasan untuk dibuka, dan daftar kepatuhan yang lebih panjang dari naskahnya. Iklan ini harus membuat produk tak kasat mata terasa lebih aman daripada kartu plastik.">BRImo's virtual debit card had no physical object to film, no packaging to unbox, and a compliance list longer than the script. The commercial had to make an invisible product feel safer than a plastic one.</p>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell grid g-12">
    <div class="col-4"><p class="eyebrow fade-up" data-en="What we did" data-id="Yang kami lakukan">What we did</p></div>
    <div class="col-8">
      <div class="steps">
        <div class="step fade-up"><span class="step__n">01</span><div class="step__b"><h3 data-en="Found the human moment" data-id="Menemukan momen manusia">Found the human moment</h3><p data-en="We stopped selling the card and started filming the two seconds after someone realises they can pay without it." data-id="Kami berhenti menjual kartunya dan mulai memfilmkan dua detik setelah seseorang sadar ia bisa membayar tanpa kartu.">We stopped selling the card and started filming the two seconds after someone realises they can pay without it.</p></div></div>
        <div class="step fade-up" data-delay="1"><span class="step__n">02</span><div class="step__b"><h3 data-en="Built the UI in camera" data-id="Membangun UI di kamera">Built the UI in camera</h3><p data-en="Screen content was pre-rendered and played back on set, so compliance approved the exact frames that shipped." data-id="Konten layar dirender lebih dulu dan diputar di lokasi syuting, sehingga tim kepatuhan menyetujui frame yang benar-benar tayang.">Screen content was pre-rendered and played back on set, so compliance approved the exact frames that shipped.</p></div></div>
        <div class="step fade-up" data-delay="2"><span class="step__n">03</span><div class="step__b"><h3 data-en="Cut once, delivered nine ways" data-id="Sekali edit, sembilan format">Cut once, delivered nine ways</h3><p data-en="One shoot produced the 30s TVC, three 15s cutdowns, vertical social edits and in-branch LED loops." data-id="Satu kali syuting menghasilkan TVC 30 detik, tiga cutdown 15 detik, edit vertikal untuk sosial, dan loop LED di cabang.">One shoot produced the 30s TVC, three 15s cutdowns, vertical social edits and in-branch LED loops.</p></div></div>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell">
    <div class="stats">
      <div class="stat fade-up"><p class="stat__n"><span data-count="9">0</span></p><p class="stat__l" data-en="Deliverables from one shoot" data-id="Deliverable dari satu syuting">Deliverables from one shoot</p></div>
      <div class="stat fade-up" data-delay="1"><p class="stat__n"><span data-count="6">0</span><sup>wk</sup></p><p class="stat__l" data-en="Brief to broadcast" data-id="Brief ke tayang">Brief to broadcast</p></div>
      <div class="stat fade-up" data-delay="2"><p class="stat__n"><span data-count="0">0</span></p><p class="stat__l" data-en="Compliance reshoots" data-id="Syuting ulang kepatuhan">Compliance reshoots</p></div>
      <div class="stat fade-up" data-delay="3"><p class="stat__n"><span data-count="3">0</span></p><p class="stat__l" data-en="Channels launched same week" data-id="Kanal tayang pekan yang sama">Channels launched same week</p></div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0">
  <div class="shell row between center gap-m">
    <a class="tlink" href="work.html" data-en="← All work" data-id="← Semua karya">← All work</a>
    <a class="tlink green" href="work.html" data-en="Next project →" data-id="Proyek berikutnya →">Next project →</a>
  </div>
</section>`
});

/* ================= CONTACT ================= */
page({
  file: 'contact.html',
  title: 'Contact — Fugo Creative | Bandung, Jakarta &amp; Bali',
  desc: 'Start a project with Fugo Creative. Offices in Bandung, Jakarta and Bali. WhatsApp +62 821 2100 0680 or email hello@fugocreativegroup.com — we answer the phone ourselves.',
  withCta: false,
  body: phead('', 'Contact', 'Kontak',
    'Tell us what&lt;br&gt;you need to land', 'Ceritakan apa&lt;br&gt;yang harus mendarat',
    'A short brief is enough to start. We reply within one working day with questions, a route and a rough number — before any meeting.',
    'Brief singkat sudah cukup untuk memulai. Kami membalas dalam satu hari kerja dengan pertanyaan, opsi jalur, dan estimasi kasar — sebelum rapat apa pun.') + `
<section class="section" style="padding-top:clamp(1.5rem,3vw,2.5rem)">
  <div class="shell grid g-12">
    <div class="col-7">
      <form data-demo class="fade-up" novalidate>
        <p class="mono faint" data-en="What do you need?" data-id="Apa yang Anda butuhkan?">What do you need?</p>
        <div class="chips" role="group">
          <button type="button" class="chip on">Design</button>
          <button type="button" class="chip" data-en="Film / TVC" data-id="Film / TVC">Film / TVC</button>
          <button type="button" class="chip" data-en="Event" data-id="Acara">Event</button>
          <button type="button" class="chip">Merch</button>
          <button type="button" class="chip" data-en="Not sure yet" data-id="Belum yakin">Not sure yet</button>
        </div>

        <div class="field" style="margin-top:2rem">
          <label for="f-name" data-en="Your name" data-id="Nama Anda">Your name</label>
          <input id="f-name" type="text" autocomplete="name" required>
        </div>
        <div class="field">
          <label for="f-co" data-en="Company" data-id="Perusahaan">Company</label>
          <input id="f-co" type="text" autocomplete="organization">
        </div>
        <div class="field">
          <label for="f-mail" data-en="Email" data-id="Email">Email</label>
          <input id="f-mail" type="email" autocomplete="email" required>
        </div>
        <div class="field">
          <label for="f-msg" data-en="What are we making?" data-id="Apa yang akan kita buat?">What are we making?</label>
          <textarea id="f-msg" rows="4"></textarea>
        </div>

        <button class="btn btn--green mt-l" type="submit" data-magnet=".3" data-en="Send the brief" data-id="Kirim brief">Send the brief</button>
        <p class="mono faint mt-m" data-en="This prototype form does not send anything yet." data-id="Formulir prototipe ini belum mengirim apa pun.">This prototype form does not send anything yet.</p>
      </form>
    </div>

    <div class="col-5">
      <div class="card fade-up" data-delay="1">
        <p class="card__num" data-en="Direct" data-id="Langsung">Direct</p>
        <h3 style="font-size:1.4rem">WhatsApp</h3>
        <p><a class="tlink green" href="https://wa.me/6282121000680" rel="noopener">+62 821 2100 0680</a></p>
        <p class="mt-m"><a class="tlink" href="mailto:hello@fugocreativegroup.com">hello@fugocreativegroup.com</a></p>
        <div class="card__tags" style="margin-top:1.6rem">
          <span class="tag" data-en="Reply within 1 working day" data-id="Balasan dalam 1 hari kerja">Reply within 1 working day</span>
        </div>
      </div>

      <div class="card fade-up mt-m" data-delay="2">
        <p class="card__num" data-en="Studios" data-id="Studio">Studios</p>
        <address class="muted mt-s" style="font-style:normal;line-height:1.7">
          <strong style="color:var(--ink)">Bandung — HQ</strong><br>Jl. Permata Taman Sari Raya No.21, Arcamanik<br><br>
          <strong style="color:var(--ink)">Jakarta</strong><br>Jl. Srengseng Sawah No.16, Jagakarsa<br><br>
          <strong style="color:var(--ink)">Bali</strong><br>Jl. Tukad Melangit, Samplangan, Gianyar
        </address>
      </div>

      <div class="card fade-up mt-m" data-delay="3">
        <p class="card__num" data-en="Careers" data-id="Karier">Careers</p>
        <h3 style="font-size:1.4rem" data-en="Join the studio" data-id="Gabung studio">Join the studio</h3>
        <p data-en="We hire designers, editors and producers in Bandung and Jakarta. Send work, not a cover letter." data-id="Kami merekrut desainer, editor, dan produser di Bandung dan Jakarta. Kirim karya, bukan surat lamaran.">We hire designers, editors and producers in Bandung and Jakarta. Send work, not a cover letter.</p>
        <a class="tlink green mt-s" href="mailto:hello@fugocreativegroup.com" data-en="Send your portfolio" data-id="Kirim portofolio">Send your portfolio</a>
      </div>
    </div>
  </div>
</section>`
});

console.log('Direction A pages generated.');


/* ================= 404 ================= */
page({
  file: '404.html',
  title: 'Page not found — Fugo Creative',
  desc: 'That page does not exist. The link may be old or the page may have moved — everything else is still where you left it.',
  body: phead('404', 'Error', 'Error',
    'This page&lt;br&gt;does not exist', 'Halaman ini&lt;br&gt;tidak ada',
    'The link may be old, or the page may have moved. Everything else is still where you left it.',
    'Tautannya mungkin sudah lama, atau halamannya dipindah. Sisanya masih di tempatnya.'),
});
