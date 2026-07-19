@extends('layouts.app')
@section('content')
    <!-- Main Canvas -->
    <main class="flex-1 ml-64 p-6 pattern-bg min-h-screen">
        <!-- Top Header & Breadcrumbs -->
        <header class="max-w-7xl mx-auto mb-6">
            <nav class="flex items-center gap-2 text-gray-500 mb-4">

                <span class="text-xs text-emerald-700 font-medium">Validator Dashboard</span>
            </nav>
            <div class="flex justify-between items-end flex-wrap gap-4">
                <div>
                    <h2 class="text-4xl font-bold text-emerald-800 mb-2">Validator Dashboard</h2>
                    <p class="text-gray-600">Kelola, tinjau, dan validasi usulan terjemahan bahasa Gorontalo dari masyarakat.
                    </p>
                </div>
                <div class="flex gap-4">
                    {{-- <button onclick="exportData()"
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-medium hover:bg-gray-200 transition-colors">
                        <span class="material-symbols-outlined text-lg">file_download</span>
                        Ekspor Laporan
                    </button> --}}
                    <button onclick="refreshData()"
                        class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-medium hover:bg-emerald-200 transition-colors">
                        <span class="material-symbols-outlined text-lg">refresh</span>
                        Refresh
                    </button>
                </div>
            </div>
        </header>

        <!-- Stats Overview -->
        <section class="max-w-7xl mx-auto grid grid-cols-12 gap-6 mb-8">
            <div class="col-span-8 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-2">Total Usulan</p>
                        <h3 class="text-4xl font-bold text-emerald-800 leading-none" id="totalUsulan">
                            {{ number_format($statusCount['total']) }}</h3>
                        {{-- <p class="text-xs text-emerald-700 font-medium mt-4 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm"
                                id="trendIcon">{{ $percentageChange >= 0 ? 'trending_up' : 'trending_down' }}</span>
                            <span
                                id="percentageChange">{{ $percentageChange >= 0 ? '+' : '' }}{{ $percentageChange }}</span>%
                            dari minggu lalu
                        </p> --}}
                    </div>
                    <div class="h-24 w-48 relative">
                        <div class="absolute bottom-0 left-0 w-full h-full flex items-end gap-1">
                            @php
                                $total = max(1, $statusCount['total']);
                                $menungguPercent = ($statusCount['menunggu'] / $total) * 100;
                                $diterimaPercent = ($statusCount['diterima'] / $total) * 100;
                                $ditolakPercent = ($statusCount['ditolak'] / $total) * 100;
                            @endphp
                            <div class="w-1/3 bg-yellow-400 rounded-t-sm transition-all duration-500"
                                style="height: {{ $menungguPercent }}%"></div>
                            <div class="w-1/3 bg-green-500 rounded-t-sm transition-all duration-500"
                                style="height: {{ $diterimaPercent }}%"></div>
                            <div class="w-1/3 bg-red-500 rounded-t-sm transition-all duration-500"
                                style="height: {{ $ditolakPercent }}%"></div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4 mt-4 pt-2 border-t border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <span class="text-xs text-gray-500">Menunggu: <span
                                id="menungguCount">{{ number_format($statusCount['menunggu']) }}</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="text-xs text-gray-500">Diterima: <span
                                id="diterimaCount">{{ number_format($statusCount['diterima']) }}</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="text-xs text-gray-500">Ditolak: <span
                                id="ditolakCount">{{ number_format($statusCount['ditolak']) }}</span></span>
                    </div>
                </div>
            </div>
            <div
                class="col-span-4 bg-gradient-to-br from-emerald-700 to-emerald-800 text-white rounded-xl p-6 flex flex-col justify-between shadow-lg">
                <div>
                    <span class="material-symbols-outlined text-3xl mb-4">assignment_late</span>
                    <p class="text-sm font-semibold">Perlu Perhatian</p>
                    <p class="text-xs opacity-80 mt-1"><span id="pendingAttention">{{ $statusCount['menunggu'] }}</span>
                        usulan menunggu untuk direview.</p>
                    @if ($priorityUsulan > 0)
                        <p class="text-xs opacity-70 mt-2">*<span id="priorityCount">{{ $priorityUsulan }}</span> usulan
                            dari Surah Al-Baqarah</p>
                    @endif
                </div>
                <button onclick="filterByStatus('menunggu')"
                    class="bg-white text-emerald-800 font-bold text-sm py-2 rounded-lg w-full mt-6 hover:bg-gray-100 transition-colors">
                    Review Usulan
                </button>
            </div>
        </section>

        <!-- Search & Filter Controls -->
        <div
            class="max-w-7xl mx-auto bg-gray-50 p-4 rounded-t-xl border-x border-t border-gray-200 flex flex-wrap items-center justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
                <input id="search" name="search"
                    class="w-full bg-white border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all outline-none"
                    placeholder="Cari ayat, kata, atau pengirim..." type="text" value="{{ request('search') }}"
                    onkeyup="handleSearch(event)" />
            </div>
            <div class="flex items-center gap-4 flex-wrap">
                <div class="relative">
                    <button onclick="toggleStatusDropdown()"
                        class="flex items-center gap-2 bg-white border border-gray-300 px-3 py-2 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                        <span class="material-symbols-outlined text-lg">filter_list</span>
                        <span class="text-sm">Filter Status</span>
                        <span id="activeStatusBadge"
                            class="hidden bg-emerald-500 text-white text-xs px-1.5 py-0.5 rounded-full"></span>
                    </button>
                    <div id="statusDropdown"
                        class="hidden absolute top-full left-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-20 min-w-[150px]">
                        <button onclick="filterByStatus('all')"
                            class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-50 transition-colors">
                            Semua Status
                        </button>
                        <button onclick="filterByStatus('menunggu')"
                            class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-50 transition-colors">
                            ⏳ Menunggu
                        </button>
                        <button onclick="filterByStatus('diterima')"
                            class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-50 transition-colors">
                            ✓ Diterima
                        </button>
                        <button onclick="filterByStatus('ditolak')"
                            class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-50 transition-colors">
                            ✗ Ditolak
                        </button>
                    </div>
                </div>

                <div class="relative">
                    <button onclick="toggleSortDropdown()"
                        class="flex items-center gap-2 bg-white border border-gray-300 px-3 py-2 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                        <span class="material-symbols-outlined text-lg">sort</span>
                        <span class="text-sm">Urutkan</span>
                    </button>
                    <div id="sortDropdown"
                        class="hidden absolute top-full left-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-20 min-w-[180px]">
                        <button onclick="sortBy('terbaru')"
                            class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-50 transition-colors">
                            📅 Terbaru
                        </button>
                        <button onclick="sortBy('terlama')"
                            class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-50 transition-colors">
                            📅 Terlama
                        </button>
                        <button onclick="sortBy('surah')"
                            class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-50 transition-colors">
                            📖 Nama Surah
                        </button>
                        <button onclick="sortBy('ayat')"
                            class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-50 transition-colors">
                            🔢 Nomor Ayat
                        </button>
                    </div>
                </div>

                <div class="relative">
                    <button onclick="toggleDateDropdown()"
                        class="flex items-center gap-2 bg-white border border-gray-300 px-3 py-2 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                        <span class="material-symbols-outlined text-lg">calendar_today</span>
                        <span class="text-sm">Rentang Waktu</span>
                        <span id="activeDateBadge"
                            class="hidden bg-emerald-500 text-white text-xs px-1.5 py-0.5 rounded-full">●</span>
                    </button>
                    <div id="dateDropdown"
                        class="hidden absolute top-full left-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-20 p-4 min-w-[280px]">
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs text-gray-600 block mb-1">Dari Tanggal</label>
                                <input type="date" id="dateFrom"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-gray-600 block mb-1">Sampai Tanggal</label>
                                <input type="date" id="dateTo"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div class="flex gap-2 pt-2">
                                <button onclick="applyDateFilter()"
                                    class="flex-1 bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-sm">Terapkan</button>
                                <button onclick="resetDateFilter()"
                                    class="flex-1 bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-sm">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button id="resetFiltersBtn" onclick="resetAllFilters()"
                    class="hidden text-sm text-gray-500 hover:text-emerald-600 transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">close</span>
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Data Table -->
        <div class="max-w-7xl mx-auto bg-white border border-gray-200 rounded-b-xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 border-b border-gray-200">
                            <th class="px-6 py-4 font-semibold text-sm cursor-pointer hover:bg-gray-100 transition-colors"
                                onclick="sortBy('surah')">
                                Ayat <span class="material-symbols-outlined text-sm inline-block">unfold_more</span>
                            </th>
                            <th class="px-6 py-4 font-semibold text-sm">Usulan (Hulontalo)</th>
                            <th class="px-6 py-4 font-semibold text-sm">Pengirim</th>
                            <th class="px-6 py-4 font-semibold text-sm cursor-pointer hover:bg-gray-100 transition-colors"
                                onclick="sortBy('terbaru')">
                                Waktu <span class="material-symbols-outlined text-sm inline-block">unfold_more</span>
                            </th>
                            <th class="px-6 py-4 font-semibold text-sm">Status</th>
                            <th class="px-6 py-4 font-semibold text-sm text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-gray-100">
                        @forelse($usulan as $item)
                            <tr class="table-row-hover transition-colors group" data-id="{{ $item->id }}"
                                data-status="{{ $item->status }}" data-created-at="{{ $item->created_at }}">
                                <td class="px-6 py-5">
                                    <span class="text-sm font-bold text-emerald-700">QS
                                        {{ $item->ayat->no_surah }}:{{ $item->ayat->nomorAyat }}</span>
                                    <p class="text-xs text-gray-500">{{ $item->ayat->surah->nama_latin ?? 'Surah' }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="max-w-xs">
                                        <p class="text-sm italic line-clamp-2">"{{ Str::limit($item->usulan_teks, 100) }}"
                                        </p>
                                        @if ($item->alasan_usulan)
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ Str::limit($item->alasan_usulan, 60) }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-[10px] 
                                        {{ $item->status == 'menunggu'
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : ($item->status == 'diterima'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-red-100 text-red-700') }}">
                                            {{ strtoupper(substr($item->nama_pengusul, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium">{{ $item->nama_pengusul }}</span>
                                            @if ($item->no_hp)
                                                <p class="text-xs text-gray-400">{{ $item->no_hp }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</span>
                                    <p class="text-xs text-gray-400">{{ $item->created_at->format('d/m/Y H:i') }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium 
                                        {{ $item->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $item->status == 'diterima' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $item->status == 'dipublikasi' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $item->status == 'diarsipkan' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $item->status == 'ditolak' ? 'bg-red-100 text-red-800' : '' }}">

                                        {{ ucfirst($item->status) }}
                                    </span>
                                    @if ($item->catatan_validator)
                                        <p class="text-xs text-gray-400 mt-1">Catatan:
                                            {{ Str::limit($item->catatan_validator, 30) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
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
            </div>

            <!-- Pagination -->
            <div
                class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500" id="paginationInfo">
                    Menampilkan {{ $usulan->firstItem() ?? 0 }} - {{ $usulan->lastItem() ?? 0 }} dari
                    {{ $usulan->total() }} usulan
                </p>
                <div class="flex items-center gap-1" id="paginationLinks">
                    {!! $usulan->links() !!}
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Detail Usulan -->
    <div id="detailModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-smooth">
        <div class="bg-white rounded-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto transform transition-all scale-95 opacity-0"
            id="detailModalContent">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white">
                <h3 class="text-xl font-bold text-emerald-800">Detail Usulan</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="p-6" id="detailContent">
                <div class="text-center py-8">
                    <div class="inline-block animate-spin-custom rounded-full h-8 w-8 border-b-2 border-emerald-600"></div>
                    <p class="text-gray-500 mt-2">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Validasi -->
    <div id="validationModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-smooth">
        <div class="bg-white rounded-xl max-w-2xl w-full mx-4 transform transition-all scale-95 opacity-0"
            id="validationModalContent">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-emerald-800">Validasi Usulan</h3>
                <button onclick="closeValidationModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="validationForm" class="p-6 space-y-4">
                @csrf
                @method('PATCH')
                <input type="hidden" id="validationUsulanId" name="usulan_id">

                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Usulan Teks:</p>
                    <p class="text-lg italic text-gray-800" id="validationUsulanTeks"></p>
                    <p class="text-xs text-gray-500 mt-2" id="validationAyatInfo"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Validasi</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="diterima"
                                class="text-green-600 focus:ring-green-500">
                            <span class="text-sm">✓ Diterima</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="ditolak"
                                class="text-red-600 focus:ring-red-500">
                            <span class="text-sm">✗ Ditolak</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Validator</label>
                    <textarea name="catatan" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                        placeholder="Berikan alasan diterima/ditolak..."></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors">
                        Simpan Validasi
                    </button>
                    <button type="button" onclick="closeValidationModal()"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Modal animation */
        #detailModal.show #detailModalContent,
        #validationModal.show #validationModalContent {
            transform: scale(1);
            opacity: 1;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

    <script>
        // Global variables
        let currentStatusFilter = '{{ request('status', 'all') }}';
        let currentSearch = '{{ request('search') }}';
        let currentSort = 'terbaru';
        let currentDateFrom = '{{ request('date_from') }}';
        let currentDateTo = '{{ request('date_to') }}';

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateFilterBadges();

            // Add animation to modals
            const detailModal = document.getElementById('detailModal');
            const validationModal = document.getElementById('validationModal');

            if (detailModal) {
                detailModal.addEventListener('click', function(e) {
                    if (e.target === detailModal) closeDetailModal();
                });
            }

            if (validationModal) {
                validationModal.addEventListener('click', function(e) {
                    if (e.target === validationModal) closeValidationModal();
                });
            }
        });

        // Toggle dropdowns
        function toggleStatusDropdown() {
            const dropdown = document.getElementById('statusDropdown');
            dropdown.classList.toggle('hidden');
            document.getElementById('sortDropdown')?.classList.add('hidden');
            document.getElementById('dateDropdown')?.classList.add('hidden');
        }

        function toggleSortDropdown() {
            const dropdown = document.getElementById('sortDropdown');
            dropdown.classList.toggle('hidden');
            document.getElementById('statusDropdown')?.classList.add('hidden');
            document.getElementById('dateDropdown')?.classList.add('hidden');
        }

        function toggleDateDropdown() {
            const dropdown = document.getElementById('dateDropdown');
            dropdown.classList.toggle('hidden');
            document.getElementById('statusDropdown')?.classList.add('hidden');
            document.getElementById('sortDropdown')?.classList.add('hidden');
        }

        // Filter functions
        function filterByStatus(status) {
            currentStatusFilter = status;
            updateFilterBadges();
            applyFilters();
            document.getElementById('statusDropdown')?.classList.add('hidden');
        }

        function sortBy(sortType) {
            currentSort = sortType;
            applyFilters();
            document.getElementById('sortDropdown')?.classList.add('hidden');
        }

        function applyDateFilter() {
            currentDateFrom = document.getElementById('dateFrom').value;
            currentDateTo = document.getElementById('dateTo').value;
            updateFilterBadges();
            applyFilters();
            document.getElementById('dateDropdown')?.classList.add('hidden');
        }

        function resetDateFilter() {
            currentDateFrom = '';
            currentDateTo = '';
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
            updateFilterBadges();
            applyFilters();
        }

        function resetAllFilters() {
            currentStatusFilter = 'all';
            currentSearch = '';
            currentSort = 'terbaru';
            currentDateFrom = '';
            currentDateTo = '';
            document.getElementById('search').value = '';
            document.getElementById('dateFrom').value = '';
            document.getElementById('dateTo').value = '';
            updateFilterBadges();
            applyFilters();
        }

        function updateFilterBadges() {
            const resetBtn = document.getElementById('resetFiltersBtn');
            const statusBadge = document.getElementById('activeStatusBadge');
            const dateBadge = document.getElementById('activeDateBadge');

            let hasActiveFilters = false;

            if (currentStatusFilter !== 'all') {
                statusBadge.textContent = currentStatusFilter === 'menunggu' ? 'Menunggu' :
                    (currentStatusFilter === 'diterima' ? 'Diterima' : 'Ditolak');
                statusBadge.classList.remove('hidden');
                hasActiveFilters = true;
            } else {
                statusBadge.classList.add('hidden');
            }

            if (currentDateFrom || currentDateTo) {
                dateBadge.classList.remove('hidden');
                hasActiveFilters = true;
            } else {
                dateBadge.classList.add('hidden');
            }

            if (hasActiveFilters || currentSearch) {
                resetBtn.classList.remove('hidden');
            } else {
                resetBtn.classList.add('hidden');
            }
        }

        // Search handler
        let searchTimeout;

        function handleSearch(event) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = event.target.value;
                applyFilters();
            }, 500);
        }

        // Apply all filters
        function applyFilters() {
            const rows = document.querySelectorAll('#tableBody tr');
            let visibleCount = 0;
            let rowsArray = Array.from(rows);

            // Filter rows
            rowsArray = rowsArray.filter(row => {
                if (row.querySelector('td[colspan]')) return true;

                const status = row.getAttribute('data-status');
                const createdAt = row.getAttribute('data-created-at');
                const ayat = row.querySelector('td:first-child .text-sm')?.textContent.toLowerCase() || '';
                const usulan = row.querySelector('td:nth-child(2) .text-sm')?.textContent.toLowerCase() || '';
                const pengirim = row.querySelector('td:nth-child(3) .text-sm')?.textContent.toLowerCase() || '';

                // Status filter
                let statusMatch = currentStatusFilter === 'all' || status === currentStatusFilter;

                // Search filter
                let searchMatch = !currentSearch ||
                    ayat.includes(currentSearch.toLowerCase()) ||
                    usulan.includes(currentSearch.toLowerCase()) ||
                    pengirim.includes(currentSearch.toLowerCase());

                // Date filter
                let dateMatch = true;
                if (currentDateFrom || currentDateTo) {
                    const rowDate = new Date(createdAt);
                    if (currentDateFrom) {
                        const fromDate = new Date(currentDateFrom);
                        fromDate.setHours(0, 0, 0, 0);
                        if (rowDate < fromDate) dateMatch = false;
                    }
                    if (currentDateTo && dateMatch) {
                        const toDate = new Date(currentDateTo);
                        toDate.setHours(23, 59, 59, 999);
                        if (rowDate > toDate) dateMatch = false;
                    }
                }

                return statusMatch && searchMatch && dateMatch;
            });

            // Sort rows
            rowsArray.sort((a, b) => {
                if (currentSort === 'terbaru') {
                    const dateA = new Date(a.getAttribute('data-created-at'));
                    const dateB = new Date(b.getAttribute('data-created-at'));
                    return dateB - dateA;
                } else if (currentSort === 'terlama') {
                    const dateA = new Date(a.getAttribute('data-created-at'));
                    const dateB = new Date(b.getAttribute('data-created-at'));
                    return dateA - dateB;
                } else if (currentSort === 'surah') {
                    const surahA = a.querySelector('td:first-child .text-gray-500')?.textContent || '';
                    const surahB = b.querySelector('td:first-child .text-gray-500')?.textContent || '';
                    return surahA.localeCompare(surahB);
                } else if (currentSort === 'ayat') {
                    const ayatA = parseInt(a.querySelector('td:first-child .text-sm')?.textContent.split(':')[1]) ||
                        0;
                    const ayatB = parseInt(b.querySelector('td:first-child .text-sm')?.textContent.split(':')[1]) ||
                        0;
                    return ayatA - ayatB;
                }
                return 0;
            });

            // Update table
            const tbody = document.getElementById('tableBody');
            const emptyRow = rowsArray.find(row => row.querySelector('td[colspan]'));

            if (rowsArray.length === 0 || (rowsArray.length === 1 && emptyRow)) {
                if (!emptyRow) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">inbox</span>
                                    <p class="text-gray-500">Tidak ada data yang sesuai</p>
                                    <p class="text-xs text-gray-400 mt-1">Coba ubah filter pencarian</p>
                                </div>
                            </td>
                        </tr>
                    `;
                }
            } else {
                tbody.innerHTML = '';
                rowsArray.forEach(row => {
                    if (!row.querySelector('td[colspan]')) {
                        tbody.appendChild(row.cloneNode(true));
                    }
                });
                visibleCount = rowsArray.length;
            }

            // Update pagination info
            const paginationInfo = document.getElementById('paginationInfo');
            if (paginationInfo) {
                paginationInfo.textContent = `Menampilkan 1-${visibleCount} dari ${visibleCount} usulan`;
            }
        }

        // Show detail modal
        async function showDetail(id) {
            const modal = document.getElementById('detailModal');
            const modalContent = document.getElementById('detailModalContent');
            const content = document.getElementById('detailContent');

            content.innerHTML = `
                <div class="text-center py-8">
                    <div class="inline-block animate-spin-custom rounded-full h-8 w-8 border-b-2 border-emerald-600"></div>
                    <p class="text-gray-500 mt-2">Memuat data...</p>
                </div>
            `;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);

            try {
                const response = await fetch(`/admin/usulan/${id}`);
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
                                        ${data.status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                          (data.status == 'diterima' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')}">
                                        ${data.status == 'menunggu' ? 'Menunggu' : (data.status == 'diterima' ? 'Diterima' : 'Ditolak')}
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
                                    </div>
                                    ` : ''}
                            
                            ${data.validated_at ? `
                                    <div>
                                        <p class="text-xs text-gray-500">Waktu Validasi</p>
                                        <p class="text-sm">${formatDate(data.validated_at)}</p>
                                    </div>
                                    ` : ''}
                        </div>
                    `;
                } else {
                    content.innerHTML =
                        `<div class="text-center py-8 text-red-500">${result.message || 'Gagal memuat data'}</div>`;
                }
            } catch (error) {
                console.error('Error:', error);
                content.innerHTML =
                    '<div class="text-center py-8 text-red-500">Terjadi kesalahan saat memuat data</div>';
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

        // Validation modal
        function openValidationModal(id, usulanTeks, surah, ayat) {
            const modal = document.getElementById('validationModal');
            const modalContent = document.getElementById('validationModalContent');

            document.getElementById('validationUsulanId').value = id;
            document.getElementById('validationUsulanTeks').textContent = usulanTeks;
            document.getElementById('validationAyatInfo').textContent = `QS ${surah}:${ayat}`;

            // Reset form
            document.querySelectorAll('input[name="status"]').forEach(radio => radio.checked = false);
            document.querySelector('textarea[name="catatan"]').value = '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }

        function closeValidationModal() {
            const modal = document.getElementById('validationModal');
            modal.classList.remove('show');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Delete usulan
        async function deleteUsulan(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus usulan ini?')) return;

            try {
                const response = await fetch(`/admin/usulan/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const result = await response.json();

                if (result.success) {
                    alert('Usulan berhasil dihapus');
                    window.location.reload();
                } else {
                    alert(result.message || 'Gagal menghapus usulan');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus usulan');
            }
        }

        // Export data
        function exportData() {
            const params = new URLSearchParams();
            if (currentStatusFilter !== 'all') params.set('status', currentStatusFilter);
            if (currentSearch) params.set('search', currentSearch);
            if (currentDateFrom) params.set('date_from', currentDateFrom);
            if (currentDateTo) params.set('date_to', currentDateTo);
            params.set('export', 'true');

            window.location.href = `/admin/usulan?${params.toString()}`;
        }

        function refreshData() {
            window.location.reload();
        }

        // Handle validation form submit
        document.getElementById('validationForm')?.addEventListener('submit', async (e) => {
            e.preventDefault();

            const id = document.getElementById('validationUsulanId').value;
            const status = document.querySelector('input[name="status"]:checked')?.value;
            const catatan = document.querySelector('textarea[name="catatan"]').value;

            if (!status) {
                alert('Pilih status validasi terlebih dahulu');
                return;
            }

            try {
                const response = await fetch(`/admin/usulan/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        status,
                        catatan
                    })
                });

                const result = await response.json();

                if (result.success) {
                    alert('Validasi berhasil disimpan');
                    window.location.reload();
                } else {
                    alert(result.message || 'Gagal menyimpan validasi');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan validasi');
            }
        });

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
            return date.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const statusDropdown = document.getElementById('statusDropdown');
            const sortDropdown = document.getElementById('sortDropdown');
            const dateDropdown = document.getElementById('dateDropdown');

            const statusButton = event.target.closest('[onclick="toggleStatusDropdown()"]');
            const sortButton = event.target.closest('[onclick="toggleSortDropdown()"]');
            const dateButton = event.target.closest('[onclick="toggleDateDropdown()"]');

            if (!statusButton && statusDropdown && !statusDropdown.contains(event.target)) {
                statusDropdown.classList.add('hidden');
            }
            if (!sortButton && sortDropdown && !sortDropdown.contains(event.target)) {
                sortDropdown.classList.add('hidden');
            }
            if (!dateButton && dateDropdown && !dateDropdown.contains(event.target)) {
                dateDropdown.classList.add('hidden');
            }
        });
    </script>
@endsection
