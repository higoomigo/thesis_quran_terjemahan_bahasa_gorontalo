{{-- resources/views/editor/antrean/index.blade.php --}}
@extends('layouts.app_editor')

@section('title', $title ?? 'Antrean Publikasi')

@section('content')
<main class="flex-1 ml-64 p-6 pattern-bg min-h-screen">
    <!-- Header & Breadcrumbs -->
    <header class="max-w-6xl mx-auto mb-6">
        <nav class="flex items-center gap-2 text-gray-500 mb-4">
            <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Editor</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs text-emerald-700 font-medium">Antrean Publikasi</span>
        </nav>
        <div class="flex justify-between items-end flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <h2 class="text-4xl font-bold text-emerald-800">Usulan telah Dipublikasi</h2>
                    <span class="material-symbols-outlined text-4xl text-emerald-500" style="font-variation-settings: 'FILL' 1;">
                        history
                    </span>
                </div>
                <p class="text-gray-600">Daftar usulan yang telah berhasil dipublikasikan ke sistem.</p>
            </div>
        </div>
    </header>

    <!-- Search & Filter -->
    <div class="max-w-6xl mx-auto bg-gray-50 p-4 rounded-t-xl border-x border-t border-gray-200 flex flex-wrap items-center justify-between gap-4">
        <div class="relative flex-1 max-w-md">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
            <input id="search" name="search" class="w-full bg-white border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none" placeholder="Cari usulan teks atau pengirim..." type="text" value="{{ request('search') }}" onkeyup="if(event.key === 'Enter') window.location.href='{{ route('editor.antrean.index') }}?search='+this.value" />
        </div>
        @if(request('search'))
            <a href="{{ route('editor.antrean.index') }}" class="text-sm text-gray-500 hover:text-emerald-600 flex items-center gap-1"><span class="material-symbols-outlined text-sm">close</span>Reset Filter</a>
        @endif
    </div>

    <!-- Data Table -->
    <div class="max-w-6xl mx-auto bg-white border border-gray-200 rounded-b-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 border-b border-gray-200">
                        <th class="px-6 py-4 font-semibold text-sm">Ayat</th>
                        <th class="px-6 py-4 font-semibold text-sm">Usulan (Hulontalo)</th>
                        <th class="px-6 py-4 font-semibold text-sm">Pengirim</th>
                        <th class="px-6 py-4 font-semibold text-sm">Tgl Validasi</th>
                        <th class="px-6 py-4 font-semibold text-sm text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($antrean as $item)
                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <span class="text-sm font-bold text-emerald-700">QS {{ $item->ayat->no_surah ?? '?' }}:{{ $item->ayat->nomorAyat ?? '?' }}</span>
                                <p class="text-xs text-gray-500">{{ $item->ayat->surah->nama_latin ?? 'Surah' }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="max-w-xs">
                                    <p class="text-sm italic line-clamp-2">"{{ Str::limit($item->usulan_teks, 100) }}"</p>
                                    <p class="text-xs text-gray-500 mt-1">Usulan perbaikan terjemahan</p>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-[10px]">
                                        {{ strtoupper(substr($item->nama_pengusul, 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="text-sm">{{ $item->nama_pengusul }}</span>
                                        <p class="text-xs text-gray-400">{{ $item->no_hp }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-xs text-gray-500">{{ $item->validated_at ? $item->validated_at->diffForHumans() : '-' }}</span>
                                <p class="text-xs text-gray-400">{{ $item->validated_at ? $item->validated_at->format('d/m/Y H:i') : '-' }}</p>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <a href="{{ route('editor.antrean.show', $item->id) }}" class="text-emerald-600 hover:bg-emerald-50 p-2 rounded-full inline-block transition-colors" title="Tinjau Usulan">
                                    <span class="material-symbols-outlined text-xl">rate_review</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">inbox</span>
                                    <p class="text-gray-500">Belum ada antrean publikasi</p>
                                    <p class="text-xs text-gray-400 mt-1">Usulan yang sudah divalidasi akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-500">Menampilkan {{ $antrean->firstItem() ?? 0 }} - {{ $antrean->lastItem() ?? 0 }} dari {{ $antrean->total() }} usulan</p>
            <div class="flex items-center gap-1">
                {{ $antrean->links() }}
            </div>
        </div>
    </div>
</main>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection