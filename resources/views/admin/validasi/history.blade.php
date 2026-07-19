@extends('layouts.app')

@section('content')
    <main class="flex-1 ml-64 p-6 pattern-bg min-h-screen">
        <!-- Header dan Breadcrumbs -->
        {{-- <header class="max-w-6xl mx-auto mb-6">
            <nav class="flex items-center gap-2 text-gray-500 mb-4">
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Administrator</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs text-emerald-700 font-medium">Riwayat Validasi</span>
            </nav>
            <div class="flex justify-between items-end flex-wrap gap-4">
                <div>
                    <h2 class="text-4xl font-bold text-emerald-800 mb-2">Riwayat Validasi</h2>
                    <p class="text-gray-600">Arsip usulan terjemahan yang telah selesai diputuskan oleh tim pakar.</p>
                </div>
            </div>
        </header> --}}

        <!-- Stats Overview -->
        {{-- <section class="max-w-6xl mx-auto grid grid-cols-12 gap-6 mb-8">
            <div class="col-span-8 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-2">Total Usulan</p>
                        <h3 class="text-4xl font-bold text-emerald-800 leading-none">
                            {{ number_format($statusCount['menunggu'] + $statusCount['diterima'] + $statusCount['ditolak']) }}
                        </h3>
                        <p class="text-xs text-emerald-700 font-medium mt-4 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">pending</span>
                            {{ $statusCount['menunggu'] }} Menunggu Review
                        </p>
                    </div>
                    <div class="h-24 w-48 relative">
                        <div class="absolute bottom-0 left-0 w-full h-full flex items-end gap-1">
                            @php
                                $total = max(1, $statusCount['menunggu'] + $statusCount['diterima'] + $statusCount['ditolak']);
                                $menungguPersen = ($statusCount['menunggu'] / $total) * 100;
                                $diterimaPersen = ($statusCount['diterima'] / $total) * 100;
                                $ditolakPersen = ($statusCount['ditolak'] / $total) * 100;
                            @endphp
                            <div class="w-1/3 bg-yellow-400 rounded-t-sm" style="height: {{ min(95, $menungguPersen) }}%"></div>
                            <div class="w-1/3 bg-green-500 rounded-t-sm" style="height: {{ min(95, $diterimaPersen) }}%"></div>
                            <div class="w-1/3 bg-red-500 rounded-t-sm" style="height: {{ min(95, $ditolakPersen) }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4 mt-4 pt-2 border-t border-gray-100">
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-yellow-400"></div><span class="text-xs text-gray-500">Menunggu: {{ $statusCount['menunggu'] }}</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-green-500"></div><span class="text-xs text-gray-500">Diterima: {{ $statusCount['diterima'] }}</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded-full bg-red-500"></div><span class="text-xs text-gray-500">Ditolak: {{ $statusCount['ditolak'] }}</span></div>
                </div>
            </div>
            <div class="col-span-4 bg-emerald-700 text-white rounded-xl p-6 flex flex-col justify-between shadow-lg">
                <div>
                    <span class="material-symbols-outlined text-3xl mb-4">assignment_late</span>
                    <p class="text-sm font-semibold">Perlu Perhatian</p>
                    <p class="text-xs opacity-80 mt-1">{{ $statusCount['menunggu'] }} usulan menunggu untuk direview.</p>
                </div>
                <button onclick="window.location.href='{{ route('admin.usulan.index') }}'" class="bg-white text-emerald-800 font-bold text-sm py-2 rounded-lg w-full mt-6 hover:bg-gray-100 transition-colors">Ke Daftar Usulan</button>
            </div>
        </section> --}}

        <header class="max-w-6xl mx-auto mb-6">
            <nav class="flex items-center gap-2 text-gray-500 mb-4">
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Administrator</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs text-emerald-700 font-medium">Antrean Otorisasi</span>
            </nav>
            <div class="flex justify-between items-end flex-wrap gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <h2 class="text-4xl font-bold text-emerald-800">Riwayat Validasi @if(Auth::user()->role === 'teologi' || Auth::user()->role === 'linguistik') Anda @endif</h2>
                        <span class="material-symbols-outlined text-4xl text-emerald-500"
                            style="font-variation-settings: 'FILL' 1;">
                            verified
                        </span>
                    </div>
                    @if(Auth::user()->role === 'admin')
                        <p class="text-gray-600">Daftar usulan yang telah divalidasi oleh validator.</p>
                    @elseif(Auth::user()->role === 'teologi' || Auth::user()->role === 'linguistik')
                        <p class="text-gray-600">Daftar usulan yang telah divalidasi oleh anda.</p>
                    @endif

                </div>

                <div class="flex gap-4">
                    {{-- <button onclick="window.location.href='{{ route('admin.validasi.export') }}'" 
                class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-medium hover:bg-gray-200 transition-colors">
            <span class="material-symbols-outlined text-lg">file_download</span>
            Ekspor Laporan
        </button> --}}
                </div>
            </div>
        </header>

        <!-- Search & Filter Controls -->
        <div
            class="max-w-6xl mx-auto bg-gray-50 p-4 rounded-t-xl border-x border-t border-gray-200 flex flex-wrap items-center justify-between gap-4">
        <div class="relative flex-1 max-w-md">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
                <input id="search" name="search"
                    class="w-full bg-white border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none"
                    placeholder="Cari usulan teks atau pengirim..." type="text" value="{{ request('search') }}"
                    onkeyup="if(event.key === 'Enter') window.location.href='{{ route('admin.riwayat') }}?search='+this.value" />
            </div>
            <div class="flex items-center gap-4">
                @if (request('search'))
                    <a href="{{ route('admin.riwayat') }}"
                        class="text-sm text-gray-500 hover:text-emerald-600 flex items-center gap-1"><span
                            class="material-symbols-outlined text-sm">close</span>Reset Filter</a>
                @endif
            </div>
        </div>

        <!-- Data Table -->
        <div class="max-w-6xl mx-auto bg-white border border-gray-200 rounded-b-xl overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 border-b border-gray-200">
                        <th class="px-6 py-4 font-semibold text-sm">Ayat</th>
                        <th class="px-6 py-4 font-semibold text-sm">Usulan (Hulontalo)</th>
                        <th class="px-6 py-4 font-semibold text-sm">Pengirim</th>
                        <th class="px-6 py-4 font-semibold text-sm">Waktu Validasi</th>
                        <th class="px-6 py-4 font-semibold text-sm">Status</th>
                        <th class="px-6 py-4 font-semibold text-sm text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat as $item)
                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <span class="text-sm font-bold text-emerald-700">QS
                                    {{ $item->ayat->no_surah ?? '?' }}:{{ $item->ayat->nomorAyat ?? '?' }}</span>
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
                                    <div
                                        class="w-8 h-8 rounded-full {{ $item->status == 'diterima' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} flex items-center justify-center font-bold text-[10px]">
                                        {{ strtoupper(substr($item->nama_pengusul, 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="text-sm">{{ $item->nama_pengusul }}</span>
                                        <p class="text-xs text-gray-400">{{ $item->no_hp }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="text-xs text-gray-500">{{ $item->validated_at ? $item->validated_at->diffForHumans() : '-' }}</span>
                                <p class="text-xs text-gray-400">
                                    {{ $item->validated_at ? $item->validated_at->format('d/m/Y H:i') : '-' }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium {{ $item->status == 'diterima' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <button onclick="showDetail({{ $item->id }})"
                                    class="text-emerald-600 hover:bg-emerald-50 p-2 rounded-full transition-colors"
                                    title="Lihat Detail">
                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">inbox</span>
                                    <p class="text-gray-500">Belum ada data riwayat validasi</p>
                                    <p class="text-xs text-gray-400 mt-1">Usulan yang selesai akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div
                class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500">Menampilkan {{ $riwayat->firstItem() ?? 0 }} -
                    {{ $riwayat->lastItem() ?? 0 }} dari {{ $riwayat->total() }} usulan</p>
                <div class="flex items-center gap-1">
                    {{ $riwayat->links() }}
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Detail Usulan (sama seperti sebelumnya) -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay bg-black/50" onclick="closeModal()"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Detail Usulan</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600"><span
                        class="material-symbols-outlined">close</span></button>
            </div>
            <div id="detailContent" class="p-6"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Show Detail Modal (sama seperti yang sudah berfungsi)
        async function showDetail(id) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('detailContent');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            content.innerHTML =
                '<div class="text-center py-8"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600"></div><p class="text-gray-500 mt-2">Memuat data...</p></div>';
            try {
                const response = await fetch(`/admin/usulan/${id}`);
                const result = await response.json();
                if (result.success) {
                    const data = result.data;
                    content.innerHTML = `
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Ayat</p>
                                <p class="font-semibold text-lg text-emerald-700">QS ${data.ayat?.no_surah || '?'}:${data.ayat?.nomorAyat || '?'}</p>
                                <p class="text-sm text-gray-600">${escapeHtml(data.ayat?.surah?.nama_latin || 'Surah')}</p>
                                ${data.ayat?.Arab ? `<p class="arabic-font text-right text-3xl mt-2">${escapeHtml(data.ayat.Arab)}</p>` : ''}
                                ${data.ayat?.teks_gorontalo ? `<p class="arabic-font text-right text-md mt-2">${escapeHtml(data.ayat.teks_gorontalo)}</p>` : ''}
                            </div>
                            <div><p class="text-xs text-gray-500 mb-1">Pengusul</p><p class="font-semibold">${escapeHtml(data.nama_pengusul)}</p><p class="text-sm text-gray-600">${escapeHtml(data.no_hp || '-')}</p></div>
                            <div><p class="text-xs text-gray-500 mb-1">Usulan Terjemahan (Hulontalo)</p><p class="bg-yellow-50 p-3 rounded-lg italic">"${escapeHtml(data.usulan_teks)}"</p></div>
                            ${data.alasan_usulan ? `<div><p class="text-xs text-gray-500 mb-1">Alasan Usulan</p><p class="bg-gray-50 p-3 rounded-lg">${escapeHtml(data.alasan_usulan)}</p></div>` : ''}
                            <div><p class="text-xs text-gray-500 mb-1">Status</p><span class="px-3 py-1 rounded-full text-xs font-medium ${getStatusBadgeClass(data.status)}">${getStatusText(data.status)}</span></div>
                            ${data.catatan_pakar ? `<div><p class="text-xs text-gray-500 mb-1">Catatan Validator</p><p class="bg-blue-50 p-3 rounded-lg">${escapeHtml(data.catatan_pakar)}</p></div>` : ''}
                            <div><p class="text-xs text-gray-500 mb-1">Waktu Pengajuan</p><p class="text-sm">${formatDate(data.created_at)}</p></div>
                            ${data.validated_at ? `<div><p class="text-xs text-gray-500 mb-1">Waktu Validasi</p><p class="text-sm">${formatDate(data.validated_at)}</p></div>` : ''}
                        </div>
                    `;
                } else {
                    content.innerHTML =
                        `<div class="text-center py-8 text-red-500"><p>${result.message || 'Gagal memuat data'}</p><button onclick="showDetail(${id})" class="mt-3 text-emerald-600 hover:underline">Coba Lagi</button></div>`;
                }
            } catch (error) {
                content.innerHTML =
                    `<div class="text-center py-8 text-red-500"><p>Terjadi kesalahan: ${error.message}</p><button onclick="showDetail(${id})" class="mt-3 text-emerald-600 hover:underline">Coba Lagi</button></div>`;
            }
        }

        function closeModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('detailContent').innerHTML = '';
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(
                /'/g, '&#39;');
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const d = new Date(dateString);
            if (isNaN(d)) return '-';
            return d.toLocaleString('id-ID');
        }

        function getStatusBadgeClass(status) {
            const map = {
                menunggu: 'bg-yellow-100 text-yellow-800',
                diterima: 'bg-green-100 text-green-800',
                ditolak: 'bg-red-100 text-red-800'
            };
            return map[status] || 'bg-gray-100 text-gray-800';
        }

        function getStatusText(status) {
            const map = {
                menunggu: 'Menunggu',
                diterima: 'Diterima',
                ditolak: 'Ditolak'
            };
            return map[status] || status;
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });
        document.addEventListener('click', e => {
            if (e.target === document.getElementById('detailModal')) closeModal();
        });
    </script>
@endsection
