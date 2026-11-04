<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#047857">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<link rel="apple-touch-icon" href="{{ asset('icons/icon-192.png') }}">

<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('sw.js')
        .then((reg) => console.log('PWA SW registered', reg.scope))
        .catch((err) => console.log('SW failed', err));
    });
  }
</script>