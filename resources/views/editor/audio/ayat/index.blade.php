{{-- resources/views/editor/audio/ayat/index.blade.php --}}
@extends('layouts.app_editor')

@section('title', 'Kelola Audio Per Ayat')

@section('content')
<main class="flex-1 ml-64 px-6 bg-gray-50/50 min-h-screen ">
    <!-- Header & Breadcrumbs -->
    <header class="max-w-6xl mx-auto mb-6">
        <nav class="flex items-center gap-2 text-gray-500 mb-4">
            <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Editor</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Manajemen Audio</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs text-emerald-700 font-medium">Audio Per Ayat</span>
        </nav>
        <div class="flex justify-between items-end flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">
                            graphic_eq
                        </span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Kelola Audio Per Ayat</h2>
                </div>
                <p class="text-gray-600 mt-1">Pilih surah di bawah ini untuk mengelola, mengunggah ZIP, atau merevisi audio per ayat.</p>
            </div>
        </div>
    </header>

    <!-- Search Bar (Sekarang pakai Form) -->
    <form id="searchForm" method="GET" action="{{ route('editor.audio.ayat.index') }}" class="max-w-6xl mx-auto bg-white p-4 rounded-t-2xl border-x border-t border-gray-200 shadow-sm flex flex-wrap items-center justify-between gap-4 relative z-10">
        <div class="relative flex-1 max-w-xl flex gap-2">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
                <input name="search" value="{{ request('search') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-12 pr-4 text-sm font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all" placeholder="Cari nama surah atau arti surah..." type="text" />
            </div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 rounded-xl font-bold transition-all shadow-sm active:scale-95">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('editor.audio.ayat.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-3 rounded-xl font-bold transition-all flex items-center justify-center">
                    Reset
                </a>
            @endif
        </div>
        <div class="text-sm font-semibold text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            Total: <span class="text-emerald-700">{{ $surahs instanceof \Illuminate\Pagination\LengthAwarePaginator ? $surahs->total() : count($surahs) }}</span> Surah
        </div>
    </form>

    <!-- BUNGKUS DATA CONTAINER BUAT AJAX -->
    <div id="data-container">
        <!-- Data List Surah -->
        <div class="max-w-6xl mx-auto bg-white border border-gray-200 rounded-b-2xl overflow-hidden shadow-sm mb-12 ">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 border-b border-gray-200">
                            <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider w-20 text-center">No</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">Nama Surah</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">Arti</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-center">Jumlah Ayat</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-center">Aksi Pengelolaan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($surahs as $surah)
                            <tr class="hover:bg-emerald-50/50 transition-colors group">
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-bold text-gray-400 group-hover:text-emerald-600">{{ $surah->no_surah }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <p class="text-base font-bold text-gray-800">{{ $surah->nama_latin }}</p>
                                            <p class="text-xs font-semibold text-emerald-600 uppercase tracking-widest mt-0.5">{{ $surah->arabic_name ?? 'Arabic' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-gray-600">{{ $surah->arti }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">
                                        {{ $surah->jumlah_ayat }} Ayat
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('editor.audio.ayat.show', $surah->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-sm font-bold hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all shadow-sm active:scale-95">
                                        <span class="material-symbols-outlined text-[18px]">audio_file</span>
                                        Kelola Audio
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">search_off</span>
                                        <h3 class="text-xl font-bold text-gray-700 mb-1">Surah Tidak Ditemukan</h3>
                                        <p class="text-gray-500 text-sm">Coba gunakan kata kunci pencarian yang lain.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- PAGINATION (Aman dipakai kalau pakai query ->paginate()) -->
                @if($surahs instanceof \Illuminate\Pagination\LengthAwarePaginator && $surahs->hasPages())
                    <div class="p-4 border-t border-gray-200 bg-gray-50">
                        {{ $surahs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

<!-- SCRIPT AJAX FETCH (Tanpa Reload) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchForm = document.getElementById('searchForm');
        const dataContainer = document.getElementById('data-container');

        // 1. Tangani pencarian form (Submit)
        if (searchForm) {
            searchForm.addEventListener('submit', function (e) {
                e.preventDefault(); 
                const url = new URL(this.action);
                url.search = new URLSearchParams(new FormData(this)).toString();
                fetchData(url.toString());
            });
        }

        // 2. Tangani klik tombol Pagination
        if (dataContainer) {
            dataContainer.addEventListener('click', function (e) {
                const link = e.target.closest('nav a'); // Tangkap klik hanya pada link pagination
                if (link && link.href) {
                    e.preventDefault();
                    fetchData(link.href);
                }
            });
        }

        // 3. Fungsi utama penarik data HTML
        function fetchData(url) {
            // Efek loading tipis
            dataContainer.style.opacity = '0.5';
            dataContainer.style.pointerEvents = 'none';

            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('data-container');

                    if (newContent) {
                        dataContainer.innerHTML = newContent.innerHTML;
                        window.history.pushState({}, '', url); 
                    }
                    
                    dataContainer.style.opacity = '1';
                    dataContainer.style.pointerEvents = 'auto';
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    dataContainer.style.opacity = '1';
                    dataContainer.style.pointerEvents = 'auto';
                });
        }

        // 4. Tangani tombol Back/Forward di browser
        window.addEventListener('popstate', function () {
            fetchData(window.location.href);
        });
    });
</script>
@endsection