<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Qur'an Gorontalo - {{ $surah->nama_latin ?? 'Baca' }}</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;family=Noto+Serif:wght@400;700&amp;display=swap"
        rel="stylesheet" />


    <style>
        body {
            background-color: #fafafa;
        }

        .ayah-card {
            transition: all 0.2s ease;
        }

        .arabic-text {
            font-family: 'Noto Serif', serif;
            font-size: 36px;
            line-height: 2.2;
            direction: rtl;
            text-align: right;
            color: #064e3b;
        }

        .translation-text {
            font-family: 'Inter', sans-serif;
            font-size: 20px;
            line-height: 1.8;
            color: #334155;
        }

        .translation-text-indo {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            line-height: 1.8;
            color: #525e70;
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
    @include('partials.pwa')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-on-surface antialiased min-h-screen flex flex-col relative overflow-x-hidden">
    <!-- Loading Screen -->
    {{-- <div id="loading-screen" class="fixed inset-0 z-[99999] flex flex-col items-center justify-center bg-[#f9f9ff]">
        <div class="relative flex items-center justify-center">
            <div class="w-16 h-16 border-4 border-emerald-200 border-t-emerald-900 rounded-full animate-spin"></div>
        </div>
        <p class="mt-4 text-xs md:text-sm font-bold text-slate-600 tracking-wider uppercase animate-pulse">Sabaripo...</p>
    </div> --}}
    {{-- @dd($pembacaGorontalo) --}}
    <!-- Progress Bar -->
    <div class="fixed top-0 left-0 w-full h-1.5 bg-gray-200 z-[100]">
        <div id="readingProgress" class="h-full bg-primary transition-all duration-150 ease-out" style="width: 0%;">
        </div>
    </div>

    <!-- Sidebar Off-Canvas -->
    <div id="sidebarBackdrop"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[60] opacity-0 pointer-events-none transition-opacity duration-300">
    </div>
    <aside id="sidebarNav"
        class="fixed top-0 left-0 h-screen w-80 bg-white z-[70] transform -translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
        <div class="p-5 border-b border-gray-100 bg-primary flex justify-between items-center text-white">
            <div>
                <h3 class="font-bold text-lg tracking-wide flex items-center gap-2"><span
                        class="material-symbols-outlined">menu_book</span> Daftar Surah</h3>
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
                            {{ $nomorUrut }}</div>
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

    <main class="flex-1 flex flex-col w-full relative z-10 pt-1.5">

        <!-- HEADER KONTROL -->
        <header
            class="sticky top-1.5 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200 px-4 sm:px-8 py-4 flex items-center justify-between shadow-sm transition-all">
            <div class="flex items-center gap-2 sm:gap-4">
                <a href="{{ url('/') }}"
                    class="flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl text-primary font-bold transition-colors shadow-sm"
                    title="Kembali ke Beranda">
                    <span class="material-symbols-outlined">home</span>
                </a>
                <button id="openSidebarBtn"
                    class="flex items-center gap-2 px-3 sm:px-4 py-2.5 bg-surface-container-low hover:bg-surface-container border border-gray-200 rounded-xl text-primary font-bold transition-colors shadow-sm">
                    <span class="material-symbols-outlined">format_list_bulleted</span>
                    <span class="hidden sm:block text-sm">Daftar Surah</span>
                </button>
                <div class="h-8 w-px bg-gray-300 hidden lg:block"></div>
                <div class="hidden lg:block">
                    <h1 class="text-xl font-bold text-gray-900 leading-tight">QS
                        {{ $surah->nama_latin ?? 'Nama Surah' }}</h1>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        {{ $surah->arti ?? 'Arti Surah' }}</p>
                </div>
            </div>

            <!-- Tombol Pengaturan & Play All -->
            <div class="flex items-center gap-1.5 sm:gap-2 bg-gray-50 p-1.5 rounded-xl border border-gray-200">
                <button onclick="toggleSettingsModal()"
                    class="w-10 h-10 rounded-lg flex items-center justify-center text-gray-600 hover:bg-white hover:shadow-sm transition-all"
                    title="Pengaturan Tampilan">
                    <span class="material-symbols-outlined">tune</span>
                </button>
                <div class="h-5 w-px bg-gray-300"></div>
                <button id="btnPlayAll" onclick="togglePlayAll()"
                    class="w-10 h-10 rounded-lg flex items-center justify-center bg-emerald-700 text-white shadow-sm hover:bg-emerald-800 transition-all"
                    title="Putar Seluruh Ayat">
                    <span class="material-symbols-outlined icon-play-all">play_arrow</span>
                </button>
            </div>
        </header>

        <!-- AREA TEKS AYAT -->
        <div class="w-full max-w-5xl mx-auto px-6 py-12 flex flex-col gap-8" id="readingContainer">

            @if (($surah->no_surah ?? 1) != 1 && ($surah->no_surah ?? 1) != 9)
                <div class="flex justify-center mb-10 pb-10 border-b border-gray-200">
                    <div class="text-center">
                        <p class="arabic-text !text-4xl">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
                        <p class="text-sm font-semibold text-gray-600 mt-4 uppercase tracking-widest">Wolo tanggulo
                            Allah ta Labatutu Mottoli’anga boli Labatutu Mommonuwa</p>
                    </div>
                </div>
            @endif

            @forelse($ayats ?? [] as $ayat)
                <div class="ayah-card flex flex-col gap-5 group border-b border-gray-300 pb-8 relative scroll-mt-32"
                    id="ayat-{{ $ayat->nomorAyat }}">

                    <div class="flex items-center justify-between w-full">
                        <span
                            class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-800 font-bold text-sm border border-emerald-100">
                            Ayat {{ $ayat->nomorAyat }}
                        </span>
                    </div>

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

                    <!-- Target Class untuk Teks & Tombol (Supaya bisa di-hide via JS) -->
                    <div class="w-full bg-white rounded-2xl p-6 flex flex-col gap-4">
                        <p class="translation-text target-goro font-normal text-primary">{{ $ayat->teks_gorontalo }}
                        </p>
                        <p class="translation-text-indo target-indo font-light text-gray-600">
                            {!! $ayat->formatted_teks_indo !!}
                        </p>

                        <div class="h-px w-full bg-gray-100"></div>

                        <!-- Target Audio Container -->
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-3 target-audio">
                            @php
                                $audioArab = $ayat->audioArabs->first();
                                $audioGto = $ayat->audioGorontalos->first();
                                $arabUrl = $audioArab?->file_path
                                    ? asset('storage/' . ltrim($audioArab->file_path, '/'))
                                    : '';
                                $gorUrl = $audioGto?->file_path
                                    ? asset('storage/' . ltrim($audioGto->file_path, '/'))
                                    : '';
                            @endphp

                            <!-- Container dengan data-ayat buat target update AJAX -->
                            <div class="flex flex-wrap items-center gap-x-6 gap-y-3 audio-buttons-container"
                                data-ayat="{{ $ayat->nomorAyat }}">
                                <button type="button" onclick="playAudio('{{ $arabUrl }}', this)"
                                    data-text="Arab" data-icon="play_circle" data-audio-url="{{ $arabUrl }}"
                                    class="audio-btn text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1.5 font-bold text-sm {{ $arabUrl ? '' : 'opacity-40 cursor-not-allowed' }}">
                                    <span class="material-symbols-outlined text-[20px] icon-play">play_circle</span>
                                    <span class="text-play">Arab</span>
                                </button>

                                <button type="button" onclick="playAudio('{{ $gorUrl }}', this)"
                                    data-text="Gorontalo" data-icon="record_voice_over"
                                    data-audio-url="{{ $gorUrl }}"
                                    class="audio-btn text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1.5 font-bold text-sm {{ $gorUrl ? '' : 'opacity-40 cursor-not-allowed' }}">
                                    <span
                                        class="material-symbols-outlined text-[20px] icon-play">record_voice_over</span>
                                    <span class="text-play">Gorontalo</span>
                                </button>
                            </div>

                            <button type="button"
                                onclick="copyAyat({{ $ayat->nomorAyat }}, `{{ addslashes($ayat->Arab) }}`, `{{ addslashes($ayat->teks_gorontalo) }}`)"
                                class="text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1.5 font-bold text-sm ml-4 border-l border-gray-200 pl-4">
                                <span class="material-symbols-outlined text-[20px]">content_copy</span> Salin
                            </button>

                            <a href="{{ route('usulan.index', ['surah_id' => $surah->no_surah, 'ayat_id' => $ayat->nomorAyat]) }}"
                                class="text-gray-500 hover:text-blue-600 transition-colors flex items-center gap-1.5 font-bold text-sm sm:ml-auto">
                                <span class="material-symbols-outlined text-[20px]">history_edu</span> Histori Usulan
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
            {{-- @dd($pembacaGorontalo) --}}
        </div>
    </main>

    <!-- Modal Backdrop -->
    <div id="settingsBackdrop" onclick="toggleSettingsModal()"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[80] opacity-0 pointer-events-none transition-opacity duration-300">
    </div>

    <!-- Bottom Sheet Modal Pengaturan -->
    <!-- MODAL PENGATURAN BACAAN (UNIVERSAL DESIGN - MODERN & ACCESSIBLE) -->
    <div id="settingsModal"
        class="fixed bottom-0 left-0 w-full bg-white rounded-t-[32px] shadow-[0_-10px_40px_rgba(0,0,0,0.1)] z-[90] transform translate-y-full transition-transform duration-500 max-h-[85vh] overflow-y-auto custom-scrollbar font-sans">

        <!-- Handle Bar (Garis penarik di atas modal) -->
        <div
            class="sticky top-0 bg-white/90 backdrop-blur-sm z-20 pt-4 pb-2 px-6 flex flex-col items-center justify-center border-b border-gray-100">
            <div class="w-14 h-1.5 bg-gray-200 rounded-full mb-4"></div>
            <div class="w-full flex justify-between items-center">
                <h3 class="text-2xl font-extrabold text-gray-800 tracking-tight">Pengaturan</h3>
                <button onclick="toggleSettingsModal()"
                    class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-red-50 hover:text-red-500 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
        </div>

        <div class="max-w-md mx-auto px-6 py-6 flex flex-col gap-8 relative">

            <!-- ========================================== -->
            <!-- SEGMEN 1: PENGATURAN AUDIO (KARTU MODERN)  -->
            <!-- ========================================== -->
            <div class="flex flex-col gap-4">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Sumber Audio</h4>

                {{-- KONDISI 1: JIKA AUDIO SAMA SEKALI KOSONG --}}
                @if ($langgams->isEmpty() && $pembacaGorontalo->isEmpty())
                    <div
                        class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 border border-orange-100/50 shadow-sm flex gap-4 items-start">
                        <div
                            class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0 text-orange-500">
                            <span class="material-symbols-outlined text-2xl">hourglass_empty</span>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-lg">Audio Sedang Disiapkan</p>
                            <p class="text-gray-500 text-sm mt-1 leading-relaxed">Rekaman murottal untuk surah ini
                                belum tersedia dan sedang dalam proses.</p>
                        </div>
                    </div>
                @else
                    {{-- KONDISI 2: AUDIO ARAB --}}
                    @if ($langgams->isNotEmpty())
                        <div
                            class="bg-white rounded-3xl p-5 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_25px_rgba(0,0,0,0.06)] transition-shadow">
                            <div class="flex items-center gap-3 mb-5">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                    <span class="material-symbols-outlined text-xl">queue_music</span>
                                </div>
                                <h3 class="font-bold text-gray-800 text-lg">Murottal Arab</h3>
                            </div>

                            <div class="flex flex-col gap-4">
                                <!-- Irama -->
                                <div class="relative">
                                    <select id="langgamSelect"
                                        class="w-full appearance-none rounded-2xl border border-gray-200 text-base py-3.5 pl-4 pr-10 focus:ring-4 focus:ring-blue-50 focus:border-blue-500 bg-gray-50/50 hover:bg-gray-50 cursor-pointer font-medium text-gray-700 transition-all">
                                        <option value="">Pilih Irama...</option>
                                        @foreach ($langgams as $langgam)
                                            <option value="{{ $langgam->id }}">{{ $langgam->nama }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                                </div>

                                <!-- Qari -->
                                <div class="relative">
                                    <select id="qariSelect" disabled
                                        style="background-color: #f9fafb; color: #9ca3af; cursor: not-allowed;"
                                        class="w-full appearance-none rounded-2xl border border-gray-200 text-base py-3.5 pl-4 pr-10 focus:ring-4 focus:ring-blue-50 focus:border-blue-500 font-medium transition-all duration-300">
                                        <option value="">Pilih Irama dahulu ↑</option>
                                    </select>
                                    <span
                                        class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"
                                        id="qariIcon">lock</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- KONDISI 3: AUDIO GORONTALO --}}
                    @if ($pembacaGorontalo->isNotEmpty())
                        <div
                            class="bg-white rounded-3xl p-5 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_25px_rgba(0,0,0,0.06)] transition-shadow">
                            <div class="flex items-center gap-3 mb-5">
                                <div
                                    class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                                    <span class="material-symbols-outlined text-xl">translate</span>
                                </div>
                                <h3 class="font-bold text-gray-800 text-lg">Terjemahan Hulontalo</h3>
                            </div>

                            <div class="relative">
                                <select id="pembacaGoroSelect"
                                    class="w-full appearance-none rounded-2xl border border-gray-200 text-base py-3.5 pl-4 pr-10 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 bg-gray-50/50 hover:bg-gray-50 cursor-pointer font-medium text-gray-700 transition-all">
                                    <option value="">Pilih Pelantun...</option>
                                    @foreach ($pembacaGorontalo as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                            </div>
                        </div>
                    @endif

                @endif
            </div>

            <!-- ========================================== -->
            <!-- SEGMEN 2: PENGATURAN TAMPILAN TEKS         -->
            <!-- ========================================== -->
            <div class="flex flex-col gap-4">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Ukuran Teks</h4>

                <div
                    class="bg-white rounded-3xl p-2 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] divide-y divide-gray-50">

                    <!-- Font Arab -->
                    <div class="flex justify-between items-center p-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500">
                                <span class="material-symbols-outlined text-xl">text_format</span>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">Teks Arab</p>
                                <p class="text-xs text-gray-400">Sesuaikan huruf</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 bg-gray-50 rounded-2xl p-1">
                            <button id="fontDecreaseArab"
                                class="w-10 h-10 rounded-xl bg-white shadow-sm text-gray-600 flex items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition-all active:scale-95"><span
                                    class="material-symbols-outlined text-lg">remove</span></button>
                            <span class="text-sm font-bold w-6 text-center text-gray-700">Aa</span>
                            <button id="fontIncreaseArab"
                                class="w-10 h-10 rounded-xl bg-white shadow-sm text-gray-600 flex items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition-all active:scale-95"><span
                                    class="material-symbols-outlined text-lg">add</span></button>
                        </div>
                    </div>

                    <!-- Font Terjemahan -->
                    <div class="flex justify-between items-center p-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500">
                                <span class="material-symbols-outlined text-xl">subtitles</span>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">Terjemahan</p>
                                <p class="text-xs text-gray-400">Sesuaikan huruf</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 bg-gray-50 rounded-2xl p-1">
                            <button id="fontDecreaseTrans"
                                class="w-10 h-10 rounded-xl bg-white shadow-sm text-gray-600 flex items-center justify-center hover:text-emerald-600 hover:bg-emerald-50 transition-all active:scale-95"><span
                                    class="material-symbols-outlined text-lg">remove</span></button>
                            <span class="text-sm font-bold w-6 text-center text-gray-700">Aa</span>
                            <button id="fontIncreaseTrans"
                                class="w-10 h-10 rounded-xl bg-white shadow-sm text-gray-600 flex items-center justify-center hover:text-emerald-600 hover:bg-emerald-50 transition-all active:scale-95"><span
                                    class="material-symbols-outlined text-lg">add</span></button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ========================================== -->
            <!-- SEGMEN 3: VISIBILITAS (TOGGLE SWITCH)      -->
            <!-- ========================================== -->
            <div class="flex flex-col gap-4">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Tampilan Layar</h4>

                <div
                    class="bg-white rounded-3xl p-2 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] divide-y divide-gray-50 mb-8">

                    <!-- Toggle Gorontalo -->
                    <div class="flex justify-between items-center p-4">
                        <div class="pr-4">
                            <p class="font-bold text-gray-800">Bahasa Hulontalo</p>
                            <p class="text-xs text-gray-400">Tampilkan teks lokal</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggleGoro" class="sr-only peer" checked>
                            <div
                                class="w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-emerald-500 shadow-inner">
                            </div>
                        </label>
                    </div>

                    <!-- Toggle Indonesia -->
                    <div class="flex justify-between items-center p-4">
                        <div class="pr-4">
                            <p class="font-bold text-gray-800">Bahasa Indonesia</p>
                            <p class="text-xs text-gray-400">Tampilkan teks nasional</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggleIndo" class="sr-only peer" checked>
                            <div
                                class="w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500 shadow-inner">
                            </div>
                        </label>
                    </div>

                    <!-- Toggle Audio -->
                    <div class="flex justify-between items-center p-4">
                        <div class="pr-4">
                            <p class="font-bold text-gray-800">Pemutar Audio</p>
                            <p class="text-xs text-gray-400">Tombol putar tiap ayat</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="toggleAudioBtn" class="sr-only peer" checked>
                            <div
                                class="w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-purple-500 shadow-inner">
                            </div>
                        </label>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- MODAL CATATAN KAKI (RAMAH LANSIA) -->
    <!-- MODAL CATATAN KAKI (RAMAH LANSIA + KONTEKS AYAT) -->
    <div id="footnoteModal"
        class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white w-full max-w-lg rounded-[28px] shadow-2xl overflow-hidden animate-fade-in">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-emerald-50/50">
                <div class="flex items-center gap-3">
                    <span id="fnModalNomor"
                        class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-extrabold text-sm shadow-sm">1</span>
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800 leading-tight">Catatan Kaki</h3>
                        <p id="fnModalAyat" class="text-xs font-semibold text-emerald-700">Ayat 1</p>
                    </div>
                </div>
                <button type="button" onclick="closeFootnoteModal()"
                    class="w-10 h-10 rounded-full bg-white text-gray-500 hover:bg-red-50 hover:text-red-500 flex items-center justify-center transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 max-h-[65vh] overflow-y-auto space-y-5">
                <!-- Kotak Terjemahan Bahasa Indonesia -->
                <div class="bg-emerald-50/60 border border-emerald-100 rounded-2xl p-4">
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-emerald-700 mb-1.5">
                        Terjemahan Bahasa Indonesia
                    </span>
                    <p id="fnModalTerjemahan" class="text-gray-800 text-base leading-relaxed italic font-normal"></p>
                </div>

                <!-- Penjelasan Catatan Kaki -->
                <div>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1.5">
                        Penjelasan
                    </span>
                    <p id="fnModalIsi" class="text-gray-700 text-base text-justify sm:text-lg leading-relaxed font-normal"></p>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                <button type="button" onclick="closeFootnoteModal()"
                    class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base transition-all active:scale-95">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Global Audio Player -->
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

    <!-- Injeksi Variabel PHP ke JS -->
    <script>
        const G_SURAH_NO = {{ $surah->no_surah ?? 1 }};
        const G_API_URL = "/api/get-audio";
    </script>

    <!-- Panggil File JS Eksternal -->
    <script src="{{ asset('js/mushaf.js') }}"></script>

</body>

</html>
