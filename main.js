/* ---------- /main.js ---------------------------------------- */
(() => {
  /* ✅ ONE clean registration that works on desktop + Android */
  if ("serviceWorker" in navigator && location.protocol === "https:") {
    navigator.serviceWorker
      .register("/github/hrManagement/src/service-worker.js", {
        scope: "/github/hrManagement/src/",
      })
      .then((reg) => console.log("✅ SW registered →", reg.scope))
      .catch((err) => console.error("❌ SW registration failed:", err));
  }

  /* ---------- Optional install‑button logic ---------- */
  let deferredPrompt;
  const installBtn = document.getElementById("installPwaBtn");

  window.addEventListener("beforeinstallprompt", (e) => {
    e.preventDefault();
    deferredPrompt = e;
    installBtn?.classList.remove("d-none");
  });

  installBtn?.addEventListener("click", async () => {
    if (!deferredPrompt) return;
    deferredPrompt.prompt();
    await deferredPrompt.userChoice;
    deferredPrompt = null;
    installBtn.classList.add("d-none");
  });
})();
