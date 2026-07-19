<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Diskusi - Qur'an Gorontalo</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="text-slate-900 antialiased flex flex-col min-h-screen">

    <!-- Panggil Navbar Lu -->
    @include('partials.navbar')

    <!-- Kontainer Utama: 2 Kolom -->
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8 w-full flex-grow flex flex-col lg:flex-row gap-8">

        <!-- ========================================== -->
        <!-- SIDEBAR KIRI (Navigasi & Filter Laracasts Style) -->
        <!-- ========================================== -->
        <aside class="w-full lg:w-64 flex-shrink-0 space-y-8 lg:sticky lg:top-16 lg:self-start lg:max-h-[calc(100vh-4rem)] overflow-y-auto pb-4" style="scrollbar-width: none; -ms-overflow-style: none;">

            <!-- Tombol Aksi Utama -->
            <div>
                @auth
                    <a href="{{ route('forum.thread.create') }}"
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-3.5 rounded-xl font-bold shadow-sm transition-all flex items-center justify-center gap-2 active:scale-95">
                        <span class="material-symbols-outlined">add_comment</span>
                        Mulai Diskusi Baru
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="w-full bg-white border-2 border-emerald-700 text-emerald-800 px-4 py-3.5 rounded-xl font-bold shadow-sm transition-all flex items-center justify-center gap-2 hover:bg-emerald-50">
                        <span class="material-symbols-outlined">login</span>
                        Masuk untuk Diskusi
                    </a>
                @endauth
            </div>

            <!-- Navigasi Status -->
            

            <!-- Navigasi Kategori -->
            <!-- Navigasi Status -->
            <nav class="space-y-1">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 px-3">Filter Diskusi</p>

                <!-- Semua Diskusi (Tanpa Filter) -->
                <a href="{{ route('forum.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg font-semibold transition-colors {{ !request('filter') && !request('kategori') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100' }}">
                    <span class="material-symbols-outlined text-[20px]">forum</span>
                    Semua Diskusi
                </a>

                @auth
                    <!-- Diskusi Saya -->
                    <a href="{{ route('forum.index', ['filter' => 'saya']) }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition-colors {{ request('filter') == 'saya' ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                        Diskusi Saya
                    </a>
                @endauth

                <!-- Belum Terjawab -->
                <a href="{{ route('forum.index', ['filter' => 'belum_terjawab']) }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition-colors {{ request('filter') == 'belum_terjawab' ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <span class="material-symbols-outlined text-[20px]">help</span>
                    Belum Terjawab
                </a>

                <!-- Sudah Selesai -->
                {{-- <a href="{{ route('forum.index', ['filter' => 'selesai']) }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium transition-colors {{ request('filter') == 'selesai' ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    Sudah Selesai
                </a> --}}
            </nav>

            <!-- Navigasi Kategori -->
            <nav class="space-y-1 mt-8">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 px-3">Kategori Topik</p>

                @forelse ($categories ?? [] as $category)
                    <a href="{{ route('forum.index', ['kategori' => $category->slug]) }}"
                        class="flex items-center justify-between px-3 py-2 rounded-lg font-medium transition-colors group {{ request('kategori') == $category->slug ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">
                        <div class="flex items-center gap-2 truncate">
                            <span
                                class="w-2 h-2 rounded-full transition-transform {{ request('kategori') == $category->slug ? 'bg-emerald-600 scale-125' : 'bg-emerald-400 group-hover:scale-125' }}"></span>
                            <span class="truncate">{{ $category->name }}</span>
                        </div>
                    </a>
                @empty
                    <div class="px-3 text-sm text-slate-400 italic">Belum ada kategori</div>
                @endforelse
            </nav>

        </aside>

        <!-- ========================================== -->
        <!-- KONTEN KANAN (Pencarian & Daftar Thread) -->
        <!-- ========================================== -->
        <main class="flex-1 min-w-0 flex flex-col">

            @yield('forum.content')

        </main>

    </div>
</body>

</html>
