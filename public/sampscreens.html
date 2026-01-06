<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PL Chatlog Renderer (crop + SA:MP style)</title>
  <style>
    :root { --bg:#0b0e14; --card:#121827; --muted:#9aa4b2; --line:#263041; }
    body { margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial; background:var(--bg); color:#e6eaf2; }
    .wrap { max-width: 1200px; margin: 24px auto; padding: 0 16px; display:grid; grid-template-columns: 420px 1fr; gap:16px; }
    .card { background:var(--card); border:1px solid var(--line); border-radius:14px; padding:14px; }
    h1 { font-size:18px; margin:0 0 10px; }
    label { display:block; font-size:12px; color:var(--muted); margin:10px 0 6px; }
    textarea { width:100%; min-height:260px; resize:vertical; border-radius:12px; border:1px solid var(--line); background:#0e1320; color:#e6eaf2; padding:10px; outline:none; }
    input[type="text"], input[type="number"], select {
      width:100%; border-radius:12px; border:1px solid var(--line); background:#0e1320; color:#e6eaf2; padding:10px; outline:none;
    }
    input[type="range"]{ width:100%; }
    input[type="file"] { width:100%; }
    .row { display:grid; grid-template-columns: 1fr 1fr; gap:10px; }
    .btns { display:flex; gap:10px; flex-wrap:wrap; margin-top:12px; }
    button {
      border:1px solid var(--line); background:#0e1320; color:#e6eaf2; padding:10px 12px; border-radius:12px; cursor:pointer;
    }
    button.primary { background:#1a2a55; border-color:#304a9a; }
    button:hover { filter:brightness(1.08); }
    canvas { width:100%; height:auto; border-radius:14px; border:1px solid var(--line); background:#0a0f1a; }
    .hint { font-size:12px; color:var(--muted); margin-top:8px; line-height:1.35; }
    .small { font-size:12px; color:var(--muted); }
    .divider { height:1px; background:var(--line); margin:12px 0; }
    .mono { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card">
      <h1>PL Chatlog Renderer</h1>
      <div class="small">Offline • wybór okienka (crop) • prostokątne obramowania • eksport PNG</div>

      <label>1) Screenshot / tło</label>
      <input id="bgFile" type="file" accept="image/*"/>

      <div class="row">
        <div>
          <label>Szerokość exportu (px)</label>
          <input id="w" type="number" value="1920" min="320" max="6000"/>
        </div>
        <div>
          <label>Wysokość exportu (px)</label>
          <input id="h" type="number" value="1080" min="240" max="6000"/>
        </div>
      </div>

      <div class="divider"></div>

      <label>2) Okienko kadru (w % podglądu)</label>
      <div class="row">
        <div>
          <label>Szerokość okienka (%)</label>
          <input id="selW" type="range" min="10" max="100" value="55" step="1"/>
        </div>
        <div>
          <label>Wysokość okienka (%)</label>
          <input id="selH" type="range" min="10" max="100" value="55" step="1"/>
        </div>
      </div>
      <div class="hint">Przeciągnij prostokąt w podglądzie (po prawej), żeby wybrać kadr. Suwaki zmieniają jego rozmiar.</div>

      <div class="divider"></div>

      <div class="row">
        <div>
          <label>Rozmiar czcionki</label>
          <input id="fontSize" type="number" value="22" min="10" max="60"/>
        </div>
        <div>
          <label>Interlinia (px)</label>
          <input id="lineH" type="number" value="28" min="12" max="90"/>
        </div>
      </div>

      <div class="row">
        <div>
          <label>Maks. szerokość czatu (px)</label>
          <input id="chatW" type="number" value="520" min="200" max="5000"/>
        </div>
        <div>
          <label>Pozycja czatu</label>
          <select id="corner">
            <option value="top-left">lewy-górny</option>
            <option value="bottom-left">lewy-dolny</option>
            <option value="top-right">prawy-górny</option>
            <option value="bottom-right">prawy-dolny</option>
          </select>
        </div>
      </div>

      <label>Tło tekstu (prostokątne)</label>
      <div class="row">
        <div>
          <label>Tryb</label>
          <select id="textBgMode">
            <option value="per-line">osobny prostokąt na linię</option>
            <option value="single-block">jedna belka pod całość</option>
            <option value="off">wyłączone</option>
          </select>
        </div>
        <div>
          <label>Krycie (0–1)</label>
          <input id="textBgAlpha" type="number" min="0" max="1" step="0.05" value="0.75"/>
        </div>
      </div>

      <div class="divider"></div>

      <label>3) Chatlog</label>
      <textarea id="log" placeholder="Np.
Jack says: Tej
Jack shouts: HALO!
* Jack poprawia kurtkę
(( OOC )) test
"></textarea>

      <div class="btns">
        <button class="primary" id="renderBtn">Render</button>
        <button id="downloadBtn">Pobierz PNG</button>
        <button id="demoBtn">Wstaw demo</button>
      </div>

      <div class="hint mono" id="cropInfo"></div>
    </div>

    <div class="card">
      <div class="hint" style="margin-bottom:8px">
        Podgląd kadru: przeciągnij prostokąt (kanciak, jak na screenie).
      </div>
      <canvas id="preview" width="960" height="540"></canvas>

      <div class="hint" style="margin:12px 0 8px">
        Finalny render (export bierze wybrany kadr + czat):
      </div>
      <canvas id="c" width="1920" height="1080"></canvas>
    </div>
  </div>

<script>
  const el = (id) => document.getElementById(id);

  const canvas = el('c');
  const ctx = canvas.getContext('2d');

  const pCanvas = el('preview');
  const pCtx = pCanvas.getContext('2d');

  let bgImg = null;

  // Selection rect w układzie preview (w pikselach preview)
  const sel = { x: 140, y: 80, w: 520, h: 300 };

  // Drag state
  let isDragging = false;
  let dragOffX = 0;
  let dragOffY = 0;

  function clamp(n, a, b){ return Math.max(a, Math.min(b, n)); }

  function loadImage(src){
    return new Promise((res, rej) => {
      const img = new Image();
      img.onload = () => res(img);
      img.onerror = rej;
      img.src = src;
    });
  }

  // ---------- PL rules ----------
  function normalizeLine(line) {
    line = line.replace(/\r/g, '');

    const rules = [
      { re: /^(.*) says \[low\]: (.*)$/i, rep: '$1 mówi [cicho]: $2' },
      { re: /^(.*) says: (.*)$/i,       rep: '$1 mówi: $2' },
      { re: /^(.*) shouts: (.*)$/i,     rep: '$1 krzyczy: $2' },
      { re: /^(.*) whispers: (.*)$/i,   rep: '$1 szepcze: $2' },
      { re: /^(.*) asks: (.*)$/i,       rep: '$1 pyta: $2' },
      { re: /^\(\( OOC \)\)\s*(.*)$/i,  rep: '(( OOC )) $1' },
    ];
    for (const r of rules) {
      if (r.re.test(line)) return line.replace(r.re, r.rep);
    }
    return line;
  }

  function classify(line) {
    const l = line.toLowerCase();
    if (l.startsWith('(( ooc ))')) return { type:'ooc', color:'#b7c0cc' };
    if (l.startsWith('* '))         return { type:'me',  color:'#c5f7c5' };
    if (l.startsWith('[radio]'))    return { type:'radio', color:'#b8d7ff' };
    if (l.startsWith('system:'))    return { type:'sys', color:'#ffd7a6' };
    if (/\bkrzyczy:\b/i.test(line)) return { type:'shout', color:'#ffb4b4' };
    if (/\bszepcze:\b/i.test(line)) return { type:'whisper', color:'#d6c7ff' };
    return { type:'say', color:'#ffffff' };
  }

  // ---------- Canvas sizes ----------
  function setMainCanvasSize() {
    const W = clamp(parseInt(el('w').value || 1920), 320, 6000);
    const H = clamp(parseInt(el('h').value || 1080), 240, 6000);
    canvas.width = W;
    canvas.height = H;
  }

  // ---------- Preview drawing ----------
  // Rysuj obraz na preview jako "contain" (żeby widzieć całość), a selection jest w preview coords.
  function drawPreview() {
    const W = pCanvas.width, H = pCanvas.height;
    pCtx.clearRect(0, 0, W, H);

    // tło preview
    const g = pCtx.createLinearGradient(0, 0, W, H);
    g.addColorStop(0, '#0b1020');
    g.addColorStop(1, '#05070d');
    pCtx.fillStyle = g;
    pCtx.fillRect(0, 0, W, H);

    if (bgImg) {
      // contain
      const r = Math.min(W / bgImg.width, H / bgImg.height);
      const nw = bgImg.width * r;
      const nh = bgImg.height * r;
      const x = (W - nw) / 2;
      const y = (H - nh) / 2;
      pCtx.drawImage(bgImg, x, y, nw, nh);

      // delikatne przyciemnienie poza selekcją
      pCtx.save();
      pCtx.fillStyle = 'rgba(0,0,0,0.35)';
      // wszystko
      pCtx.fillRect(0,0,W,H);
      // wytnij selekcję (clear)
      pCtx.clearRect(sel.x, sel.y, sel.w, sel.h);
      // przywróć obraz w selekcji (żeby nie była pusta)
      pCtx.drawImage(bgImg, x, y, nw, nh);
      // wytnij tylko selekcję z obrazu
      pCtx.globalCompositeOperation = 'destination-in';
      pCtx.fillStyle = '#000';
      pCtx.fillRect(sel.x, sel.y, sel.w, sel.h);
      pCtx.restore();

      // ramka selekcji (kanciak)
      pCtx.save();
      pCtx.strokeStyle = '#4da3ff';
      pCtx.lineWidth = 2;
      pCtx.strokeRect(sel.x, sel.y, sel.w, sel.h);

      // uchwyty (kanciaki)
      const s = 8;
      const handles = getHandles();
      pCtx.fillStyle = '#4da3ff';
      for (const h of handles) {
        pCtx.fillRect(h.x - s/2, h.y - s/2, s, s);
      }
      pCtx.restore();

      // info
      updateCropInfo();
    } else {
      pCtx.save();
      pCtx.fillStyle = 'rgba(255,255,255,0.7)';
      pCtx.font = '14px system-ui, Arial';
      pCtx.fillText('Wgraj screenshot, żeby kadrować.', 16, 22);
      pCtx.restore();
    }
  }

  function getHandles() {
    // 4 narożniki
    return [
      { name:'tl', x: sel.x, y: sel.y },
      { name:'tr', x: sel.x + sel.w, y: sel.y },
      { name:'bl', x: sel.x, y: sel.y + sel.h },
      { name:'br', x: sel.x + sel.w, y: sel.y + sel.h },
    ];
  }

  function hitTestHandle(px, py) {
    const hs = 10;
    for (const h of getHandles()) {
      if (Math.abs(px - h.x) <= hs && Math.abs(py - h.y) <= hs) return h.name;
    }
    return null;
  }

  // Resize state
  let resizing = null; // 'tl'|'tr'|'bl'|'br'|null

  function previewMousePos(ev) {
    const rect = pCanvas.getBoundingClientRect();
    const x = (ev.clientX - rect.left) * (pCanvas.width / rect.width);
    const y = (ev.clientY - rect.top) * (pCanvas.height / rect.height);
    return { x, y };
  }

  pCanvas.addEventListener('mousedown', (ev) => {
    const {x,y} = previewMousePos(ev);
    if (!bgImg) return;

    const h = hitTestHandle(x,y);
    if (h) {
      resizing = h;
      isDragging = false;
      return;
    }

    // drag całego prostokąta
    if (x >= sel.x && x <= sel.x+sel.w && y >= sel.y && y <= sel.y+sel.h) {
      isDragging = true;
      dragOffX = x - sel.x;
      dragOffY = y - sel.y;
    }
  });

  window.addEventListener('mouseup', () => {
    isDragging = false;
    resizing = null;
  });

  window.addEventListener('mousemove', (ev) => {
    if (!bgImg) return;

    const {x,y} = previewMousePos(ev);

    if (resizing) {
      const minSize = 40;
      const maxW = pCanvas.width;
      const maxH = pCanvas.height;

      // zapamiętaj stare
      const ox = sel.x, oy = sel.y, ow = sel.w, oh = sel.h;

      if (resizing === 'tl') {
        const nx = clamp(x, 0, ox + ow - minSize);
        const ny = clamp(y, 0, oy + oh - minSize);
        sel.w = (ox + ow) - nx;
        sel.h = (oy + oh) - ny;
        sel.x = nx; sel.y = ny;
      } else if (resizing === 'tr') {
        const nx2 = clamp(x, ox + minSize, maxW);
        const ny = clamp(y, 0, oy + oh - minSize);
        sel.w = nx2 - ox;
        sel.h = (oy + oh) - ny;
        sel.y = ny;
      } else if (resizing === 'bl') {
        const nx = clamp(x, 0, ox + ow - minSize);
        const ny2 = clamp(y, oy + minSize, maxH);
        sel.w = (ox + ow) - nx;
        sel.h = ny2 - oy;
        sel.x = nx;
      } else if (resizing === 'br') {
        const nx2 = clamp(x, ox + minSize, maxW);
        const ny2 = clamp(y, oy + minSize, maxH);
        sel.w = nx2 - ox;
        sel.h = ny2 - oy;
      }

      // clamp do granic
      sel.x = clamp(sel.x, 0, pCanvas.width - sel.w);
      sel.y = clamp(sel.y, 0, pCanvas.height - sel.h);

      syncSlidersFromSel();
      drawPreview();
      render();
      return;
    }

    if (isDragging) {
      sel.x = clamp(x - dragOffX, 0, pCanvas.width - sel.w);
      sel.y = clamp(y - dragOffY, 0, pCanvas.height - sel.h);
      drawPreview();
      render();
      return;
    }
  });

  // ---------- Crop mapping preview->image ----------
  // Preview rysuje "contain" w prostokącie (x0,y0,nw,nh).
  // Selection jest w koordynatach preview, więc musimy przeliczyć na koordynaty obrazka.
  function computeContainRect() {
    const W = pCanvas.width, H = pCanvas.height;
    const r = Math.min(W / bgImg.width, H / bgImg.height);
    const nw = bgImg.width * r;
    const nh = bgImg.height * r;
    const x0 = (W - nw) / 2;
    const y0 = (H - nh) / 2;
    return { x0, y0, nw, nh, r };
  }

  function getCropInImageCoords() {
    // zwraca {sx,sy,sw,sh} w pikselach źródłowego obrazu
    const { x0, y0, nw, nh, r } = computeContainRect();

    // selection w preview coords -> w obrębie contain rect
    const relX = (sel.x - x0) / nw;
    const relY = (sel.y - y0) / nh;
    const relW = sel.w / nw;
    const relH = sel.h / nh;

    // clamp do [0..1] (gdy selekcja wyjechała poza obraz)
    const cx = clamp(relX, 0, 1);
    const cy = clamp(relY, 0, 1);
    const cw = clamp(relW, 0, 1 - cx);
    const ch = clamp(relH, 0, 1 - cy);

    const sx = Math.round(cx * bgImg.width);
    const sy = Math.round(cy * bgImg.height);
    const sw = Math.round(cw * bgImg.width);
    const sh = Math.round(ch * bgImg.height);

    // minimalne zabezpieczenie
    return {
      sx: clamp(sx, 0, bgImg.width-1),
      sy: clamp(sy, 0, bgImg.height-1),
      sw: clamp(sw, 1, bgImg.width),
      sh: clamp(sh, 1, bgImg.height)
    };
  }

  function updateCropInfo() {
    if (!bgImg) { el('cropInfo').textContent = ''; return; }
    const c = getCropInImageCoords();
    el('cropInfo').textContent = `Crop: sx=${c.sx}, sy=${c.sy}, sw=${c.sw}, sh=${c.sh} (z ${bgImg.width}x${bgImg.height})`;
  }

  // ---------- Text rendering ----------
  function wrapText(ctx, text, maxWidth) {
    const words = text.split(' ');
    const lines = [];
    let cur = '';

    for (const w of words) {
      const test = cur ? (cur + ' ' + w) : w;
      if (ctx.measureText(test).width <= maxWidth) {
        cur = test;
      } else {
        if (cur) lines.push(cur);

        if (ctx.measureText(w).width > maxWidth) {
          let chunk = '';
          for (const ch of w) {
            const t2 = chunk + ch;
            if (ctx.measureText(t2).width <= maxWidth) chunk = t2;
            else { lines.push(chunk); chunk = ch; }
          }
          cur = chunk;
        } else {
          cur = w;
        }
      }
    }
    if (cur) lines.push(cur);
    return lines;
  }

  // prostokątne tło pod tekst
  function drawTextBgRect(x, y, w, h, alpha) {
    ctx.save();
    ctx.fillStyle = `rgba(0,0,0,${alpha})`;
    ctx.fillRect(x, y, w, h); // <- kanciak
    ctx.restore();
  }

  function setChatPosition(W, H, boxW, boxH, corner) {
    const outerPad = 14;
    let x = outerPad, y = outerPad;

    if (corner === 'top-left') { x = outerPad; y = outerPad; }
    if (corner === 'top-right') { x = W - outerPad - boxW; y = outerPad; }
    if (corner === 'bottom-left') { x = outerPad; y = H - outerPad - boxH; }
    if (corner === 'bottom-right') { x = W - outerPad - boxW; y = H - outerPad - boxH; }

    return { x: clamp(x, 0, W - boxW), y: clamp(y, 0, H - boxH) };
  }

  // ---------- Main render ----------
  function render() {
    setMainCanvasSize();
    const W = canvas.width, H = canvas.height;

    ctx.clearRect(0, 0, W, H);

    // Tło: jeśli jest obraz, rysuj crop na cały canvas
    if (bgImg) {
      const { sx, sy, sw, sh } = getCropInImageCoords();
      ctx.drawImage(bgImg, sx, sy, sw, sh, 0, 0, W, H);
    } else {
      const g = ctx.createLinearGradient(0, 0, W, H);
      g.addColorStop(0, '#0b1020');
      g.addColorStop(1, '#05070d');
      ctx.fillStyle = g;
      ctx.fillRect(0, 0, W, H);
    }

    // Tekst
    const fontSize = clamp(parseInt(el('fontSize').value || 22), 10, 60);
    const lineH = clamp(parseInt(el('lineH').value || 28), 12, 90);
    const chatW = clamp(parseInt(el('chatW').value || 520), 200, W);
    const corner = el('corner').value;

    const textBgMode = el('textBgMode').value;
    const textBgAlpha = clamp(parseFloat(el('textBgAlpha').value || 0.75), 0, 1);

    ctx.font = `700 ${fontSize}px "Segoe UI", "Arial", sans-serif`;
    ctx.textBaseline = 'top';

    const raw = el('log').value.split('\n').map(s => s.trimEnd());
    const lines = raw.filter(l => l.trim().length > 0).map(normalizeLine);

    const wrapped = [];
    for (const line of lines) {
      const meta = classify(line);
      const pieces = wrapText(ctx, line, chatW);
      for (const p of pieces) wrapped.push({ text: p, meta });
    }

    const boxH = wrapped.length * lineH;
    const boxW = chatW;

    const pos = setChatPosition(W, H, boxW, boxH, corner);
    const x = pos.x;
    const y = pos.y;

    // tło single-block
    if (textBgMode === 'single-block') {
      const pad = 10;
      drawTextBgRect(x - pad, y - pad, boxW + pad*2, boxH + pad*2, textBgAlpha);
    }

    const linePadX = 10;
    const linePadY = 4;

    let yy = y;
    for (const row of wrapped) {
      if (textBgMode === 'per-line') {
        const textW = ctx.measureText(row.text).width;
        // jak na screenie: tło jest "na styk" pod tekst
        drawTextBgRect(
          x - linePadX,
          yy - linePadY,
          Math.min(boxW + linePadX*2, textW + linePadX*2),
          fontSize + linePadY*2,
          textBgAlpha
        );
      }

      // outline
      ctx.lineWidth = 4;
      ctx.strokeStyle = 'rgba(0,0,0,0.85)';
      ctx.strokeText(row.text, x, yy);

      // fill
      ctx.fillStyle = row.meta.color;
      ctx.fillText(row.text, x, yy);

      yy += lineH;
    }
  }

  function downloadPNG() {
    const a = document.createElement('a');
    a.download = 'chatlog_pl.png';
    a.href = canvas.toDataURL('image/png');
    a.click();
  }

  // ---------- Slider <-> selection sync ----------
  function applySlidersToSel() {
    const wPct = clamp(parseInt(el('selW').value || 55), 10, 100) / 100;
    const hPct = clamp(parseInt(el('selH').value || 55), 10, 100) / 100;

    const newW = Math.round(pCanvas.width * wPct);
    const newH = Math.round(pCanvas.height * hPct);

    // zachowaj środek
    const cx = sel.x + sel.w/2;
    const cy = sel.y + sel.h/2;

    sel.w = newW;
    sel.h = newH;

    sel.x = clamp(Math.round(cx - sel.w/2), 0, pCanvas.width - sel.w);
    sel.y = clamp(Math.round(cy - sel.h/2), 0, pCanvas.height - sel.h);
  }

  function syncSlidersFromSel() {
    const wPct = Math.round((sel.w / pCanvas.width) * 100);
    const hPct = Math.round((sel.h / pCanvas.height) * 100);
    el('selW').value = clamp(wPct, 10, 100);
    el('selH').value = clamp(hPct, 10, 100);
  }

  // ---------- UI wiring ----------
  el('bgFile').addEventListener('change', async (e) => {
    const file = e.target.files?.[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    bgImg = await loadImage(url);
    URL.revokeObjectURL(url);

    // ustaw selekcję na sensowny start (środek, ~55%)
    applySlidersToSel();
    drawPreview();
    render();
  });

  el('renderBtn').addEventListener('click', () => { drawPreview(); render(); });
  el('downloadBtn').addEventListener('click', downloadPNG);

  el('demoBtn').addEventListener('click', () => {
    el('log').value =
`Jack says: Hej
Jack shouts: HALO!
* Jack poprawia kurtkę i rozgląda się.
(( OOC )) test OOC`;
    drawPreview();
    render();
  });

  el('selW').addEventListener('input', () => { applySlidersToSel(); drawPreview(); render(); });
  el('selH').addEventListener('input', () => { applySlidersToSel(); drawPreview(); render(); });

  ['w','h','fontSize','lineH','chatW','corner','textBgMode','textBgAlpha','log'].forEach(id => {
    el(id).addEventListener('input', () => { drawPreview(); render(); });
  });

  // Start
  drawPreview();
  render();
</script>
</body>
</html>
