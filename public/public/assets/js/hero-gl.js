/* ==========================================================================
   FUGO CREATIVE — Direction A "SIGNAL"  ·  WebGL hero
   Signals entering from off-screen. Nothing is drawn until a burst fires:
   two or three pulses cross in from the same edge, staircase inward on right
   angles, land on a pad and fade. The routes exist in memory but are never
   drawn.

   Right angles only. Deliberately slow.

   Self-contained. Reads scroll from window.__fugoScroll (set by motion.js)
   rather than adding a listener or a second rAF. If Three fails to load the
   hero stays dark and nothing else on the page notices.
   ========================================================================== */
import * as THREE from 'three';

const canvas = document.querySelector('.hero__canvas');
if (canvas) init(canvas);

function init(canvas) {
  const tier = document.documentElement.dataset.tier || 'full';
  if (tier === 'off') return;
  const REDUCED = tier === 'reduced';

  const GREEN = new THREE.Color('#3ddc97');
  const LIME  = new THREE.Color('#c8f24e');

  /* ---- tuning ----------------------------------------------------------
     ROUTES       distinct paths available to choose from (never drawn)
     MAX_LIVE     pulses alive at once — the ceiling on how busy it gets
     BURST        how many fire together
     BURST_RATE   bursts started per second
     SPEED        world units/sec; a long route takes proportionally longer,
                  so nothing races
     ---------------------------------------------------------------------- */
  const ROUTES      = REDUCED ? 44 : 72;
  const MAX_LIVE    = REDUCED ? 6 : 9;
  const BURST_MIN   = 2, BURST_MAX = 3;
  const BURST_RATE  = REDUCED ? 0.30 : 0.45;
  const SPEED_MIN   = 2.0, SPEED_MAX = 3.4;
  const CELL        = 1.7;
  const HALF_H      = 15;                 // world half-height, fixed
  const OUTSIDE     = 2;                  // cells beyond the edge to start at

  let renderer;
  try {
    renderer = new THREE.WebGLRenderer({
      canvas, alpha: true, antialias: !REDUCED, powerPreference: 'low-power',
    });
  } catch { return; }
  renderer.setPixelRatio(Math.min(devicePixelRatio || 1, REDUCED ? 1.25 : 1.75));

  const scene = new THREE.Scene();
  const board = new THREE.Group();
  scene.add(board);
  const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, -10, 10);
  const uFade = { value: 1 };

  /* Half-extents in grid cells. halfW tracks the viewport aspect, so a route
     that starts "just off the left edge" really does.                       */
  let colsHalf = 20, rowsHalf = Math.round(HALF_H / CELL);
  function measure() {
    const r = canvas.getBoundingClientRect();
    const aspect = (r.width || 16) / (r.height || 9);
    colsHalf = Math.max(6, Math.round((HALF_H * aspect) / CELL));
  }
  measure();

  /* ------------------------------------------------------ route routing --
     Start just outside one edge, then staircase inward: legs alternate axis,
     and every leg on the entry axis keeps heading inward so the signal
     crosses the screen instead of bouncing back out.                        */
  const EDGES = [
    { name: 'left',   axis: 'h', sign:  1 },
    { name: 'right',  axis: 'h', sign: -1 },
    { name: 'top',    axis: 'v', sign: -1 },
    { name: 'bottom', axis: 'v', sign:  1 },
  ];

  function buildRoute(edgeIdx) {
    const e = EDGES[edgeIdx];
    let cx, cy;
    if (e.axis === 'h') {
      cx = e.sign > 0 ? -(colsHalf + OUTSIDE) : (colsHalf + OUTSIDE);
      cy = Math.round((Math.random() * 2 - 1) * rowsHalf);
    } else {
      cy = e.sign > 0 ? -(rowsHalf + OUTSIDE) : (rowsHalf + OUTSIDE);
      cx = Math.round((Math.random() * 2 - 1) * colsHalf);
    }

    const cells = [[cx, cy]];
    const legs = 3 + Math.floor(Math.random() * 4);
    let onEntryAxis = true;                     // first leg heads inward
    const limX = colsHalf + OUTSIDE, limY = rowsHalf + OUTSIDE;

    for (let l = 0; l < legs; l++) {
      let dx = 0, dy = 0, len;
      if (onEntryAxis) {
        // inward, and long enough to make progress across the board
        len = 3 + Math.floor(Math.random() * 6);
        if (e.axis === 'h') dx = e.sign; else dy = e.sign;
      } else {
        len = 2 + Math.floor(Math.random() * 4);
        const s = Math.random() < 0.5 ? 1 : -1;
        if (e.axis === 'h') dy = s; else dx = s;
      }
      const nx = Math.max(-limX, Math.min(limX, cx + dx * len));
      const ny = Math.max(-limY, Math.min(limY, cy + dy * len));
      onEntryAxis = !onEntryAxis;
      if (nx === cx && ny === cy) continue;      // clamped flat against an edge
      cx = nx; cy = ny;
      cells.push([cx, cy]);
    }
    if (cells.length < 2) return null;

    const pos = new Float32Array(cells.length * 3);
    const at  = new Float32Array(cells.length);
    let run = 0;
    for (let i = 0; i < cells.length; i++) {
      const x = cells[i][0] * CELL, y = cells[i][1] * CELL;
      if (i > 0) run += Math.hypot(x - cells[i - 1][0] * CELL, y - cells[i - 1][1] * CELL);
      pos[i * 3] = x; pos[i * 3 + 1] = y; pos[i * 3 + 2] = 0;
      at[i] = run;
    }
    if (run <= 0) return null;
    for (let i = 0; i < at.length; i++) at[i] /= run;
    return { pos, at, length: run, edge: edgeIdx };
  }

  const routes = [];
  for (let r = 0; routes.length < ROUTES && r < ROUTES * 3; r++) {
    const built = buildRoute(r % EDGES.length);
    if (built) routes.push(built);
  }
  if (!routes.length) return;

  /* -------------------------------------------------------------- pads --
     Only the pad a pulse lands on is ever visible, so the hero is genuinely
     empty between bursts.                                                   */
  const padPos = new Float32Array(routes.length * 3);
  const padBright = new Float32Array(routes.length);
  const padGeo = new THREE.BufferGeometry();
  const padPosAttr = new THREE.BufferAttribute(padPos, 3);
  const padBrightAttr = new THREE.BufferAttribute(padBright, 1);
  padPosAttr.setUsage(THREE.DynamicDrawUsage);
  padBrightAttr.setUsage(THREE.DynamicDrawUsage);
  padGeo.setAttribute('position', padPosAttr);
  padGeo.setAttribute('aBright', padBrightAttr);
  function syncPad(i) {
    const t = routes[i], n = t.pos.length / 3;
    padPos[i * 3] = t.pos[(n - 1) * 3];
    padPos[i * 3 + 1] = t.pos[(n - 1) * 3 + 1];
    padPosAttr.needsUpdate = true;
  }
  routes.forEach((_, i) => syncPad(i));

  board.add(new THREE.Points(padGeo, new THREE.ShaderMaterial({
    uniforms: {
      u_col: { value: GREEN }, u_hot: { value: LIME },
      u_fade: uFade, u_dpr: { value: renderer.getPixelRatio() },
    },
    transparent: true, depthWrite: false, blending: THREE.AdditiveBlending,
    vertexShader: `
      attribute float aBright; uniform float u_dpr; varying float vB;
      void main(){
        vB = aBright;
        gl_PointSize = (2.0 + aBright * 6.0) * u_dpr;
        gl_Position = projectionMatrix * modelViewMatrix * vec4(position,1.0);
      }`,
    fragmentShader: `
      precision mediump float;
      uniform vec3 u_col; uniform vec3 u_hot; uniform float u_fade;
      varying float vB;
      void main(){
        if (vB <= 0.002) discard;                 // invisible at rest
        vec2 c = gl_PointCoord - 0.5;
        float m = 1.0 - smoothstep(0.30, 0.5, max(abs(c.x), abs(c.y)));
        if (m <= 0.0) discard;
        gl_FragColor = vec4(mix(u_col, u_hot, vB), m * vB * u_fade);
      }`,
  })));

  /* ------------------------------------------------------------ pulses --
     A bright head with a long exponential tail. The tail is the only thing
     that reveals the route, so it runs long.                                */
  const PULSE_VERT = `
    attribute float aT;
    uniform float u_head; uniform float u_width;
    varying float vA; varying float vD;
    void main(){
      float d = u_head - aT;                       // >0 = behind the head
      float head = exp(-pow((aT - u_head) / u_width, 2.0));
      float tail = d > 0.0 ? exp(-d * 4.2) * 0.62 : 0.0;
      vA = clamp(head + tail, 0.0, 1.0);
      vD = clamp(d * 1.8, 0.0, 1.0);
      gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
    }`;
  const PULSE_FRAG = `
    precision mediump float;
    uniform vec3 u_core; uniform vec3 u_tail;
    uniform float u_alpha; uniform float u_fade;
    varying float vA; varying float vD;
    void main(){
      gl_FragColor = vec4(mix(u_core, u_tail, vD), vA * u_alpha * u_fade);
    }`;

  const lines = routes.map(t => {
    const g = new THREE.BufferGeometry();
    g.setAttribute('position', new THREE.BufferAttribute(t.pos, 3));
    g.setAttribute('aT', new THREE.BufferAttribute(t.at, 1));
    const line = new THREE.Line(g, new THREE.ShaderMaterial({
      uniforms: {
        u_head:  { value: 0 }, u_width: { value: 0.05 }, u_alpha: { value: 0 },
        u_core:  { value: LIME }, u_tail: { value: GREEN }, u_fade: uFade,
      },
      transparent: true, depthWrite: false, blending: THREE.AdditiveBlending,
      vertexShader: PULSE_VERT, fragmentShader: PULSE_FRAG,
    }));
    line.visible = false;
    board.add(line);
    return line;
  });

  /* A resized window moves the edges, so idle routes are re-cut to the new
     ones. Live routes are left alone and re-cut when they finish — mutating
     geometry mid-flight would snap a pulse sideways. */
  const stale = new Set();
  function recut(i) {
    const built = buildRoute(routes[i].edge);
    if (!built) return;
    routes[i] = built;
    const g = lines[i].geometry;
    g.setAttribute('position', new THREE.BufferAttribute(built.pos, 3));
    g.setAttribute('aT', new THREE.BufferAttribute(built.at, 1));
    syncPad(i);
    stale.delete(i);
  }

  const live = [];
  const idle = new Set(routes.map((_, i) => i));

  function burst() {
    if (live.length >= MAX_LIVE) return;
    // One edge per burst, so it reads as a wavefront arriving rather than
    // unrelated pulses that happened to coincide.
    const byEdge = [[], [], [], []];
    idle.forEach(i => byEdge[routes[i].edge].push(i));
    const options = byEdge.filter(a => a.length);
    if (!options.length) return;
    const pool = options[Math.floor(Math.random() * options.length)];

    const want = Math.min(
      BURST_MIN + Math.floor(Math.random() * (BURST_MAX - BURST_MIN + 1)),
      MAX_LIVE - live.length, pool.length);

    for (let k = 0; k < want; k++) {
      const i = pool.splice(Math.floor(Math.random() * pool.length), 1)[0];
      idle.delete(i);
      if (stale.has(i)) recut(i);
      const t = routes[i];
      lines[i].visible = true;
      lines[i].material.uniforms.u_width.value = Math.min(0.07, 1.0 / t.length);
      live.push({
        i,
        // small stagger so the group moves together without marching in lockstep
        head: -0.03 - k * 0.05,
        speed: (SPEED_MIN + Math.random() * (SPEED_MAX - SPEED_MIN)) / t.length,
        alpha: 0,
        phase: 'in',
      });
    }
  }

  /* ------------------------------------------------------------ resize -- */
  let lastCols = colsHalf;
  function resize() {
    const r = canvas.getBoundingClientRect();
    const W = Math.max(1, r.width), H = Math.max(1, r.height);
    renderer.setSize(W, H, false);
    const halfW = HALF_H * (W / H);
    camera.left = -halfW; camera.right = halfW;
    camera.top = HALF_H; camera.bottom = -HALF_H;
    camera.updateProjectionMatrix();

    measure();
    if (Math.abs(colsHalf - lastCols) >= 1) {
      lastCols = colsHalf;
      routes.forEach((_, i) => (idle.has(i) ? recut(i) : stale.add(i)));
    }
  }
  resize();
  addEventListener('resize', resize);

  /* ------------------------------------------------------------- input -- */
  let mx = 0, my = 0, tmx = 0, tmy = 0;
  addEventListener('pointermove', e => {
    tmx = e.clientX / innerWidth - 0.5;
    tmy = e.clientY / innerHeight - 0.5;
  }, { passive: true });

  let visible = true, onScreen = true;
  document.addEventListener('visibilitychange', () => { visible = !document.hidden; });
  new IntersectionObserver(([e]) => { onScreen = e.isIntersecting; }, { threshold: 0 })
    .observe(canvas);

  /* -------------------------------------------------------------- loop -- */
  let prev = performance.now();
  let burstDebt = 1;                     // one burst already arriving on load

  function frame(now) {
    requestAnimationFrame(frame);
    if (!visible || !onScreen) { prev = now; return; }

    const dt = Math.min(0.05, (now - prev) * 0.001);
    prev = now;

    const S = window.__fugoScroll || { y: 0 };
    uFade.value = Math.max(0, 1 - S.y / Math.max(1, innerHeight * 0.85));
    if (uFade.value <= 0.001) { renderer.clear(); return; }

    // parallax — small enough to feel like depth, not movement
    mx += (tmx - mx) * 0.04; my += (tmy - my) * 0.04;
    board.position.x = -mx * 2.2;
    board.position.y = my * 1.4;

    burstDebt += dt * BURST_RATE;
    while (burstDebt >= 1) { burstDebt -= 1; burst(); }

    for (let k = live.length - 1; k >= 0; k--) {
      const p = live[k];
      const u = lines[p.i].material.uniforms;
      p.head += p.speed * dt;
      // slow, even fade so the tail dissolves rather than blinking out
      p.alpha += ((p.phase === 'out' ? 0 : 1) - p.alpha) * (p.phase === 'out' ? 0.035 : 0.10);

      if (p.phase === 'in' && p.head >= 1) {
        p.phase = 'out';
        padBright[p.i] = 1;                        // the pulse lands
      }
      u.u_head.value = p.head;
      u.u_alpha.value = p.alpha;

      if (p.phase === 'out' && p.alpha < 0.015) {
        lines[p.i].visible = false;
        u.u_alpha.value = 0;
        idle.add(p.i);
        if (stale.has(p.i)) recut(p.i);
        live.splice(k, 1);
      }
    }

    // pads decay back to nothing
    let dirty = false;
    for (let i = 0; i < padBright.length; i++) {
      if (padBright[i] > 0.002) { padBright[i] *= 0.972; dirty = true; }
      else if (padBright[i] !== 0) { padBright[i] = 0; dirty = true; }
    }
    if (dirty) padBrightAttr.needsUpdate = true;

    renderer.render(scene, camera);
  }
  requestAnimationFrame(frame);
}
