<nav class="bg-white/95 backdrop-blur-sm w-full top-0 sticky z-50 border-b border-slate-100 shadow-sm">
    <div class="flex justify-between items-center w-full px-6 py-3 max-w-7xl mx-auto">

        <div class="text-2xl font-bold text-emerald-800 tracking-tighter">
            <a href="{{ route('home') ?? '#' }}" class="flex items-center gap-2">
                <span class="material-symbols-outlined">auto_stories</span>
                Qur'an Hulontalo
            </a>
        </div>

        <div class="hidden md:flex items-center gap-8">
            <a class="hover:text-emerald-600 transition-colors text-base {{ request()->routeIs('home') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : 'text-slate-500' }}"
                href="{{ route('home') }}">
                Beranda
            </a>

            <a class="hover:text-emerald-600 transition-colors text-base {{ request()->routeIs('mushaf') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : 'text-slate-500' }}"
                href="{{ route('mushaf') }}">
                Baca Qur'an
            </a>

            <a class="hover:text-emerald-600 transition-colors text-base {{ request()->routeIs('forum.*') ? 'text-emerald-700 font-semibold border-b-2 border-emerald-600 pb-1' : 'text-slate-500' }}"
                href="{{ route('forum.index') }}">
                Ruang Diskusi
                {{-- <span --}}
                {{-- class="bg-emerald-100 text-emerald-700 text-[10px] px-2 py-0.5 rounded-full font-bold animate-pulse">BARU</span> --}}
            </a>
        </div>

        <div class="flex items-center gap-3">

            @auth
                @php
                    $role = Auth::user()->role;
                    // Cek apakah user punya hak akses ke dashboard (bukan user biasa)
                    $isAdminOrPakar = in_array($role, ['teologi', 'linguistik', 'editor', 'admin']);

                    // Tentukan URL Dashboard khusus (sesuaikan nama route-nya dengan yang ada di web.php lu)
                    $dashboardUrl = match ($role) {
                        'teologi', 'linguistik', 'admin' => route('admin.dashboard'),
                        'editor' => route(
                            'editor.dashboard',
                        ), // Ganti jadi route('editor.dashboard') kalau URL-nya beda
                        default => route('profile.edit'),
                    };
                @endphp

                @if ($isAdminOrPakar)
                    {{-- TOMBOL UNTUK ADMIN / EDITOR / VALIDATOR --}}
                    <a href="{{ $dashboardUrl }}"
                        class="hidden md:flex items-center gap-1.5 bg-emerald-700 text-white px-4 py-2 rounded-md font-bold text-sm hover:bg-emerald-800 transition-all shadow-sm active:scale-95">
                        <span class="material-symbols-outlined text-[18px]">dashboard</span>
                        Dashboard
                    </a>
                @else
                    {{-- TOMBOL PROFIL UNTUK USER BIASA (MASYARAKAT) --}}
                    <div class="relative inline-block text-left">

                        <button type="button" id="userDropdownBtn" onclick="toggleUserDropdown()"
                            class="hidden md:flex items-center gap-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 py-1.5 px-3 rounded-full transition-all cursor-pointer group shadow-sm active:scale-95">

                            <div
                                class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center overflow-hidden shrink-0 border border-transparent group-hover:border-emerald-300 transition-all">
                                @if (Auth::user()->avatar)
                                    <img alt="Avatar" class="w-full h-full object-cover"
                                        src="{{ asset('storage/' . Auth::user()->avatar) }}" />
                                @else
                                    <span
                                        class="font-bold text-emerald-700 text-xs">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                @endif
                            </div>

                            <span
                                class="text-sm font-bold text-slate-700 group-hover:text-emerald-700 truncate max-w-[120px] transition-colors">
                                {{ Auth::user()->name }}
                            </span>

                            <span
                                class="material-symbols-outlined text-[18px] text-slate-400 group-hover:text-emerald-700 transition-colors">expand_more</span>
                        </button>

                        <div id="userDropdownMenu"
                            class="hidden absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1.5 z-50 transform opacity-100 transition-all">

                            <a href="{{ route('profile.show', Auth::id()) }}"
                                class="flex items-center gap-2.5 px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">account_circle</span>
                                Profil Saya
                            </a>

                            <hr class="my-1 border-slate-100">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left flex items-center gap-2.5 px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">logout</span>
                                    Keluar
                                </button>
                            </form>
                        </div>

                    </div>
                @endif
            @else
                {{-- Kodingan tombol Login/Register lu yang lama biarkan di sini --}}
                {{-- Tombol untuk User BELUM Login (Guest) --}}
                <a href="{{ route('login') }}"
                    class="hidden md:flex items-center gap-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200 px-4 py-2 rounded-lg font-bold text-base hover:bg-emerald-100 hover:text-emerald-900 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-[20px]">login</span>
                    Masuk
                </a>
            @endauth

            <button
                class="md:hidden active:scale-95 duration-150 p-2 rounded-full text-emerald-700 hover:bg-emerald-50">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>

    </div>
</nav>

<script>
    // Fungsi buat buka-tutup dropdown
    function toggleUserDropdown() {
        const menu = document.getElementById('userDropdownMenu');
        menu.classList.toggle('hidden');
    }

    // Fungsi sakti: Tutup dropdown kalau user ngeklik di luar area menu
    window.addEventListener('click', function(e) {
        const btn = document.getElementById('userDropdownBtn');
        const menu = document.getElementById('userDropdownMenu');
        
        // Pastikan elementnya ada di halaman (mencegah error kalau user belum login)
        if (btn && menu) {
            // Kalau yang diklik BUKAN tombol dan BUKAN isi menu, maka sembunyikan
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        }
    });
</script>
