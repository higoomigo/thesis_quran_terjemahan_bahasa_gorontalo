{{-- resources/views/editor/antrean/show.blade.php --}}
@extends('layouts.app_editor')

@section('title', $title ?? 'Tinjau Usulan Publikasi')

@section('content')
<main class="flex-1 ml-64 p-6 pattern-bg min-h-screen">
    <div class="max-w-6xl mx-auto">
        <header class="mb-6">
            <nav class="flex items-center gap-2 text-gray-500 mb-4">
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Beranda</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Editor</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <a href="{{ route('editor.antrean.index') }}" class="text-xs hover:text-emerald-600 transition-colors cursor-pointer">Antrean Publikasi</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-xs text-emerald-700 font-medium">Tinjau Usulan</span>
            </nav>
            <div class="flex justify-between items-end flex-wrap gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <h2 class="text-4xl font-bold text-emerald-800">Tinjau Usulan Publikasi</h2>
                        <span class="material-symbols-outlined text-4xl text-emerald-500" style="font-variation-settings: 'FILL' 1;">
                            rate_review
                        </span>
                    </div>
                    <p class="text-gray-600">Review usulan yang sudah divalidasi tim pakar, edit teks final, dan publikasikan ke sistem.</p>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800">Detail Konteks Usulan</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Ayat</p>
                            <p class="text-lg font-bold text-emerald-800">QS {{ $usulan->ayat->no_surah ?? '?' }}:{{ $usulan->ayat->nomorAyat ?? '?' }} - {{ $usulan->ayat->surah->nama_latin ?? 'Surah' }}</p>
                            <p class="arabic-font text-right text-2xl mt-2 leading-loose">{{ $usulan->ayat->Arab ?? '--' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Terjemahan Saat Ini (Gorontalo)</p>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <p class="text-gray-700">{{ $usulan->ayat->teks_gorontalo ?? 'Belum ada terjemahan' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Usulan Awal (Dari Masyarakat)</p>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <p class="italic text-gray-700">"{{ $usulan->usulan_teks }}"</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-4 pt-2 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500">Pengusul</p>
                                <p class="font-semibold text-gray-800">{{ $usulan->nama_pengusul }}</p>
                                <p class="text-xs text-gray-500">{{ $usulan->no_hp }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Tanggal Validasi Pakar</p>
                                <p class="text-sm text-gray-700 font-medium">{{ $usulan->validated_at ? $usulan->validated_at->format('d F Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ==========================================
                     KOTAK BARU: REKOMENDASI & CATATAN PAKAR
                     ========================================== --}}
                <div class="bg-white rounded-xl border border-blue-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-blue-50/50 border-b border-blue-100 flex items-center gap-2 text-blue-800">
                        <span class="material-symbols-outlined">gavel</span>
                        <h3 class="font-bold">Hasil Keputusan & Catatan Dewan Pakar</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-xs text-blue-600 uppercase tracking-wider font-bold mb-1">Pesan Internal Untuk Editor :</p>
                            <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100 text-sm text-blue-900 font-medium">
                                {{ $usulan->catatan_pakar ?? 'Tidak ada catatan khusus dari tim pakar untuk editor.' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Alasan Revisi (Akan Dilihat Publik) :</p>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-sm text-gray-700">
                                "{{ $usulan->alasan_revisi ?? 'Tidak ada alasan khusus yang dicantumkan.' }}"
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Teks Translasi Terbaru</p>
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-sm text-gray-700">
                                "{{ $usulan->teks_rekomendasi ?? 'Tidak ada rekomendasi khusus yang dicantumkan.' }}"
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Finalisasi Publikasi (Dengan Konteks Terintegrasi) -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-emerald-50 border-b border-emerald-200">
                        <h3 class="font-bold text-emerald-800 flex items-center gap-2">
                            <span class="material-symbols-outlined">publish</span>
                            Penerbitan Resmi Terjemahan
                        </h3>
                    </div>

                    <form id="publikasiForm" action="{{ route('editor.antrean.publikasi', $usulan->id) }}" method="POST">
                        @csrf
                        
                        {{-- ==========================================
                             BAGIAN 1: REFERENSI (BEFORE)
                             ========================================== --}}
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Kolom Ayat Arab -->
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1 font-bold">Konteks Ayat</p>
                                    <p class="text-base font-bold text-emerald-800">QS {{ $usulan->ayat->no_surah ?? '?' }}:{{ $usulan->ayat->nomorAyat ?? '?' }} - {{ $usulan->ayat->surah->nama_latin ?? 'Surah' }}</p>
                                    <p class="arabic-font text-right text-3xl mt-4 leading-loose text-gray-900" dir="rtl">{{ $usulan->ayat->Arab ?? '--' }}</p>
                                </div>
                                <!-- Kolom Terjemahan Lama -->
                                <div class="flex flex-col">
                                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1 font-bold">Terjemahan Saat Ini (Gorontalo)</p>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm flex-1">
                                        <p class="text-gray-700 leading-relaxed">{{ $usulan->ayat->teks_gorontalo ?? 'Belum ada terjemahan' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ==========================================
                             BAGIAN 2: EKSEKUSI (AFTER)
                             ========================================== --}}
                        <div class="p-6">
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex justify-between items-end">
                                    <span>Teks Final Bahasa Gorontalo <span class="text-red-500">*</span></span>
                                    <span class="text-xs text-emerald-600 bg-emerald-50 px-2 py-1 rounded border border-emerald-100">Berdasarkan Rumusan Pakar</span>
                                </label>
                                
                                {{-- MODIFIKASI: Mengambil data teks_rekomendasi milik pakar secara otomatis --}}
                                <textarea name="teks_final" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors text-lg font-medium bg-white shadow-inner" placeholder="Tuliskan teks terjemahan final...">{{ old('teks_final', $usulan->teks_rekomendasi ?? $usulan->usulan_teks) }}</textarea>
                                
                                <p class="text-xs text-gray-500 mt-2 flex items-start gap-1">
                                    <span class="material-symbols-outlined text-[14px]">info</span>
                                    <span>Draf di atas otomatis terisi oleh rumusan tim pakar. Anda tetap bisa menyesuaikan tanda baca atau *typo* kecil jika diperlukan sebelum tombol publikasi ditekan.</span>
                                </p>
                            </div>
                            
                            <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                                <a href="{{ route('editor.antrean.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-bold text-sm transition-colors">Batal</a>
                                <button type="button" id="submitPublish" class="px-6 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 font-bold text-sm transition-colors flex items-center gap-2 shadow-md">
                                    <span class="material-symbols-outlined text-base">cloud_upload</span>
                                    Publikasikan Sekarang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-600">group</span>
                            Tim Dewan Pakar
                        </h3>
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse($usulan->assignments as $assign)
                            <div class="flex items-center justify-between p-2.5 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-800 font-bold text-xs border border-emerald-100">
                                        {{ strtoupper(substr($assign->user->name ?? 'P', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm text-gray-800">{{ $assign->user->name ?? 'Pakar' }}</p>
                                        <p class="text-[10px] text-gray-500">Validator Assignee</p>
                                    </div>
                                </div>
                                @php
                                    $vote = $usulan->votes->where('user_id', $assign->user_id)->first();
                                @endphp
                                @if($vote)
                                    <span class="text-xs font-medium {{ $vote->keputusan == 'setuju' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }} px-2.5 py-0.5 rounded-md">
                                        {{ $vote->keputusan == 'setuju' ? 'Setuju' : 'Tolak' }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">Belum voting</span>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-2">Belum ada validator terdaftar</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-600">how_to_vote</span>
                            Persentase Mufakat
                        </h3>
                    </div>
                    <div class="p-6">
                        @php
                            $totalVotes = $usulan->votes->count();
                            $setuju = $usulan->votes->where('keputusan', 'setuju')->count();
                            $tolak = $usulan->votes->where('keputusan', 'tolak')->count();
                        @endphp
                        <div class="flex justify-between text-sm mb-2 font-medium">
                            <span class="text-gray-600">Mendukung Usulan</span>
                            <span class="font-bold text-emerald-600">{{ $setuju }} Pakar</span>
                        </div>
                        <div class="flex justify-between text-sm mb-3 font-medium">
                            <span class="text-gray-600">Menolak Usulan</span>
                            <span class="font-bold text-red-600">{{ $tolak }} Pakar</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full transition-all" style="width: {{ $totalVotes > 0 ? ($setuju / $totalVotes) * 100 : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-4 text-center font-medium">
                            Seluruh keputusan dewan pakar bersifat mutlak.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('submitPublish').addEventListener('click', function(e) {
        e.preventDefault();
        
        const teksFinal = document.querySelector('textarea[name="teks_final"]').value.trim();
        if (!teksFinal) {
            Swal.fire({
                icon: 'error',
                title: 'Teks Final Kosong',
                text: 'Silakan isi teks terjemahan final sebelum mempublikasikan.',
                confirmButtonColor: '#059669'
            });
            return;
        }

        Swal.fire({
            title: 'Publikasikan Terjemahan?',
            text: "Terjemahan baru resmi tayang. Versi lama otomatis masuk ke dalam brankas riwayat perubahan.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Terbitkan!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('publikasiForm').submit();
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Nangkep pesan sukses (yang dikirim pakai ->with('success', '...'))
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Alhamdulillah!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#059669'
            });
        @endif

        // Nangkep pesan error dari try-catch (yang dikirim pakai ->with('error', '...'))
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops, Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc2626'
            });
        @endif

        // Nangkep error dari Validasi (misal: teks_final kosong)
        @if($errors->any())
            Swal.fire({
                icon: 'warning',
                title: 'Validasi Gagal!',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#f59e0b'
            });
        @endif
    });
</script>

<style>
    .arabic-font {
        font-family: 'Noto Serif', serif;
    }
</style>
@endsection