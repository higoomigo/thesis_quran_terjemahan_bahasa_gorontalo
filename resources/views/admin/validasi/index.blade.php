{{-- resources/views/admin/validasi/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Antrean Otorisasi | Admin Panel - Qur'an Gorontalo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;family=Noto+Serif:ital,wght@0,400;0,700;1,400&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .arabic-font {
            font-family: 'Noto Serif', serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .pattern-bg {
            background-image: radial-gradient(circle at 2px 2px, rgba(0, 0, 0, 0.03) 1px, transparent 0);
            background-size: 24px 24px;
        }

        /* Modal styles */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease;
        }

        .modal-container {
            transition: all 0.3s ease;
            transform: scale(0.95);
            opacity: 0;
        }

        .modal-container.active {
            transform: scale(1);
            opacity: 1;
        }

        .countdown-timer {
            font-feature-settings: 'tnum';
            font-variant-numeric: tabular-nums;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen flex">

    <!-- SideNavBar -->
    @include('partials.sidebar')

    <!-- Main Canvas -->
    <main class="flex-1 ml-64 p-6 pattern-bg min-h-screen">
        <!-- Top Header & Breadcrumbs -->
        <header class="max-w-6xl mx-auto mb-6">
            {{-- <nav class="flex items-center gap-2 text-gray-500 mb-4">
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Administrator</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs text-emerald-700 font-medium">Antrean Otorisasi</span>
            </nav> --}}
            <div class="flex justify-between items-end flex-wrap gap-4">
                <div>
                    <h2 class="text-4xl font-bold text-emerald-800 mb-2">Usulan dalam Penanganan</h2>
                    {{-- <p class="text-gray-600">daftar usulan ini udah diklaim oleh anda </p> --}}
                    <p class="text-gray-600">Daftar usulan yang saat ini sedang Anda tinjau dan proses.</p>
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

        <!-- Stats Overview -->
        {{-- <section class="max-w-6xl mx-auto grid grid-cols-12 gap-6 mb-8">
            <div class="col-span-8 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-2">Total Antrean</p>
                        <h3 class="text-4xl font-bold text-emerald-800 leading-none">
                            {{ number_format($statistics['total_antrean'] ?? 0) }}
                        </h3>
                        <p class="text-xs text-emerald-700 font-medium mt-4 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">trending_up</span>
                            +{{ $statistics['hari_ini'] ?? 0 }} hari ini
                        </p>
                    </div>
                    <div class="h-24 w-48 relative">
                        <div class="absolute bottom-0 left-0 w-full h-full flex items-end gap-1">
                            <div
                                class="w-1/3 bg-yellow-400 h-[{{ ($statistics['total_antrean'] ?? 0) > 0 ? 65 : 5 }}%] rounded-t-sm">
                            </div>
                            <div
                                class="w-1/3 bg-green-500 h-[{{ ($statistics['total_selesai'] ?? 0) > 0 ? 25 : 5 }}%] rounded-t-sm">
                            </div>
                            <div class="w-1/3 bg-red-500 h-[5%] rounded-t-sm"></div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4 mt-4 pt-2 border-t border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <span class="text-xs text-gray-500">Menunggu: {{ $statistics['total_antrean'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="text-xs text-gray-500">Selesai: {{ $statistics['total_selesai'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="text-xs text-gray-500">Kadaluarsa: {{ $statistics['total_expired'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div
                class="col-span-4 bg-gradient-to-br from-emerald-700 to-emerald-800 text-white rounded-xl p-6 flex flex-col justify-between shadow-lg">
                <div>
                    <span class="material-symbols-outlined text-3xl mb-4">assignment_late</span>
                    <p class="text-sm font-semibold">Priority (Urgent)</p>
                    <p class="text-xs opacity-80 mt-1">{{ $statistics['prioritas'] ?? 0 }} usulan prioritas perlu segera
                        direview.</p>
                    <p class="text-xs opacity-70 mt-2">*Juz 30 memerlukan perhatian khusus</p>
                </div>
                <button onclick="document.getElementById('search').focus()"
                    class="bg-white text-emerald-800 font-bold text-sm py-2 rounded-lg w-full mt-6 hover:bg-gray-100 transition-colors">
                    Mulai Review
                </button>
            </div>
        </section> --}}

        <!-- Search & Filter Controls -->
        <div
            class="max-w-6xl mx-auto bg-gray-50 p-4 rounded-t-xl border-x border-t border-gray-200 flex flex-wrap items-center justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
                <input id="search" name="search"
                    class="w-full bg-white border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all outline-none"
                    placeholder="Cari Surah atau Kata Kunci..." type="text" value="{{ request('search') }}"
                    onkeyup="handleSearch(event)" />
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button onclick="toggleSortDropdown()"
                        class="flex items-center gap-2 bg-white border border-gray-300 px-3 py-2 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                        <span class="material-symbols-outlined text-lg">sort</span>
                        <span class="text-sm">Urutkan</span>
                        @if (request('sort'))
                            <span
                                class="bg-emerald-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ request('sort') == 'terbaru' ? 'Terbaru' : 'Terlama' }}</span>
                        @endif
                    </button>
                    <div id="sortDropdown"
                        class="hidden absolute top-full left-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-20 min-w-[150px]">
                        <a href="{{ route('admin.validasi.index', array_merge(request()->except('sort', 'page'), ['sort' => 'terbaru'])) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ request('sort') == 'terbaru' || !request('sort') ? 'text-emerald-600 font-medium' : 'text-gray-700' }}">
                            📅 Terbaru
                        </a>
                        <a href="{{ route('admin.validasi.index', array_merge(request()->except('sort', 'page'), ['sort' => 'terlama'])) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ request('sort') == 'terlama' ? 'text-emerald-600 font-medium' : 'text-gray-700' }}">
                            📅 Terlama
                        </a>
                    </div>
                </div>
                <div class="h-8 w-px bg-gray-200 hidden md:block"></div>
                {{-- <div class="flex items-center gap-2 text-sm">
                    <span class="text-gray-500">Tampilan:</span>
                    <div class="flex bg-gray-100 p-1 rounded-lg">
                        <button class="p-1.5 bg-white rounded shadow-sm text-emerald-700">
                            <span class="material-symbols-outlined text-lg block">table_rows</span>
                        </button>
                        <button class="p-1.5 text-gray-400 hover:text-gray-600 transition-colors">
                            <span class="material-symbols-outlined text-lg block">grid_view</span>
                        </button>
                    </div>
                </div> --}}
                @if (request('search') || request('sort'))
                    <a href="{{ route('admin.validasi.index') }}"
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
                        <th class="px-6 py-4 font-semibold text-sm">Surah/Ayat</th>
                        <th class="px-6 py-4 font-semibold text-sm">Usulan Diksi Baru</th>

                        <th class="px-6 py-4 font-semibold text-sm">Tanggal Masuk</th>
                        <th class="px-6 py-4 font-semibold text-sm text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($usulan as $item)
                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-on-surface">{{ $item->ayat->nama_surah ?? 'Surah' }}:
                                        {{ $item->ayat->nomor_ayat ?? '-' }}</span>
                                    <span class="text-xs text-gray-500">Juz {{ $item->ayat->juz ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="max-w-md">
                                    <p class="text-sm italic line-clamp-2 text-emerald-900">
                                        "{{ Str::limit($item->usulan_teks, 100) }}"</p>
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <span class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</span>
                                <p class="text-xs text-gray-400">{{ $item->created_at->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @if (in_array($item->status, ['diterima', 'ditolak']))
                                    <!-- Kondisi 3: Selesai/Ditolak -->
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-semibold {{ $item->status == 'diterima' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            <span class="material-symbols-outlined text-sm">{{ $item->status == 'diterima' ? 'check_circle' : 'cancel' }}</span>
                                            {{ $item->status == 'diterima' ? 'Telah Diterima' : 'Telah Ditolak' }}
                                        </span>
                                        <div class="flex items-center gap-2 mt-1">
                                            <a href="{{ route('admin.validasi.chat.show', $item->id) }}" 
                                               class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-2.5 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all flex items-center gap-1" title="Lihat Riwayat Chat">
                                                <span class="material-symbols-outlined text-[14px]">history</span> Riwayat Chat
                                            </a>
                                            <button onclick="showDetail({{ $item->id }})" 
                                                    class="bg-emerald-50 text-emerald-700 hover:bg-emerald-100 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-colors flex items-center gap-1" title="Lihat Detail">
                                                <span class="material-symbols-outlined text-[14px]">visibility</span> Detail
                                            </button>
                                        </div>
                                    </div>

                                @elseif(!$item->tim_lengkap)
                                    <!-- Kondisi 1: Tim Belum Lengkap -->
                                    <div class="flex flex-col items-center gap-1">
                                        <button disabled class="bg-gray-200 text-gray-500 px-3 py-1.5 rounded-lg text-xs font-bold cursor-not-allowed flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-sm">hourglass_top</span>
                                            Tim ({{ $item->total_pakar }}/3)
                                        </button>
                                        <p class="text-[10px] text-gray-400 mb-1">Kurang {{ 3 - $item->total_pakar }} pakar</p>
                                        <button onclick="showDetail({{ $item->id }})" class="text-emerald-600 hover:bg-emerald-50 px-2.5 py-1 rounded-lg text-xs font-bold transition-colors flex items-center gap-1" title="Lihat Detail">
                                            <span class="material-symbols-outlined text-[14px]">visibility</span> Detail
                                        </button>
                                    </div>

                                @elseif($item->tim_lengkap && !$item->is_expired)
                                    <!-- Kondisi 2: Tim Lengkap, Belum Kadaluarsa - Tampilkan Tombol Masuk Chat -->
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="flex flex-wrap justify-center items-center gap-2">
                                            <a href="{{ route('admin.validasi.chat.show', $item->id) }}"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-[14px]">chat</span> Chat Validasi
                                            </a>
                                            <button onclick="showDetail({{ $item->id }})"
                                                class="bg-white border border-emerald-200 text-emerald-700 hover:bg-emerald-50 px-2.5 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all flex items-center gap-1" title="Lihat Detail">
                                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                                            </button>
                                        </div>
                                        <div class="flex items-center gap-1 text-[10px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full font-semibold countdown-timer border border-emerald-100">
                                            <span class="material-symbols-outlined text-[12px]">schedule</span> Sisa {{ round($item->sisa_hari) }} hari
                                        </div>
                                    </div>

                                @else
                                    <!-- Kondisi 4: Usulan Kadaluarsa -->
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-semibold bg-orange-100 text-orange-700">
                                            <span class="material-symbols-outlined text-sm">warning</span> Kadaluarsa
                                        </span>
                                        <div class="flex items-center gap-2 mt-1">
                                            <a href="{{ route('admin.validasi.chat.show', $item->id) }}" 
                                               class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-2.5 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all flex items-center gap-1" title="Lihat Riwayat Chat">
                                                <span class="material-symbols-outlined text-[14px]">history</span> Riwayat
                                            </a>
                                            <button onclick="showDetail({{ $item->id }})" 
                                                    class="bg-emerald-50 text-emerald-700 hover:bg-emerald-100 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-colors flex items-center gap-1" title="Lihat Detail">
                                                <span class="material-symbols-outlined text-[14px]">visibility</span> Detail
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">inbox</span>
                                    <p class="text-gray-500">Belum ada usulan yang diklaim</p>
                                    <p class="text-xs text-gray-400 mt-1">Usulan akan muncul setelah Anda mengklaimnya
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
                        <button
                            class="p-2 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed"
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
                        <button
                            class="p-2 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed"
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Search handler
        let searchTimeout;

        function handleSearch(event) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchValue = event.target.value;
                const currentUrl = new URL(window.location.href);
                if (searchValue) {
                    currentUrl.searchParams.set('search', searchValue);
                } else {
                    currentUrl.searchParams.delete('search');
                }
                currentUrl.searchParams.delete('page');
                window.location.href = currentUrl.toString();
            }, 500);
        }

        // Toggle Sort Dropdown
        function toggleSortDropdown() {
            const dropdown = document.getElementById('sortDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('sortDropdown');
            const button = event.target.closest('[onclick="toggleSortDropdown()"]');
            if (!button && dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

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
                const response = await fetch(`/admin/validasi/${id}`);
                const result = await response.json();

                if (result.success) {
                    const data = result.data;
                    content.innerHTML = `
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Ayat</p>
                                <p class="font-semibold text-lg text-emerald-700">
                                    QS ${data.ayat?.no_surah || '?'}:${data.ayat?.nomorAyat || '?'}
                                </p>
                                <p class="text-sm text-gray-600">${escapeHtml(data.ayat?.surah?.nama_latin || 'Surah')}</p>
                                ${data.ayat?.Arab ? `<p class="arabic-font text-right text-3xl mt-2">${escapeHtml(data.ayat.Arab)}</p>` : ''}
                                ${data.ayat?.teks_gorontalo ? `<p class="text-right text-md mt-2 italic">${escapeHtml(data.ayat.teks_gorontalo)}</p>` : ''}
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Pengusul</p>
                                <p class="font-semibold">${escapeHtml(data.nama_pengusul)}</p>
                                <p class="text-sm text-gray-600">${escapeHtml(data.no_hp || '-')}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Usulan Terjemahan (Hulontalo)</p>
                                <p class="bg-yellow-50 p-3 rounded-lg italic">"${escapeHtml(data.usulan_teks)}"</p>
                            </div>
                            
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Catatan Linguistik</p>
                                <p class="bg-gray-50 p-3 rounded-lg">${escapeHtml(data.catatan_linguistik || 'Belum ada catatan')}</p>
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
                            
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">Tim Validator</p>
                                <div class="space-y-1">
                                    <p class="text-sm font-medium">Jumlah Pakar: ${data.assignments?.length || 0}/3</p>
                                    ${data.assignments && data.assignments.length > 0 ? `
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                    ${data.assignments.map(ass => `
                                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-white rounded-md text-xs">
                                                    <span class="material-symbols-outlined text-xs">person</span>
                                                    ${escapeHtml(ass.user?.name || 'Pakar')}
                                                </span>
                                            `).join('')}
                                                </div>
                                            ` : '<p class="text-xs text-gray-500">Belum ada pakar yang mengklaim</p>'}
                                </div>
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
                closeModal();
            }
        });
    </script>
</body>

</html>
