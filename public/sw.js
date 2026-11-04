const CACHE_NAME = 'hulontalo-quran-v2';

const PRECACHE_URLS = [
  '/',
  '/mushaf',
  // '/juz',
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

  // 1. Deteksi apakah request ini adalah aset statis (CSS, JS, Gambar, Font, Audio MP3)
  const isStaticAsset = request.destination === 'style' || 
                        request.destination === 'script' || 
                        request.destination === 'image' || 
                        request.destination === 'font' || 
                        // request.destination === 'audio' || 
                        url.pathname.startsWith('/storage/'); 
                        // url.hostname.includes('fonts') || 
                        // url.hostname.includes('tailwind');

  // 2. Eksekusi Caching JIKA itu halaman baca (isReadablePath) ATAU aset statis
  if (isReadablePath(url.pathname) || isStaticAsset) {
    event.respondWith(
      caches.open(CACHE_NAME).then(async (cache) => {
        try {
          // Selalu coba ambil dari internet dulu (Network First)
          const networkResponse = await fetch(request);
          if (networkResponse && networkResponse.ok) {
            // Kalau berhasil, diam-diam simpan ke cache buat jaga-jaga kalau nanti offline
            cache.put(request, networkResponse.clone());
          }
          return networkResponse;
        } catch (error) {
          // KALAU OFFLINE: Cari file/halaman di dalam cache
          const cached = await cache.match(request);
          if (cached) return cached;

          // KALAU OFFLINE & TIDAK ADA DI CACHE: Kasih fallback (hanya untuk halaman web)
          if (request.mode === 'navigate' || isReadablePath(url.pathname)) {
            const fallback = await cache.match('/');
            if (fallback) return fallback;

            return new Response('Offline. Konten belum tersedia di cache.', {
              status: 503,
              headers: { 'Content-Type': 'text/plain; charset=utf-8' }
            });
          }
        }
      })
    );
  }
});