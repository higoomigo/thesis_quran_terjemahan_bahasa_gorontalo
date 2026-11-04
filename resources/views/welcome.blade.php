{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Hulontalo Qur'an - Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Noto+Serif:wght@400;700&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    @include('partials.pwa')
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        slate: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        },
                        surface: {
                            DEFAULT: '#f9f9ff',
                            dark: '#1e293b'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Noto Serif', 'serif'],
                    }
                }
            }
        }
    </script>

    <!-- Add CSS ini di dalam <head> -->
    <style>
        #loading-screen {
            opacity: 1;
            visibility: visible;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        #loading-screen.hidden-loader {
            opacity: 0;
            visibility: hidden;
        }
    </style>
</head>

<body class="bg-surface text-slate-900 font-sans min-h-screen flex flex-col antialiased">

    <div id="loading-screen" class="fixed inset-0 z-[99999] flex flex-col items-center justify-center bg-[#f9f9ff]">
        <div class="relative flex items-center justify-center">
            <!-- Spinner Outer Ring -->
            <div class="w-16 h-16 border-4 border-emerald-200 border-t-emerald-900 rounded-full animate-spin"></div>
            <!-- Icon Al-Qur'an di Tengah -->
            
        </div>
        <!-- Teks Khas Bahasa Gorontalo / Indonesia -->
        <p class="mt-4 text-xs md:text-sm font-bold text-slate-600 tracking-wider uppercase animate-pulse">
            Sabaripo...
        </p>
    </div>

    <!-- TopNavBar -->
    @include('partials.navbar')

    <!-- Main Content Canvas -->
    <main class="flex-grow relative overflow-hidden">
        <!-- Hero Section -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 py-16 md:py-20 flex flex-col items-center text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 max-w-4xl mb-6 leading-tight">
                Matoduwolo ode <br> Qur'ani Tarjama Hulo-hulontalo
            </h1>
            <p class="text-slate-600 text-lg max-w-2xl mb-10 leading-relaxed">
                Todelomo mopolamahu wawu mopolayi'o Hulontalo
                <br>Toduwolo pohileyala huhama todelomo tarjama Qur'ani ode Hulontalo
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center w-full">
                <a href="{{ route('mushaf') ?? '#' }}" class="w-full sm:w-auto">
                    <button
                        class="w-full bg-emerald-900 text-white px-8 py-4 rounded-lg font-medium text-sm shadow-md hover:bg-emerald-800 transition-all active:scale-95 flex items-center justify-center">
                        <span class="material-symbols-outlined mr-2">import_contacts</span>
                        Mamongadi
                    </button>
                </a>

                <!-- PINTU MASUK FORUM (HERO) -->
                <a href="{{ route('forum.index') }}" class="w-full sm:w-auto">
                    <button
                        class="w-full bg-white border-2 border-emerald-900 text-emerald-950 px-8 py-3.5 rounded-lg font-bold text-sm hover:bg-emerald-50 transition-all active:scale-95 flex items-center justify-center">
                        <span class="material-symbols-outlined mr-2">forum</span>
                        Dulohupa
                    </button>
                </a>

                {{-- <a href="{{ route('login') ?? '#' }}" class="w-full sm:w-auto hidden md:block">
                    <button
                        class="w-full bg-emerald-100 text-emerald-950 px-6 py-4 rounded-lg font-medium text-sm hover:bg-emerald-200 transition-all active:scale-95 flex items-center justify-center">
                        <span class="material-symbols-outlined mr-2">login</span>
                        Validator
                    </button>
                </a> --}}
            </div>

            <!-- Hero Image/Visual -->
            <div
                class="mt-20 w-full max-w-5xl rounded-2xl overflow-hidden shadow-2xl border border-slate-200 relative aspect-video bg-slate-50">
                <img alt="Minimalist Qur'an visual" class="w-full h-full object-cover opacity-90"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuATf3LAftYlBoEBdaxFLtAdixAnZv3Pd1ewSBSKRbV49fUcaElTGv9Swhip_26mJbNy9U1Sk3jc9XQf7D8jhVnn2ltWb_heP5EvAnB4CVUQErfukeWE7wVcd7BtBfBKnWhS-U_pYSHudixFOPPybOkjxXzoM66rXPLFH94WTbKGQvAdCpv8a9CkWQm6MzB6woxlZqaSLZ6Tosu3bu0zZZ45u9hos5zot0e2txHvAeRw3ui_cxBkDU0QWUsnA2J6CL8Nx0nSv04oW7Zh" />
                <div class="absolute inset-0 bg-gradient-to-t from-surface/80 to-transparent"></div>
            </div>
        </section>

        <section class="relative z-10 border-y border-slate-200 bg-white py-8 md:py-10">
            <div class="max-w-7xl mx-auto px-6">
                <p
                    class="text-center text-xs md:text-sm font-bold text-slate-400 uppercase tracking-widest mb-8 md:mb-10">
                    Diproduksi atas Kerjasama
                </p>

                <div class="flex flex-wrap justify-center items-center gap-10 md:gap-16 lg:gap-24">


                    <div class="group flex items-center justify-center cursor-pointer"
                        title="Pemerintah Provinsi Gorontalo">
                        <img src="{{ asset('img/pemprov.png') }}" alt="Pemprov Gorontalo"
                            class="h-16 md:h-20 lg:h-24 object-contain  transition-all duration-300">
                    </div>

                    <div class="group flex items-center justify-center cursor-pointer" title="Majelis Ulama Indonesia">
                        <img src="{{ asset('img/mui.png') }}" alt="MUI"
                            class="h-16 md:h-20 lg:h-24 object-contain  transition-all duration-300">
                    </div>

                    <div class="group flex items-center justify-center cursor-pointer"
                        title="Universitas Negeri Gorontalo">
                        <img src="{{ asset('img/ung.png') }}" alt="UNG"
                            class="h-16 md:h-20 lg:h-24 object-contain  transition-all duration-300">
                    </div>

                    <div class="group flex items-center justify-center cursor-pointer" title="Kementerian Agama RI">
                        <img src="{{ asset('img/kemenag.png') }}" alt="Kementerian Agama RI"
                            class="h-16 md:h-20 lg:h-24 object-contain  transition-all duration-300">
                    </div>

                    <div class="group flex items-center justify-center cursor-pointer" title="IPQOH Gorontalo">
                        <img src="{{ asset('img/logo_ipqoh.png') }}" alt="IPQOH Gorontalo"
                            class="h-16 md:h-20 lg:h-24 object-contain  transition-all duration-300">
                    </div>

                    {{-- <div class="group flex items-center justify-center cursor-pointer"
                        title="Ikatan Persaudaraan Qari-Qariah dan Hafiz-Hafizah">
                        <div
                            class="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 rounded-full border-2 border-slate-300 bg-slate-50 group-hover:border-emerald-700 group-hover:bg-emerald-50 flex items-center justify-center text-center p-1 shadow-sm transition-all duration-300">
                            <span
                                class="text-[11px] md:text-[13px] lg:text-[15px] font-black text-slate-500 group-hover:text-emerald-800 leading-tight tracking-wider">
                                IPQOH<br>Gorontalo
                            </span>
                        </div>
                    </div> --}}

                </div>
            </div>
        </section>

        <!-- Features Bento Grid -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 py-12 md:py-24">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-semibold text-slate-900 mb-4">Dibuat untuk Kejelasan</h2>
                <p class="text-slate-600 max-w-2xl mx-auto">Menggabungkan kebijaksanaan kuno dengan prinsip desain
                    modern untuk pengalaman membaca yang tanpa gangguan.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1: Accurate Translation -->
                <div
                    class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:border-emerald-300 hover:shadow-md transition-all group col-span-1 md:col-span-2 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 opacity-5 group-hover:opacity-10 transition-opacity">
                        <span class="material-symbols-outlined text-[200px]">translate</span>
                    </div>
                    <div
                        class="w-12 h-12 bg-emerald-800 text-emerald-200 rounded-xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined">translate</span>
                    </div>
                    <h3 class="text-2xl font-semibold text-slate-900 mb-3">Terjemahan Akurat</h3>
                    <p class="text-slate-600 text-base max-w-md">
                        Diterjemahkan secara teliti ke dalam bahasa Gorontalo oleh para pakar terkemuka, memastikan
                        makna aslinya dipertahankan dan tetap dapat diakses oleh penutur asli.
                    </p>
                </div>
                <!-- Feature 2: Modern Reader -->
                <div
                    class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:border-emerald-300 hover:shadow-md transition-all group col-span-1">
                    <div
                        class="w-12 h-12 bg-orange-500 text-orange-950 rounded-xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined">devices</span>
                    </div>
                    <h3 class="text-2xl font-semibold text-slate-900 mb-3">Pembaca Modern</h3>
                    <p class="text-slate-600 text-base">
                        Antarmuka yang bersih dan bebas gangguan yang disesuaikan untuk layar digital, memprioritaskan
                        tipografi dan ruang putih.
                    </p>
                </div>
            </div>
        </section>

        <!-- ZONA BARU: Ruang Diskusi Terbuka (Menggantikan Stat Section) -->
        <section class="relative z-10 max-w-7xl mx-auto px-6 py-12">
            <div
                class="bg-emerald-900 text-white rounded-3xl p-8 md:p-12 overflow-hidden relative shadow-xl border border-emerald-800">
                <div class="absolute inset-0 opacity-10 pointer-events-none"
                    style="background-image: radial-gradient(circle at 4px 4px, white 2px, transparent 0); background-size: 40px 40px;">
                </div>

                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="max-w-2xl text-center md:text-left">
                        <div
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-800/50 text-emerald-200 font-bold text-xs mb-4 border border-emerald-700/50">
                            <span class="material-symbols-outlined text-[14px]">forum</span> FORUM DISKUSI
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Mari Berdiskusi & Berkontribusi</h2>
                        <p class="text-emerald-100 text-base md:text-lg leading-relaxed mb-6">
                            Punya pertanyaan tentang tata bahasa Gorontalo? Atau ingin mendiskusikan tafsir dan makna
                            sebuah ayat? Tuangkan pikiran Anda dan temukan wawasan baru bersama para pakar dan
                            masyarakat luas.
                        </p>

                        <!-- PINTU MASUK FORUM (BANNER) -->
                        <a href="{{ route('forum.index') }}" class="inline-flex">
                            <button
                                class="bg-white text-emerald-950 px-8 py-3.5 rounded-xl font-bold text-sm shadow-md hover:bg-emerald-50 transition-all active:scale-95 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">explore</span>
                                Eksplorasi Thread Terkini
                            </button>
                        </a>
                    </div>

                    <!-- Ilustrasi Dekoratif Forum -->
                    <div class="hidden lg:flex flex-col gap-3 w-72 opacity-90">
                        <div
                            class="bg-emerald-800/50 backdrop-blur-sm p-4 rounded-xl border border-emerald-700/50 transform rotate-2 translate-x-4">
                            <div class="flex gap-2 items-center mb-2">
                                <div class="w-6 h-6 rounded-full bg-emerald-600"></div>
                                <div class="h-2 w-20 bg-emerald-700 rounded-full"></div>
                            </div>
                            <div class="h-2 w-full bg-emerald-700/50 rounded-full mb-1"></div>
                            <div class="h-2 w-3/4 bg-emerald-700/50 rounded-full"></div>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-lg transform -rotate-2 -translate-x-2">
                            <div class="flex gap-2 items-center mb-2">
                                <div class="w-6 h-6 rounded-full bg-emerald-100"></div>
                                <div class="h-2 w-24 bg-slate-200 rounded-full"></div>
                            </div>
                            <div class="h-2 w-full bg-slate-100 rounded-full mb-1"></div>
                            <div class="h-2 w-4/5 bg-slate-100 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Methodology Section -->
        <section class="relative z-10 bg-slate-50 py-24 mt-12 border-y border-slate-200">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-semibold text-slate-900 mb-4">Metodologi yang Ketat</h2>
                    <p class="text-slate-600 max-w-2xl mx-auto">Proses validasi ganda yang ketat menjamin standar
                        akurasi dan keaslian tertinggi.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div
                        class="flex flex-col items-center text-center p-8 bg-white rounded-2xl shadow-sm border border-slate-200">
                        <div
                            class="w-16 h-16 bg-emerald-50 text-emerald-900 rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-3xl">spellcheck</span>
                        </div>
                        <h3 class="text-2xl font-semibold text-slate-900 mb-4">Validasi Linguistik</h3>
                        <p class="text-slate-600 text-base">
                            Ahli bahasa meninjau setiap terjemahan untuk memastikan kelancaran alami, tata bahasa yang
                            benar, dan resonansi budaya yang mendalam dalam konteks bahasa Gorontalo.
                        </p>
                    </div>
                    <div
                        class="flex flex-col items-center text-center p-8 bg-white rounded-2xl shadow-sm border border-slate-200">
                        <div
                            class="w-16 h-16 bg-emerald-950/10 text-emerald-950 rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-3xl">menu_book</span>
                        </div>
                        <h3 class="text-2xl font-semibold text-slate-900 mb-4">Validasi Teologis</h3>
                        <p class="text-slate-600 text-base">
                            Sarjana Islam memverifikasi terjemahan terhadap sumber-sumber Tafsir yang diakui,
                            melestarikan maksud ilahi dan integritas teologis dari bahasa Arab aslinya.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Comprehensive Footer -->
    @include('partials.footer')

    <!-- BottomNavBar (Mobile) -->
    {{-- <nav
        class="md:hidden fixed bottom-0 left-0 w-full flex justify-around items-center px-2 pb-6 pt-3 bg-white/95 backdrop-blur-md z-50 border-t border-slate-200 rounded-t-2xl shadow-[0_-4px_20px_rgba(0,0,0,0.06)]">
        <a class="flex flex-col items-center justify-center bg-emerald-100 text-emerald-800 rounded-xl px-4 py-2 active:scale-90 transition-transform duration-75"
            href="{{ route('mushaf') ?? '#' }}">
            <span class="material-symbols-outlined mb-1 text-xl"
                style="font-variation-settings: 'FILL' 1;">menu_book</span>
            <span class="text-[10px] font-semibold uppercase tracking-widest">Membaca</span>
        </a>

        <!-- PINTU MASUK FORUM (MOBILE NAV) -->
        <a class="flex flex-col items-center justify-center text-slate-500 py-2 hover:bg-emerald-50 hover:text-emerald-700 rounded-xl px-4 active:scale-90 transition-transform duration-75 relative"
            href="#">
            <div class="absolute top-2 right-4 w-2 h-2 bg-red-500 rounded-full border border-white"></div>
            <span class="material-symbols-outlined mb-1 text-xl">forum</span>
            <span class="text-[10px] font-semibold uppercase tracking-widest">Diskusi</span>
        </a>

        <a class="flex flex-col items-center justify-center text-slate-500 py-2 hover:bg-emerald-50 hover:text-emerald-700 rounded-xl px-4 active:scale-90 transition-transform duration-75"
            href="#">
            <span class="material-symbols-outlined mb-1 text-xl">bookmark</span>
            <span class="text-[10px] font-semibold uppercase tracking-widest">Disimpan</span>
        </a>

        <a class="flex flex-col items-center justify-center text-slate-500 py-2 hover:bg-emerald-50 hover:text-emerald-700 rounded-xl px-4 active:scale-90 transition-transform duration-75"
            href="#">
            <span class="material-symbols-outlined mb-1 text-xl">person</span>
            <span class="text-[10px] font-semibold uppercase tracking-widest">Profil</span>
        </a>
    </nav> --}}
    <div class="h-24 md:hidden"></div>

    <x-toaster />

    <script>
        window.addEventListener('load', function() {
            const loader = document.getElementById('loading-screen');
            if (loader) {
                // Tambahkan efek fade-out
                loader.classList.add('hidden-loader');

                // Hilangkan dari DOM total setelah transisi 400ms selesai
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 400);
            }
        });
    </script>

    {{-- Floating Install Bubble --}}
<div id="pwaInstallWrap" class="hidden fixed bottom-5 right-5 z-[9999]">
    <button id="btnInstallPwa"
        class="flex items-center gap-2 rounded-full bg-emerald-700 text-white shadow-lg px-4 py-3 hover:bg-emerald-800 transition"
        title="Install aplikasi">
        <span class="material-symbols-outlined text-[22px]">download</span>
        <span class="text-sm font-medium pr-1">Install App</span>
    </button>
</div>

{{-- Modal konfirmasi install --}}
<div id="pwaInstallModal"
     class="hidden fixed inset-0 z-[10000] bg-black/40 flex items-end sm:items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-sm p-5 shadow-xl">
        <div class="flex items-start gap-3">
            <img src="{{ asset('icons/icon-192.png') }}" alt="App Icon"
                 class="w-12 h-12 rounded-xl border border-gray-100">
            <div>
                <h3 class="text-base font-semibold text-gray-900">Install Qur'an Hulontalo</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Pasang aplikasi untuk akses lebih cepat ke landing page dan baca naskah Al-Qur'an terjemahan Gorontalo.
                </p>
            </div>
        </div>

        <div class="mt-5 flex gap-2 justify-end">
            <button id="pwaInstallCancel"
                class="px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition">
                Nanti saja
            </button>
            <button id="pwaInstallConfirm"
                class="px-4 py-2 rounded-lg text-sm bg-emerald-700 text-white hover:bg-emerald-800 transition">
                Install
            </button>
        </div>
    </div>
</div>

<script>
(() => {
    let deferredPrompt = null;

    const wrap = document.getElementById('pwaInstallWrap');
    const btn = document.getElementById('btnInstallPwa');
    const modal = document.getElementById('pwaInstallModal');
    const btnCancel = document.getElementById('pwaInstallCancel');
    const btnConfirm = document.getElementById('pwaInstallConfirm');

    function showBubble() {
        wrap?.classList.remove('hidden');
    }

    function hideBubble() {
        wrap?.classList.add('hidden');
    }

    function openModal() {
        modal?.classList.remove('hidden');
    }

    function closeModal() {
        modal?.classList.add('hidden');
    }

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        showBubble();
    });

    btn?.addEventListener('click', () => {
        if (!deferredPrompt) return;
        openModal();
    });

    btnCancel?.addEventListener('click', closeModal);

    btnConfirm?.addEventListener('click', async () => {
        if (!deferredPrompt) return;

        closeModal();
        deferredPrompt.prompt();

        const result = await deferredPrompt.userChoice;
        console.log('PWA install:', result.outcome);

        deferredPrompt = null;
        hideBubble();
    });

    window.addEventListener('appinstalled', () => {
        deferredPrompt = null;
        hideBubble();
        closeModal();
    });

    // klik luar modal = tutup
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
})();
</script>
</body>

</html>
