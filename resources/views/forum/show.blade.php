@extends('forum.layout')

@section('forum.content')
    <div class="mb-6">
        <a href="{{ route('forum.index') }}"
            class="inline-flex items-center gap-1.5 text-emerald-700 hover:text-emerald-800 font-semibold text-sm transition-colors bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Daftar Diskusi
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6">
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl shadow-sm flex items-center gap-3">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 mb-8">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
            <div class="flex-shrink-0">
                @if ($thread->user->avatar)
                    <img src="{{ asset('storage/' . $thread->user->avatar) }}" alt="Avatar"
                        class="w-14 h-14 rounded-full object-cover border border-slate-200">
                @else
                    <div
                        class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xl border border-emerald-200">
                        {{ strtoupper(substr($thread->user->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="flex-1 min-w-0">
                <h1 class="text-xl md:text-2xl font-bold text-slate-900 leading-tight mb-2">{{ $thread->title }}</h1>
                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 font-medium">
                    Oleh <a href="{{ route('profile.show', $thread->user->id) }}"
                        class="font-bold text-emerald-700 hover:text-emerald-800 hover:underline transition-colors">
                        {{ $thread->user->name }}
                    </a>
                    <span class="text-slate-300">•</span>
                    <span>{{ $thread->created_at->translatedFormat('d M Y, H:i') }}</span>
                    <span class="text-slate-300">•</span>
                    <span
                        class="bg-slate-100 border border-slate-200 text-slate-600 px-2.5 py-0.5 rounded-full uppercase text-[10px] font-bold tracking-wider">
                        {{ $thread->category->name ?? 'Umum' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="text-slate-800 leading-relaxed text-base whitespace-pre-line">
            {{ $thread->body }}
        </div>
    </div>

    <div class="mb-5 flex items-center gap-2 px-2">
        <span class="material-symbols-outlined text-emerald-700">forum</span>
        <h3 class="text-lg font-bold text-slate-800">{{ $replies->total() }} Balasan</h3>
    </div>

    <div class="space-y-4 mb-8">
        @forelse ($replies as $reply)
            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 flex gap-4 transition-all hover:shadow-md">
                <div class="flex-shrink-0">
                    @if ($reply->user->avatar)
                        <img src="{{ asset('storage/' . $reply->user->avatar) }}" alt="Avatar"
                            class="w-10 h-10 rounded-full object-cover border border-slate-200">
                    @else
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm border border-slate-200">
                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-sm text-slate-900">{{ $reply->user->name }}</span>
                            <span class="text-xs font-medium text-slate-400" title="{{ $reply->created_at }}">•
                                {{ $reply->created_at->diffForHumans() }}</span>
                        </div>

                        @auth
                            @if (Auth::user()->role == 'admin' || Auth::id() == $reply->user_id)
                                <form action="{{ route('forum.reply.destroy', $reply->id) }}" method="POST"
                                    class="shrink-0 ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus balasan ini?')"
                                        class="text-slate-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-md transition-colors flex items-center justify-center"
                                        title="Hapus Balasan">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $reply->body }}</p>
                </div>
            </div>
        @empty
            <div
                class="bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 p-10 text-center flex flex-col items-center justify-center">
                <span class="material-symbols-outlined text-5xl text-slate-300 mb-3 block">speaker_notes_off</span>
                <p class="text-slate-500 font-medium">Belum ada balasan di diskusi ini.</p>
                <p class="text-slate-400 text-sm mt-1">Jadilah yang pertama memberikan tanggapan atau referensi!</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $replies->links() }}
        </div>
    </div>

    @auth
        <div class="bg-emerald-50/50 rounded-2xl border border-emerald-100 p-6 shadow-sm">
            <h4 class="font-bold text-emerald-900 mb-4 flex items-center gap-2 text-sm sm:text-base">
                <span class="material-symbols-outlined text-[20px]">reply</span> Tulis Tanggapan Anda
            </h4>
            <form action="{{ route('forum.reply.store', $thread->id) }}" method="POST">
                @csrf
                <textarea name="body" rows="4"
                    class="w-full rounded-xl border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm mb-4 p-3.5 text-sm transition-all"
                    placeholder="Ketik argumen, ilmu, atau referensi penafsiran Anda di sini..." required></textarea>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-emerald-800 transition-all shadow-sm active:scale-95 text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">send</span>
                        Kirim Balasan
                    </button>
                </div>
            </form>
        </div>
    @else
        <div
            class="bg-white rounded-2xl border border-slate-200 p-8 text-center shadow-sm flex flex-col items-center justify-center">
            <span class="material-symbols-outlined text-4xl text-emerald-600 mb-3 block">lock_open</span>
            <p class="text-slate-700 font-medium mb-4">Masuk ke sistem untuk ikut berdiskusi dan memberikan tanggapan.</p>
            <a href="{{ route('login') }}"
                class="inline-flex items-center gap-2 bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-emerald-800 transition-colors shadow-sm text-sm">
                Masuk Sekarang
            </a>
        </div>
    @endauth
@endsection
