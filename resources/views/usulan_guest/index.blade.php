{{-- resources/views/usulan/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Usulan Terjemahan - QS {{ $data_surah->no_surah ?? 1 }}:{{ $data_ayat->nomorAyat ?? 1 }} | Qur'an Gorontalo
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;family=Noto+Serif:wght@400;700&amp;display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
            scroll-behavior: smooth;
        }

        .arabic-text {
            font-family: 'Noto Serif', serif;
            font-size: 32px;
            line-height: 1.8;
            direction: rtl;
            text-align: right;
            color: #064e3b;
        }

        input:focus,
        textarea:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.2);
            border-color: #059669;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .flash-message {
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-enter {
            animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
    </style>
</head>

<body class="text-gray-800 antialiased min-h-screen flex flex-col">

    @if (session('success'))
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md px-4">
            <div
                class="flash-message bg-emerald-100 border-l-4 border-emerald-600 text-emerald-900 p-3 rounded shadow-lg">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-2xl">check_circle</span>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md px-4">
            <div class="flash-message bg-red-100 border-l-4 border-red-600 text-red-900 p-3 rounded shadow-lg">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-600 text-2xl">error</span>
                    <p class="font-bold text-sm">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <nav class="sticky top-0 w-full bg-white/95 backdrop-blur-md border-b border-gray-200 shadow-sm z-50">
        <div class="max-w-5xl mx-auto px-4 h-14 flex items-center justify-between">
            <a class="text-lg font-bold tracking-tight text-emerald-800 flex items-center gap-2"
                href="{{ route('mushaf') ?? '#' }}">
                Qur'an Gorontalo
            </a>
            <a href="{{ isset($data_surah) ? route('surah.show', $data_surah->no_surah) : '#' }}"
                class="inline-flex items-center gap-1 text-gray-600 hover:text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg font-bold text-sm transition-all">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                <span>Kembali</span>
            </a>
        </div>
    </nav>

    <div class="flex-1 w-full max-w-5xl mx-auto px-4 py-6">

        <section class="pb-8 border-b border-gray-300">
            <div class="mb-6 flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-black text-gray-900">QS
                        {{ $data_surah->no_surah ?? '?' }}:{{ $data_ayat->nomorAyat ?? '?' }}</h1>
                    <p class="text-sm text-gray-600 font-medium">{{ $data_surah->nama_latin ?? 'Nama Surah' }} •
                        {{ $data_surah->arti ?? 'Arti Surah' }}</p>
                </div>
                <button onclick="document.getElementById('form-usulan').scrollIntoView({behavior: 'smooth'})"
                    class="hidden sm:flex bg-emerald-100 text-emerald-800 hover:bg-emerald-200 px-3 py-1.5 rounded-lg font-bold text-sm transition-colors items-center gap-1">
                    <span class="material-symbols-outlined text-lg">edit</span> Buat Usulan
                </button>
            </div>

            <div class="space-y-6">
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <p class="arabic-text text-3xl leading-loose text-gray-900">
                                {{ $data_ayat->Arab ?? 'Teks Arab tidak tersedia' }}
                            </p>
                        </div>
                        <div class="flex-shrink-0 mt-1">
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm border-2 border-emerald-200 shadow-sm">
                                {{-- PERBAIKAN: Jika fungsi numberToArabic tidak ada, langsung cetak angkanya --}}
                                {{ function_exists('numberToArabic') ? numberToArabic($data_ayat->nomorAyat ?? 0) : $data_ayat->nomorAyat ?? 0 }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between text-xs text-gray-400">
                        <span>QS {{ $data_surah->no_surah ?? '?' }}:{{ $data_ayat->nomorAyat ?? '?' }}</span>
                        <span>{{ $data_surah->nama_latin ?? '' }}</span>
                    </div>
                </div>

                <div
                    class="border-l-4 border-emerald-500 pl-5 py-2 transition-all hover:border-emerald-600 hover:pl-6 bg-emerald-50/20 rounded-r-lg pr-4">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-base">g_translate</span>
                        Terjemahan Saat Ini (Gorontalo)
                    </h3>
                    <p class="text-xl text-gray-800 leading-relaxed font-medium">
                        {{ $data_ayat->teks_gorontalo ?? 'Belum ada terjemahan Gorontalo untuk ayat ini.' }}
                    </p>
                    @if (empty($data_ayat->teks_gorontalo))
                        <div class="mt-2 flex items-center gap-2 text-amber-600 text-sm">
                            <span class="material-symbols-outlined text-base">info</span>
                            <span>Belum ada terjemahan. Kirim usulan Anda!</span>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="py-8 border-b border-gray-300">
            <div class="mb-6">
                <h2 class="text-2xl font-black text-emerald-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-3xl">history_edu</span>
                    Jejak Sejarah Terjemahan
                </h2>
                <p class="text-sm text-gray-600 mt-1 font-medium">Daftar perjalanan perubahan terjemahan ayat dari waktu
                    ke waktu.</p>
            </div>

            <div class="space-y-6">
                @forelse($riwayat_terjemahans ?? [] as $riwayat)
                    <div
                        class="group relative pl-6 sm:pl-10 border-l-4 {{ in_array($riwayat->usulan->status ?? '', ['diterima', 'dipublikasi']) ? 'border-emerald-400' : 'border-gray-300' }} transition-all duration-300 hover:border-emerald-500">
                        <div
                            class="absolute -left-[12px] top-0 w-5 h-5 rounded-full bg-white border-4 {{ in_array($riwayat->usulan->status ?? '', ['diterima', 'dipublikasi']) ? 'border-emerald-500' : 'border-gray-300' }} transition-transform duration-300 group-hover:scale-125 shadow-sm">
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-3">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ $riwayat->created_at ? $riwayat->created_at->translatedFormat('d F Y') : '-' }}
                                </h3>
                                <p class="text-xs text-gray-500 font-medium">Diusulkan oleh: <span
                                        class="font-bold text-gray-700">{{ $riwayat->usulan->nama_pengusul ?? 'Anonim' }}</span>
                                </p>
                            </div>
                            <button onclick="bukaModalRiwayat({{ $riwayat->id }})"
                                class="w-full sm:w-auto bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 hover:border-blue-400 px-4 py-1.5 rounded-lg font-bold text-sm transition-all flex items-center justify-center gap-1 shadow-sm group-hover:shadow-md">
                                <span class="material-symbols-outlined text-base">plumbing</span>
                                LIHAT DETAIL PROSES
                            </button>
                        </div>

                        <div
                            class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm group-hover:shadow-md transition-shadow">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Terjemahan yang
                                disahkan:</p>
                            <p class="text-xl text-emerald-900 font-bold leading-relaxed">
                                "{{ $riwayat->teks_baru ?? '' }}"
                            </p>
                        </div>
                    </div>

                    <div id="modal-riwayat-{{ $riwayat->id }}"
                        class="hidden fixed inset-0 z-[100] flex items-center justify-center p-3 sm:p-5 bg-black/75 backdrop-blur-sm transition-opacity">
                        <div
                            class="modal-enter bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden">
                            <div class="bg-emerald-800 px-5 py-3 flex justify-between items-center shrink-0">
                                <div>
                                    <h3 class="text-xl font-black text-white flex items-center gap-2">
                                        <span class="material-symbols-outlined text-2xl">task_alt</span>
                                        Laporan Otentikasi Terjemahan
                                    </h3>
                                    <p class="text-emerald-200 text-xs mt-0.5">ID Riwayat: #{{ $riwayat->id }} |
                                        Tanggal:
                                        {{ $riwayat->created_at ? $riwayat->created_at->translatedFormat('d F Y') : '-' }}
                                    </p>
                                </div>
                                <button onclick="tutupModalRiwayat({{ $riwayat->id }})"
                                    class="bg-red-500 text-white hover:bg-red-600 px-3 py-1.5 rounded-lg font-bold text-sm flex items-center gap-1 transition-colors">
                                    <span class="material-symbols-outlined text-base">close</span> TUTUP
                                </button>
                            </div>

                            <div class="p-5 sm:p-6 overflow-y-auto custom-scrollbar space-y-6 bg-gray-50/50">
                                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                    <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-3">
                                        <h4 class="text-sm font-bold text-gray-800 flex items-center gap-1">
                                            <span
                                                class="material-symbols-outlined text-emerald-600 text-base">menu_book</span>
                                            Konteks Ayat
                                        </h4>
                                        <span
                                            class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full text-xs font-bold">QS
                                            {{ $data_surah->no_surah ?? '?' }}:{{ $data_ayat->nomorAyat ?? '?' }}</span>
                                    </div>
                                    <p class="arabic-text text-2xl">{{ $data_ayat->Arab ?? '' }}</p>
                                </div>

                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Perubahan
                                        Teks Terjemahan</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="bg-white p-4 rounded-lg border-l-4 border-red-400 shadow-sm">
                                            <p
                                                class="text-[11px] font-bold text-red-500 uppercase tracking-widest mb-2 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs">cancel</span> Teks
                                                Sebelumnya
                                            </p>
                                            <p
                                                class="text-sm text-gray-600 line-through decoration-red-300 leading-relaxed font-medium">
                                                "{{ $riwayat->teks_lama ?? '' }}"
                                            </p>
                                        </div>
                                        <div
                                            class="bg-emerald-50 p-4 rounded-lg border-l-4 border-emerald-500 shadow-sm">
                                            <p
                                                class="text-[11px] font-bold text-emerald-600 uppercase tracking-widest mb-2 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs">check_circle</span> Teks
                                                Baru (Disahkan)
                                            </p>
                                            <p class="text-lg text-emerald-900 font-bold leading-relaxed">
                                                "{{ $riwayat->teks_baru ?? '' }}"
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm space-y-5">
                                    <h4
                                        class="text-sm font-bold text-gray-800 flex items-center gap-1 border-b border-gray-100 pb-3">
                                        <span
                                            class="material-symbols-outlined text-blue-600 text-base">account_tree</span>
                                        Alur Validasi
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <p class="text-[11px] font-bold text-gray-400 uppercase mb-1">1. Diusulkan
                                                Oleh</p>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="material-symbols-outlined text-2xl text-gray-400">person_raised_hand</span>
                                                <div>
                                                    <p class="font-bold text-gray-900 text-sm">
                                                        {{ $riwayat->usulan->nama_pengusul ?? 'Masyarakat' }}</p>
                                                    <p class="text-xs text-gray-500">Warga Gorontalo</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-gray-400 uppercase mb-1">2. Divalidasi
                                                Oleh (Pakar)</p>
                                            <div class="space-y-2">
                                                @if (!empty($riwayat->usulan) && !empty($riwayat->usulan->assignments) && count($riwayat->usulan->assignments) > 0)
                                                    @foreach ($riwayat->usulan->assignments as $assign)
                                                        <div class="flex items-center gap-1">
                                                            <span
                                                                class="material-symbols-outlined text-emerald-500 text-sm">verified</span>
                                                            <p class="font-bold text-gray-800 text-sm">
                                                                {{ $assign->user->name ?? 'Pakar' }}</p>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p class="text-xs text-gray-500 italic">Data pakar tidak tersedia.
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-gray-400 uppercase mb-1">3.
                                                Dipublikasikan Oleh (Editor)</p>
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="material-symbols-outlined text-2xl text-blue-500">gavel</span>
                                                <div>
                                                    <p class="font-bold text-gray-900 text-sm">
                                                        {{ $riwayat->editor->name ?? 'Sistem' }}</p>
                                                    <p class="text-xs text-gray-500">Meja Redaksi</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($riwayat->alasan_revisi))
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                            Catatan / Alasan Keputusan Pakar</h4>
                                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                            <p class="text-md text-yellow-900 leading-relaxed font-medium italic">
                                                "{{ $riwayat->alasan_revisi }}"
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="p-4 bg-white border-t border-gray-200 shrink-0">
                                <button onclick="tutupModalRiwayat({{ $riwayat->id }})"
                                    class="w-full bg-gray-900 hover:bg-black text-white py-2 rounded-lg font-bold text-base shadow-md transition-all active:scale-[0.98]">
                                    TUTUP LAPORAN INI
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                        <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">history_off</span>
                        <h3 class="text-xl font-bold text-gray-700 mb-1">Belum Ada Riwayat Perubahan</h3>
                        <p class="text-md text-gray-500">Terjemahan ayat ini masih menggunakan versi asli dan belum
                            pernah direvisi.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section id="form-usulan" class="py-8">
            <div class="mb-6">
                <h2 class="text-2xl font-black text-emerald-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-3xl">edit_square</span>
                    Kirim Usulan Terjemahan Baru
                </h2>
                <p class="text-sm text-gray-600 mt-1 font-medium">Bantu sempurnakan terjemahan dengan tata bahasa
                    Gorontalo yang baik.</p>
            </div>

            <form action="{{ route('usulan.store') }}" method="POST"
                class="space-y-6 max-w-4xl bg-white p-6 sm:p-7 rounded-xl shadow-sm border border-gray-200 relative overflow-hidden">
                @csrf
                <input type="hidden" name="ayat_id" value="{{ $data_ayat->id ?? '' }}">

                @auth
                    <input type="hidden" name="nama_pengusul" value="{{ Auth::user()->name }}">
                    <input type="hidden" name="no_hp" value="{{ Auth::user()->no_hp ?? '000000000000' }}">

                    <div
                        class="bg-emerald-50 border border-emerald-100 rounded-lg p-3 flex items-start sm:items-center gap-3 mb-2">
                        <span class="material-symbols-outlined text-emerald-600 mt-0.5 sm:mt-0">verified_user</span>
                        <p class="text-sm text-emerald-800">
                            Anda mengirim usulan sebagai <span class="font-bold">{{ Auth::user()->name }}</span>.
                        </p>
                    </div>

                    @if (!Auth::user()->no_hp)
                        <div
                            class="bg-orange-50 border border-orange-100 rounded-lg p-3 flex items-start sm:items-center gap-3 mb-2">
                            <span class="material-symbols-outlined text-orange-600 mt-0.5 sm:mt-0">warning</span>
                            <p class="text-sm text-orange-800">
                                Nomor HP di profil Anda masih kosong. Silakan perbarui profil Anda nanti.
                            </p>
                        </div>
                    @endif
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="group">
                            <label for="nama_pengusul"
                                class="block font-bold text-sm text-gray-800 mb-2 group-focus-within:text-emerald-700 transition-colors">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama_pengusul" name="nama_pengusul"
                                value="{{ old('nama_pengusul') }}"
                                class="w-full px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-50 transition-all focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                                placeholder="Tulis nama lengkap Anda..." required>
                            @error('nama_pengusul')
                                <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="no_hp"
                                class="block font-bold text-sm text-gray-800 mb-2 group-focus-within:text-emerald-700 transition-colors">
                                Nomor WA / HP <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                                class="w-full px-4 py-2 text-sm border-2 border-gray-300 rounded-lg bg-gray-50 transition-all focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                                placeholder="Contoh: 081234567890" required>
                            @error('no_hp')
                                <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endauth

                <div class="group">
                    <label for="usulan_teks"
                        class="block font-bold text-sm text-gray-800 mb-2 group-focus-within:text-emerald-700 transition-colors">
                        Teks Usulan Terjemahan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="usulan_teks" name="usulan_teks" rows="4"
                        class="w-full px-4 py-3 text-md font-medium border-2 border-gray-300 rounded-lg bg-gray-50 transition-all leading-relaxed focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500"
                        placeholder="Tuliskan kalimat terjemahan yang menurut Anda lebih tepat di sini..." required>{{ old('usulan_teks') }}</textarea>
                    @error('usulan_teks')
                        <p class="mt-1 text-xs font-bold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-lg rounded-lg transition-all border-b-2 border-emerald-900 active:border-b-0 active:mt-0.5 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                    <span class="material-symbols-outlined text-2xl transform -rotate-12">send</span>
                    KIRIM USULAN SEKARANG
                </button>
        </form>
        </section>

    </div>

    <script>
        function bukaModalRiwayat(id) {
            const modal = document.getElementById('modal-riwayat-' + id);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function tutupModalRiwayat(id) {
            const modal = document.getElementById('modal-riwayat-' + id);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                event.target.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }

        setTimeout(function() {
            const flashes = document.querySelectorAll('.flash-message');
            flashes.forEach(flash => {
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 400);
            });
        }, 5000);
    </script>
</body>

</html>
