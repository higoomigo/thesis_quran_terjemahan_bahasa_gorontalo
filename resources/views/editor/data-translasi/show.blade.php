{{-- resources/views/editor/data-terjemahan/show.blade.php --}}
@extends('layouts.app_editor')

@section('title', 'Edit Terjemahan QS. ' . $surah->nama_latin)

@push('styles')
<style>
    
    textarea:focus {
        box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.15);
    }
</style>
@endpush

@section('content')
<main class="flex-1 ml-64 p-6 bg-gray-50/50 min-h-screen">
    
    @if(session('success'))
        <div id="flash-message" class="fixed top-6 right-6 z-50 bg-emerald-100 border-l-4 border-emerald-600 text-emerald-900 px-6 py-4 rounded shadow-lg flex items-center gap-3 transition-opacity duration-500">
            <span class="material-symbols-outlined text-emerald-600">check_circle</span>
            <p class="font-bold">{{ session('success') }}</p>
        </div>
    @endif

    {{-- @dd($surah, $ayats) --}}
    <header class="max-w-4xl mx-auto mb-8">
        <nav class="flex items-center gap-2 text-gray-500 mb-6">
            <a href="{{ route('editor.data-terjemahan.index') }}" class="text-xs hover:text-emerald-600 transition-colors cursor-pointer font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Daftar
            </a>
        </nav>
        
        <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <p class="text-sm font-bold text-emerald-600 uppercase tracking-widest mb-1">Surah Ke-{{ $surah->no_surah }}</p>
                <h2 class="text-3xl font-black text-gray-800">QS. {{ $surah->nama_latin }}</h2>
                <p class="text-gray-500 mt-1 font-medium mb-4">{{ $surah->arti }} • {{ count($ayats) }} Ayat</p>
                
                <form action="{{ route('editor.data-terjemahan.import', $surah->no_surah) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start sm:items-center gap-3 bg-gray-50 p-3 rounded-xl border border-gray-200">
                    @csrf
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600">upload_file</span>
                        <input type="file" name="file_excel" accept=".xlsx, .xls, .csv" required
                            class="text-sm text-gray-600 
                            file:mr-3 file:py-2 file:px-4 
                            file:rounded-lg file:border-0 
                            file:text-xs file:font-bold 
                            file:bg-emerald-100 file:text-emerald-800 
                            hover:file:bg-emerald-200 file:transition-colors cursor-pointer">
                    </div>
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-gray-800 hover:bg-black text-white text-sm font-bold rounded-lg transition-colors shadow-sm active:scale-95">
                        Import Data
                    </button>
                </form>
            </div>
            
            <div class="bg-emerald-50 px-5 py-3 rounded-xl border border-emerald-100 text-center hidden md:block">
                <span class="block text-2xl font-black text-emerald-700">{{ $surah->arabic_name ?? 'Arabic' }}</span>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto space-y-6 pb-20">
        
        @if($surah->no_surah != 1 && $surah->no_surah != 9)
            <div class="text-center py-6">
                <p class="arabic-text !text-4xl">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
            </div>
        @endif

        @forelse($ayats as $ayat)
            <div id="ayat-{{ $ayat->nomorAyat }}" class="scroll-mt-24">
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    
                    <div class="p-6 sm:p-8 bg-gray-50/50 border-b border-gray-100">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <span class="inline-flex items-center justify-center min-w-[3rem] px-3 py-1 bg-emerald-100 text-emerald-800 font-bold text-sm rounded-lg border border-emerald-200">
                                Ayat {{ $ayat->nomorAyat }}
                            </span>
                        </div>
                        <p class="arabic-text">
                            {{ $ayat->Arab }}
                        </p>
                    </div>

                    <div class="p-6 sm:p-8">
                        {{-- Sesuaikan route action di bawah ini dengan route update milik lu --}}
                        <form action="{{ route('editor.data-terjemahan.update', $ayat->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <label for="teks_{{ $ayat->id }}" class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-emerald-600 text-lg">g_translate</span> 
                                Input Terjemahan Gorontalo
                            </label>
                            
                            <textarea 
                                id="teks_{{ $ayat->id }}" 
                                name="teks_gorontalo" 
                                rows="3" 
                                class="w-full bg-white border border-gray-300 rounded-xl p-4 text-gray-800 font-medium text-lg focus:border-emerald-500 outline-none transition-all leading-relaxed" 
                                placeholder="Ketikkan terjemahan bahasa Gorontalo di sini..."
                                required
                            >{{ old('teks_gorontalo', $ayat->teks_gorontalo) }}</textarea>

                            <div class="mt-4 flex items-center justify-between">
                                <p class="text-xs text-gray-400 font-medium">
                                    {{ $ayat->teks_gorontalo ? 'Telah diterjemahkan' : 'Belum diterjemahkan' }}
                                </p>
                                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition-colors shadow-sm active:scale-95">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    Simpan Ayat {{ $ayat->nomorAyat }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white border border-gray-200 rounded-2xl">
                <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">database</span>
                <h3 class="text-xl font-bold text-gray-700">Data Ayat Kosong</h3>
                <p class="text-gray-500 mt-2">Belum ada ayat yang diinputkan untuk surah ini.</p>
            </div>
        @endforelse

    </div>
</main>

<script>
    // Hilangkan flash message success otomatis setelah 4 detik
    document.addEventListener('DOMContentLoaded', function() {
        const flashMsg = document.getElementById('flash-message');
        if (flashMsg) {
            setTimeout(() => {
                flashMsg.style.opacity = '0';
                setTimeout(() => flashMsg.remove(), 500); // Hapus elemen setelah transisi fade out
            }, 4000);
        }
    });
</script>
@endsection