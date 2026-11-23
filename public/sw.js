const CACHE_NAME = 'hulontalo-quran-v6'; // Naikkin versi biar browser maksa update

const PRECACHE_URLS = [
  '/',
  '/mushaf',
  '/manifest.json',
  '/icons/icon-192.png',
  '/icons/icon-512.png'
];

function isReadablePath(pathname) {
  return (
    pathname === '/' ||
    pathname.startsWith('/mushaf') ||
    pathname.startsWith('/surah') ||
    pathname.startsWith('/juz')
  );
}

function isExcludedPath(pathname) {
  return (
    pathname.startsWith('/admin') ||
    pathname.startsWith('/editor') ||
    pathname.startsWith('/login') ||
    pathname.startsWith('/register') ||
    pathname.startsWith('/dashboard') ||
    pathname.startsWith('/profile') ||
    pathname.startsWith('/forum') ||
    pathname.startsWith('/livewire') ||
    pathname.startsWith('/api')
  );
}

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(PRECACHE_URLS))
  );
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key)))
    )
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  const request = event.request;
  const url = new URL(request.url);

  // Abaikan request selain GET (misal POST form) dan route backend/admin
  if (request.method !== 'GET') return;
  if (isExcludedPath(url.pathname)) return;

  // Deteksi aset statis (CSS, JS, Gambar, Font, Audio MP3)
  const isStaticAsset = request.destination === 'style' || 
                        request.destination === 'script' || 
                        request.destination === 'image' || 
                        request.destination === 'font' || 
                        request.destination === 'audio' || 
                        // url.pathname.startsWith('/storage/') || 
                        url.pathname.startsWith('/js/') || 
                        url.hostname.includes('fonts') || 
                        url.hostname.includes('tailwind');

  if (isReadablePath(url.pathname) || isStaticAsset) {
    event.respondWith(
      caches.open(CACHE_NAME).then(async (cache) => {
        try {
          // 1. Coba ambil dari internet dulu
          const networkResponse = await fetch(request);
          if (networkResponse && networkResponse.ok) {
            cache.put(request, networkResponse.clone());
          }
          return networkResponse; // Wajib kembalikan response
        } catch (error) {
          // 2. KALAU OFFLINE/GAGAL: Cari di cache
          const cached = await cache.match(request, { ignoreSearch: true });
          if (cached) return cached;

          // 3. KALAU NGGAK ADA DI CACHE: Kasih halaman fallback khusus untuk HTML
          if (request.mode === 'navigate' || isReadablePath(url.pathname)) {
            const fallback = await cache.match('/', { ignoreSearch: true });
            if (fallback) return fallback;

            return new Response('Offline. Konten belum tersedia di cache.', {
              status: 503,
              headers: { 'Content-Type': 'text/plain; charset=utf-8' }
            });
          }

          // 4. Kalau aset statis (JS/CSS/Font) gagal di-load saat offline
          // Kembalikan Response kosong (status 404) agar tidak error 'undefined'
          return new Response('', { 
              status: 404, 
              statusText: 'Asset Not Found Offline' 
          });
        }
      })
    );
  }
});