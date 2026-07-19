{{-- resources/views/components/admin-sidebar.blade.php --}}
<aside id="adminSidebar" data-collapsed="false"
    class="bg-white border-r border-slate-200 h-screen w-64 fixed left-0 top-0 flex flex-col z-40 transition-all duration-300 ease-in-out shadow-sm group/sidebar">
    
    <button onclick="toggleAdminSidebar()" id="toggleBtn"
        class="absolute -right-3.5 top-6 bg-white border border-slate-200 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-full w-7 h-7 flex items-center justify-center shadow-sm z-50 hidden md:flex transition-transform duration-300">
        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
    </button>

    <div class="h-16 flex items-center px-4 border-b border-slate-100 shrink-0 overflow-hidden">
        <div class="flex items-center gap-3 whitespace-nowrap">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-xl font-bold">admin_panel_settings</span>
            </div>
            <div class="sidebar-text transition-opacity duration-300">
                <h1 class="text-base font-black text-emerald-800 leading-tight">Admin Panel</h1>
                <p class="text-slate-500 text-[10px] uppercase tracking-widest font-bold">Hulontalo Qur'an</p>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto overflow-x-hidden p-3 space-y-6 custom-scrollbar pb-24">

        <div>
            <p class="sidebar-text text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-3">Validasi & Usulan</p>
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                    <span class="material-symbols-outlined text-[20px] shrink-0">dashboard</span>
                    <span class="sidebar-text text-sm whitespace-nowrap">Dasbor Utama</span>
                </a>

                <a href="{{ route('admin.usulan.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.usulan.*') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                    <span class="material-symbols-outlined text-[20px] shrink-0">menu_book</span>
                    <span class="sidebar-text text-sm whitespace-nowrap flex-1">Antrean Usulan</span>
                    @php $pendingCount = \App\Models\Usulan::where('status', 'menunggu')->count(); @endphp
                    @if ($pendingCount > 0)
                        <span class="sidebar-text bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0">{{ $pendingCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.riwayat') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 cursor-pointer {{ request()->routeIs('admin.riwayat') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                    <span class="material-symbols-outlined text-[20px] shrink-0">history</span>
                    <span class="sidebar-text text-sm whitespace-nowrap">Riwayat Validasi</span>
                </a>
            </nav>
        </div>

        <div>
            <p class="sidebar-text text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-3">Komunitas</p>
            <nav class="space-y-1">
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 cursor-pointer text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium">
                    <span class="material-symbols-outlined text-[20px] shrink-0">category</span>
                    <span class="sidebar-text text-sm whitespace-nowrap">Kategori Forum</span>
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 cursor-pointer text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium">
                    <span class="material-symbols-outlined text-[20px] shrink-0">forum</span>
                    <span class="sidebar-text text-sm whitespace-nowrap">Manajemen Diskusi</span>
                </a>
            </nav>
        </div>

        <div>
            <p class="sidebar-text text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-3">Sistem & Konten</p>
            <nav class="space-y-1">
                
                <button onclick="toggleDropdown('dropdownKonten')" 
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium outline-none">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] shrink-0">source</span>
                        <span class="sidebar-text text-sm whitespace-nowrap">Pengaturan Konten</span>
                    </div>
                    <span id="arrow-dropdownKonten" class="sidebar-text material-symbols-outlined text-[18px] transition-transform duration-200 shrink-0">expand_more</span>
                </button>

                <div id="dropdownKonten" class="hidden flex-col space-y-1 pl-9 pr-2 overflow-hidden transition-all duration-300">
                    <a href="{{ route('editor.data-terjemahan.index') ?? '#' }}" 
                       class="flex items-center gap-2 py-2 text-sm text-slate-500 hover:text-emerald-700 font-medium transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                        <span class="whitespace-nowrap">Data Terjemahan</span>
                    </a>
                    <a href="#" 
                       class="flex items-center gap-2 py-2 text-sm text-slate-500 hover:text-emerald-700 font-medium transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                        <span class="whitespace-nowrap">Manajemen Audio</span>
                    </a>
                    <a href="#" 
                       class="flex items-center gap-2 py-2 text-sm text-slate-500 hover:text-emerald-700 font-medium transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                        <span class="whitespace-nowrap">Daftar Mitra</span>
                    </a>
                </div>

                <a href="#"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 cursor-pointer text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium">
                    <span class="material-symbols-outlined text-[20px] shrink-0">group</span>
                    <span class="sidebar-text text-sm whitespace-nowrap">Kelola Pengguna</span>
                </a>
            </nav>
        </div>

    </div>

    <div class="border-t border-slate-200 p-3 bg-slate-50/50 shrink-0">
        
        <a href="{{ route('home') }}" class="flex items-center gap-3 px-2 py-2 mb-2 text-slate-500 hover:text-emerald-700 transition-colors rounded-lg group">
            <span class="material-symbols-outlined text-[20px] shrink-0 group-hover:-translate-x-1 transition-transform">home</span>
            <span class="sidebar-text text-xs font-bold whitespace-nowrap">Kembali ke Beranda</span>
        </a>

        <div class="flex items-center justify-between bg-white border border-slate-200 rounded-xl p-2 shadow-sm">
            <a href="{{ route('profile.show', Auth::user()->id) }}" class="flex items-center gap-3 flex-1 min-w-0 hover:opacity-80 transition-opacity">
                <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center overflow-hidden shrink-0 border border-emerald-200">
                    @if (Auth::user()->avatar)
                        <img alt="Avatar" class="w-full h-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" />
                    @else
                        <span class="font-bold text-emerald-700 text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="sidebar-text flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-semibold text-emerald-600 uppercase tracking-widest mt-0.5">Admin</p>
                </div>
            </a>

            <form action="{{ route('admin.logout') ?? '#' }}" method="POST" class="shrink-0 ml-1">
                @csrf
                <button type="submit" class="text-slate-400 hover:bg-red-50 hover:text-red-600 p-2 rounded-lg transition-all flex items-center justify-center" title="Keluar">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
    /* Styling scrollbar tipis khusus sidebar */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #94a3b8; }
</style>

<script>
    // ========================================================
    // 1. JALANKAN MEMORI SAAT HALAMAN SELESAI DIMUAT
    // ========================================================
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById('adminSidebar');
        const texts = document.querySelectorAll('.sidebar-text');
        const toggleBtn = document.getElementById('toggleBtn');
        
        // Cek memori sidebar (apakah sebelumnya diperkecil?)
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

        if (isCollapsed) {
            // Terapkan mode kecil
            sidebar.style.width = '5rem';
            toggleBtn.style.transform = 'rotate(180deg)';
            sidebar.setAttribute('data-collapsed', 'true');
            
            texts.forEach(el => {
                el.style.opacity = '0';
                el.style.display = 'none';
            });
        }

        // Cek memori dropdown (mana aja yang sebelumnya kebuka?)
        const dropdowns = document.querySelectorAll('[id^="dropdown"]');
        dropdowns.forEach(drop => {
            const id = drop.id;
            const arrow = document.getElementById('arrow-' + id);
            const isDropdownOpen = localStorage.getItem(id) === 'open';
            
            // Kalau memorinya nyatet kebuka, DAN sidebar lagi mode lebar -> Buka dropdownnya
            if (isDropdownOpen && !isCollapsed) {
                drop.classList.remove('hidden');
                drop.classList.add('flex');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            }
        });
    });

    // ========================================================
    // 2. FUNGSI PERKECIL/PERLEBAR SIDEBAR
    // ========================================================
    function toggleAdminSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const texts = document.querySelectorAll('.sidebar-text');
        const toggleBtn = document.getElementById('toggleBtn');
        
        let isCollapsed = sidebar.getAttribute('data-collapsed') === 'true';

        if (isCollapsed) {
            // PERLEBAR SIDEBAR
            sidebar.style.width = '16rem'; 
            toggleBtn.style.transform = 'rotate(0deg)'; 
            sidebar.setAttribute('data-collapsed', 'false');
            
            // Simpan ke memori
            localStorage.setItem('sidebarCollapsed', 'false');
            
            setTimeout(() => {
                texts.forEach(el => {
                    el.style.opacity = '1';
                    el.style.display = '';
                });
            }, 150);

            // Buka kembali dropdown yang ada di memori
            const dropdowns = document.querySelectorAll('[id^="dropdown"]');
            dropdowns.forEach(drop => {
                if (localStorage.getItem(drop.id) === 'open') {
                    drop.classList.remove('hidden');
                    drop.classList.add('flex');
                    const arrow = document.getElementById('arrow-' + drop.id);
                    if(arrow) arrow.style.transform = 'rotate(180deg)';
                }
            });
            
        } else {
            // PERKECIL SIDEBAR (COLLAPSE)
            sidebar.style.width = '5rem'; 
            toggleBtn.style.transform = 'rotate(180deg)'; 
            sidebar.setAttribute('data-collapsed', 'true');
            
            // Simpan ke memori
            localStorage.setItem('sidebarCollapsed', 'true');
            
            texts.forEach(el => {
                el.style.opacity = '0';
                el.style.display = 'none';
            });

            // Sembunyikan dropdown sementara (tapi jangan hapus dari memori)
            const dropdowns = document.querySelectorAll('[id^="dropdown"]');
            dropdowns.forEach(drop => {
                drop.classList.add('hidden');
                drop.classList.remove('flex');
            });
            const arrows = document.querySelectorAll('[id^="arrow-"]');
            arrows.forEach(arrow => arrow.style.transform = 'rotate(0deg)');
        }
    }

    // ========================================================
    // 3. FUNGSI BUKA/TUTUP DROPDOWN
    // ========================================================
    function toggleDropdown(id) {
        const sidebar = document.getElementById('adminSidebar');
        
        if (sidebar.getAttribute('data-collapsed') === 'true') {
            toggleAdminSidebar();
            setTimeout(() => toggleDropdown(id), 250); 
            return;
        }

        const menu = document.getElementById(id);
        const arrow = document.getElementById('arrow-' + id);
        
        if (menu.classList.contains('hidden')) {
            // Buka Dropdown & Simpan ke memori
            menu.classList.remove('hidden');
            menu.classList.add('flex');
            arrow.style.transform = 'rotate(180deg)';
            localStorage.setItem(id, 'open'); // <--- SIMPAN MEMORI
        } else {
            // Tutup Dropdown & Hapus dari memori
            menu.classList.add('hidden');
            menu.classList.remove('flex');
            arrow.style.transform = 'rotate(0deg)';
            localStorage.setItem(id, 'closed'); // <--- SIMPAN MEMORI
        }
    }
</script>