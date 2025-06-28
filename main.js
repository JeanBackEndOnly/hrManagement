/* ---------- /main.js ---------------------------------------- */
(() => {
  /* Register service worker (one level up from /src/) */
 
// ✅ Final working version for index.php inside src/
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('./service-worker.js')
      .then(reg => console.log('✅ SW registered ➜', reg.scope))
      .catch(err => console.error('❌ SW registration failed:', err));
  });
}



  /* Handle beforeinstallprompt (optional install button) */
  let deferredPrompt;
  const installBtn = document.getElementById('installPwaBtn');

  window.addEventListener('beforeinstallprompt', e => {
    e.preventDefault();
    deferredPrompt = e;
    installBtn?.classList.remove('d-none');
  });

  installBtn?.addEventListener('click', async () => {
    if (!deferredPrompt) return;
    deferredPrompt.prompt();
    await deferredPrompt.userChoice;
    deferredPrompt = null;
    installBtn.classList.add('d-none');
  });
})();
