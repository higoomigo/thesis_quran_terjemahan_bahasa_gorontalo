@extends('layouts.app')

@section('content')
    <!-- Stats Overview -->
    <main class="flex-1 ml-64 p-6 pattern-bg min-h-screen">
        <!-- Top Header & Breadcrumbs -->
        <header class="max-w-6xl mx-auto mb-6">
            <nav class="flex items-center gap-2 text-gray-500 mb-4">
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Administrator</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs text-emerald-700 font-medium">Daftar Usulan</span>
            </nav>
            <div class="flex justify-between items-end flex-wrap gap-4">
                <div>
                    <h2 class="text-4xl font-bold text-emerald-800 mb-2">Daftar Usulan</h2>
                    <p class="text-gray-600">Kelola dan tinjau usulan terjemahan bahasa Gorontalo dari masyarakat.</p>
                </div>
                <div class="flex gap-4">
                    {{-- <button onclick="window.location.href='{{ route('admin.usulan.export') }}'" 
                            class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-medium hover:bg-gray-200 transition-colors">
                        <span class="material-symbols-outlined text-lg">file_download</span>
                        Ekspor Laporan
                    </button> --}}
                </div>
            </div>
        </header>

        <!-- Stats Overview -->
        <section class="max-w-6xl mx-auto grid grid-cols-12 gap-6 mb-8">
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
                            <div
                                class="w-1/3 bg-yellow-400 h-[{{ $statusCount['menunggu'] > 0 ? min(95, ($statusCount['menunggu'] / max(1, $statusCount['menunggu'] + $statusCount['diterima'] + $statusCount['ditolak'])) * 100) : 5 }}%] rounded-t-sm">
                            </div>
                            <div
                                class="w-1/3 bg-green-500 h-[{{ $statusCount['diterima'] > 0 ? min(95, ($statusCount['diterima'] / max(1, $statusCount['menunggu'] + $statusCount['diterima'] + $statusCount['ditolak'])) * 100) : 5 }}%] rounded-t-sm">
                            </div>
                            <div
                                class="w-1/3 bg-red-500 h-[{{ $statusCount['ditolak'] > 0 ? min(95, ($statusCount['ditolak'] / max(1, $statusCount['menunggu'] + $statusCount['diterima'] + $statusCount['ditolak'])) * 100) : 5 }}%] rounded-t-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4 mt-4 pt-2 border-t border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <span class="text-xs text-gray-500">Menunggu: {{ $statusCount['menunggu'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="text-xs text-gray-500">Diterima: {{ $statusCount['diterima'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="text-xs text-gray-500">Ditolak: {{ $statusCount['ditolak'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-span-4 bg-emerald-700 text-white rounded-xl p-6 flex flex-col justify-between shadow-lg">
                <div>
                    <span class="material-symbols-outlined text-3xl mb-4">assignment_late</span>
                    <p class="text-sm font-semibold">Perlu Perhatian</p>
                    <p class="text-xs opacity-80 mt-1">{{ $statusCount['menunggu'] }} usulan menunggu untuk direview.
                    </p>
                </div>
                <button onclick="document.getElementById('search').focus()"
                    class="bg-white text-emerald-800 font-bold text-sm py-2 rounded-lg w-full mt-6 hover:bg-gray-100 transition-colors">
                    Mulai Review
                </button>
            </div>
        </section>

        <!-- Search & Filter Controls -->
        <div
            class="max-w-6xl mx-auto bg-gray-50 p-4 rounded-t-xl border-x border-t border-gray-200 flex flex-wrap items-center justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
                <input id="search" name="search"
                    class="w-full bg-white border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all outline-none"
                    placeholder="Cari ayat, kata, atau pengirim..." type="text" value="{{ request('search') }}"
                    onkeyup="if(event.key === 'Enter') window.location.href='{{ route('admin.usulan.index') }}?search='+this.value+'&status={{ request('status') }}'" />
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button onclick="toggleStatusDropdown()"
                        class="flex items-center gap-2 bg-white border border-gray-300 px-3 py-2 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                        <span class="material-symbols-outlined text-lg">filter_list</span>
                        <span class="text-sm">Filter Status</span>
                        @if (request('status'))
                            <span
                                class="bg-emerald-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ request('status') }}</span>
                        @endif
                    </button>
                    <div id="statusDropdown"
                        class="hidden absolute top-full left-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-20 min-w-[150px]">
                        <a href="{{ route('admin.usulan.index', ['search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ !request('status') ? 'text-emerald-600 font-medium' : 'text-gray-700' }}">
                            Semua Status
                        </a>
                        <a href="{{ route('admin.usulan.index', ['status' => 'menunggu', 'search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ request('status') == 'menunggu' ? 'text-emerald-600 font-medium bg-yellow-50' : 'text-gray-700' }}">
                            ⏳ Menunggu
                        </a>
                        <a href="{{ route('admin.usulan.index', ['status' => 'diterima', 'search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ request('status') == 'diterima' ? 'text-emerald-600 font-medium bg-green-50' : 'text-gray-700' }}">
                            ✓ Diterima
                        </a>
                        <a href="{{ route('admin.usulan.index', ['status' => 'ditolak', 'search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ request('status') == 'ditolak' ? 'text-emerald-600 font-medium bg-red-50' : 'text-gray-700' }}">
                            ✗ Ditolak
                        </a>
                    </div>
                </div>
                {{-- <div
                    class="flex items-center gap-2 bg-white border border-gray-300 px-3 py-2 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors relative">
                    <span class="material-symbols-outlined text-lg">calendar_today</span>
                    <span class="text-sm">Rentang Waktu</span>
                </div> --}}
                @if (request('search') || request('status'))
                    <a href="{{ route('admin.usulan.index') }}"
                        class="text-sm text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">close</span>
                        Reset Filter
                    </a>
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
                        <th class="px-6 py-4 font-semibold text-sm">Waktu</th>
                        <th class="px-6 py-4 font-semibold text-sm">Status</th>
                        <th class="px-6 py-4 font-semibold text-sm text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($usulan as $item)
                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <span class="text-sm font-bold text-emerald-700">QS
                                    {{ $item->ayat->no_surah }}:{{ $item->ayat->nomorAyat }}</span>
                                <p class="text-xs text-gray-500">{{ $item->ayat->surah->nama_latin ?? 'Surah' }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="max-w-xs">
                                    <p class="text-sm italic line-clamp-2">"{{ Str::limit($item->usulan_teks, 100) }}"
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">Usulan perbaikan terjemahan</p>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-full {{ $item->status == 'menunggu' ? 'bg-yellow-100 text-yellow-700' : ($item->status == 'diterima' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }} flex items-center justify-center font-bold text-[10px]">
                                        {{ strtoupper(substr($item->nama_pengusul, 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="text-sm">{{ $item->nama_pengusul }}</span>
                                        <p class="text-xs text-gray-400">{{ $item->no_hp }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</span>
                                <p class="text-xs text-gray-400">{{ $item->created_at->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col items-start gap-2">

                                    @if ($item->status == 'menunggu')
                                        @php
                                            // Menghitung jumlah pakar yang sudah klaim
                                            $jumlahValidator = $item->assignments->count();
                                        @endphp

                                        <div
                                            class="flex items-center gap-1 px-2 py-0.5 rounded-md border text-[11px] font-semibold
                {{ $jumlahValidator == 3 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                                            <span class="material-symbols-outlined text-[14px]">group</span>
                                            {{ $jumlahValidator }}/3 Validator
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">

                                    @if ($item->status == 'menunggu')
                                        @if (isset($jumlahValidator) && $jumlahValidator >= 3)
                                            <div class="text-gray-400 bg-gray-50 px-3 py-1.5 border border-gray-200 rounded-2xl flex items-center gap-1 cursor-not-allowed"
                                                title="Kuota validator sudah penuh (3/3)">
                                                <span class="material-symbols-outlined text-sm">lock</span>
                                                <p class="text-sm font-medium">Tim Lengkap</p>
                                            </div>
                                        @else
                                            <button onclick="claimUsulan({{ $item->id }})"
                                                class="text-blue-600 hover:bg-blue-50 px-3 py-1.5 border border-blue-600 rounded-2xl transition-colors flex items-center gap-1 group"
                                                title="Klaim Usulan">
                                                <span
                                                    class="material-symbols-outlined text-sm group-hover:scale-110 transition-transform">person_add</span>
                                                <p class="text-sm font-medium">Klaim</p>
                                            </button>
                                        @endif
                                    @endif

                                    <button onclick="showDetail({{ $item->id }})"
                                        class="text-emerald-600 hover:bg-emerald-50 p-2 rounded-full transition-colors"
                                        title="Lihat Detail">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>

                                    @auth
                                        @if (in_array(Auth::user()->role, ['admin', 'editor']))
                                            <div class="w-px h-6 bg-gray-200 mx-1"></div>

                                            <form action="{{ route('admin.usulan.arsip', $item->id) }}" method="POST"
                                                class="inline-block m-0">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    onclick="return confirm('Arsipkan usulan ini? Data akan disembunyikan dari tabel utama.')"
                                                    class="text-orange-500 hover:text-orange-700 hover:bg-orange-50 p-2 rounded-full transition-colors flex items-center justify-center"
                                                    title="Arsipkan Usulan">
                                                    <span class="material-symbols-outlined text-xl">archive</span>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.usulan.destroy', $item->id) }}" method="POST"
                                                class="inline-block m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('PERINGATAN: Yakin ingin menghapus permanen usulan ini? Tindakan ini tidak bisa dibatalkan.')"
                                                    class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition-colors flex items-center justify-center"
                                                    title="Hapus Permanen">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">inbox</span>
                                    <p class="text-gray-500">Belum ada data usulan</p>
                                    <p class="text-xs text-gray-400 mt-1">Usulan dari masyarakat akan muncul di sini
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div
                class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500">
                    Menampilkan {{ $usulan->firstItem() ?? 0 }} - {{ $usulan->lastItem() ?? 0 }} dari
                    {{ $usulan->total() }} usulan
                </p>
                <div class="flex items-center gap-1">
                    @if ($usulan->onFirstPage())
                        <button class="p-2 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed"
                            disabled>
                            <span class="material-symbols-outlined text-xl">chevron_left</span>
                        </button>
                    @else
                        <a href="{{ $usulan->previousPageUrl() }}"
                            class="p-2 rounded-md border border-gray-300 hover:bg-gray-100 transition-colors">
                            <span class="material-symbols-outlined text-xl">chevron_left</span>
                        </a>
                    @endif

                    @foreach ($usulan->getUrlRange(1, $usulan->lastPage()) as $page => $url)
                        @if ($page == $usulan->currentPage())
                            <span
                                class="w-8 h-8 rounded-md bg-emerald-600 text-white text-sm font-bold flex items-center justify-center">{{ $page }}</span>
                        @elseif(
                            $page == 1 ||
                                $page == $usulan->lastPage() ||
                                ($page >= $usulan->currentPage() - 2 && $page <= $usulan->currentPage() + 2))
                            <a href="{{ $url }}"
                                class="w-8 h-8 rounded-md hover:bg-gray-100 text-sm transition-colors flex items-center justify-center">{{ $page }}</a>
                        @elseif($page == $usulan->currentPage() - 3 || $page == $usulan->currentPage() + 3)
                            <span class="px-1 text-gray-500">...</span>
                        @endif
                    @endforeach

                    @if ($usulan->hasMorePages())
                        <a href="{{ $usulan->nextPageUrl() }}"
                            class="p-2 rounded-md border border-gray-300 hover:bg-gray-100 transition-colors">
                            <span class="material-symbols-outlined text-xl">chevron_right</span>
                        </a>
                    @else
                        <button class="p-2 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed"
                            disabled>
                            <span class="material-symbols-outlined text-xl">chevron_right</span>
                        </button>
                    @endif
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
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div id="detailContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Modal Validasi -->
    <div id="validasiModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay bg-black/50" onclick="closeValidasiModal()"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Validasi Usulan</h3>
                <button onclick="closeValidasiModal()" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="validasiForm" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" id="validasiStatus">
                <div id="validasiContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeValidasiModal()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                    <button type="submit" formaction="" id="approveBtn"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">Terima
                        Usulan</button>
                    <button type="button" onclick="showRejectForm()"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Tolak
                        Usulan</button>
                </div>
                <div id="rejectForm" class="hidden pt-4 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Penolakan <span
                            class="text-red-500">*</span></label>
                    <textarea name="catatan_pakar" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Berikan alasan penolakan usulan ini..."></textarea>
                    <div class="flex justify-end mt-3">
                        <button type="submit" formaction="" id="rejectBtn"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Konfirmasi
                            Tolak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        async function claimUsulan(id) {
            // 1. Ganti confirm() bawaan dengan Popup Konfirmasi SweetAlert2
            const confirmation = await Swal.fire({
                title: 'Ambil Peran Validasi?',
                text: "Anda akan ditambahkan ke dalam tim validator untuk usulan ini.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669', // Kode warna untuk bg-emerald-600
                cancelButtonColor: '#dc2626', // Kode warna untuk bg-red-600
                confirmButtonText: 'Ya, Ambil Peran!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            });

            // Jika user klik "Batal", hentikan fungsi
            if (!confirmation.isConfirmed) return;

            // 2. Tampilkan Loading State agar UI tidak terlihat "nge-freeze"
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang mendaftarkan Anda ke dalam tim...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch(`/admin/usulan/${id}/claim`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // 3. Popup Sukses
                    await Swal.fire({
                        title: 'Berhasil!',
                        text: 'Anda telah ditambahkan ke dalam tim validator.',
                        icon: 'success',
                        confirmButtonColor: '#059669'
                    });
                    window.location.reload();
                } else {
                    // 4. Popup Gagal (misal: kuota penuh)
                    Swal.fire({
                        title: 'Peringatan',
                        text: result.message || 'Gagal mengambil peran.',
                        icon: 'warning',
                        confirmButtonColor: '#059669'
                    });
                }
            } catch (error) {
                // 5. Pengganti console.error() -> Tampilkan error ke layar
                Swal.fire({
                    title: 'Koneksi Terputus',
                    text: 'Terjadi kesalahan saat menghubungi server. Silakan periksa koneksi internet Anda.',
                    icon: 'error',
                    confirmButtonColor: '#059669'
                });
            }
        }

        // Function to show detail modal
        async function showDetail(id) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('detailContent');

            // Show modal with loading state
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            content.innerHTML = `
        <div class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600"></div>
            <p class="text-gray-500 mt-2">Memuat data...</p>
        </div>
        `;

            try {
                // Fetch data from API
                const response = await fetch(`/admin/usulan/${id}`);
                const result = await response.json();

                if (result.success) {
                    const data = result.data;

                    // ===== LOGIKA MEMBUAT DAFTAR TIM VALIDATOR =====
                    let validatorHtml = '';
                    if (data.assignments && data.assignments.length > 0) {
                        const listItems = data.assignments.map(assignment => `
                        <li class="flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined text-emerald-600 text-sm">person</span>
                            <span class="font-medium text-sm text-gray-800">${escapeHtml(assignment.user.name)}</span>
                            <span class="text-xs text-gray-500 uppercase tracking-wider bg-gray-100 px-2 py-0.5 rounded">
                                ${escapeHtml(assignment.user.role)}
                            </span>
                        </li>
                    `).join('');

                        validatorHtml = `
                        <div class="mt-4 border-t pt-4">
                            <p class="text-xs text-gray-500 mb-2">Tim Validator (${data.assignments.length}/3)</p>
                            <ul class="pl-1">
                                ${listItems}
                            </ul>
                        </div>
                    `;
                    } else {
                        validatorHtml = `
                        <div class="mt-4 border-t pt-4">
                            <p class="text-xs text-gray-500 mb-2">Tim Validator</p>
                            <p class="text-sm text-gray-400 italic">Belum ada pakar yang mengklaim usulan ini.</p>
                        </div>
                    `;
                    }
                    // =================================================

                    // Render the detail content
                    content.innerHTML = `
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">Ayat</p>
                        <p class="font-semibold text-lg text-emerald-700">
                            QS ${data.ayat?.no_surah || '?'}:${data.ayat?.nomorAyat || '?'}
                        </p>
                        <p class="text-sm text-gray-600">${data.ayat?.surah?.nama_latin || 'Surah'}</p>
                        ${data.ayat?.Arab ? `<p class="arabic-font text-right text-3xl mt-2">${escapeHtml(data.ayat.Arab)}</p>` : ''}
                        
                        ${data.ayat?.teks_gorontalo ? `<p class="arabic-font text-right text-md mt-2">${escapeHtml(data.ayat.teks_gorontalo)}</p>` : ''}
                    </div>
                    
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Pengusul</p>
                        <p class="font-semibold">${escapeHtml(data.nama_pengusul)}</p>
                        <p class="text-sm text-gray-600">${escapeHtml(data.no_hp || '-')}</p>
                    </div>

                    ${validatorHtml}
                    
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Usulan Terjemahan (Hulontalo)</p>
                        <p class="bg-yellow-50 p-3 rounded-lg italic">"${escapeHtml(data.usulan_teks)}"</p>
                    </div>
                    
                    ${data.alasan_usulan ? `
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Alasan Usulan</p>
                                    <p class="bg-gray-50 p-3 rounded-lg">${escapeHtml(data.alasan_usulan)}</p>
                                </div>
                                ` : ''}
                    
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Status</p>
                        <span class="px-3 py-1 rounded-full text-xs font-medium ${getStatusBadgeClass(data.status)}">
                            ${getStatusText(data.status)}
                        </span>
                    </div>
                    
                    ${data.catatan_pakar ? `
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Catatan Validator</p>
                                    <p class="bg-blue-50 p-3 rounded-lg">${escapeHtml(data.catatan_pakar)}</p>
                                </div>
                                ` : ''}
                    
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Waktu Pengajuan</p>
                        <p class="text-sm">${formatDate(data.created_at)}</p>
                    </div>
                    
                    ${data.validated_at ? `
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Waktu Validasi</p>
                                    <p class="text-sm">${formatDate(data.validated_at)}</p>
                                </div>
                                ` : ''}
                </div>
            `;
                } else {
                    // ... (kode error bawaan lu tetep aman di sini) ...
                    content.innerHTML = `
                <div class="text-center py-8 text-red-500">
                    <p>${result.message || 'Gagal memuat data'}</p>
                    <button onclick="showDetail(${id})" class="mt-3 text-emerald-600 hover:underline">
                        Coba Lagi
                    </button>
                </div>
            `;
                }
            } catch (error) {
                console.error('Error:', error);
                content.innerHTML = `
            <div class="text-center py-8 text-red-500">
                <p>Terjadi kesalahan: ${error.message}</p>
                <button onclick="showDetail(${id})" class="mt-3 text-emerald-600 hover:underline">
                    Coba Lagi
                </button>
            </div>
             `;
            }
        }

        // Close modal function
        function closeModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('detailContent').innerHTML = '';
        }

        // Helper functions
        function escapeHtml(str) {
            if (!str) return '';
            return str
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return '-';
            return date.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function getStatusBadgeClass(status) {
            switch (status) {
                case 'menunggu':
                    return 'bg-yellow-100 text-yellow-800';
                case 'diterima':
                    return 'bg-green-100 text-green-800';
                case 'ditolak':
                    return 'bg-red-100 text-red-800';
                default:
                    return 'bg-gray-100 text-gray-800';
            }
        }

        function getStatusText(status) {
            switch (status) {
                case 'menunggu':
                    return 'Menunggu';
                case 'diterima':
                    return 'Diterima';
                case 'ditolak':
                    return 'Ditolak';
                default:
                    return status || 'Unknown';
            }
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDetailModal();
            }
        });

        // Close modal when clicking overlay
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('detailModal');
            if (event.target === modal) {
                closeDetailModal();
            }
        });
    </script>
@endsection
