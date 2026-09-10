@extends('layouts.app_editor')

@section('title', 'Tambah Langgam')

@section('content')
<main class="flex-1 ml-64 px-6 py-8 bg-gray-50/50 min-h-screen">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('editor.audio.langgam.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-indigo-600 mb-4 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800">Tambah Langgam Baru</h3>
            </div>
            
            <form action="{{ route('editor.audio.langgam.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Langgam</label>
                    <input type="text" name="nama" required class="w-full rounded-lg border-gray-300 bg-gray-50 py-2.5 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Bayati, Rost, Nahawand">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Qari (Pelantun) yang Menguasai Langgam Ini</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($qaris as $qari)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="qari_ids[]" value="{{ $qari->id }}" class="peer hidden">
                            <div class="rounded-xl border-2 border-gray-200 bg-gray-50 py-2.5 px-3 text-sm font-semibold text-gray-500 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">mic</span>
                                {{ $qari->nama }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-[11px] text-gray-400 mt-1.5">*Bisa pilih lebih dari satu.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Ringkas (Opsional)</label>
                    <textarea name="deskripsi" rows="3" class="w-full rounded-lg border-gray-300 bg-gray-50 py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Irama lembut dan menenangkan..."></textarea>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-lg transition-all shadow-sm active:scale-95">
                        Simpan Langgam
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection