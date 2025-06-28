/* ---------- /service-worker.js ------------------------------- */
/* Cache version – bump when you change file names */
const CACHE_NAME = 'pueri-cache-v1';

/* Pre‑cache the key app shell files */
const urlsToCache = [
  './src/index.php',
  './main.js',
  './webApp/manifest.json',
  './webApp/images/icon-192x192.png',
  './webApp/images/icon-512x512.png'
];

/* INSTALL – add files to cache */
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
      .then(() => self.skipWaiting())
  );
});

/* ACTIVATE – clear old caches */
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(
        keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k))
      )
    ).then(() => self.clients.claim())
  );
});

/* FETCH – network‑first fallback‑to‑cache */
self.addEventListener('fetch', event => {
  if (event.request.method !== 'GET') return; // ignore POST/PUT
  event.respondWith(
    fetch(event.request)
      .then(response => response)
      .catch(() => caches.match(event.request))
  );
});
