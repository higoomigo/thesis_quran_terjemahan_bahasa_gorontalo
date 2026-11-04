{{-- resources/views/validator/dashboard.blade.php --}}
@extends('layouts.app')
@section('content')
    <main class="flex-1 ml-64 p-6 pattern-bg min-h-screen">
        <!-- Top Header -->
        <header class="max-w-7xl mx-auto mb-6">
            <nav class="flex items-center gap-2 text-gray-500 mb-4">
                <span class="text-xs text-emerald-700 font-medium">Validator Dashboard</span>
            </nav>
            <div class="flex justify-between items-end flex-wrap gap-4">
                <div>
                    <h2 class="text-4xl font-bold text-emerald-800 mb-2">Validator Dashboard</h2>
                    <p class="text-gray-600">Tinjau, diskusikan, dan validasi usulan terjemahan bahasa Gorontalo yang
                        ditugaskan kepadamu.</p>
                </div>
                <div class="flex gap-4">
                    <button onclick="refreshData()"
                        class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-medium hover:bg-emerald-200 transition-colors">
                        <span class="material-symbols-outlined text-lg">refresh</span>
                        Refresh
                    </button>
                </div>
            </div>
        </header>

        <!-- Stats Overview -->
        <section class="max-w-7xl mx-auto mb-8 space-y-4">

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- BARIS 1: 3 KARTU UTAMA (Headline) --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-12 gap-4">

        {{-- Total Diambil --}}
        <div class="col-span-4 bg-gradient-to-br from-emerald-700 to-emerald-800 text-white rounded-xl p-6 shadow-lg relative overflow-hidden">
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-white/10" style="font-size: 8rem;">inventory_2</span>
            <div class="relative">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-2xl">assignment_ind</span>
                    <span class="text-[10px] uppercase tracking-wider bg-white/20 px-2 py-1 rounded-full font-bold">Total</span>
                </div>
                <p class="text-xs uppercase tracking-wider opacity-80 font-semibold">Usulan yang Anda Ambil</p>
                <h3 class="text-5xl font-bold mt-2 leading-none">
                    {{ number_format($statistik['total_diklaim']) }}
                </h3>
                <p class="text-xs opacity-70 mt-3">Semua usulan yang ditugaskan kepadamu</p>
            </div>
        </div>

        {{-- Sedang Proses --}}
        <div class="col-span-4 bg-white border border-gray-200 rounded-xl p-6 shadow-sm relative overflow-hidden">
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-yellow-500/10" style="font-size: 8rem;">pending</span>
            <div class="relative">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-yellow-500 text-2xl">hourglass_top</span>
                    <span class="text-[10px] uppercase tracking-wider bg-yellow-50 text-yellow-600 px-2 py-1 rounded-full font-bold">Proses</span>
                </div>
                <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold">Sedang Diproses</p>
                <h3 class="text-5xl font-bold text-emerald-800 mt-2 leading-none">
                    {{ number_format($statistik['menunggu']) }}
                </h3>
                <p class="text-xs text-gray-400 mt-3">Belum kamu beri vote</p>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="col-span-4 bg-white border border-gray-200 rounded-xl p-6 shadow-sm relative overflow-hidden">
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-green-500/10" style="font-size: 8rem;">task_alt</span>
            <div class="relative">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-green-500 text-2xl">check_circle</span>
                    <span class="text-[10px] uppercase tracking-wider bg-green-50 text-green-600 px-2 py-1 rounded-full font-bold">Selesai</span>
                </div>
                <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold">Sudah Selesai</p>
                <h3 class="text-5xl font-bold text-emerald-800 mt-2 leading-none">
                    {{ number_format($statistik['divote']) }}
                </h3>
                <p class="text-xs text-gray-400 mt-3">Total vote yang sudah kamu berikan</p>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- BARIS 2: PENJABARAN (Breakdown dari total) --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-emerald-700 text-lg">insights</span>
            <p class="text-xs uppercase tracking-wider text-gray-500 font-bold">Detail Usulan yang Anda Kerjakan</p>
        </div>

        <div class="grid grid-cols-3 gap-4">

            {{-- Menunggu --}}
            <div class="flex items-center gap-3 p-3 rounded-lg bg-yellow-50/60 border border-yellow-100">
                <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-yellow-600">schedule</span>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Menunggu</p>
                    <p class="text-xl font-bold text-emerald-800 leading-tight">{{ number_format($statistik['menunggu']) }}</p>
                </div>
            </div>

            {{-- Sudah Divote --}}
            {{-- <div class="flex items-center gap-3 p-3 rounded-lg bg-blue-50/60 border border-blue-100">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-blue-600">how_to_vote</span>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Sudah Divote</p>
                    <p class="text-xl font-bold text-emerald-800 leading-tight">{{ number_format($statistik['divote']) }}</p>
                </div>
            </div> --}}

            {{-- Diterima --}}
            <div class="flex items-center gap-3 p-3 rounded-lg bg-green-50/60 border border-green-100">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-green-600">thumb_up</span>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Diterima</p>
                    <p class="text-xl font-bold text-emerald-800 leading-tight">{{ number_format($statistik['diterima']) }}</p>
                </div>
            </div>

            {{-- Ditolak --}}
            <div class="flex items-center gap-3 p-3 rounded-lg bg-red-50/60 border border-red-100">
                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-red-600">thumb_down</span>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Ditolak</p>
                    <p class="text-xl font-bold text-emerald-800 leading-tight">{{ number_format($statistik['ditolak']) }}</p>
                </div>
            </div>

        </div>
    </div>
</section>

        {{-- Main Grid: Antrean Prioritas + Aktivitas --}}
        <section class="max-w-7xl mx-auto grid grid-cols-12 gap-6">
            <!-- Antrean Prioritas -->
            <div class="col-span-8">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-emerald-700">priority_high</span>
                            <h3 class="font-bold text-emerald-800">Antrean Prioritas</h3>
                        </div>
                        <span class="text-xs text-gray-500">Diurutkan berdasarkan deadline diskusi terdekat</span>
                    </div>

                    <div class="divide-y divide-gray-100" id="antreanList">
                        @forelse($antreanPrioritas as $item)
                            @php
                                $batas = $item->batas_waktu_diskusi ? \Carbon\Carbon::parse($item->batas_waktu_diskusi) : null;
                                $diff = $batas ? now()->diffInHours($batas, false) : null;
                                $isUrgent = $batas && $diff !== null && $diff <= 24 && $diff > 0;
                                $isExpired = $batas && $diff !== null && $diff <= 0;
                            @endphp
                            <div class="p-5 hover:bg-gray-50 transition-colors flex items-start gap-4">
                                <div class="w-12 h-12 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-emerald-700">menu_book</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3 mb-1">
                                        <div>
                                            <p class="text-sm font-bold text-emerald-700">
                                                QS {{ $item->ayat->no_surah ?? '?' }}:{{ $item->ayat->nomorAyat ?? '?' }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $item->ayat->surah->nama_latin ?? 'Surah' }}
                                            </p>
                                        </div>
                                        @if ($batas)
                                            <span class="text-[10px] font-bold px-2 py-1 rounded-full whitespace-nowrap
                                                {{ $isExpired ? 'bg-red-100 text-red-700' : ($isUrgent ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700') }}">
                                                @if ($isExpired)
                                                    <span class="material-symbols-outlined text-[10px] align-middle">error</span>
                                                    Deadline lewat
                                                @elseif ($isUrgent)
                                                    <span class="material-symbols-outlined text-[10px] align-middle">timer</span>
                                                    {{ $diff }} jam lagi
                                                @else
                                                    <span class="material-symbols-outlined text-[10px] align-middle">calendar_today</span>
                                                    {{ $batas->diffForHumans() }}
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm italic text-gray-700 line-clamp-2 mt-2">
                                        "{{ \Illuminate\Support\Str::limit($item->usulan_teks ?? '', 120) }}"
                                    </p>
                                    <div class="flex items-center justify-between mt-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] font-bold">
                                                {{ strtoupper(substr($item->nama_pengusul ?? 'AN', 0, 2)) }}
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $item->nama_pengusul ?? 'Anonim' }}</span>
                                        </div>
                                        <a href="{{ route('admin.validasi.chat.show', ['id' => $item->id]) }}"
                                            class="text-xs font-medium text-emerald-700 hover:text-emerald-900 flex items-center gap-1">
                                            Ke Halaman Tugas
                                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center">
                                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">task_alt</span>
                                <p class="text-gray-500 font-medium">Tidak ada antrean tugas</p>
                                <p class="text-xs text-gray-400 mt-1">Semua usulan yang ditugaskan sudah kamu review 🎉</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($antreanPrioritas->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                            <p class="text-xs text-gray-500">
                                Menampilkan {{ $antreanPrioritas->firstItem() }}–{{ $antreanPrioritas->lastItem() }}
                                dari {{ $antreanPrioritas->total() }}
                            </p>
                            <div>{!! $antreanPrioritas->links() !!}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="col-span-4">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-2 bg-gray-50">
                        <span class="material-symbols-outlined text-emerald-700">forum</span>
                        <h3 class="font-bold text-emerald-800">Aktivitas Diskusi</h3>
                    </div>
                    <div class="p-4 space-y-3 max-h-[600px] overflow-y-auto">
                        @forelse($aktivitasTerbaru as $chat)
                            <div class="flex gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0">
                                    {{ strtoupper(substr($chat->user->name ?? 'U', 0, 2)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-semibold text-gray-700 truncate">
                                            {{ $chat->user->name ?? 'Pengguna' }}
                                        </span>
                                        <span class="text-[10px] text-gray-400">
                                            {{ $chat->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 line-clamp-2">
                                        {{ \Illuminate\Support\Str::limit($chat->pesan ?? ($chat->message ?? ''), 90) }}
                                    </p>
                                    @if ($chat->usulan)
                                        <p class="text-[10px] text-emerald-700 font-medium mt-1">
                                            <span class="material-symbols-outlined text-[10px] align-middle">menu_book</span>
                                            QS {{ $chat->usulan->ayat->no_surah ?? '?' }}:{{ $chat->usulan->ayat->nomorAyat ?? '?' }}
                                            — {{ $chat->usulan->ayat->surah->nama_latin ?? '' }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center">
                                <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">chat_bubble</span>
                                <p class="text-xs text-gray-400">Belum ada aktivitas diskusi</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Riwayat Validasi -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center gap-2 bg-gray-50">
                        <span class="material-symbols-outlined text-emerald-700">history</span>
                        <h3 class="font-bold text-emerald-800">Riwayat Validasi</h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @forelse($riwayatValidasi as $vote)
                            <div class="px-4 py-3 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                                    {{ ($vote->vote ?? '') === 'setuju' || ($vote->keputusan ?? '') === 'terima'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700' }}">
                                    <span class="material-symbols-outlined text-base">
                                        {{ ($vote->vote ?? '') === 'setuju' || ($vote->keputusan ?? '') === 'terima' ? 'check' : 'close' }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-gray-700 truncate">
                                        QS {{ $vote->usulan->ayat->no_surah ?? '?' }}:{{ $vote->usulan->ayat->nomorAyat ?? '?' }}
                                        — {{ $vote->usulan->ayat->surah->nama_latin ?? '' }}
                                    </p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">
                                        {{ $vote->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center">
                                <p class="text-xs text-gray-400">Belum ada riwayat validasi</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Detail Usulan -->
    <div id="detailModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-smooth">
        <div class="bg-white rounded-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto transform transition-all scale-95 opacity-0"
            id="detailModalContent">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-emerald-800">Detail Usulan</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-6" id="detailContent">
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600"></div>
                    <p class="text-gray-500 mt-2">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        #detailModal.show #detailModalContent {
            transform: scale(1);
            opacity: 1;
        }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const detailModal = document.getElementById('detailModal');
            detailModal.addEventListener('click', function (e) {
                if (e.target === detailModal) closeDetailModal();
            });
        });

        function refreshData() { window.location.reload(); }

        async function showDetail(id) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('detailContent');

            content.innerHTML = `
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600"></div>
                    <p class="text-gray-500 mt-2">Memuat data...</p>
                </div>`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => modal.classList.add('show'), 10);

            try {
                const response = await fetch(`/validator/usulan/${id}`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const result = await response.json();

                if (result.success) {
                    const data = result.data;
                    content.innerHTML = `
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Ayat</p>
                                    <p class="font-semibold text-lg text-emerald-700">QS ${data.ayat.no_surah}:${data.ayat.nomorAyat}</p>
                                    <p class="text-sm text-gray-600">${escapeHtml(data.ayat.surah?.nama_latin || 'Surah')}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Status</p>
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium mt-1 
                                        ${data.status == 'menunggu_validasi' ? 'bg-yellow-100 text-yellow-800' : 
                                          (data.status == 'diterima' || data.status == 'dipublikasi' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')}">
                                        ${data.status}
                                    </span>
                                </div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Usulan Teks (Hulontalo)</p>
                                <p class="text-base italic">"${escapeHtml(data.usulan_teks)}"</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Alasan Usulan</p>
                                <p class="text-sm mt-1">${escapeHtml(data.alasan_usulan || '-')}</p>
                            </div>
                            <div class="border-t pt-4">
                                <p class="text-xs text-gray-500">Pengusul</p>
                                <p class="font-medium">${escapeHtml(data.nama_pengusul)}</p>
                                <p class="text-sm text-gray-600">${escapeHtml(data.no_hp || '-')}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Waktu Pengajuan</p>
                                <p class="text-sm">${formatDate(data.created_at)}</p>
                            </div>
                            ${data.catatan_validator ? `
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-xs text-gray-500">Catatan Validator</p>
                                    <p class="text-sm mt-1">${escapeHtml(data.catatan_validator)}</p>
                                </div>` : ''}
                        </div>`;
                } else {
                    content.innerHTML = `<div class="text-center py-8 text-red-500">${result.message || 'Gagal memuat data'}</div>`;
                }
            } catch (error) {
                console.error(error);
                content.innerHTML = '<div class="text-center py-8 text-red-500">Terjadi kesalahan saat memuat data</div>';
            }
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleString('id-ID', {
                day: '2-digit', month: '2-digit', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        }
    </script>
@endsection