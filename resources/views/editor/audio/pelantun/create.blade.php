@extends('layouts.app_editor')

@section('title', 'Tambah Pelantun')

@section('content')
<main class="flex-1 ml-64 px-6 py-8 bg-gray-50/50 min-h-screen">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('editor.audio.pelantun.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-emerald-600 mb-4 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Tambah Pelantun Baru</h3>
            </div>
            
            <form action="{{ route('editor.audio.pelantun.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" required class="w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-3 text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Contoh: Bpk. Wahyudin">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Peran Bacaan</label>
                    <select name="peran" required class="w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-3 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="qari">Qari (Hanya Arab)</option>
                        <option value="pembaca_terjemahan">Pembaca Terjemahan (Hanya Gorontalo)</option>
                        <option value="keduanya">Bisa Keduanya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Ringkas (Opsional)</label>
                    <textarea name="deskripsi" rows="3" class="w-full rounded-lg border-gray-300 bg-gray-50 py-2 px-3 text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Contoh: Qari perwakilan IPQAH Gorontalo"></textarea>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-lg transition-all shadow-sm active:scale-95">
                        Simpan Pelantun
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection