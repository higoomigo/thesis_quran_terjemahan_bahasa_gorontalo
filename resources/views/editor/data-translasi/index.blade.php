{{-- resources/views/editor/data-terjemahan/index.blade.php --}}
@extends('layouts.app_editor')

@section('title', 'Manajemen Terjemahan')

@section('content')
<main class="flex-1 ml-64 p-6 bg-gray-50/50 min-h-screen">
    <!-- Header & Breadcrumbs -->
    <header class="max-w-6xl mx-auto mb-6">
        <nav class="flex items-center gap-2 text-gray-500 mb-4">
            <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Editor</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs text-emerald-700 font-medium">Manajemen Terjemahan</span>
        </nav>
        <div class="flex justify-between items-end flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">
                            translate
                        </span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Manajemen Terjemahan</h2>
                </div>
                <p class="text-gray-600 mt-1">Pilih surah di bawah ini untuk menginput atau mengedit teks terjemahan Gorontalo pada ayat.</p>
            </div>
        </div>
    </header>

    <!-- Search Bar -->
    <div class="max-w-6xl mx-auto bg-white p-4 rounded-t-2xl border-x border-t border-gray-200 shadow-sm flex flex-wrap items-center justify-between gap-4 relative z-10">
        <div class="relative flex-1 max-w-xl">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
            <input id="searchInput" class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-12 pr-4 text-sm font-medium text-gray-700 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all" placeholder="Cari nama surah atau arti surah..." type="text" />
        </div>
        <div class="text-sm font-semibold text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            Total: <span class="text-emerald-700">{{ count($surahs) }}</span> Surah
        </div>
    </div>

    <!-- Data List Surah -->
    <div class="max-w-6xl mx-auto bg-white border border-gray-200 rounded-b-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 border-b border-gray-200">
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider w-20 text-center">No</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">Nama Surah</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider">Arti</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-center">Jumlah Ayat</th>
                        <th class="px-6 py-4 font-bold text-xs uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="surahTableBody">
                    @forelse($surahs as $surah)
                        <tr class="hover:bg-emerald-50/50 transition-colors group surah-row">
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-gray-400 group-hover:text-emerald-600">{{ $surah->no_surah }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <p class="text-base font-bold text-gray-800 surah-name">{{ $surah->nama_latin }}</p>
                                        <p class="text-xs font-semibold text-emerald-600 uppercase tracking-widest mt-0.5">{{ $surah->arabic_name ?? 'Arabic' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-600 surah-arti">{{ $surah->arti }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">
                                    {{ $surah->jumlah_ayat }} Ayat
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{-- Ganti route di bawah ini sesuai dengan route halaman form input terjemahan lu --}}
                                <a href="{{ route('editor.data-terjemahan.show', $surah->no_surah) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-sm font-bold hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all shadow-sm active:scale-95">
                                    <span class="material-symbols-outlined text-[18px]">edit_document</span>
                                    Input / Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">menu_book</span>
                                    <h3 class="text-xl font-bold text-gray-700 mb-1">Data Surah Kosong</h3>
                                    <p class="text-gray-500">Belum ada data surah yang tersedia di database.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    
                    <!-- Pesan jika hasil pencarian tidak ditemukan -->
                    <tr id="noSearchResult" class="hidden">
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">search_off</span>
                                <p class="text-gray-600 font-medium">Surah tidak ditemukan</p>
                                <p class="text-sm text-gray-400 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Script Pencarian Real-Time Client Side -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const surahRows = document.querySelectorAll('.surah-row');
        const noSearchResult = document.getElementById('noSearchResult');

        searchInput.addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            let visibleCount = 0;

            surahRows.forEach(row => {
                const name = row.querySelector('.surah-name').textContent.toLowerCase();
                const arti = row.querySelector('.surah-arti').textContent.toLowerCase();

                if (name.includes(searchTerm) || arti.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Tampilkan pesan kosong jika tidak ada hasil
            if (visibleCount === 0 && surahRows.length > 0) {
                noSearchResult.classList.remove('hidden');
            } else {
                noSearchResult.classList.add('hidden');
            }
        });
    });
</script>
@endsection