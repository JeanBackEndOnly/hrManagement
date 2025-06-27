/*  /github/hrManagement/service-worker.js  */
const CACHE_NAME = 'pueri-cache-v1';

const urlsToCache = [
  '/github/hrManagement/src/index.php',
  '/github/hrManagement/main.js',
  '/github/hrManagement/webApp/images/icon-192x192.png',
  '/github/hrManagement/webApp/images/icon-512x512.png',
  '/github/hrManagement/webApp/manifest.json'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
    ).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request).then(resp => resp || fetch(event.request))
  );
});
