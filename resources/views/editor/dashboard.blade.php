{{-- resources/views/editor/dashboard/index.blade.php --}}
@extends('layouts.app_editor')

@section('title', $title ?? 'Dashboard Editor')

@section('content')
    <main class="flex-1 ml-64 p-6 pattern-bg min-h-screen">
        <!-- Header -->
        <header class="max-w-6xl mx-auto mb-6">
            <nav class="flex items-center gap-2 text-gray-500 mb-4">
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs text-emerald-700 font-medium">Dashboard Editor</span>
            </nav>
            <div class="flex justify-between items-end flex-wrap gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <h2 class="text-4xl font-bold text-emerald-800">Dashboard Editor</h2>
                        <span class="material-symbols-outlined text-4xl text-emerald-500"
                            style="font-variation-settings: 'FILL' 1;">
                            space_dashboard
                        </span>
                    </div>
                    <p class="text-gray-600">Selamat datang, Editor. Kelola antrean publikasi terjemahan Al-Qur'an bahasa
                        Gorontalo.</p>
                </div>
                <div class="flex items-center gap-2 bg-white px-3 py-2 rounded-lg shadow-sm border border-gray-200">
                    <span class="material-symbols-outlined text-emerald-600">today</span>
                    <span class="text-sm text-gray-600">{{ now()->format('d F Y') }}</span>
                </div>
            </div>
        </header>

        <!-- Stats Cards -->
        <section class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card Antrean -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                        <span class="material-symbols-outlined text-yellow-600">pending_actions</span>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $totalAntrean ?? 0 }}</span>
                </div>
                <h3 class="text-gray-700 font-semibold mt-3">Antrean Publikasi</h3>
                <p class="text-xs text-gray-400 mt-1">Usulan yang menunggu keputusan publikasi</p>
            </div>

            <!-- Card Total Tayang -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $totalPublikasi ?? 0 }}</span>
                </div>
                <h3 class="text-gray-700 font-semibold mt-3">Total Tayang</h3>
                <p class="text-xs text-gray-400 mt-1">Usulan yang sudah dipublikasikan</p>
            </div>

            <!-- Card Validator Aktif -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-600">groups</span>
                    </div>
                    <span class="text-3xl font-bold text-gray-800">{{ $tim }}</span>
                </div>
                <h3 class="text-gray-700 font-semibold mt-3">Tim Editor Aktif</h3>
                <p class="text-xs text-gray-400 mt-1">Sedang bertugas</p>
            </div>

        </section>
        </section>

        <!-- Daftar Antrean Terbaru -->
        <div class="max-w-6xl mx-auto bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Antrean Publikasi Terbaru</h3>
                <a href="{{ route('editor.antrean.index') }}"
                    class="text-sm text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                    Lihat semua <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-600 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-sm font-semibold">Ayat</th>
                            <th class="px-6 py-3 text-sm font-semibold">Usulan</th>
                            <th class="px-6 py-3 text-sm font-semibold">Pengirim</th>
                            <th class="px-6 py-3 text-sm font-semibold">Tanggal Validasi</th>
                            <th class="px-6 py-3 text-sm font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($antreanTerbaru ?? [] as $item)
                            <tr class="hover:bg-emerald-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-emerald-700">QS
                                        {{ $item->ayat->no_surah ?? '' }}:{{ $item->ayat->nomorAyat ?? '' }}</span>
                                    <p class="text-xs text-gray-500">{{ $item->ayat->surah->nama_latin ?? 'Surah' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm italic line-clamp-2">"{{ Str::limit($item->usulan_teks ?? '', 80) }}"
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold">
                                            {{ substr($item->nama_pengusul ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="text-sm">{{ $item->nama_pengusul ?? 'Anonim' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $item->validated_at ? $item->validated_at->diffForHumans() : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('editor.antrean.show', $item->id) }}"
                                        class="text-emerald-600 hover:bg-emerald-50 p-2 rounded-full inline-block transition-colors"
                                        title="Tinjau">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <span class="material-symbols-outlined text-4xl mb-2">inbox</span>
                                    <p>Tidak ada antrean publikasi saat ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
