<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Qur'an Gorontalo - {{ $surah->nama_latin ?? 'Baca' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Noto+Serif:wght@400;700&amp;display=swap"
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
                    "fontFamily": {
                        "label-md": ["Inter"],
                        "caption": ["Inter"],
                        "headline-lg": ["Inter"],
                        "headline-xl": ["Inter"],
                        "body-reading-translation": ["Inter"],
                        "body-reading-arabic": ["Noto Serif"]
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #fafafa;
        }

        .ayah-card {
            transition: all 0.2s ease;
        }

        /* .ayah-card:hover { background-color: rgba(0, 69, 50, 0.02); } */

        .arabic-text {
            font-family: 'Noto Serif', serif;
            font-size: 36px;
            /* Ukuran pas untuk fokus */
            line-height: 2.2;
            direction: rtl;
            text-align: right;
            color: #064e3b;
        }

        .translation-text {
            font-family: 'Inter', sans-serif;
            font-size: 18px;
            line-height: 1.8;
            color: #334155;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="text-on-surface antialiased min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- 1. READING PROGRESS BAR (Tetap di atas layar) -->
    <div class="fixed top-0 left-0 w-full h-1.5 bg-gray-200 z-[100]">
        <div id="readingProgress" class="h-full bg-primary transition-all duration-150 ease-out" style="width: 0%;">
        </div>
    </div>

    <!-- 2. SIDEBAR OFF-CANVAS (Tersembunyi by default) -->
    <div id="sidebarBackdrop"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300">
    </div>

    <aside id="sidebarNav"
        class="fixed top-0 left-0 h-screen w-80 bg-white z-[70] transform -translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
        <div class="p-5 border-b border-gray-100 bg-primary flex justify-between items-center text-white">
            <div>
                <h3 class="font-bold text-lg tracking-wide flex items-center gap-2">
                    <span class="material-symbols-outlined">menu_book</span> Daftar Surah
                </h3>
                <p class="text-xs text-primary-fixed opacity-90 mt-1">Lompat ke surah lain</p>
            </div>
            <button id="closeSidebarBtn"
                class="p-2 bg-white/10 hover:bg-white/20 rounded-full transition-colors flex items-center justify-center">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-1 bg-surface-bright">
            @foreach ($allSurahs ?? [] as $listSurah)
                @php $nomorUrut = $loop->iteration; @endphp
                <a href="{{ route('surah.show', $listSurah->no_surah) }}"
                    class="flex items-center justify-between p-3 rounded-xl transition-colors border {{ isset($surah) && $surah->no_surah == $listSurah->no_surah ? 'bg-primary-container/10 border-primary shadow-sm' : 'border-transparent hover:bg-gray-100' }}">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                            {{ $nomorUrut }}
                        </div>
                        <div>
                            <p
                                class="font-bold text-gray-800 {{ isset($surah) && $surah->no_surah == $listSurah->no_surah ? 'text-primary' : '' }}">
                                {{ $listSurah->nama_latin }}</p>
                            <p class="text-xs text-gray-500">{{ $listSurah->arti }} • {{ $listSurah->jumlah_ayat }} Ayat
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </aside>

    <!-- 3. MAIN CANVAS (Area Fokus Membaca) -->
    <main class="flex-1 flex flex-col w-full relative z-10 pt-1.5">

        <!-- Header Kontrol -->
        <header
            class="sticky top-1.5 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200 px-4 sm:px-8 py-4 flex items-center justify-between shadow-sm transition-all">
            <div class="flex items-center gap-2 sm:gap-4">

                {{-- Ganti route('home') sesuai dengan nama route beranda lu, misalnya url('/') atau route('mushaf') --}}
                <a href="{{ url('/') }}"
                    class="flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl text-primary font-bold transition-colors shadow-sm"
                    title="Kembali ke Beranda">
                    <span class="material-symbols-outlined">home</span>
                    {{-- <span class="hidden md:block text-sm">Beranda</span> --}}
                </a>

                <button id="openSidebarBtn"
                    class="flex items-center gap-2 px-3 sm:px-4 py-2.5 bg-surface-container-low hover:bg-surface-container border border-gray-200 rounded-xl text-primary font-bold transition-colors shadow-sm">
                    <span class="material-symbols-outlined">format_list_bulleted</span>
                    <span class="hidden sm:block text-sm">Daftar Surah</span>
                </button>

                <div class="h-8 w-px bg-gray-300 hidden lg:block"></div>

                <div class="hidden lg:block">
                    <h1 class="text-xl font-bold text-gray-900 leading-tight">QS
                        {{ $surah->nama_latin ?? 'Al-Fatihah' }}</h1>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        {{ $surah->arti ?? 'Pembukaan' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 bg-gray-50 p-1.5 rounded-xl border border-gray-200">
                <button id="fontDecrease"
                    class="w-10 h-10 rounded-lg flex items-center justify-center text-gray-600 hover:bg-white hover:shadow-sm transition-all"
                    title="Perkecil Teks">
                    <span class="material-symbols-outlined">text_decrease</span>
                </button>
                <div class="h-5 w-px bg-gray-300"></div>
                <button id="fontIncrease"
                    class="w-10 h-10 rounded-lg flex items-center justify-center text-gray-600 hover:bg-white hover:shadow-sm transition-all"
                    title="Perbesar Teks">
                    <span class="material-symbols-outlined">text_increase</span>
                </button>
                <div class="h-5 w-px bg-gray-300"></div>
                <button id="btnPlayAll" onclick="togglePlayAll()"
                    class="w-10 h-10 rounded-lg flex items-center justify-center bg-emerald-700 text-white shadow-sm hover:bg-emerald-800 transition-all"
                    title="Putar Seluruh Ayat (Arab & Gorontalo)">
                    <span class="material-symbols-outlined icon-play-all">play_arrow</span>
                </button>
            </div>
        </header>

        <!-- Area Teks Ayat (Centered max-w-4xl untuk fokus) -->
        <div class="w-full max-w-5xl mx-auto px-6 py-12 flex flex-col gap-8" id="readingContainer">

            <!-- Bismillah Header -->
            @if (($surah->no_surah ?? 1) != 1 && ($surah->no_surah ?? 1) != 9)
                <div class="flex justify-center mb-10 pb-10 border-b border-gray-200">
                    <div class="text-center">
                        <p class="arabic-text !text-4xl">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
                        <p class="text-sm font-semibold text-gray-600 mt-4 uppercase tracking-widest">Wolo tanggulo
                            Allah ta Labatutu Mottoli’anga boli Labatutu Mommonuwa</p>
                    </div>
                </div>
            @endif

            <!-- Loop Ayats -->
            <!-- Loop Ayats -->
            @forelse($ayats ?? [] as $ayat)
                <div class="ayah-card flex flex-col gap-5 group border-b border-gray-300 pb-8 relative scroll-mt-32"
                    id="ayat-{{ $ayat->nomorAyat }}">

                    <!-- Header Ayat -->
                    <div class="flex items-center justify-between w-full">
                        <span
                            class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-800 font-bold text-sm border border-emerald-100">
                            Ayat {{ $ayat->nomorAyat }}
                        </span>
                    </div>

                    <!-- Teks Arab -->
                    <div class="w-full flex justify-end">
                        <p class="arabic-text max-w-4xl">
                            {{ $ayat->Arab }}
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full border-2 border-primary text-primary mx-2 relative translate-y-[-4px]"
                                style="font-size: 16px; font-weight:bold;">
                                {{ numberToArabic($ayat->nomorAyat) }}
                            </span>
                        </p>
                    </div>

                    <!-- Terjemahan & 3 Tombol Aksi -->
                    <div class="w-full bg-white rounded-2xl p-6  flex flex-col gap-4">
                        <!-- Teks Terjemahan -->
                        <p class="translation-text">
                            {{ $ayat->teks_gorontalo }}
                        </p>

                        <!-- Garis Pembatas -->
                        <div class="h-px w-full bg-gray-100"></div>

                        <!-- Dengarkan, Salin, Riwayat & Usulan -->
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                            <!-- Tombol Play Audio -->
                            <button
                                onclick="playAudio({{ $surah->no_surah ?? 1 }}, {{ $ayat->nomorAyat }}, 'murottal',this)"
                                class="audio-btn text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1.5 font-bold text-sm">
                                <span class="material-symbols-outlined text-[20px] icon-play">play_circle</span>
                                <span class="text-play">Arab</span>
                            </button>

                            <button
                                onclick="playAudio({{ $surah->no_surah ?? 1 }}, {{ $ayat->nomorAyat }}, 'gorontalo', this)"
                                data-text="Gorontalo" data-icon="record_voice_over"
                                class="audio-btn text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1.5 font-bold text-sm">
                                <span class="material-symbols-outlined text-[20px] icon-play">record_voice_over</span>
                                <span class="text-play">Gorontalo</span>
                            </button>

                            <!-- Tombol Salin -->
                            <button
                                onclick="copyAyat({{ $ayat->nomorAyat }}, '{{ addslashes($ayat->Arab) }}', '{{ addslashes($ayat->teks_gorontalo) }}')"
                                class="text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1.5 font-bold text-sm">
                                <span class="material-symbols-outlined text-[20px]">content_copy</span>
                                Salin
                            </button>

                            <!-- Tombol Riwayat & Usulan -->
                            <a href="{{ route('usulan.index', ['surah_id' => $surah->no_surah, 'ayat_id' => $ayat->nomorAyat]) }}"
                                class="text-gray-500 hover:text-blue-600 transition-colors flex items-center gap-1.5 font-bold text-sm sm:ml-auto">
                                <span class="material-symbols-outlined text-[20px]">history_edu</span>
                                Riwayat & Usulan
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">auto_stories</span>
                    <h3 class="text-xl font-bold text-gray-600">Belum ada ayat untuk surah ini.</h3>
                </div>
            @endforelse

            <!-- Navigasi Bawah -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 py-8 mt-4">
                @if ($prevSurah ?? null)
                    <a href="{{ route('surah.show', $prevSurah->no_surah) }}"
                        class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-xl font-bold text-gray-700 hover:border-primary hover:text-primary transition-all shadow-sm">
                        <span class="material-symbols-outlined">arrow_back</span> {{ $prevSurah->nama_latin }}
                    </a>
                @else
                    <div></div>
                @endif

                @if ($nextSurah ?? null)
                    <a href="{{ route('surah.show', $nextSurah->no_surah) }}"
                        class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 bg-primary rounded-xl font-bold text-white hover:bg-tertiary transition-all shadow-sm">
                        {{ $nextSurah->nama_latin }} <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                @else
                    <div></div>
                @endif
            </div>

        </div>
    </main>

    <div id="globalAudioPlayer"
        class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.1)] z-50 transform translate-y-full transition-transform duration-300 flex justify-center">
        <div class="max-w-4xl w-full px-4 sm:px-6 md:px-8 py-4 flex flex-col gap-2">

            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3 min-w-0">
                    <div id="playerIconBg"
                        class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <span id="playerIcon" class="material-symbols-outlined">graphic_eq</span>
                    </div>
                    <div class="truncate">
                        <h4 id="playerTitle" class="text-sm md:text-base font-bold text-slate-900 truncate">Memuat...
                        </h4>
                        <p id="playerSubtitle" class="text-xs text-slate-500 truncate">Mode Putar Otomatis</p>
                    </div>
                </div>

                <button onclick="closeGlobalPlayer()"
                    class="text-slate-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="flex items-center gap-3">
                <span id="currentTimeDisplay" class="text-xs font-medium text-slate-500 w-10 text-right">00:00</span>

                <input type="range" id="audioSeeker" min="0" max="100" value="0"
                    class="flex-1 h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">

                <span id="totalTimeDisplay" class="text-xs font-medium text-slate-500 w-10">00:00</span>
            </div>

            <div class="flex justify-center items-center gap-6">
                <button onclick="prevTrack()"
                    class="text-slate-500 hover:text-emerald-700 transition-colors active:scale-95">
                    <span class="material-symbols-outlined text-3xl">skip_previous</span>
                </button>

                <button id="mainPlayPauseBtn" onclick="togglePlayAll()"
                    class="text-emerald-700 hover:text-emerald-800 transition-colors active:scale-95">
                    <span class="material-symbols-outlined text-5xl">pause_circle</span>
                </button>

                <button onclick="nextTrack()"
                    class="text-slate-500 hover:text-emerald-700 transition-colors active:scale-95">
                    <span class="material-symbols-outlined text-3xl">skip_next</span>
                </button>
            </div>
        </div>
    </div>

    <script>
        // --- LOGIKA PROGRESS BAR BACAAN ---
        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('readingProgress').style.width = scrolled + '%';
        });

        // --- LOGIKA SIDEBAR OFF-CANVAS ---
        const sidebar = document.getElementById('sidebarNav');
        const backdrop = document.getElementById('sidebarBackdrop');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'hidden'; // Kunci scroll layar utama
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'auto'; // Buka scroll layar utama
        }

        openBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        backdrop.addEventListener('click', closeSidebar); // Tutup kalau klik area gelap

        // --- LOGIKA KONTROL UKURAN FONT ---
        let currentFontSizeArab = 36;
        let currentFontSizeTrans = 18;
        const arabicTexts = document.querySelectorAll('.arabic-text');
        const translationTexts = document.querySelectorAll('.translation-text');

        document.getElementById('fontIncrease')?.addEventListener('click', () => {
            if (currentFontSizeArab < 56) { // Maksimal ukuran
                currentFontSizeArab += 2;
                currentFontSizeTrans += 1;
                arabicTexts.forEach(text => text.style.fontSize = currentFontSizeArab + 'px');
                translationTexts.forEach(text => text.style.fontSize = currentFontSizeTrans + 'px');
            }
        });

        document.getElementById('fontDecrease')?.addEventListener('click', () => {
            if (currentFontSizeArab > 24) { // Minimal ukuran
                currentFontSizeArab -= 2;
                currentFontSizeTrans -= 1;
                arabicTexts.forEach(text => text.style.fontSize = currentFontSizeArab + 'px');
                translationTexts.forEach(text => text.style.fontSize = currentFontSizeTrans + 'px');
            }
        });

        // --- FUNGSI COPY ---
        function copyAyat(ayatNumber, arabic, translation) {
            const textToCopy = `Ayat ${ayatNumber}\n${arabic}\n\n${translation}\n\n(Qur'an Gorontalo)`;
            navigator.clipboard.writeText(textToCopy).then(() => {
                alert('Teks ayat berhasil disalin!');
            });
        }
    </script>

    <script>
        // Variabel global buat nyimpen data audio yang lagi jalan
        let currentAudio = null;
        let currentButton = null;

        function playAudio(surahNo, ayatNo, type, btnElement) {
            // Rangkai URL file audionya otomatis
            const audioUrl = `/storage/audio_${type}/${surahNo}_${ayatNo}.mp3`;

            const iconSpan = btnElement.querySelector('.icon-play');
            const textSpan = btnElement.querySelector('.text-play');

            // Skenario 1: Kalau tombol yang SAMA diklik lagi (buat Pause/Play lanjut)
            if (currentAudio && currentAudio.src.includes(audioUrl)) {
                if (!currentAudio.paused) {
                    currentAudio.pause();
                    setButtonState(btnElement, 'pause'); // Ubah UI ke state Jeda
                } else {
                    currentAudio.play();
                    setButtonState(btnElement, 'play'); // Ubah UI ke state Jalan
                }
                return;
            }

            // Skenario 2: Kalau audio LAIN lagi jalan, matiin dulu audio yang lama
            if (currentAudio) {
                currentAudio.pause();
                // Kembalikan tombol yang sebelumnya aktif ke wujud aslinya
                if (currentButton && currentButton !== btnElement) {
                    resetButtonState(currentButton);
                }
            }

            // Skenario 3: Bikin pemutar baru dan langsung mainkan
            currentAudio = new Audio(audioUrl);
            currentButton = btnElement;

            // Tampilkan animasi loading selagi ngambil file (Aman dari null)
            if (iconSpan) {
                iconSpan.innerHTML = 'hourglass_empty';
                iconSpan.classList.add('animate-spin');
            }
            if (textSpan) {
                textSpan.innerHTML = 'Memuat...';
            }

            // Jalankan audio
            currentAudio.play().then(() => {
                setButtonState(btnElement, 'play');
            }).catch(error => {
                console.error("Audio tidak ditemukan:", error);
                const namaAudio = type === 'gorontalo' ? 'Terjemahan Gorontalo' : 'Murottal Arab';
                alert(`Mohon maaf, file audio ${namaAudio} untuk ayat ini belum tersedia.`);

                // Kalau gagal, langsung balikin tombol seperti semula
                resetButtonState(btnElement);
                currentAudio = null;
                currentButton = null;
            });

            // Kalau audio udah selesai diputar sampai habis
            currentAudio.onended = () => {
                resetButtonState(btnElement);
                currentAudio = null;
                currentButton = null;
            };
        }

        // --- FUNGSI BANTUAN UI (Matang & Anti Bug) ---
        function setButtonState(btn, state) {
            if (!btn) return;
            const iconSpan = btn.querySelector('.icon-play');
            const textSpan = btn.querySelector('.text-play');

            if (iconSpan) iconSpan.classList.remove('animate-spin');

            if (state === 'play') {
                btn.classList.add('text-emerald-600');
                if (iconSpan) iconSpan.innerHTML = 'pause_circle';
                if (textSpan) textSpan.innerHTML = 'Jeda';
            } else if (state === 'pause') {
                btn.classList.remove('text-emerald-600');
                if (iconSpan) iconSpan.innerHTML = 'play_circle';
                if (textSpan) textSpan.innerHTML = 'Lanjutkan';
            }
        }

        function resetButtonState(btn) {
            if (!btn) return;
            const iconSpan = btn.querySelector('.icon-play');
            const textSpan = btn.querySelector('.text-play');

            // JARING PENGAMAN: Kalau data-icon/text lupa ditulis di HTML, pakai nilai default ini
            const defaultIcon = btn.getAttribute('data-icon') || 'play_circle';
            const defaultText = btn.getAttribute('data-text') || 'Dengarkan';

            btn.classList.remove('text-emerald-600');

            if (iconSpan) {
                iconSpan.classList.remove('animate-spin');
                iconSpan.innerHTML = defaultIcon;
            }

            if (textSpan) {
                textSpan.innerHTML = defaultText;
            }
        }
    </script>

    <script>
        // Injeksi data dari PHP
        const G_SURAH_NO = {{ $surah->no_surah ?? 1 }};
        const G_TOTAL_AYAT = {{ count($ayats) }}; // Pastikan variabel array ayat lu namanya $ayahs

        // State Global Player
        let playlist = [];
        let currentIndex = 0;
        let isGlobalPlaying = false;
        let globalAudio = new Audio();

        // Referensi Elemen UI
        const globalPlayerUI = document.getElementById('globalAudioPlayer');
        const headerBtnIcon = document.querySelector('.icon-play-all');
        const mainPlayPauseBtn = document.getElementById('mainPlayPauseBtn');
        const playerTitle = document.getElementById('playerTitle');
        const audioSeeker = document.getElementById('audioSeeker');
        const currentTimeDisplay = document.getElementById('currentTimeDisplay');
        const totalTimeDisplay = document.getElementById('totalTimeDisplay');

        // 1. Buat Playlist (Arab 1 -> Gorontalo 1 -> Arab 2 -> Gorontalo 2)
        function buildPlaylist() {
            playlist = [];
            for (let i = 1; i <= G_TOTAL_AYAT; i++) {
                playlist.push({
                    type: 'murottal',
                    ayat: i,
                    label: 'Murottal Arab'
                });
                playlist.push({
                    type: 'gorontalo',
                    ayat: i,
                    label: 'Terjemahan Gorontalo'
                });
            }
        }

        // 2. Fungsi Eksekusi Trek
        function loadAndPlayTrack(index) {
            if (index < 0 || index >= playlist.length) {
                closeGlobalPlayer(); // Kalo udah habis, tutup
                return;
            }

            currentIndex = index;
            const track = playlist[currentIndex];
            const audioUrl = `/storage/audio_${track.type}/${G_SURAH_NO}_${track.ayat}.mp3`;

            // Update UI Text
            playerTitle.innerHTML = `Ayat ${track.ayat} - ${track.label}`;
            audioSeeker.value = 0;
            currentTimeDisplay.innerHTML = "00:00";
            totalTimeDisplay.innerHTML = "00:00";

            globalAudio.src = audioUrl;

            // Coba putar
            globalAudio.play().then(() => {
                isGlobalPlaying = true;
                updatePlayPauseUI(true);

                // JIKA ADA AUDIO INDIVIDU YANG LAGI JALAN, MATIIN DULU!
                if (typeof currentAudio !== 'undefined' && currentAudio) {
                    currentAudio.pause();
                    if (typeof currentButton !== 'undefined') resetButtonState(currentButton);
                }
            }).catch(err => {
                console.warn(`File ${audioUrl} tidak ditemukan. Otomatis skip ke trek selanjutnya...`);
                // Kalo file ga ada, skip otomatis setelah 1 detik
                setTimeout(() => {
                    nextTrack();
                }, 1000);
            });
        }

        // 3. Tombol Utama (Play/Pause)
        function togglePlayAll() {
            if (playlist.length === 0) buildPlaylist();

            // Tampilkan panel bawah
            globalPlayerUI.classList.remove('translate-y-full');

            if (isGlobalPlaying) {
                globalAudio.pause();
                isGlobalPlaying = false;
                updatePlayPauseUI(false);
            } else {
                if (globalAudio.src) {
                    globalAudio.play();
                } else {
                    loadAndPlayTrack(currentIndex);
                }
                isGlobalPlaying = true;
                updatePlayPauseUI(true);
            }
        }

        function updatePlayPauseUI(playing) {
            if (playing) {
                headerBtnIcon.innerHTML = 'pause';
                mainPlayPauseBtn.innerHTML = '<span class="material-symbols-outlined text-5xl">pause_circle</span>';
            } else {
                headerBtnIcon.innerHTML = 'play_arrow';
                mainPlayPauseBtn.innerHTML = '<span class="material-symbols-outlined text-5xl">play_circle</span>';
            }
        }

        // 4. Next & Prev Track
        function nextTrack() {
            loadAndPlayTrack(currentIndex + 1);
        }

        function prevTrack() {
            loadAndPlayTrack(currentIndex - 1);
        }

        // 5. Tutup Panel
        function closeGlobalPlayer() {
            globalAudio.pause();
            isGlobalPlaying = false;
            updatePlayPauseUI(false);
            globalPlayerUI.classList.add('translate-y-full');
        }

        // ==========================================
        // LOGIKA PROGRESS BAR (SEEK & TIME UPDATE)
        // ==========================================

        // Tiap kali durasi jalan, update slider & text
        globalAudio.addEventListener('timeupdate', () => {
            if (!isNaN(globalAudio.duration)) {
                const progressPercent = (globalAudio.currentTime / globalAudio.duration) * 100;
                audioSeeker.value = progressPercent;
                currentTimeDisplay.innerHTML = formatTime(globalAudio.currentTime);
                totalTimeDisplay.innerHTML = formatTime(globalAudio.duration);
            }
        });

        // Otomatis lanjut ke trek selanjutnya kalau audio udah abis
        globalAudio.addEventListener('ended', () => {
            nextTrack();
        });

        // Kalo user geser slider, ganti posisi audionya
        audioSeeker.addEventListener('input', (e) => {
            if (!isNaN(globalAudio.duration)) {
                const seekTo = (e.target.value / 100) * globalAudio.duration;
                globalAudio.currentTime = seekTo;
            }
        });

        // Format angka ke menit:detik (contoh: 01:05)
        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }
    </script>

</body>

</html>
