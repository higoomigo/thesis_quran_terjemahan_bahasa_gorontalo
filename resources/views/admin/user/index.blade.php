@extends('layouts.app')
@section('content')
    <main class="flex-1 ml-64 p-6 pattern-bg min-h-screen">
        <!-- Top Header & Breadcrumbs -->
        <header class="max-w-6xl mx-auto mb-6">
            <nav class="flex items-center gap-2 text-gray-500 mb-4">
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Administrator</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs text-emerald-700 font-medium">Manajemen Pengguna</span>
            </nav>
            <div class="flex justify-between items-end flex-wrap gap-4">
                <div>
                    <h2 class="text-4xl font-bold text-emerald-800 mb-2">Manajemen Pengguna</h2>
                    <p class="text-gray-600">Kelola akun, peran, dan hak akses pengguna sistem.</p>
                </div>
                <div class="flex gap-4">
                    <button onclick="openCreateModal()"
                        class="bg-emerald-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 text-sm font-medium hover:bg-emerald-800 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-lg">person_add</span>
                        Tambah Pengguna
                    </button>
                </div>
            </div>
        </header>

        <!-- Stats Overview -->
        <section class="max-w-6xl mx-auto grid grid-cols-12 gap-6 mb-8">
            <div class="col-span-12 bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-2">Total Pengguna</p>
                        <h3 class="text-4xl font-bold text-emerald-800 leading-none">
                            {{ number_format($roleCount['all']) }}
                        </h3>
                        <p class="text-xs text-emerald-700 font-medium mt-4 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">verified_user</span>
                            {{ $roleCount['admin'] + $roleCount['editor'] }} Pengelola Aktif
                        </p>
                    </div>
                    <div class="h-24 w-48 relative">
                        <div class="absolute bottom-0 left-0 w-full h-full flex items-end gap-1">
                            @php
                                $roles = ['admin', 'editor', 'teologi', 'linguistik'];
                                $colors = ['bg-emerald-600', 'bg-blue-500', 'bg-purple-500', 'bg-amber-500'];
                            @endphp
                            @foreach ($roles as $i => $r)
                                @php
                                    $val = $roleCount[$r] ?? 0;
                                    $pct = $roleCount['all'] > 0 ? max(5, min(95, ($val / $roleCount['all']) * 100)) : 5;
                                @endphp
                                <div class="w-1/4 {{ $colors[$i] }} h-[{{ $pct }}%] rounded-t-sm" title="{{ ucfirst($r) }}: {{ $val }}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 mt-4 pt-2 border-t border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-emerald-600"></div>
                        <span class="text-xs text-gray-500">Admin: {{ $roleCount['admin'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                        <span class="text-xs text-gray-500">Editor: {{ $roleCount['editor'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                        <span class="text-xs text-gray-500">Teologi: {{ $roleCount['teologi'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <span class="text-xs text-gray-500">Linguistik: {{ $roleCount['linguistik'] }}</span>
                    </div>
                    {{-- <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                        <span class="text-xs text-gray-500">Belum Aktif: {{ $roleCount['null'] }}</span>
                    </div> --}}
                </div>
            </div>
            {{-- <div class="col-span-4 bg-emerald-700 text-white rounded-xl p-6 flex flex-col justify-between shadow-lg">
                <div>
                    <span class="material-symbols-outlined text-3xl mb-4">admin_panel_settings</span>
                    <p class="text-sm font-semibold">Manajemen Akses</p>
                    <p class="text-xs opacity-80 mt-1">
                        {{ $roleCount['null'] }} pengguna belum memiliki peran. Segera tetapkan hak akses mereka.
                    </p>
                </div>
                <button onclick="document.getElementById('search').focus()"
                    class="bg-white text-emerald-800 font-bold text-sm py-2 rounded-lg w-full mt-6 hover:bg-gray-100 transition-colors">
                    Kelola Sekarang
                </button>
            </div> --}}
        </section>

        <!-- Search & Filter Controls -->
        <div class="max-w-6xl mx-auto bg-gray-50 p-4 rounded-t-xl border-x border-t border-gray-200 flex flex-wrap items-center justify-between gap-4">
            <div class="relative flex-1 max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xl">search</span>
                <input id="search" name="search"
                    class="w-full bg-white border border-gray-300 rounded-lg py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all outline-none"
                    placeholder="Cari nama, email, atau no. HP..." type="text" value="{{ request('search') }}"
                    onkeyup="if(event.key === 'Enter') window.location.href='{{ route('admin.user.index') }}?search='+this.value+'&role={{ request('role') }}'" />
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button onclick="toggleRoleDropdown()"
                        class="flex items-center gap-2 bg-white border border-gray-300 px-3 py-2 rounded-lg cursor-pointer hover:border-emerald-500 transition-colors">
                        <span class="material-symbols-outlined text-lg">filter_list</span>
                        <span class="text-sm">Filter Peran</span>
                        @if (request('role') && request('role') !== 'all')
                            <span class="bg-emerald-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ request('role') }}</span>
                        @endif
                    </button>
                    <div id="roleDropdown"
                        class="hidden absolute top-full right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg z-20 min-w-[170px]">
                        <a href="{{ route('admin.user.index', ['search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ !request('role') || request('role') == 'all' ? 'text-emerald-600 font-medium' : 'text-gray-700' }}">
                            Semua Peran ({{ $roleCount['all'] }})
                        </a>
                        <a href="{{ route('admin.user.index', ['role' => 'admin', 'search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ request('role') == 'admin' ? 'text-emerald-600 font-medium bg-emerald-50' : 'text-gray-700' }}">
                            🛡️ Admin ({{ $roleCount['admin'] }})
                        </a>
                        <a href="{{ route('admin.user.index', ['role' => 'editor', 'search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ request('role') == 'editor' ? 'text-emerald-600 font-medium bg-blue-50' : 'text-gray-700' }}">
                            ✏️ Editor ({{ $roleCount['editor'] }})
                        </a>
                        <a href="{{ route('admin.user.index', ['role' => 'teologi', 'search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ request('role') == 'teologi' ? 'text-emerald-600 font-medium bg-purple-50' : 'text-gray-700' }}">
                            📖 Teologi ({{ $roleCount['teologi'] }})
                        </a>
                        <a href="{{ route('admin.user.index', ['role' => 'linguistik', 'search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ request('role') == 'linguistik' ? 'text-emerald-600 font-medium bg-amber-50' : 'text-gray-700' }}">
                            🔤 Linguistik ({{ $roleCount['linguistik'] }})
                        </a>
                        <a href="{{ route('admin.user.index', ['role' => 'null', 'search' => request('search')]) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-50 transition-colors {{ request('role') == 'null' ? 'text-emerald-600 font-medium bg-gray-100' : 'text-gray-700' }}">
                            ⚪ Belum Aktif ({{ $roleCount['null'] }})
                        </a>
                    </div>
                </div>
                @if (request('search') || (request('role') && request('role') !== 'all'))
                    <a href="{{ route('admin.user.index') }}"
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
                        <th class="px-6 py-4 font-semibold text-sm">Pengguna</th>
                        <th class="px-6 py-4 font-semibold text-sm">Kontak</th>
                        <th class="px-6 py-4 font-semibold text-sm">Peran</th>
                        {{-- <th class="px-6 py-4 font-semibold text-sm">Status</th> --}}
                        <th class="px-6 py-4 font-semibold text-sm">Terdaftar</th>
                        <th class="px-6 py-4 font-semibold text-sm text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        @php
                            $roleStyles = [
                                'admin'      => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'editor'     => 'bg-blue-100 text-blue-700 border-blue-200',
                                'teologi'    => 'bg-purple-100 text-purple-700 border-purple-200',
                                'linguistik' => 'bg-amber-100 text-amber-700 border-amber-200',
                            ];
                            $roleStyle = $roleStyles[$user->role] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                            $avatarColor = $roleStyles[$user->role] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <tr class="hover:bg-emerald-50/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full {{ $avatarColor }} flex items-center justify-center font-bold text-xs uppercase">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-400">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col gap-1">
                                    <span class="text-sm text-gray-700 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-gray-400">mail</span>
                                        {{ $user->email }}
                                    </span>
                                    <span class="text-xs text-gray-500 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm text-gray-400">call</span>
                                        {{ $user->no_hp ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @if ($user->role)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md border text-xs font-semibold {{ $roleStyle }}">
                                        <span class="material-symbols-outlined text-[14px]">badge</span>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md border text-xs font-semibold bg-gray-50 text-gray-500 border-gray-200">
                                        <span class="material-symbols-outlined text-[14px]">help</span>
                                        Belum Diatur
                                    </span>
                                @endif
                            </td>
                            {{-- <td class="px-6 py-5">
                                @if ($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-gray-500">
                                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                        Pending
                                    </span>
                                @endif
                            </td> --}}
                            <td class="px-6 py-5">
                                <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                                <p class="text-xs text-gray-400">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="showUserDetail({{ $user->id }})"
                                        class="text-emerald-600 hover:bg-emerald-50 p-2 rounded-full transition-colors"
                                        title="Lihat Detail">
                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                    </button>
                                    <button onclick="openEditModal({{ $user->id }})"
                                        class="text-blue-600 hover:bg-blue-50 p-2 rounded-full transition-colors"
                                        title="Edit Pengguna">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </button>
                                    @auth
                                        @if (Auth::user()->role === 'admin' && Auth::id() !== $user->id)
                                            <div class="w-px h-6 bg-gray-200 mx-1"></div>
                                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                                class="inline-block m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus pengguna ini? Tindakan ini tidak bisa dibatalkan.')"
                                                    class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition-colors flex items-center justify-center"
                                                    title="Hapus Pengguna">
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
                                    <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">group_off</span>
                                    <p class="text-gray-500">Belum ada data pengguna</p>
                                    <p class="text-xs text-gray-400 mt-1">Tambahkan pengguna baru untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-500">
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari
                    {{ $users->total() }} pengguna
                </p>
                <div class="flex items-center gap-1">
                    @if ($users->onFirstPage())
                        <button class="p-2 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed" disabled>
                            <span class="material-symbols-outlined text-xl">chevron_left</span>
                        </button>
                    @else
                        <a href="{{ $users->previousPageUrl() }}"
                            class="p-2 rounded-md border border-gray-300 hover:bg-gray-100 transition-colors">
                            <span class="material-symbols-outlined text-xl">chevron_left</span>
                        </a>
                    @endif
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if ($page == $users->currentPage())
                            <span class="w-8 h-8 rounded-md bg-emerald-600 text-white text-sm font-bold flex items-center justify-center">{{ $page }}</span>
                        @elseif(
                            $page == 1 ||
                                $page == $users->lastPage() ||
                                ($page >= $users->currentPage() - 2 && $page <= $users->currentPage() + 2))
                            <a href="{{ $url }}"
                                class="w-8 h-8 rounded-md hover:bg-gray-100 text-sm transition-colors flex items-center justify-center">{{ $page }}</a>
                        @elseif($page == $users->currentPage() - 3 || $page == $users->currentPage() + 3)
                            <span class="px-1 text-gray-500">...</span>
                        @endif
                    @endforeach
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}"
                            class="p-2 rounded-md border border-gray-300 hover:bg-gray-100 transition-colors">
                            <span class="material-symbols-outlined text-xl">chevron_right</span>
                        </a>
                    @else
                        <button class="p-2 rounded-md border border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed" disabled>
                            <span class="material-symbols-outlined text-xl">chevron_right</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Detail Pengguna -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay bg-black/50" onclick="closeDetailModal()"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Detail Pengguna</h3>
                <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div id="detailContent" class="p-6"></div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Pengguna -->
    <div id="userModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-overlay bg-black/50" onclick="closeUserModal()"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h3 id="userModalTitle" class="text-lg font-bold text-gray-900">Tambah Pengguna</h3>
                <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="userForm" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="userFormMethod" value="POST">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="form_name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="form_email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                    <input type="text" name="no_hp" id="form_no_hp"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Peran <span class="text-red-500">*</span></label>
                    <select name="role" id="form_role" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                        <option value="">-- Pilih Peran --</option>
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="teologi">Teologi</option>
                        <option value="linguistik">Linguistik</option>
                        <option value="user">User Biasa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password <span id="passwordHint" class="text-xs text-gray-400 font-normal"></span>
                    </label>
                    <input type="password" name="password" id="form_password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeUserModal()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ============ DROPDOWN FILTER ============
        function toggleRoleDropdown() {
            document.getElementById('roleDropdown').classList.toggle('hidden');
        }
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('roleDropdown');
            const btn = event.target.closest('button');
            if (dropdown && !dropdown.contains(event.target) && (!btn || !btn.onclick?.toString().includes('toggleRoleDropdown'))) {
                dropdown.classList.add('hidden');
            }
        });

        // ============ MODAL DETAIL ============
        async function  showUserDetail(id) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('detailContent');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            content.innerHTML = `
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600"></div>
                    <p class="text-gray-500 mt-2">Memuat data...</p>
                </div>
            `;
            try {
                const response = await fetch(`/admin/user/${id}/edit`, {
                    headers: { 'Accept': 'application/json' }
                });
                const result = await response.json();
                if (result.success) {
                    const data = result.data;
                    const roleStyles = {
                        admin: 'bg-emerald-100 text-emerald-700',
                        editor: 'bg-blue-100 text-blue-700',
                        teologi: 'bg-purple-100 text-purple-700',
                        linguistik: 'bg-amber-100 text-amber-700',
                    };
                    const roleStyle = roleStyles[data.role] || 'bg-gray-100 text-gray-600';
                    content.innerHTML = `
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-lg">
                                <div class="w-16 h-16 rounded-full ${roleStyle} flex items-center justify-center font-bold text-lg uppercase">
                                    ${escapeHtml(data.name.substring(0, 2))}
                                </div>
                                <div>
                                    <p class="font-bold text-lg text-gray-900">${escapeHtml(data.name)}</p>
                                    <p class="text-sm text-gray-500">${escapeHtml(data.email)}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-medium ${roleStyle}">
                                        ${data.role ? escapeHtml(data.role) : 'Belum diatur'}
                                    </span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">No. HP</p>
                                    <p class="text-sm">${escapeHtml(data.no_hp || '-')}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Status</p>
                                    <p class="text-sm">${data.email_verified_at ? '✅ Aktif' : '⏳ Pending'}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Terdaftar</p>
                                    <p class="text-sm">${formatDate(data.created_at)}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Update Terakhir</p>
                                    <p class="text-sm">${formatDate(data.updated_at)}</p>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    content.innerHTML = `
                        <div class="text-center py-8 text-red-500">
                            <p>${escapeHtml(result.message || 'Gagal memuat data')}</p>
                        </div>
                    `;
                }
            } catch (error) {
                content.innerHTML = `
                    <div class="text-center py-8 text-red-500">
                        <p>Terjadi kesalahan: ${escapeHtml(error.message)}</p>
                    </div>
                `;
            }
        }
        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('detailContent').innerHTML = '';
        }

        // ============ MODAL CREATE/EDIT ============
        function openCreateModal() {
            document.getElementById('userModalTitle').textContent = 'Tambah Pengguna';
            document.getElementById('userForm').action = `{{ route('admin.user.store') }}`;
            document.getElementById('userFormMethod').value = 'POST';
            document.getElementById('passwordHint').textContent = '(wajib)';
            document.getElementById('form_password').required = true;
            document.getElementById('userForm').reset();
            document.getElementById('userModal').classList.remove('hidden');
            document.getElementById('userModal').classList.add('flex');
        }

        async function openEditModal(id) {
            document.getElementById('userModalTitle').textContent = 'Edit Pengguna';
            document.getElementById('userForm').action = `/admin/user/${id}`;
            document.getElementById('userFormMethod').value = 'PUT';
            document.getElementById('passwordHint').textContent = '(kosongkan jika tidak diubah)';
            document.getElementById('form_password').required = false;

            try {
                const response = await fetch(`/admin/user/${id}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const result = await response.json();
                if (result.success) {
                    const d = result.data;
                    document.getElementById('form_name').value = d.name || '';
                    document.getElementById('form_email').value = d.email || '';
                    document.getElementById('form_no_hp').value = d.no_hp || '';
                    document.getElementById('form_role').value = d.role || '';
                    document.getElementById('form_password').value = '';
                    document.getElementById('userModal').classList.remove('hidden');
                    document.getElementById('userModal').classList.add('flex');
                } else {
                    Swal.fire('Gagal', result.message || 'Tidak bisa memuat data', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Terjadi kesalahan koneksi', 'error');
            }
        }

        function closeUserModal() {
            document.getElementById('userModal').classList.add('hidden');
            document.getElementById('userModal').classList.remove('flex');
        }

        // ============ HELPERS ============
        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return '-';
            return date.toLocaleString('id-ID', {
                day: '2-digit', month: '2-digit', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        }

        // Close modal with ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDetailModal();
                closeUserModal();
            }
        });
    </script>
@endsection