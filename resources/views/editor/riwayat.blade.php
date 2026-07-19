{{-- resources/views/editor/riwayat/index.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="flex-1 ml-64 p-6 pattern-bg min-h-screen">
    <!-- Header dan Breadcrumbs -->
    <header class="max-w-6xl mx-auto mb-6">
        <nav class="flex items-center gap-2 text-gray-500 mb-4">
            <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Editor</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-xs text-emerald-700 font-medium">Riwayat Tayang</span>
        </nav>
        <div class="flex justify-between items-end flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <h2 class="text-4xl font-bold text-emerald-800">Riwayat Tayang</h2>
                    <span class="material-symbols-outlined text-4xl text-emerald-500" style="font-variation-settings: 'FILL' 1;">
                        history
                    </span>
                </div>
                <p class="text-gray-600">Arsip usulan terjemahan yang telah dipublikasikan.</p>
            </div>
        </div>
    </header>

    <!-- Search -->
    <div class="max-w-6xl mx-auto bg-gray-50 p-4 rounded-t-xl border-x border-t border-gray-200 flex flex-wrap items-center justify-between gap-4">
        <div class="relative flex-1 max-w-md">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
            <input id="search" name="search" class="w-full bg-white border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none" placeholder="Cari usulan teks atau pengirim..." type="text" value="{{ request('search') }}" onkeyup="if(event.key === 'Enter') window.location.href='{{ route('editor.riwayat.index') }}?search='+this.value" />
        </div>
        @if(request('search'))
            <a href="{{ route('editor.riwayat.index') }}" class="text-sm text-gray-500 hover:text-emerald-600 flex items-center gap-1"><span class="material-symbols-outlined text-sm">close</span>Reset Filter</a>
        @endif
    </div>

    <!-- Data Table -->
    <div class="max-w-6xl mx-auto bg-white border border-gray-200 rounded-b-xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 border-b border-gray-200">
                    <th class="px-6 py-4 font-semibold text-sm">Ayat</th>
                    <th class="px-6 py-4 font-semibold text-sm">Usulan (Hulontalo)</th>
                    <th class="px-6 py-4 font-semibold text-sm">Pengirim</th>
                    <th class="px-6 py-4 font-semibold text-sm">Tanggal Publikasi</th>
                    <th class="px-6 py-4 font-semibold text-sm text-right">Aksi</th>
                 </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($riwayat as $item)
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
                            <span class="text-xs text-gray-500">{{ $item->published_at ? $item->published_at->diffForHumans() : '-' }}</span>
                            <p class="text-xs text-gray-400">{{ $item->published_at ? $item->published_at->format('d/m/Y H:i') : '-' }}</p>
                         </td>
                        <td class="px-6 py-5 text-right">
                            <button onclick="showDetail({{ $item->id }})" class="text-emerald-600 hover:bg-emerald-50 p-2 rounded-full transition-colors" title="Lihat Detail">
                                <span class="material-symbols-outlined text-xl">visibility</span>
                            </button>
                         </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">inbox</span>
                                <p class="text-gray-500">Belum ada riwayat tayang</p>
                                <p class="text-xs text-gray-400 mt-1">Usulan yang sudah dipublikasikan akan muncul di sini</p>
                            </div>
                         </td>
                    </tr>
                @endforelse
            </tbody>
         </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-500">Menampilkan {{ $riwayat->firstItem() ?? 0 }} - {{ $riwayat->lastItem() ?? 0 }} dari {{ $riwayat->total() }} usulan</p>
            <div class="flex items-center gap-1">
                {{ $riwayat->links() }}
            </div>
        </div>
    </div>
</main>

<!-- Modal Detail Usulan -->
<div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 modal-overlay bg-black/50" onclick="closeModal()"></div>
    <div class="relative bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">Detail Usulan</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600"><span class="material-symbols-outlined">close</span></button>
        </div>
        <div id="detailContent" class="p-6"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    async function showDetail(id) {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('detailContent');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        content.innerHTML = '<div class="text-center py-8"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600"></div><p class="text-gray-500 mt-2">Memuat data...</p></div>';
        try {
            const response = await fetch(`/editor/usulan/${id}`);
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
                        <div><p class="text-xs text-gray-500 mb-1">Status</p><span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Dipublikasi</span></div>
                        ${data.catatan_editor ? `<div><p class="text-xs text-gray-500 mb-1">Catatan Editor</p><p class="bg-blue-50 p-3 rounded-lg">${escapeHtml(data.catatan_editor)}</p></div>` : ''}
                        <div><p class="text-xs text-gray-500 mb-1">Waktu Pengajuan</p><p class="text-sm">${formatDate(data.created_at)}</p></div>
                        ${data.published_at ? `<div><p class="text-xs text-gray-500 mb-1">Waktu Publikasi</p><p class="text-sm">${formatDate(data.published_at)}</p></div>` : ''}
                    </div>
                `;
            } else {
                content.innerHTML = `<div class="text-center py-8 text-red-500"><p>${result.message || 'Gagal memuat data'}</p><button onclick="showDetail(${id})" class="mt-3 text-emerald-600 hover:underline">Coba Lagi</button></div>`;
            }
        } catch (error) {
            content.innerHTML = `<div class="text-center py-8 text-red-500"><p>Terjadi kesalahan: ${error.message}</p><button onclick="showDetail(${id})" class="mt-3 text-emerald-600 hover:underline">Coba Lagi</button></div>`;
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
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        const d = new Date(dateString);
        if (isNaN(d)) return '-';
        return d.toLocaleString('id-ID');
    }

    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
    document.addEventListener('click', e => { if (e.target === document.getElementById('detailModal')) closeModal(); });
</script>
@endsection