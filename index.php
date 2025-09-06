<?php
// ==============================
// Realistic Update Simulator 95
// ==============================
// TUNE ME: default test settings (about 60s without interruptions)
$GAME_CONFIG = [
  'totalSeconds' => 60,              // baseline (no interruptions)
  'sizeMB'       => 600,             // payload size in MB (speed is derived to match totalSeconds)
  'entropy'      => 0.45,            // 0.0..1.0 (0=boring, 1=chaos)

  'popup' => [
    'minDelayMs' => 800,
    'maxDelayMs' => 42000,
    'critChanceOnPopup' => 0.06,
    'reasons' => [
  "Contacting update server in Greenland…",
  "Decrypting README.txt with 40-bit encryption…",
  "Waiting for your hard drive to spin up…",
  "Compacting registry hives into one giant mess…",
  "Re-enabling Internet Explorer because we said so…",
  "Renegotiating EULA terms you’ll never read…",
  "Checking your system clock against 1997…",
  "Re-compressing files into .CABs for nostalgia…",
  "Scanning for drivers on that one install CD…",
  "Re-mapping IRQ conflicts that never mattered…",
  "Buffering update through RealPlayer…",
  "Re-downloading the same patch you installed yesterday…",
  "Searching Yahoo! for installation instructions…",
  "Pausing for dramatic effect…",
  "Double-checking if Clippy approves…",
  "Running Disk Cleanup but leaving the temp files…",
  "Dialing Microsoft via fax to verify authenticity…",
  "Packing update into a .ZIP inside another .ZIP…",
  "Re-registering 4,532 DLLs you don’t use…",
  "Simulating BSOD to test user patience…"
],

  ],
  'lowSignal' => [
    'probPerSec' => 0.28,
    'durationMs' => [200, 19000],
    'slowdown'   => [0.02, 0.6],
  ],
  'tempOutage' => [
    'probPerSec' => 0.09,
    'durationMs' => [3000, 20000],
  ],
  'critical' => [
    'probPerSec' => 0.005,
    'codes' => ["0xDEAD","0xD00PA","0xBRVH","0xA55","0x5H133T","0x0AMN","0x1337"]
  ],
  'blocks' => 16,
  'bgColor' => '#0aaeaa',
];

// Build base URL for OG tags
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
$path   = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
$baseUrl = $scheme.'://'.$host.$path.'/';
$ogImage = $baseUrl.'og-image.png'; 
?><!doctype html>
<html lang="en"><
<head>
  <meta charset="utf-8">
  <title>Realistic Update Simulator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Primary Meta Tags -->
<title>Realistic Update Simulator 95</title>
<meta name="title" content="Realistic Update Simulator" />
<meta name="description" content="Experience authentic Windows-95-style update." />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website" />
<meta property="og:url" content="https://dev.szmelc.com/realistic-update-simulator/" />
<meta property="og:title" content="Realistic Update Simulator" />
<meta property="og:description" content="Experience authentic Windows-95-style update." />
<meta property="og:image" content="https://i.imgur.com/2syPYY4.png" />

<!-- X (Twitter) -->
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:url" content="https://dev.szmelc.com/realistic-update-simulator/" />
<meta property="twitter:title" content="Realistic Update Simulator" />
<meta property="twitter:description" content="Experience authentic Windows-95-style update." />
<meta property="twitter:image" content="https://i.imgur.com/2syPYY4.png" />

<!-- Meta Tags Generated with https://metatags.io -->

  <!-- Favicon (optional) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 128 128'%3E%3Crect width='128' height='128' fill='%23008080'/%3E%3Ctext x='50%25' y='55%25' dominant-baseline='middle' text-anchor='middle' font-family='monospace' font-size='56' fill='white'%3E95%3C/text%3E%3C/svg%3E">

  <!-- Bootstrap 4 + Win95 UI Kit -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@themesberg/windows-95-ui-kit@1.2.0/css/w95.css">
  <style>
    :root { --page-bg: <?= htmlspecialchars($GAME_CONFIG['bgColor'], ENT_QUOTES) ?>; }

    body {
      background: var(--page-bg);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      /* No global font override — back to defaults from the kit/browser */
    }
    .game-wrap { width: 95%; max-width: 720px; }
    .card { box-shadow: 0 0 0 2px #000 inset; }

button.btn,
button.btn .btn-text {
  border: 1px !important;
  box-shadow: none !important;
}

    .btn:disabled { filter: grayscale(0.2) brightness(0.95); opacity: 1; }
    .btn:active { box-shadow: inset 2px 2px 0 #808080; }

    /* Progress bar */
    .progress95 {
      width: 100%;
      max-width: 420px;
      height: 14px;
      border: 2px solid #000;
      border-radius: 2px;
      overflow: hidden;
      background: #c0c0c0;
      display: flex;
      align-items: stretch;
      margin: 8px 0 6px;
    }
    .progress95 .block {
      width: calc(100% / <?= (int)$GAME_CONFIG['blocks'] ?>);
      margin-right: 2px;
      background: #c0c0c0;
      border-right: 1px solid transparent;
      transition: background-color 0.2s linear;
    }
    .progress95 .block.filled { background: #0000a0; }

    .hud-line { font-size: 10px; line-height: 2; }
    .hud-line .label { font-weight: bold; }
    .muted { opacity: .9; }
    .hr95 { border-top: 2px solid #fff; border-bottom: 2px solid #808080; height: 0; margin: 8px 0; }
    .hidden { display: none!important; }

    /* Modal */
    .modal95-backdrop {
      position: fixed; inset: 0; background: rgba(0,0,0,.35);
      display: none; align-items: center; justify-content: center; z-index: 2000;
    }
    .modal95 {
      background: #c0c0c0; border: 2px solid #000; min-width: 320px; max-width: 520px;
      box-shadow: 6px 6px 0 #000;
    }
    .modal95 .header {
      background: #000080; color: #fff; padding: 6px 10px; font-weight: bold; display:flex;align-items:center;
    }
    .modal95.critical .header { background: #800000; }
    .modal95 .body { padding: 12px 12px 0; color: #000; white-space: pre-line; }
    .modal95 .footer { padding: 0 12px 12px; display:flex; gap:8px; justify-content:flex-end; }
    .modal95 .btn { min-width: 92px; }

    /* Title screen style */
    #titleWindow .title { font-size: 22px; font-weight: 700; letter-spacing: 0; }

    /* Center header content in Update Manager */
    #updateWindow .card-header {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    #updateWindow .card-header .icon { margin-right: 6px; }

    /* Corner mini-HUD (Current/Best) */
    .corner-hud {
      position: fixed;
      top: 8px;
      left: 8px;
      font-size: 12px;
      line-height: 2;
      color: #000;
      user-select: none;
      z-index: 3000;
    }
    .corner-hud .label { font-weight: 700; }
  </style>
</head>
<body>
  <!-- Corner HUD -->
<div class="corner-hud">
  <div>Current: <span id="hudCurrent" class="label">1</span></div>
  <div>Best: <span id="hudBest" class="label">1</span></div>
</div>


  <div class="game-wrap">
    <!-- Title Screen -->
    <div class="col-12" id="titleWindow">
      <div class="card card-tertiary">
        <div class="card-header d-flex align-items-center">
          <span class="icon icon-xs w95-window"></span>
          <span class="ml-4">Welcome</span>
        </div>
        <div class="card-body">
          <p class="title mb-2">Realistic Update Simulator</p>
          <p class="mb-3">Press <b>Start</b> to proceed.</p>
          <div class="d-flex mt-2">
            <button class="btn btn-sm mr-2" id="startBtn" type="button"><span class="btn-text">Start</span></button>
          </div>
        </div>
      </div>
    </div>

    <!-- Update Manager Window -->
    <div class="col-12 hidden" id="updateWindowWrap">
      <div class="card card-tertiary" id="updateWindow">
        <div class="card-header">
          <span class="icon icon-xs w95-folder"></span>
          <span class="header-title">Update Manager</span>
        </div>
        <div class="card-body" id="cardBody">
          <p class="card-text" id="statusText">Would you like to download new update?</p>
          <div class="d-flex mt-3" id="buttonRow">
            <button class="btn btn-sm mr-2" id="okBtn" type="button"><span class="btn-text">OK</span></button>
            <button class="btn btn-sm" id="cancelBtn" type="button"><span class="btn-text">Cancel</span></button>
          </div>

          <!-- Progress + HUD-->
          <div id="dlWrap" class="hidden">
            <div class="progress95" id="w95bar"></div>
            <div class="hud-line"><span class="label">Progress:</span>
              <span id="percent">0%</span> — <span id="downloaded">0.00</span>/<span id="size"><?= (int)$GAME_CONFIG['sizeMB'] ?></span> MB
            </div>
            <div class="hud-line"><span class="label">Speed:</span> <span id="speed">0.00</span> MB/s
              <span class="muted">(<span id="netState">stable</span>)</span>
            </div>
            <div class="hud-line"><span class="label">Elapsed:</span> <span id="elapsed">00:00</span>
              — <span class="label">ETA:</span> <span id="eta">--:--</span>
            </div>
            <div class="hr95"></div>
            <div class="d-flex mt-2">
              <button class="btn btn-sm mr-2" id="pauseBtn" type="button"><span class="btn-text">Pause</span></button>
              <button class="btn btn-sm" id="resumeBtn" type="button" disabled><span class="btn-text">Resume</span></button>
              <button class="btn btn-sm ml-auto" id="rageQuitBtn" type="button"><span class="btn-text">Abort</span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Win95-style modal -->
  <div class="modal95-backdrop" id="modalBg">
    <div class="modal95" id="modalBox" role="dialog" aria-modal="true">
      <div class="header">
        <span class="icon icon-xs w95-window-empty"></span>
        <span id="modalTitle">System Notice</span>
      </div>
      <div class="body"><p id="modalMsg">Something happened.</p></div>
      <div class="footer">
        <button class="btn btn-sm" id="modalConfirm"><span class="btn-text">Continue</span></button>
      </div>
    </div>
  </div>

  <!-- Dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@themesberg/windows-95-ui-kit@1.2.0/js/w95.js"></script>
  <script>
    const GAME_CONFIG = <?= json_encode($GAME_CONFIG, JSON_UNESCAPED_SLASHES) ?>;
    const $ = (sel, root=document) => root.querySelector(sel);
    const fmt2 = n => n.toFixed(2);
    const clamp = (v, a, b) => Math.max(a, Math.min(b, v));
    const rand = (a, b) => a + Math.random() * (b - a);
    const choice = arr => arr[(Math.random()*arr.length)|0];
    const nowMs = () => performance.now();
    const fmtTime = s => { s = Math.max(0, Math.round(s)); const m = String((s/60|0)).padStart(2,'0'); const ss = String(s%60).padStart(2,'0'); return `${m}:${ss}`; };

    // WebAudio beeps
    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    function beep(freq=880, durMs=120, type='square', gain=0.06) {
      const o = audioCtx.createOscillator(); const g = audioCtx.createGain();
      o.type = type; o.frequency.value = freq; g.gain.value = gain;
      o.connect(g).connect(audioCtx.destination); o.start(); setTimeout(()=>o.stop(), durMs);
    }
    function errBeep() { beep(110, 180, 'square', 0.08); setTimeout(()=>beep(90, 220,'square',0.1), 200); }

    // DOM references
    const titleWindow = $("#titleWindow");
    const startBtn = $("#startBtn");

    const updateWindowWrap = $("#updateWindowWrap");
    const statusText = $("#statusText");
    const okBtn = $("#okBtn");
    const cancelBtn = $("#cancelBtn");
    const buttonRow = $("#buttonRow");
    const dlWrap = $("#dlWrap");
    const w95bar = $("#w95bar");
    const percent = $("#percent");
    const downloaded = $("#downloaded");
    const sizeEl = $("#size");
    const speedEl = $("#speed");
    const elapsedEl = $("#elapsed");
    const etaEl = $("#eta");
    const netStateEl = $("#netState");
    const pauseBtn = $("#pauseBtn");
    const resumeBtn = $("#resumeBtn");
    const rageQuitBtn = $("#rageQuitBtn");

    const modalBg = $("#modalBg");
    const modalBox = $("#modalBox");
    const modalTitle = $("#modalTitle");
    const modalMsg = $("#modalMsg");
    const modalConfirm = $("#modalConfirm");

    const hudCurrent = $("#hudCurrent");
    const hudBest = $("#hudBest");

    // Build blocky progress bar
    const BLOCKS = Math.max(8, Math.min(64, GAME_CONFIG.blocks|0));
    for (let i=0;i%BLOCKS;i++){} // placeholder
    for (let i=0;i<BLOCKS;i++) {
      const b = document.createElement('div'); b.className = 'block'; w95bar.appendChild(b);
    }
    const blocks = [...w95bar.children];

    // ====== LEVEL / PROGRESSION ======
    const LEVEL_BASE_SECONDS = 10;   // level 1 = 10s
    const LEVEL_BASE_MB      = 100;  // level 1 = 100MB
    let level = 1;
    let bestLevel = Math.max(1, parseInt(localStorage.getItem('rus95_best') || '1', 10));
    hudCurrent.textContent = level;
    hudBest.textContent = bestLevel;

    function levelSeconds(lvl){ return LEVEL_BASE_SECONDS * Math.pow(2, lvl-1); }
    function levelSizeMB(lvl){ return LEVEL_BASE_MB * Math.pow(2, lvl-1); }

    // Game state
    let totalSizeMB = GAME_CONFIG.sizeMB;       // will be overwritten by level params
    let speedBaseMBps = (GAME_CONFIG.sizeMB / Math.max(1,GAME_CONFIG.totalSeconds)); // overwritten too

    let started=false, paused=false, done=false;
    let downloadedMB = 0;
    let t0=0, lastTick=0, pausedAccum=0, pauseStart=0;
    let lowSignalUntil=0, outageUntil=0;
    let popupTimer=null;

    // For 2 Hz HUD update
    let uiTimer = null;
    let lastUiMB = 0;
    let lastUiT = 0;

    function applyLevel(lvl) {
      level = Math.max(1, lvl|0);
      totalSizeMB = levelSizeMB(level);
      const seconds = levelSeconds(level);
      speedBaseMBps = totalSizeMB / seconds;

      // Reset per-run numbers
      downloadedMB = 0;
      t0 = lastTick = nowMs();
      pausedAccum = 0;
      lowSignalUntil = 0;
      outageUntil = 0;

      // Reflect size in HUD
      sizeEl.textContent = String(totalSizeMB);

      // Corner HUD
      hudCurrent.textContent = level;
      hudBest.textContent = bestLevel;

      // Reset progress bar fill
      blocks.forEach(b => b.classList.remove('filled'));
      percent.textContent = "0%";
      downloaded.textContent = "0.00";
      speedEl.textContent = "0.00";
      elapsedEl.textContent = "00:00";
      etaEl.textContent = "--:--";
      netStateEl.textContent = "stable";
    }

    function setPaused(p) {
      if (paused === p) return;
      paused = p;
      pauseBtn.disabled = p;
      resumeBtn.disabled = !p;
      if (p) { pauseStart = nowMs(); }
      else   { pausedAccum += (nowMs() - pauseStart); }
    }

    function showModal(title, msg, {critical=false, button="Continue", onClose=null}={}) {
      modalTitle.textContent = title;
      modalMsg.textContent = msg;
      modalBox.classList.toggle('critical', !!critical);
      $("#modalConfirm .btn-text").textContent = button;
      modalBg.style.display = 'flex';
      if (critical) errBeep(); else beep(880, 120);
      const handler = () => {
        modalBg.style.display = 'none';
        modalConfirm.removeEventListener('click', handler);
        if (onClose) onClose();
      };
      modalConfirm.addEventListener('click', handler);
    }

    function scheduleNextPopup() {
      const { minDelayMs, maxDelayMs, reasons, critChanceOnPopup } = GAME_CONFIG.popup;
      const delay = rand(minDelayMs, maxDelayMs);
      popupTimer = setTimeout(() => {
        if (Math.random() < critChanceOnPopup) return triggerCritical("0xA55");
        setPaused(true);
        showModal("System Notice", choice(reasons), {
          onClose: () => { setPaused(false); scheduleNextPopup(); }
        });
      }, delay);
    }

function triggerCritical(code=null) {
  setPaused(true);
  if (popupTimer) { clearTimeout(popupTimer); popupTimer = null; }
  const c = code || choice(GAME_CONFIG.critical.codes);

  showModal("CRITICAL ERROR", `A serious error occurred: ${c}\nReturning to Level 1.`, {
    critical: true,
    button: "Restart",
    onClose: () => {
      // hard reset to Level 1 and restart
      applyLevel(1);
      statusText.textContent = "Downloading new update, please wait";
      buttonRow.classList.add('hidden');
      dlWrap.classList.remove('hidden');

      started = true;
      done = false;
      paused = false;
      pausedAccum = 0;

      scheduleNextPopup();
      loop();
    }
  });
}


    function maybeEnterLowSignal(dtSec) {
      if (nowMs() < lowSignalUntil) return;
      const p = GAME_CONFIG.lowSignal.probPerSec * dtSec * (0.5 + GAME_CONFIG.entropy);
      if (Math.random() < p) {
        const dur = rand(...GAME_CONFIG.lowSignal.durationMs);
        lowSignalUntil = nowMs() + dur;
      }
    }
    function maybeEnterOutage(dtSec) {
      if (nowMs() < outageUntil) return;
      const p = GAME_CONFIG.tempOutage.probPerSec * dtSec * (0.5 + GAME_CONFIG.entropy);
      if (Math.random() < p) {
        const dur = rand(...GAME_CONFIG.tempOutage.durationMs);
        outageUntil = nowMs() + dur;
      }
    }
    function maybeCritical(dtSec) {
      const p = GAME_CONFIG.critical.probPerSec * dtSec * (0.5 + GAME_CONFIG.entropy);
      if (Math.random() < p) triggerCritical();
    }

    function updateHUD(avgSpeed, elapsed, eta) {
      percent.textContent = `${Math.floor((downloadedMB / totalSizeMB) * 100)}%`;
      downloaded.textContent = fmt2(downloadedMB);
      speedEl.textContent = fmt2(avgSpeed);
      elapsedEl.textContent = fmtTime(elapsed);
      etaEl.textContent = (eta === Infinity ? "--:--" : fmtTime(eta));
      let state = "stable";
      if (nowMs() < outageUntil) state = "connection lost";
      else if (nowMs() < lowSignalUntil) state = "low signal";
      netStateEl.textContent = state;

      const filled = Math.round((downloadedMB / totalSizeMB) * BLOCKS);
      blocks.forEach((b,i)=> b.classList.toggle('filled', i < filled));
    }

    function startDownload() {
      statusText.textContent = "Downloading new update, please wait";
      buttonRow.classList.add('hidden');
      dlWrap.classList.remove('hidden');
      t0 = lastTick = nowMs();
      lastUiT = t0;
      lastUiMB = 0;
      started = true; done = false; paused = false; pausedAccum = 0; popupTimer && clearTimeout(popupTimer);
      scheduleNextPopup();
      loop();
      startUiTicker();
    }

    function loop() {
      if (!started || done) return;
      const t = nowMs(), dt = t - lastTick; lastTick = t;

      if (!paused) {
        const dtSec = dt/1000;
        maybeEnterLowSignal(dtSec);
        maybeEnterOutage(dtSec);
        maybeCritical(dtSec);
      }

      let speed = 0;
      if (!paused) {
        const jitter = 1 + (Math.random() * 2 - 1) * (0.25 * GAME_CONFIG.entropy);
        speed = (speedBaseMBps) * jitter;                   
        if (t < lowSignalUntil) speed *= rand(...GAME_CONFIG.lowSignal.slowdown);
        if (t < outageUntil) speed = 0;
        downloadedMB = clamp(downloadedMB + speed * (dt/1000), 0, totalSizeMB);
      }

      if (downloadedMB >= totalSizeMB) {
  done = true;
  popupTimer && clearTimeout(popupTimer);
  beep(1200, 200);
  setTimeout(() => beep(1500, 200), 220);
  setTimeout(() => beep(1800, 220), 450);

  // Update best level
  if (level > bestLevel) {
    bestLevel = level;
    localStorage.setItem('rus95_best', String(bestLevel));
    hudBest.textContent = bestLevel;
  }

  showModal("Update Complete", `Level ${level} complete.\nProceeding to the next update.`, {
    button: "Continue",
    onClose: () => {
      // go to next level
      applyLevel(level + 1);

      // change status text to reflect the level number
      statusText.textContent = `Downloading ${level} update, please wait`;

      buttonRow.classList.add('hidden');
      dlWrap.classList.remove('hidden');

      started = true;
      done = false;
      paused = false;
      pausedAccum = 0;

      scheduleNextPopup();
      loop();
    }
  });

  pauseBtn.disabled = true;
  resumeBtn.disabled = true;
  return;
}

      requestAnimationFrame(loop);
    }

    function startUiTicker() {
      if (uiTimer) clearInterval(uiTimer);
      uiTimer = setInterval(() => {
        const t = nowMs();
        const dtSec = Math.max(0.001, (t - lastUiT) / 1000);
        const deltaMB = Math.max(0, downloadedMB - lastUiMB);
        const avgSpeed = deltaMB / dtSec;

        const elapsed = ((t - t0) - pausedAccum) / 1000;
        const remaining = Math.max(0, totalSizeMB - downloadedMB);
        const eta = (avgSpeed > 0) ? remaining / avgSpeed : Infinity;

        updateHUD(avgSpeed, elapsed, eta);

        lastUiT = t;
        lastUiMB = downloadedMB;
      }, 500); // 2 Hz
    }

    // Event wiring
    startBtn.addEventListener('click', () => {
      beep(880,120);
      titleWindow.classList.add('hidden');
      updateWindowWrap.classList.remove('hidden');
    });

    okBtn.addEventListener('click', () => {
      // Begin at Level 1: 10s / 100MB
      applyLevel(1);
      pauseBtn.disabled = false;
      resumeBtn.disabled = true;
      startDownload();
    });

    cancelBtn.addEventListener('click', () => { $("#updateWindow").classList.add('hidden'); beep(500,100); });
    pauseBtn.addEventListener('click', () => setPaused(true));
    resumeBtn.addEventListener('click', () => { setPaused(false); beep(900,100); });
    rageQuitBtn.addEventListener('click', () => {
      errBeep();
      showModal("Abort Update?", "This will stop the process and close the window.", {
        button: "OK",
        onClose: () => { $("#updateWindow").classList.add('hidden'); }
      });
    });
  </script>
</body>
</html>
