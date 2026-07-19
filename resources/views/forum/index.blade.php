@extends('forum.layout')
@section('forum.content')
    <!-- Header: Search & Sort -->
    <div class="flex flex-col sm:flex-row gap-4 mb-6">
        <!-- Search Bar -->
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-slate-400">search</span>
            </div>
            <input type="text" name="search" placeholder="Cari topik diskusi, tafsir, atau tata bahasa..."
                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all text-sm">
        </div>

        <!-- Sort Dropdown -->
        <div class="shrink-0 relative">
            <select id="sortSelect" onchange="updateSort(this.value)"
                class="w-full sm:w-48 py-3 pl-4 pr-10 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm text-sm text-slate-700 font-medium appearance-none cursor-pointer">
                <option value="latest" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Terbaru
                </option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Paling Ramai</option>
                {{-- <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Paling Banyak Dilihat</option> --}}
            </select>

            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
                <span class="material-symbols-outlined text-[20px]">expand_more</span>
            </div>
        </div>
    </div>

    <!-- Area Daftar Thread -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex-1">
        <div class="divide-y divide-slate-100">

            @forelse ($threads as $thread)
                <div class="p-5 sm:p-6 hover:bg-slate-50 transition-colors group block">
                    <div class="flex items-start gap-4">

                        <!-- Avatar -->
                        <div class="flex-shrink-0 hidden sm:block">
                            @if ($thread->user->avatar)
                                <img src="{{ asset('storage/' . $thread->user->avatar) }}" alt="Avatar"
                                    class="w-12 h-12 rounded-full object-cover border border-slate-200">
                            @else
                                <div
                                    class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg border border-emerald-200">
                                    {{ strtoupper(substr($thread->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Konten Utama Thread -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ $thread->category->name ?? 'Tanpa Kategori' }}
                                </span>
                                <span class="text-xs text-slate-400">• Dibuat oleh
                                    <a href="{{ route('profile.show', $thread->user->id) }}"
                                        class="font-bold text-slate-600 hover:text-emerald-700 hover:underline transition-colors">
                                        {{ $thread->user->name }}
                                    </a>
                                </span>
                                <span class="text-xs text-slate-400">• {{ $thread->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="flex justify-between items-start gap-4 mb-1.5">
                                <a href="{{ route('forum.thread.show', $thread->slug) }}"
                                    class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-2">
                                    {{ $thread->title }}
                                </a>

                                @auth
                                    @if(Auth::user()->role == 'admin' || Auth::id() == $thread->user_id)
                                        <form action="{{ route('forum.thread.destroy', $thread->id) }}" method="POST" class="shrink-0" onclick="event.stopPropagation();">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                onclick="return confirm('Yakin ingin menghapus diskusi ini? Semua balasan di dalamnya juga akan terhapus.')" 
                                                class="text-slate-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition-colors"
                                                title="Hapus Diskusi">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>

                            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">
                                {{ strip_tags($thread->body) }}
                            </p>
                        </div>

                        <!-- Statistik (Komentar & View) -->
                        <div class="hidden md:flex flex-col items-center justify-center gap-1 shrink-0 w-24">
                            <div
                                class="flex flex-col items-center justify-center {{ $thread->replies_count > 0 ? 'text-emerald-700' : 'text-slate-400' }}">
                                <span class="material-symbols-outlined text-[24px]">chat_bubble</span>
                                <span class="font-bold text-sm mt-0.5">{{ $thread->replies_count ?? 0 }}</span>
                                <span class="text-[10px] uppercase tracking-wider font-semibold">Balasan</span>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="p-16 text-center">
                    <span class="material-symbols-outlined text-6xl text-slate-200 mb-4 block">forum</span>
                    <h3 class="text-xl font-bold text-slate-700 mb-1">Belum Ada Diskusi</h3>
                    <p class="text-slate-500 text-sm">Jadilah yang pertama memulai topik pembicaraan di komunitas ini!</p>
                </div>
            @endforelse

        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $threads->links() }}
    </div>

    <script>
    function updateSort(value) {
        // 1. Ambil URL web lu yang lagi aktif sekarang (beserta filter-filter yang lagi jalan)
        const url = new URL(window.location.href);
        
        // 2. Set parameter 'sort' di URL pakai value dari dropdown yang dipilih
        url.searchParams.set('sort', value);
        
        // 3. Hapus parameter 'page' (Biar kalau lu lagi di halaman 3 terus ngubah sorting, dia balik ke halaman 1 dengan data baru)
        url.searchParams.delete('page');
        
        // 4. Langsung sikat reload halamannya ke URL yang baru
        window.location.href = url.toString();
    }
    </script>
@endsection
