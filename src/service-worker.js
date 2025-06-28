/* ---------- /service-worker.js ------------------------------ */
const CACHE_NAME = 'pueri-cache-v1';
const urlsToCache = [
  './src/index.php',
  './main.js',
  './webApp/manifest.json',
  './webApp/images/icon-192x192.png',
  './webApp/images/icon-512x512.png'
];

/* Install */
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
          .then(cache => cache.addAll(urlsToCache))
          .then(() => self.skipWaiting())
  );
});

/* Activate */
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(
        keys.filter(k => k !== CACHE_NAME).map(caches.delete)
      )
    ).then(() => self.clients.claim())
  );
});

/* Fetch – network‑first, cache‑fallback */
self.addEventListener('fetch', event => {
  if (event.request.method !== 'GET') return;
  event.respondWith(
    fetch(event.request).catch(() => caches.match(event.request))
  );
});


