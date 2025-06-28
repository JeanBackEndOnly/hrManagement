/* ---------- /main.js ----------------------------------------- */
(() => {
  /* 1) Register the Service Worker */
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker
      .register('/service-worker.js', { scope: '/' })   // controls entire site
      .then(reg => console.log('✅ SW registered ➜', reg.scope))
      .catch(err => console.error('❌ SW registration failed ➜', err));
  }

  /* 2) Optional "Add to Home Screen" prompt */
  let deferredPrompt;
  const installBtn = document.getElementById('installPwaBtn');

  window.addEventListener('beforeinstallprompt', e => {
    e.preventDefault();
    deferredPrompt = e;
    if (installBtn) installBtn.style.display = 'block';
  });

  if (installBtn) {
    installBtn.addEventListener('click', async () => {
      if (!deferredPrompt) return;
      deferredPrompt.prompt();
      const { outcome } = await deferredPrompt.userChoice;
      console.log('A2HS outcome ➜', outcome);
      deferredPrompt = null;
      installBtn.style.display = 'none';
    });
  }

  /* 3) Place any page‑specific JS below … */
})();
