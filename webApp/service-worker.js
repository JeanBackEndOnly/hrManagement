const CACHE_NAME = 'my-web-app-cache-v1';
const urlsToCache = [
  '../src/index.php',
  'main.js',
  'images/icon-192x192.png',
  'images/icon-512x512.png',
  'manifest.json',
 
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      const cachePromises = urlsToCache.map(url => {
        console.log('Attempting to cache:', url);
        return fetch(url).then(response => {
          if (!response.ok) {
            throw new Error('Failed to fetch: ' + url);
          }
          return cache.add(url);
        });
      });
      return Promise.all(cachePromises);
    }).catch((error) => {
      console.error('Failed to cache resources:', error);
    })
  );
});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      console.log(response);
      return response || fetch(event.request);
    })
  );
});

if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('service-worker.js').then((registration) => {
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }, (error) => {
      console.log('ServiceWorker registration failed: ', error);
    });
  });
}
