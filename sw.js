const CACHE_NAME = 'ordenes-cache-v1';
const urlsToCache = [
  '/',
  '/style.css',
  '/orden_trabajo.html',
  '/panel_operario.php',
  '/panel_supervisor.php'
];
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(urlsToCache);
    })
  );
});
self.addEventListener('fetch', event => {
  event.respondWith(
    fetch(event.request).catch(() =>
      caches.match(event.request)
    )
  );
});
