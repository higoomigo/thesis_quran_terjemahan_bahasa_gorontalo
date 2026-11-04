<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Qur'an Gorontalo - Juz {{ $juz_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Noto+Serif:wght@400;700&amp;display=swap" rel="stylesheet" />
    @include('partials.pwa')
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
        body { background-color: #fafafa; }
        .ayah-card { transition: all 0.2s ease; }
        .arabic-text { font-family: 'Noto Serif', serif; font-size: 36px; line-height: 2.2; direction: rtl; text-align: right; color: #064e3b; }
        .translation-text { font-family: 'Inter', sans-serif; font-size: 18px; line-height: 1.8; color: #334155; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        #loading-screen { opacity: 1; visibility: visible; transition: opacity 0.4s ease, visibility 0.4s ease; }
        #loading-screen.hidden-loader { opacity: 0; visibility: hidden; }
        .surah-divider { background-image: url('data:image/svg+xml,%3Csvg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23a6f2d1" fill-opacity="0.1" fill-rule="evenodd"%3E%3Ccircle cx="3" cy="3" r="3"/%3E%3Ccircle cx="13" cy="13" r="3"/%3E%3C/g%3E%3C/svg%3E'); }
    </style>
</head>

<body class="text-on-surface antialiased min-h-screen flex flex-col relative overflow-x-hidden">
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 z-[99999] flex flex-col items-center justify-center bg-[#f9f9ff]">
        <div class="relative flex items-center justify-center">
            <div class="w-16 h-16 border-4 border-emerald-200 border-t-emerald-900 rounded-full animate-spin"></div>
        </div>
        <p class="mt-4 text-xs md:text-sm font-bold text-slate-600 tracking-wider uppercase animate-pulse">Sabaripo...</p>
    </div>

    <!-- 1. READING PROGRESS BAR -->
    <div class="fixed top-0 left-0 w-full h-1.5 bg-gray-200 z-[100]">
        <div id="readingProgress" class="h-full bg-primary transition-all duration-150 ease-out" style="width: 0%;"></div>
    </div>

    <!-- 2. SIDEBAR OFF-CANVAS -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300"></div>

    <aside id="sidebarNav" class="fixed top-0 left-0 h-screen w-80 bg-white z-[70] transform -translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
        <div class="p-5 border-b border-gray-100 bg-primary flex justify-between items-center text-white">
            <div>
                <h3 class="font-bold text-lg tracking-wide flex items-center gap-2">
                    <span class="material-symbols-outlined">menu_book</span> Daftar Juz
                </h3>
                <p class="text-xs text-primary-fixed opacity-90 mt-1">Lompat ke juz lain</p>
            </div>
            <button id="closeSidebarBtn" class="p-2 bg-white/10 hover:bg-white/20 rounded-full transition-colors flex items-center justify-center">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-1 bg-surface-bright">
            @foreach ($allJuz ?? range(1, 30) as $listJuz)
                <a href="{{ route('juz.show', $listJuz) }}"
                    class="flex items-center justify-between p-3 rounded-xl transition-colors border {{ $juz_id ==$listJuz ? 'bg-primary-container/10 border-primary shadow-sm' : 'border-transparent hover:bg-gray-100' }}">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                            {{ $listJuz }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 {{ $juz_id == $listJuz ? 'text-primary' : '' }}">Juz {{ $listJuz }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </aside>

    <!-- 3. MAIN CANVAS -->
    <main class="flex-1 flex flex-col w-full relative z-10 pt-1.5">

        <!-- Header Kontrol -->
        <header class="sticky top-1.5 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200 px-4 sm:px-8 py-4 flex items-center justify-between shadow-sm transition-all">
            <div class="flex items-center gap-2 sm:gap-4">
                <a href="{{ url('/') }}" class="flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl text-primary font-bold transition-colors shadow-sm" title="Kembali ke Beranda">
                    <span class="material-symbols-outlined">home</span>
                </a>

                <button id="openSidebarBtn" class="flex items-center gap-2 px-3 sm:px-4 py-2.5 bg-surface-container-low hover:bg-surface-container border border-gray-200 rounded-xl text-primary font-bold transition-colors shadow-sm">
                    <span class="material-symbols-outlined">format_list_bulleted</span>
                    <span class="hidden sm:block text-sm">Daftar Juz</span>
                </button>

                <div class="h-8 w-px bg-gray-300 hidden lg:block"></div>

                <div class="hidden lg:block">
                    <h1 class="text-xl font-bold text-gray-900 leading-tight">Juz {{ $juz_id }}</h1>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">{{ count($ayats) }} Ayat</p>
                </div>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 bg-gray-50 p-1.5 rounded-xl border border-gray-200">
                <button id="fontDecrease" class="w-10 h-10 rounded-lg flex items-center justify-center text-gray-600 hover:bg-white hover:shadow-sm transition-all" title="Perkecil Teks">
                    <span class="material-symbols-outlined">text_decrease</span>
                </button>
                <div class="h-5 w-px bg-gray-300"></div>
                <button id="fontIncrease" class="w-10 h-10 rounded-lg flex items-center justify-center text-gray-600 hover:bg-white hover:shadow-sm transition-all" title="Perbesar Teks">
                    <span class="material-symbols-outlined">text_increase</span>
                </button>
                <div class="h-5 w-px bg-gray-300"></div>
                <button id="btnPlayAll" onclick="togglePlayAll()" class="w-10 h-10 rounded-lg flex items-center justify-center bg-emerald-700 text-white shadow-sm hover:bg-emerald-800 transition-all" title="Putar Seluruh Ayat (Arab & Gorontalo)">
                    <span class="material-symbols-outlined icon-play-all">play_arrow</span>
                </button>
            </div>
        </header>

        <!-- Area Teks Ayat -->
        <div class="w-full max-w-5xl mx-auto px-6 py-12 flex flex-col gap-8" id="readingContainer">

            @php $currentSurahId = null; @endphp

            @forelse($ayats ?? [] as $ayat)
                
                {{-- PENDETEKSI SURAH BARU --}}
                @if($currentSurahId !==$ayat->no_surah)
                    {{-- BANNER NAMA SURAH --}}
                    <div class="w-full bg-primary-container text-on-primary-container rounded-2xl p-6 mt-12 mb-6 flex flex-col md:flex-row justify-between items-center shadow-md surah-divider border border-primary relative overflow-hidden">
                        <div class="relative z-10 text-center md:text-left">
                            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-widest mb-2 inline-block">Surah Ke-{{ $ayat->surah->no_surah }}</span>
                            <h2 class="text-3xl font-bold text-white mb-1">{{ $ayat->surah->nama_latin }}</h2>
                            <p class="text-primary-fixed-dim text-sm">{{ $ayat->surah->arti }} • {{$ayat->surah->jumlah_ayat }} Ayat</p>
                        </div>
                        <div class="relative z-10 mt-4 md:mt-0">
                            <h2 class="font-body-reading-arabic text-4xl text-white">{{ $ayat->surah->arabic_name ?? '' }}</h2>
                        </div>
                    </div>

                    {{-- BISMILLAH --}}
                    @if ($ayat->surah->no_surah != 1 &&$ayat->surah->no_surah != 9)
                        <div class="flex justify-center mb-10 pb-10 border-b border-gray-200">
                            <div class="text-center">
                                <p class="arabic-text !text-4xl">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
                                <p class="text-sm font-semibold text-gray-600 mt-4 uppercase tracking-widest">Wolo tanggulo Allah ta Labatutu Mottoli’anga boli Labatutu Mommonuwa</p>
                            </div>
                        </div>
                    @endif

                    @php $currentSurahId =$ayat->no_surah; @endphp
                @endif

                {{-- CARD AYAT --}}
                <div class="ayah-card flex flex-col gap-5 group border-b border-gray-300 pb-8 relative scroll-mt-32" id="ayat-{{ $ayat->no_surah }}-{{$ayat->nomorAyat }}">
                    
                    <div class="flex items-center justify-between w-full">
                        <span class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-800 font-bold text-sm border border-emerald-100 flex items-center gap-2">
                            <span class="opacity-50 text-xs">{{ $ayat->surah->nama_latin }} :</span> {{$ayat->nomorAyat }}
                        </span>
                    </div>

                    <div class="w-full flex justify-end">
                        <p class="arabic-text max-w-4xl">
                            {{ $ayat->Arab }}
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full border-2 border-primary text-primary mx-2 relative translate-y-[-4px]" style="font-size: 16px; font-weight:bold;">
                                {{ numberToArabic($ayat->nomorAyat) }}
                            </span>
                        </p>
                    </div>

                    <div class="w-full bg-white rounded-2xl p-6 flex flex-col gap-4">
                        <p class="translation-text">{{ $ayat->teks_gorontalo }}</p>
                        <div class="h-px w-full bg-gray-100"></div>

                        <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                            <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                                
                                {{-- Tombol Arab --}}
                                @php $audioArab =$ayat->audioArabs->first(); @endphp
                                <button onclick="playAudio(this)" data-src="{{ $audioArab ? asset('storage/' . $audioArab->file_path_arab) : '' }}" class="audio-btn text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1.5 font-bold text-sm {{ !$audioArab ? 'opacity-40 cursor-not-allowed' : '' }}" {{ !$audioArab ? 'disabled' : '' }}>
                                    <span class="material-symbols-outlined text-[20px] icon-play">play_circle</span>
                                    <span class="text-play">Arab</span>
                                </button>

                                {{-- Tombol Gorontalo --}}
                                @php $audioGto =$ayat->audioGorontalos->first(); @endphp
                                <button onclick="playAudio(this)" data-src="{{ $audioGto ? asset('storage/' . $audioGto->file_path_gorontalo) : '' }}" class="audio-btn text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1.5 font-bold text-sm {{ !$audioGto ? 'opacity-40 cursor-not-allowed' : '' }}" {{ !$audioGto ? 'disabled' : '' }}>
                                    <span class="material-symbols-outlined text-[20px] icon-play">record_voice_over</span>
                                    <span class="text-play">Gorontalo</span>
                                </button>
                            </div>

                            <button onclick="copyAyat('{{ $ayat->surah->nama_latin }}', {{$ayat->nomorAyat }}, '{{ addslashes($ayat->Arab) }}', '{{ addslashes($ayat->teks_gorontalo) }}')" class="text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1.5 font-bold text-sm">
                                <span class="material-symbols-outlined text-[20px]">content_copy</span> Salin
                            </button>

                            <a href="{{ route('usulan.index', ['surah_id' => $ayat->no_surah, 'ayat_id' =>$ayat->nomorAyat]) }}" class="text-gray-500 hover:text-blue-600 transition-colors flex items-center gap-1.5 font-bold text-sm sm:ml-auto">
                                <span class="material-symbols-outlined text-[20px]">history_edu</span> Riwayat & Usulan
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">auto_stories</span>
                    <h3 class="text-xl font-bold text-gray-600">Belum ada ayat untuk juz ini.</h3>
                </div>
            @endforelse

            <!-- Navigasi Bawah -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 py-8 mt-4">
                @if ($prevJuz ?? null)
                    <a href="{{ route('juz.show', $prevJuz) }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-xl font-bold text-gray-700 hover:border-primary hover:text-primary transition-all shadow-sm">
                        <span class="material-symbols-outlined">arrow_back</span> Juz {{ $prevJuz }}
                    </a>
                @else
                    <div></div>
                @endif

                @if ($nextJuz ?? null)
                    <a href="{{ route('juz.show', $nextJuz) }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 bg-primary rounded-xl font-bold text-white hover:bg-tertiary transition-all shadow-sm">
                        Juz {{ $nextJuz }} <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                @else
                    <div></div>
                @endif
            </div>

        </div>
    </main>

    <!-- Global Audio Player -->
    <div id="globalAudioPlayer" class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.1)] z-50 transform translate-y-full transition-transform duration-300 flex justify-center">
        <div class="max-w-4xl w-full px-4 sm:px-6 md:px-8 py-4 flex flex-col gap-2">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3 min-w-0">
                    <div id="playerIconBg" class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <span id="playerIcon" class="material-symbols-outlined">graphic_eq</span>
                    </div>
                    <div class="truncate">
                        <h4 id="playerTitle" class="text-sm md:text-base font-bold text-slate-900 truncate">Memuat...</h4>
                        <p id="playerSubtitle" class="text-xs text-slate-500 truncate">Mode Putar Otomatis</p>
                    </div>
                </div>

                <button onclick="closeGlobalPlayer()" class="text-slate-400 hover:text-red-500 transition-colors p-1 rounded-full hover:bg-red-50">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="flex items-center gap-3">
                <span id="currentTimeDisplay" class="text-xs font-medium text-slate-500 w-10 text-right">00:00</span>
                <input type="range" id="audioSeeker" min="0" max="100" value="0" class="flex-1 h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                <span id="totalTimeDisplay" class="text-xs font-medium text-slate-500 w-10">00:00</span>
            </div>

            <div class="flex justify-center items-center gap-6">
                <button onclick="prevTrack()" class="text-slate-500 hover:text-emerald-700 transition-colors active:scale-95">
                    <span class="material-symbols-outlined text-3xl">skip_previous</span>
                </button>
                <button id="mainPlayPauseBtn" onclick="togglePlayAll()" class="text-emerald-700 hover:text-emerald-800 transition-colors active:scale-95">
                    <span class="material-symbols-outlined text-5xl">pause_circle</span>
                </button>
                <button onclick="nextTrack()" class="text-slate-500 hover:text-emerald-700 transition-colors active:scale-95">
                    <span class="material-symbols-outlined text-3xl">skip_next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        window.addEventListener('load', function() {
            const loader = document.getElementById('loading-screen');
            if (loader) {
                loader.classList.add('hidden-loader');
                setTimeout(() => { loader.style.display = 'none'; }, 400);
            }
        });

        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('readingProgress').style.width = scrolled + '%';
        });

        const sidebar = document.getElementById('sidebarNav');
        const backdrop = document.getElementById('sidebarBackdrop');
        const openBtn = document.getElementById('openSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'auto';
        }

        openBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        backdrop.addEventListener('click', closeSidebar);

        let currentFontSizeArab = 36;
        let currentFontSizeTrans = 18;
        const arabicTexts = document.querySelectorAll('.arabic-text');
        const translationTexts = document.querySelectorAll('.translation-text');

        document.getElementById('fontIncrease')?.addEventListener('click', () => {
            if (currentFontSizeArab < 56) {
                currentFontSizeArab += 2;
                currentFontSizeTrans += 1;
                arabicTexts.forEach(text => text.style.fontSize = currentFontSizeArab + 'px');
                translationTexts.forEach(text => text.style.fontSize = currentFontSizeTrans + 'px');
            }
        });

        document.getElementById('fontDecrease')?.addEventListener('click', () => {
            if (currentFontSizeArab > 24) {
                currentFontSizeArab -= 2;
                currentFontSizeTrans -= 1;
                arabicTexts.forEach(text => text.style.fontSize = currentFontSizeArab + 'px');
                translationTexts.forEach(text => text.style.fontSize = currentFontSizeTrans + 'px');
            }
        });

        function copyAyat(surahName, ayatNumber, arabic, translation) {
            const textToCopy = `${surahName} Ayat ${ayatNumber}\n${arabic}\n\n${translation}\n\n(Qur'an Gorontalo)`;
            navigator.clipboard.writeText(textToCopy).then(() => { alert('Teks ayat berhasil disalin!'); });
        }

        let currentAudio = null;
        let currentBtn = null;

        function playAudio(btn) {
            const src = btn.dataset.src;
            if (!src) { alert('Audio belum tersedia'); return; }

            if (currentBtn === btn && currentAudio && !currentAudio.paused) {
                currentAudio.pause();
                resetButton(btn);
                return;
            }

            if (currentAudio) {
                currentAudio.pause();
                if (currentBtn) resetButton(currentBtn);
            }

            currentAudio = new Audio(src);
            currentBtn = btn;

            btn.querySelector('.icon-play').textContent = 'pause_circle';
            btn.querySelector('.text-play').textContent = 'Pause';

            currentAudio.play();

            currentAudio.onended = () => {
                resetButton(btn);
                currentAudio = null;
                currentBtn = null;
            };
        }

        function resetButton(btn) {
            const isArab = btn.querySelector('.text-play').textContent.toLowerCase().includes('arab') || 
                           btn.querySelector('.icon-play').textContent.includes('play_circle');
            btn.querySelector('.icon-play').textContent = isArab ? 'play_circle' : 'record_voice_over';
            btn.querySelector('.text-play').textContent = isArab ? 'Arab' : 'Gorontalo';
        }

    </script>

    @php
        $playlistArray = $ayats->map(function($ayat) {
            return [
                'surah_no' => $ayat->no_surah,
                'ayat_no' => $ayat->nomorAyat,
                'surah_name' => $ayat->surah->nama_latin,
                'audio_arab' => $ayat->audioArabs->first() ? asset('storage/' . $ayat->audioArabs->first()->file_path_arab) : null,
                'audio_gto' => $ayat->audioGorontalos->first() ? asset('storage/' . $ayat->audioGorontalos->first()->file_path_gorontalo) : null
            ];
        })->values()->all();
    @endphp
    <script>

        // Injeksi data yang sudah matang dari PHP
        const G_TOTAL_AYAT = {{ count($ayats) }}; 

        // State Global Player
        
        const playlistData = @json($playlistArray);

        let playlist = [];
        let currentIndex = 0;
        let isGlobalPlaying = false;
        let globalAudio = new Audio();

        const globalPlayerUI = document.getElementById('globalAudioPlayer');
        const headerBtnIcon = document.querySelector('.icon-play-all');
        const mainPlayPauseBtn = document.getElementById('mainPlayPauseBtn');
        const playerTitle = document.getElementById('playerTitle');
        const audioSeeker = document.getElementById('audioSeeker');
        const currentTimeDisplay = document.getElementById('currentTimeDisplay');
        const totalTimeDisplay = document.getElementById('totalTimeDisplay');

        function buildPlaylist() {
            playlist = [];
            playlistData.forEach(item => {
                if(item.audio_arab) {
                    playlist.push({
                        src: item.audio_arab,
                        title: `${item.surah_name} : ${item.ayat_no}`,
                        label: 'Murottal Arab'
                    });
                }
                if(item.audio_gto) {
                    playlist.push({
                        src: item.audio_gto,
                        title: `${item.surah_name} : ${item.ayat_no}`,
                        label: 'Terjemahan Gorontalo'
                    });
                }
            });
        }

        function loadAndPlayTrack(index) {
            if (index < 0 || index >= playlist.length) {
                closeGlobalPlayer();
                return;
            }

            currentIndex = index;
            const track = playlist[currentIndex];

            playerTitle.innerHTML = `${track.title}<br>${track.label}`;
            audioSeeker.value = 0;
            currentTimeDisplay.innerHTML = "00:00";
            totalTimeDisplay.innerHTML = "00:00";

            globalAudio.src = track.src;

            globalAudio.play().then(() => {
                isGlobalPlaying = true;
                updatePlayPauseUI(true);

                if (typeof currentAudio !== 'undefined' && currentAudio) {
                    currentAudio.pause();
                    if (typeof currentButton !== 'undefined') resetButtonState(currentButton);
                }
            }).catch(err => {
                console.warn(`File audio tidak dapat diputar. Skip...`);
                setTimeout(() => { nextTrack(); }, 1000);
            });
        }

        function togglePlayAll() {
            if (playlist.length === 0) {
                buildPlaylist();
                if(playlist.length === 0) {
                    alert("Tidak ada audio yang tersedia di juz ini.");
                    return;
                }
            }

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

        function nextTrack() { loadAndPlayTrack(currentIndex + 1); }
        function prevTrack() { loadAndPlayTrack(currentIndex - 1); }

        function closeGlobalPlayer() {
            globalAudio.pause();
            isGlobalPlaying = false;
            updatePlayPauseUI(false);
            globalPlayerUI.classList.add('translate-y-full');
        }

        globalAudio.addEventListener('timeupdate', () => {
            if (!isNaN(globalAudio.duration)) {
                const progressPercent = (globalAudio.currentTime / globalAudio.duration) * 100;
                audioSeeker.value = progressPercent;
                currentTimeDisplay.innerHTML = formatTime(globalAudio.currentTime);
                totalTimeDisplay.innerHTML = formatTime(globalAudio.duration);
            }
        });

        globalAudio.addEventListener('ended', () => { nextTrack(); });

        audioSeeker.addEventListener('input', (e) => {
            if (!isNaN(globalAudio.duration)) {
                const seekTo = (e.target.value / 100) * globalAudio.duration;
                globalAudio.currentTime = seekTo;
            }
        });

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }
    </script>
</body>

</html>