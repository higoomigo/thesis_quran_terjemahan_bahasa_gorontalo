<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Qur'an Gorontalo - Mushaf</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Noto+Serif:wght@400&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed": "#a6f2d1",
                        "surface": "#f9f9ff",
                        "on-tertiary-container": "#a8d0bc",
                        "on-secondary-fixed": "#331200",
                        "tertiary": "#1e4334",
                        "surface-bright": "#f9f9ff",
                        "secondary-container": "#fd8a42",
                        "error": "#ba1a1a",
                        "tertiary-container": "#365a4a",
                        "surface-tint": "#1b6b51",
                        "on-tertiary-fixed": "#002115",
                        "primary-fixed-dim": "#8bd6b6",
                        "on-primary-fixed": "#002116",
                        "inverse-surface": "#2a313d",
                        "on-primary-container": "#8bd6b7",
                        "on-background": "#151c27",
                        "background": "#f9f9ff",
                        "tertiary-fixed-dim": "#a8cfbc",
                        "secondary": "#9b4500",
                        "on-primary": "#ffffff",
                        "surface-container-low": "#f0f3ff",
                        "inverse-primary": "#8bd6b6",
                        "on-secondary-container": "#682c00",
                        "on-surface": "#151c27",
                        "primary-container": "#065f46",
                        "on-tertiary": "#ffffff",
                        "error-container": "#ffdad6",
                        "surface-container-lowest": "#ffffff",
                        "on-surface-variant": "#3f4944",
                        "primary": "#004532",
                        "surface-container-high": "#e2e8f8",
                        "secondary-fixed": "#ffdbca",
                        "on-error-container": "#93000a",
                        "surface-container-highest": "#dce2f3",
                        "on-secondary-fixed-variant": "#763300",
                        "outline": "#6f7973",
                        "on-primary-fixed-variant": "#00513b",
                        "on-secondary": "#ffffff",
                        "on-error": "#ffffff",
                        "tertiary-fixed": "#c3ecd7",
                        "surface-dim": "#d3daea",
                        "surface-container": "#e7eefe",
                        "inverse-on-surface": "#ebf1ff",
                        "outline-variant": "#bec9c2",
                        "surface-variant": "#dce2f3",
                        "secondary-fixed-dim": "#ffb68e",
                        "on-tertiary-fixed-variant": "#294e3f"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "md": "1rem",
                        "gutter": "1.5rem",
                        "lg": "1.5rem",
                        "xl": "2.5rem",
                        "xs": "0.25rem",
                        "container-max": "1200px",
                        "sm": "0.5rem",
                        "unit": "4px"
                    },
                    "fontFamily": {
                        "label-md": ["Inter"],
                        "caption": ["Inter"],
                        "headline-lg": ["Inter"],
                        "headline-xl": ["Inter"],
                        "body-reading-translation": ["Inter"],
                        "body-reading-arabic": ["Noto Serif"]
                    },
                    "fontSize": {
                        "label-md": ["14px", {
                            "lineHeight": "1.4",
                            "letterSpacing": "0.02em",
                            "fontWeight": "500"
                        }],
                        "caption": ["12px", {
                            "lineHeight": "1.4",
                            "fontWeight": "400"
                        }],
                        "headline-lg": ["28px", {
                            "lineHeight": "1.3",
                            "fontWeight": "600"
                        }],
                        "headline-xl": ["36px", {
                            "lineHeight": "1.2",
                            "fontWeight": "700"
                        }],
                        "body-reading-translation": ["18px", {
                            "lineHeight": "1.6",
                            "fontWeight": "400"
                        }],
                        "body-reading-arabic": ["32px", {
                            "lineHeight": "2.0",
                            "fontWeight": "400"
                        }]
                    }
                }
            }
        }
    </script>
    <style>
        .pattern-bg {
            background-image: radial-gradient(var(--tw-colors-primary-container) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.03;
        }
    </style>
</head>

<body class="bg-background text-on-background min-h-screen font-body-reading-translation relative">
    <!-- Background Pattern -->
    <div class="fixed inset-0 pattern-bg pointer-events-none z-0"></div>
    <!-- TopNavBar (from SCREEN_13) -->
    <nav
        class="bg-surface/95 backdrop-blur-md font-label-md sticky top-0 w-full flex justify-between items-center px-8 h-16 max-w-7xl mx-auto border-b border-surface-variant shadow-sm z-50">
        <div class="flex items-center gap-8">
            <div class="text-xl font-headline-lg font-bold tracking-tight text-primary">Qur'an Gorontalo</div>
            <div class="hidden md:flex items-center gap-6">
                <a class="text-primary border-b-2 border-primary pb-1 font-semibold" href="#">Mushaf</a>
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors duration-200"
                    href="#">Juz</a>
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors duration-200"
                    href="#">Bookmarks</a>
                <a class="text-on-surface-variant font-medium hover:text-primary transition-colors duration-200"
                    href="#">Search</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button
                class="text-on-surface-variant hover:text-primary transition-colors duration-200 active:scale-95 transition-transform">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
            </button>
            <button
                class="text-on-surface-variant hover:text-primary transition-colors duration-200 active:scale-95 transition-transform">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
            </button>
            <img alt="User profile" class="w-8 h-8 rounded-full border border-surface-variant"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCBAz2e1KC0GNlRMTDBdUGHMtwgu9fa4h3jnkIwHAnGm4yoCYQjHqHiJLFLTByofqpohNGunKtUJ_v8n10ocE5gN_kSkgx7OLkUxENPy738KndSBrMrrlqxGmDmN4NgeNWroxkgv0Bih2f3-aU2Gp4XmvLqpvx1Yoo42u2pjpVUL25rc5OJziceq_FVpciJYhq6PFBTVIAGjm0SZ2OZj8tNgT5Mkydu0NG25FmD0NSFdml2sCLguXrwPHGGMHl1KZbrMOsoQEL916x0" />
        </div>
    </nav>
    <!-- Main Canvas -->
    <main class="relative z-10 max-w-container-max mx-auto px-4 md:px-8 pt-16 pb-24">
        <!-- Hero Search Section (from SCREEN_13) -->
        <section class="flex flex-col items-center text-center mb-24">
            {{-- <h1 class="font-headline-xl text-headline-xl text-primary mb-sm">Baca, Pelajari, dan Pahami</h1>
            <p
                class="font-body-reading-translation text-body-reading-translation text-on-surface-variant mb-lg max-w-2xl">
                Jelajahi teks suci dengan terjemahan bahasa Gorontalo yang mendalam. Temukan ketenangan dan kejelasan di
                setiap Ayat.</p> --}}
            <div class="w-full max-w-xl mx-auto relative">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-outline text-sm" data-icon="search">search</span>
                </div>
                <input
                    class="w-full pl-10 pr-24 py-2.5 bg-surface rounded-full border border-outline-variant text-on-surface focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary font-label-md transition-all"
                    placeholder="Cari Surah, Ayat..." type="text" />
                <div class="absolute inset-y-0 right-1 flex items-center">
                    <button
                        class="bg-primary text-on-primary px-4 py-1.5 rounded-full font-label-md text-sm hover:bg-primary-container transition-colors">Cari</button>
                </div>
            </div>
            {{-- <div class="mt-6 flex flex-wrap justify-center gap-3">
<span class="font-caption text-caption text-on-surface-variant">Populer:</span>
<span class="px-3 py-1 bg-surface-container-low text-on-surface-variant rounded-full font-caption text-caption hover:bg-surface-container transition-colors cursor-pointer border border-surface-variant">Populer:</span>
<span class="px-3 py-1 bg-surface-container-low text-on-surface-variant rounded-full font-caption text-caption hover:bg-surface-container transition-colors cursor-pointer border border-surface-variant">Populer:</span>
<span class="px-3 py-1 bg-surface-container-low text-on-surface-variant rounded-full font-caption text-caption hover:bg-surface-container transition-colors cursor-pointer border border-surface-variant">Populer:</span>
<span class="px-3 py-1 bg-surface-container-low text-on-surface-variant rounded-full font-caption text-caption hover:bg-surface-container transition-colors cursor-pointer border border-surface-variant">Populer:</span>
</div> --}}
        </section>
        <!-- Featured Surahs (from SCREEN_13) -->
        <section class="mb-24">
            make a search bar flex aside with this h2 tag "surah pilihan"
            
            <h2
                class="font-headline-lg text-headline-lg text-primary mb-lg border-b border-surface-variant pb-2 inline-block">
                Surah Pilihan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                @foreach ($surahs as $surah)
                    <div
                        class="bg-surface rounded-xl border border-outline-variant p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:border-primary-fixed hover:shadow-md transition-all group cursor-pointer relative overflow-hidden flex flex-col justify-between h-auto">
                        <a href="{{ route('surah.show') }}">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    {{-- <span
                                        class="bg-primary-fixed text-on-primary-fixed px-2 py-1 rounded-full font-caption text-caption">{{ $surah->type }}</span> --}}
                                    <span class="text-outline font-caption text-caption">{{ $surah->no_surah }}</span>
                                </div>
                                <h3 class="font-headline-lg text-headline-lg text-on-surface">{{ $surah->nama_latin }}</h3>
                                <p class="font-caption text-caption text-on-surface-variant mt-1">{{ $surah->arti }}</p>
                            </div>
                            <div class="text-right">
                                <span class="font-body-reading-arabic text-body-reading-arabic text-primary">{{ $surah->arabic_name }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
                {{-- <div
                    class="bg-surface rounded-xl border border-outline-variant p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:border-primary-fixed hover:shadow-md transition-all group cursor-pointer relative overflow-hidden flex flex-col justify-between h-auto">
                    <a href="{{ route('surah.show') }}">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <span
                                    class="bg-primary-fixed text-on-primary-fixed px-2 py-1 rounded-full font-caption text-caption">Makkiyah</span>
                                <span class="text-outline font-caption text-caption">1</span>
                            </div>
                            <h3 class="font-headline-lg text-headline-lg text-on-surface">Al-Fatihah</h3>
                            <p class="font-caption text-caption text-on-surface-variant mt-1">Pembukaan</p>
                        </div>
                        <div class="text-right">
                            <span class="font-body-reading-arabic text-body-reading-arabic text-primary">الفاتحة</span>
                        </div>
                    </a>
                </div> --}}
                {{-- <!-- Card 2 -->
                <div
                    class="bg-surface rounded-xl border border-outline-variant p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:border-primary-fixed hover:shadow-md transition-all group cursor-pointer relative overflow-hidden flex flex-col justify-between h-auto">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span
                                class="bg-surface-container-high text-on-surface px-2 py-1 rounded-full font-caption text-caption">Madaniyah</span>
                            <span class="text-outline font-caption text-caption">2</span>
                        </div>
                        <h3 class="font-headline-lg text-headline-lg text-on-surface">Al-Baqarah</h3>
                        <p class="font-caption text-caption text-on-surface-variant mt-1">Sapi Betina</p>
                    </div>
                    <div class="text-right">
                        <span class="font-body-reading-arabic text-body-reading-arabic text-primary">البقرة</span>
                    </div>
                </div>
                <!-- Card 3 -->
                <div
                    class="bg-surface rounded-xl border border-outline-variant p-6 shadow-[0_4px_20px_rgba(0,0,0,0.04)] hover:border-primary-fixed hover:shadow-md transition-all group cursor-pointer relative overflow-hidden flex flex-col justify-between h-auto">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span
                                class="bg-primary-fixed text-on-primary-fixed px-2 py-1 rounded-full font-caption text-caption">Makkiyah</span>
                            <span class="text-outline font-caption text-caption">36</span>
                        </div>
                        <h3 class="font-headline-lg text-headline-lg text-on-surface">Ya-Sin</h3>
                        <p class="font-caption text-caption text-on-surface-variant mt-1">Ya Sin</p>
                    </div>
                    <div class="text-right">
                        <span class="font-body-reading-arabic text-body-reading-arabic text-primary">يس</span>
                    </div>
                </div> --}}
            </div>
        </section>
        <!-- Continue Reading / Recent Activity (from SCREEN_13) -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-24">
            <div class="lg:col-span-2">
                <h2
                    class="font-headline-lg text-headline-lg text-primary mb-lg border-b border-surface-variant pb-2 inline-block">
                    Lanjutkan Membaca</h2>
                <div
                    class="bg-surface-container-low rounded-lg p-4 flex items-center justify-between border border-surface-variant">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary" data-icon="menu_book">menu_book</span>
                        <div class="flex flex-wrap items-baseline gap-2">
                            <span class="font-label-md text-on-surface">Surah Al-Kahf</span>
                            <span class="text-xs text-on-surface-variant">Ayat 10</span>
                        </div>
                    </div>
                    <a class="text-primary font-label-md text-sm hover:underline flex items-center gap-1"
                        href="#">
                        <span>Lanjut</span>
                        <span class="material-symbols-outlined text-xs" data-icon="arrow_forward">arrow_forward</span>
                    </a>
                </div>
            </div>
            <div>
                <h2
                    class="font-headline-lg text-headline-lg text-primary mb-lg border-b border-surface-variant pb-2 inline-block">
                    Akses Cepat</h2>
                <ul class="divide-y divide-surface-variant">
                    <li><a class="flex items-center gap-3 py-3 text-on-surface-variant hover:text-primary transition-colors group"
                            href="#"><span class="material-symbols-outlined text-sm"
                                data-icon="bookmark">bookmark</span><span class="font-label-md">Markah Saya</span></a>
                    </li>
                    <li><a class="flex items-center gap-3 py-3 text-on-surface-variant hover:text-primary transition-colors group"
                            href="#"><span class="material-symbols-outlined text-sm"
                                data-icon="history">history</span><span class="font-label-md">Riwayat Bacaan</span></a>
                    </li>
                    <li><a class="flex items-center gap-3 py-3 text-on-surface-variant hover:text-primary transition-colors group"
                            href="#"><span class="material-symbols-outlined text-sm"
                                data-icon="format_list_bulleted">format_list_bulleted</span><span
                                class="font-label-md">Indeks Juz</span></a></li>
                </ul>
            </div>
        </section>
    </main>
    <!-- Footer (from SCREEN_12) -->
    <footer class="bg-surface-container-low border-t border-outline-variant pt-16 pb-8 relative z-10">
        <div class="max-w-container-max mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="md:col-span-1">
                    <div class="text-2xl font-headline-lg text-primary mb-6">Hulontalo Qur'an</div>
                    <p class="text-on-surface-variant font-body-reading-translation text-sm leading-relaxed">
                        Inisiatif untuk menyediakan akses Al-Qur'an dengan terjemahan bahasa Gorontalo yang mendalam
                        untuk masyarakat.
                    </p>
                    <div class="flex gap-4 mt-8">
                        <a class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-primary hover:bg-primary hover:text-on-primary transition-all"
                            href="#">
                            <span class="material-symbols-outlined text-[20px]" data-icon="share">share</span>
                        </a>
                        <a class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-primary hover:bg-primary hover:text-on-primary transition-all"
                            href="#">
                            <span class="material-symbols-outlined text-[20px]" data-icon="mail">mail</span>
                        </a>
                        <a class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-primary hover:bg-primary hover:text-on-primary transition-all"
                            href="#">
                            <span class="material-symbols-outlined text-[20px]" data-icon="public">public</span>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-label-md text-on-surface font-semibold mb-6 uppercase tracking-wider">Explore</h4>
                    <ul class="space-y-4 font-label-md text-on-surface-variant">
                        <li><a class="hover:text-primary transition-colors" href="#">Mushaf Online</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Daftar Surah</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Index Juz</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Pencarian Ayat</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-label-md text-on-surface font-semibold mb-6 uppercase tracking-wider">Project</h4>
                    <ul class="space-y-4 font-label-md text-on-surface-variant">
                        <li><a class="hover:text-primary transition-colors" href="#">Tentang Kami</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Metodologi Terjemahan</a>
                        </li>
                        <li><a class="hover:text-primary transition-colors" href="#">Kontribusi</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Donasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-label-md text-on-surface font-semibold mb-6 uppercase tracking-wider">Legal</h4>
                    <ul class="space-y-4 font-label-md text-on-surface-variant">
                        <li><a class="hover:text-primary transition-colors" href="#">Kebijakan Privasi</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Syarat Penggunaan</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Hak Cipta</a></li>
                    </ul>
                </div>
            </div>
            <div
                class="pt-8 border-t border-outline-variant flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="font-caption text-on-surface-variant">© 2024 Hulontalo Qur'an Project. Hak Cipta Dilindungi.
                </p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="font-caption text-on-surface-variant">Status Server: Online</span>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
