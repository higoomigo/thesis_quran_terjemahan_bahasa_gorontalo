{{-- resources/views/components/editor-sidebar.blade.php --}}
<aside
    class="bg-white border-r border-gray-200 h-screen w-64 fixed left-0 top-0 flex flex-col p-4 gap-2 z-40 transition-all duration-300">
    <div class="mb-6 px-2 pt-2">
        @if (Auth::user()->role === 'admin')
            <h1 class="text-lg font-black text-emerald-800 text-xl">Admin Panel</h1>
        @elseif (Auth::user()->role === 'editor')
            <h1 class="text-lg font-black text-emerald-800 text-xl">Editor Panel</h1>
        @elseif (Auth::user()->role === 'teologi' || Auth::user()->role === 'linguistik')
            <h1 class="text-lg font-black text-emerald-800 text-xl">Validator Panel</h1>
        @endif



        <p class="text-gray-500 text-xs">Gorontalo Translation</p>
    </div>

    <nav class="flex-1 space-y-1">
        <!-- Dashboard Editor -->


        @if (Auth::user()->role === 'teologi' || Auth::user()->role === 'linguistik')
            {{-- tugas admin adalah tambah validator --}}
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : '' }}">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                <span class="text-sm font-medium">Dasbor</span>
            </a>

            <a href="{{ route('admin.usulan.index') }}"
                class="flex items-center gap-3 px-4 py-3 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('admin.usulan.*') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined text-xl">menu_book</span>
                <span class="text-sm font-semibold">Antrean Usulan</span>
                @php
                    $pendingCount = \App\Models\Usulan::where('status', 'menunggu')->count();
                @endphp
                @if ($pendingCount > 0)
                    <span
                        class="ml-auto bg-emerald-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>
            @if (Auth::user()->role === 'teologi' || Auth::user()->role === 'linguistik')
                <a href="{{ route('admin.validasi.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('admin.validasi.*') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : '' }}">
                    <span class="material-symbols-outlined text-xl">verified</span>
                    <span class="text-sm font-medium">Daftar Validasi Anda </span>
                </a>
            @endif
            <a href="{{ route('admin.riwayat') }}"
                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('admin.riwayat') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : '' }}">
                <span class="material-symbols-outlined text-xl">history</span>
                <span class="text-sm font-medium">Riwayat Validasi</span>
            </a>

        @endif

        {{-- @if (Auth::user()->role === 'admin')
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('admin.riwayat') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : '' }}">
                <span class="material-symbols-outlined text-xl">person_add</span>
                <span class="text-sm font-medium">Tambahkan Validator</span>
            </a>
        @endif --}}

        @if (Auth::user()->role === 'editor')
            <a href="{{ route('editor.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('editor.dashboard') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : '' }}">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                <span class="text-sm font-medium">Dasbor</span>
            </a>
        @endif

        @if (Auth::user()->role === 'editor')
            <!-- Antrean Publikasi (Meja Redaksi) -->
            <a href="{{ route('editor.antrean.index') }}"
                class="flex items-center gap-3 px-4 py-3 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('editor.antrean.*') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined text-xl">pending_actions</span>
                <span class="text-sm font-semibold">Antrean Publikasi</span>
                @php
                    $antreanCount = \App\Models\Usulan::where('status', 'diterima')->count(); // usulan siap publikasi
                @endphp
                @if ($antreanCount > 0)
                    <span
                        class="ml-auto bg-emerald-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $antreanCount }}</span>
                @endif
            </a>
            <a href="{{ route('editor.riwayat.index') }}"
                class="flex items-center gap-3 px-4 py-3 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('editor.riwayat.*') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined text-xl">history</span>
                <span class="text-sm font-semibold">Riwayat Publikasi</span>

            </a>
            {{-- <a href="{{ route('editor.riwayat.index') }}"  --}}
            <a href="{{ route('editor.data-terjemahan.index') }}"
                class="flex items-center gap-3 px-4 py-3 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('editor.data-terjemahan.*') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined text-xl">translate</span>
                <span class="text-sm font-semibold">Data Terjemahan</span>
            </a>
            {{-- <a href="#"
                class="flex items-center gap-3 px-4 py-3 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('editor.data-terjemahan.*') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="material-symbols-outlined text-xl">audiotrack</span>
                <span class="text-sm font-semibold">Manajemen Audio</span>
            </a> --}}
        @endif


        <!-- Riwayat Tayang -->
        {{-- <a href="{{ route('editor.riwayat.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-all duration-200 ease-in-out hover:pl-6 cursor-pointer group rounded-lg {{ request()->routeIs('editor.riwayat.index') ? 'bg-emerald-50 text-emerald-700 border-r-4 border-emerald-600 rounded-r-lg' : '' }}">
            <span class="material-symbols-outlined text-xl">history</span>
            <span class="text-sm font-medium">Riwayat Tayang</span>
        </a> --}}
    </nav>

    <!-- User Profile -->
    <div class="mt-auto pt-2">

        <a href="{{ route('home') }}"
            class="flex items-center gap-3 px-4 py-2.5 mb-3 text-gray-600 hover:bg-emerald-50 hover:text-emerald-700 transition-all duration-200 rounded-lg group">
            <span class="material-symbols-outlined text-xl group-hover:-translate-x-1 transition-transform">home</span>
            <span class="text-sm font-medium">Kembali ke Beranda</span>
        </a>

        <div class="border-t border-gray-200 mb-2"></div>

        <div class="flex items-center justify-between gap-2">

            <!-- Area Profil -->
            <a href="{{ route('profile.show', Auth::user()->id) }}"
                class="flex items-center gap-3 flex-1 hover:bg-gray-50 p-2 rounded-lg transition-colors cursor-pointer group"
                title="Pengaturan Akun">

                <!-- Avatar: shrink-0 biar lingkarannya nggak ikut gepeng -->
                <div
                    class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center overflow-hidden shrink-0 border border-transparent group-hover:border-emerald-300 transition-all">
                    @if (Auth::user()->avatar)
                        <img alt="Avatar" class="w-full h-full object-cover"
                            src="{{ asset('storage/' . Auth::user()->avatar) }}" />
                    @else
                        <span
                            class="font-bold text-emerald-700 text-lg">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    @endif
                </div>

                <!-- Teks Profil -->
                <div class="flex-1">
                    <!-- Hapus truncate, ganti line-clamp-2 biar nama panjang bisa turun 2 baris -->
                    <p
                        class="text-sm font-semibold text-gray-900 line-clamp-2 leading-snug group-hover:text-emerald-700 transition-colors">
                        {{ Auth::user()->name }}
                    </p>

                    @if (Auth::user()->role === 'teologi')
                        <p class="text-xs text-gray-500 mt-0.5">Validator Teologi</p>
                    @elseif(Auth::user()->role === 'linguistik')
                        <p class="text-xs text-gray-500 mt-0.5">Validator Linguistik</p>
                    @elseif(Auth::user()->role === 'admin')
                        <p class="text-xs text-gray-500 mt-0.5">Administrator</p>
                    @elseif(Auth::user()->role === 'editor')
                        <p class="text-xs text-gray-500 mt-0.5">Editor</p>
                    @endif
                </div>
            </a>

            <!-- Area Tombol Logout -->
            <!-- Ubah form jadi shrink-0 dan flex biar nggak kegencet teks sebelahnya -->
            <form action="{{ route('admin.logout') }}" method="POST" class="shrink-0 flex items-center">
                @csrf
                <button type="submit"
                    class="text-gray-400 hover:bg-red-50 hover:text-red-600 p-2.5 rounded-xl transition-all flex items-center justify-center"
                    title="Keluar dari sistem">
                    <span class="material-symbols-outlined text-[22px] block">logout</span>
                </button>
            </form>

        </div>
    </div>
</aside>
