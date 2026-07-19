<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil {{ $user->name }} - Qur'an Gorontalo</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    @include('partials.navbar')

    <main class="flex-grow max-w-5xl mx-auto w-full px-4 py-8 sm:px-6 lg:px-8 pb-20">

        <div class="mb-6">
            <a href="{{ route('forum.index') }}"
                class="inline-flex items-center gap-1.5 text-emerald-700 hover:text-emerald-800 font-semibold text-sm transition-colors bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Kembali ke Forum
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-10 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-3 bg-emerald-600"></div>

            <div class="flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-8 mt-2">

                <div class="shrink-0 relative">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                            class="w-28 h-28 md:w-32 md:h-32 rounded-full object-cover border-4 border-emerald-50 shadow-md">
                    @else
                        <div
                            class="w-28 h-28 md:w-32 md:h-32 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-5xl border-4 border-emerald-50 shadow-md">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    @if (in_array($user->role, ['teologi', 'linguistik', 'admin']))
                        <div class="absolute bottom-1 right-1 bg-emerald-600 text-white rounded-full p-1.5 border-4 border-white"
                            title="Akun Terverifikasi">
                            <span class="material-symbols-outlined text-[16px] block">verified</span>
                        </div>
                    @endif
                </div>

                <div class="flex-1 text-center md:text-left min-w-0">
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 truncate mb-2">{{ $user->name }}</h1>

                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-2 mb-4">
                        @if ($user->role === 'teologi')
                            <span
                                class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border border-emerald-200">Pakar
                                Teologi</span>
                        @elseif($user->role === 'linguistik')
                            <span
                                class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border border-blue-200">Pakar
                                Linguistik</span>
                        @elseif($user->role === 'editor' || $user->role === 'admin')
                            <span
                                class="bg-slate-800 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Tim
                                Pengembang</span>
                        @else
                            <span
                                class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border border-slate-200">Masyarakat
                                Umum</span>
                        @endif

                        <span class="text-sm text-slate-500 font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                            Bergabung {{ $user->created_at->translatedFormat('M Y') }}
                        </span>
                    </div>

                    <div
                        class="mt-2 p-4 bg-slate-50 rounded-xl border border-slate-100 max-w-2xl inline-block text-left w-full">
                        @if ($user->bio)
                            <p class="text-slate-700 text-sm md:text-base leading-relaxed italic">
                                "{{ $user->bio }}"
                            </p>
                        @else
                            <p
                                class="text-slate-400 text-sm md:text-base leading-relaxed italic flex items-center justify-center md:justify-start gap-1.5">
                                <span class="material-symbols-outlined text-[18px]">info</span>
                                Pengguna ini belum mengatur bio.
                            </p>
                        @endif
                    </div>
                </div>

                @auth
                    @if (Auth::id() === $user->id)
                        <div class="shrink-0">
                            <a href="{{ route('profile.edit') }}"
                                class="inline-flex items-center gap-2 bg-white border-2 border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold hover:border-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 transition-all shadow-sm active:scale-95">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                Edit Profil Saya
                            </a>
                        </div>
                    @endif
                @endauth

            </div>
        </div>

        <h3 class="font-bold text-slate-800 mb-4 text-lg px-1">Rekam Jejak Kontribusi</h3>
        <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-8">

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">forum</span>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">{{ $user->threads()->count() }}</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Topik Dibuat</div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">chat</span>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">{{ $user->replies()->count() }}</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Tanggapan</div>
                </div>
            </div>

            {{-- <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center gap-4 col-span-2 md:col-span-1">
                <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">workspace_premium</span>
                </div>
                <div>
                    <div class="text-2xl font-black text-slate-900">0</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jawaban Terbaik</div>
                </div>
            </div> --}}

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800">Topik Diskusi Terbaru</h3>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse ($user->threads()->latest()->take(5)->get() as $thread)
                    <a href="{{ route('forum.thread.show', $thread->slug) }}"
                        class="block p-5 hover:bg-slate-50 transition-colors group">
                        <h4
                            class="font-bold text-slate-900 group-hover:text-emerald-700 transition-colors mb-1 line-clamp-1">
                            {{ $thread->title }}
                        </h4>
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <span
                                class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded-sm font-semibold">{{ $thread->category->name ?? 'Umum' }}</span>
                            <span>• {{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-slate-500 text-sm">
                        Pengguna ini belum pernah membuat topik diskusi.
                    </div>
                @endforelse
            </div>
        </div>

    </main>
</body>

</html>
